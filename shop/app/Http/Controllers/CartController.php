<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CartController extends Controller
{
    protected const SESSION_KEY = 'cart';

    public function index(Request $request): View
    {
        $cart = $this->getCart($request);

        return view('cart.index', [
            'cart' => $cart,
            'cartTotal' => $this->calculateTotal($cart),
            'cartCount' => $this->calculateCount($cart),
        ]);
    }

    public function store(Request $request, Product $product): RedirectResponse
    {
        if (! $product->is_active) {
            abort(404);
        }

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart = $this->getCart($request);
        $existingQuantity = $cart[$product->id]['quantity'] ?? 0;
        $quantity = min($existingQuantity + $validated['quantity'], $product->stock);

        if ($quantity < 1) {
            return back()->withErrors([
                'cart' => 'Товар недоступен для добавления в корзину.',
            ]);
        }

        $cart[$product->id] = [
            'product_id' => $product->id,
            'slug' => $product->slug,
            'name' => $product->name,
            'price' => (float) $product->price,
            'image_path' => $product->image_path,
            'quantity' => $quantity,
            'stock' => $product->stock,
        ];

        $request->session()->put(self::SESSION_KEY, $cart);

        return redirect()->route('cart.index')->with('status', 'Товар добавлен в корзину.');
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $cart = $this->getCart($request);

        if (! isset($cart[$product->id])) {
            return redirect()->route('cart.index');
        }

        $cart[$product->id]['quantity'] = min($validated['quantity'], $product->stock);
        $cart[$product->id]['price'] = (float) $product->price;
        $cart[$product->id]['stock'] = $product->stock;

        $request->session()->put(self::SESSION_KEY, $cart);

        return redirect()->route('cart.index')->with('status', 'Корзина обновлена.');
    }

    public function destroy(Request $request, Product $product): RedirectResponse
    {
        $cart = $this->getCart($request);

        unset($cart[$product->id]);

        $request->session()->put(self::SESSION_KEY, $cart);

        return redirect()->route('cart.index')->with('status', 'Товар удален из корзины.');
    }

    public function clear(Request $request): RedirectResponse
    {
        $request->session()->forget(self::SESSION_KEY);

        return redirect()->route('cart.index')->with('status', 'Корзина очищена.');
    }

    protected function getCart(Request $request): array
    {
        return $request->session()->get(self::SESSION_KEY, []);
    }

    protected function calculateTotal(array $cart): float
    {
        return collect($cart)->sum(fn (array $item) => $item['price'] * $item['quantity']);
    }

    protected function calculateCount(array $cart): int
    {
        return (int) collect($cart)->sum('quantity');
    }
}