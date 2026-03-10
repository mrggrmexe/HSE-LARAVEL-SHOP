<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class OrderController extends Controller
{
    protected const SESSION_KEY = 'cart';

    public function checkout(Request $request): View|RedirectResponse
    {
        $cart = $request->session()->get(self::SESSION_KEY, []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->withErrors([
                'cart' => 'Корзина пуста.',
            ]);
        }

        return view('orders.checkout', [
            'cart' => $cart,
            'cartTotal' => $this->calculateTotal($cart),
            'cartCount' => (int) collect($cart)->sum('quantity'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $cart = $request->session()->get(self::SESSION_KEY, []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->withErrors([
                'cart' => 'Корзина пуста.',
            ]);
        }

        $order = DB::transaction(function () use ($cart, $request): Order {
            $order = Order::create([
                'user_id' => $request->user()->id,
            ]);

            foreach ($cart as $item) {
                $product = Product::query()->find($item['product_id']);

                if (! $product || ! $product->is_active) {
                    throw ValidationException::withMessages([
                        'cart' => "Товар {$item['name']} недоступен.",
                    ]);
                }

                if ($product->stock < $item['quantity']) {
                    throw ValidationException::withMessages([
                        'cart' => "Недостаточно товара {$product->name} на складе.",
                    ]);
                }

                $lineTotal = round((float) $product->price * $item['quantity'], 2);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                    'line_total' => $lineTotal,
                ]);

                $product->decrement('stock', $item['quantity']);
            }

            $order->refresh();
            $order->recalculateTotal();

            return $order;
        });

        $request->session()->forget(self::SESSION_KEY);

        return redirect()->route('orders.show', $order)->with('status', 'Заказ успешно оформлен.');
    }

    public function index(Request $request): View
    {
        $orders = Order::query()
            ->withCount('items')
            ->where('user_id', $request->user()->id)
            ->latest('ordered_at')
            ->paginate(10);

        return view('orders.index', [
            'orders' => $orders,
        ]);
    }

    public function show(Request $request, Order $order): View
    {
        if ($order->user_id !== $request->user()->id && ! $request->user()->isAdmin()) {
            abort(403);
        }

        $order->load(['items.product', 'user']);

        return view('orders.show', [
            'order' => $order,
        ]);
    }

    protected function calculateTotal(array $cart): float
    {
        return collect($cart)->sum(fn (array $item) => $item['price'] * $item['quantity']);
    }
}