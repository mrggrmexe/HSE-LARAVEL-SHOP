<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(StoreReviewRequest $request, Product $product): RedirectResponse
    {
        $user = $request->user();

        $hasPurchased = OrderItem::query()
            ->where('product_id', $product->id)
            ->whereHas('order', fn ($query) => $query->where('user_id', $user->id))
            ->exists();

        if (! $hasPurchased) {
            return back()->withErrors([
                'review' => 'Отзыв можно оставить только после покупки товара.',
            ]);
        }

        Review::query()->updateOrCreate(
            [
                'user_id' => $user->id,
                'product_id' => $product->id,
            ],
            $request->validated()
        );

        return redirect()->route('catalog.show', $product)->with('status', 'Отзыв сохранен.');
    }

    public function destroy(Request $request, Review $review): RedirectResponse
    {
        if ($review->user_id !== $request->user()->id && ! $request->user()->isAdmin()) {
            abort(403);
        }

        $product = $review->product;
        $review->delete();

        return redirect()->route('catalog.show', $product)->with('status', 'Отзыв удален.');
    }
}