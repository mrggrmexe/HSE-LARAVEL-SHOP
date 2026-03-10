<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\RecentlyViewedProduct;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CatalogController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'min_price' => ['nullable', 'numeric', 'min:0'],
            'max_price' => ['nullable', 'numeric', 'min:0'],
        ]);

        $products = Product::query()
            ->with('category')
            ->withAvg('reviews', 'rating')
            ->withCount('reviews')
            ->active()
            ->search($filters['search'] ?? null)
            ->when(
                filled($filters['category'] ?? null),
                fn ($query) => $query->whereHas('category', fn ($categoryQuery) => $categoryQuery->where('slug', $filters['category']))
            )
            ->when(
                filled($filters['min_price'] ?? null),
                fn ($query) => $query->where('price', '>=', $filters['min_price'])
            )
            ->when(
                filled($filters['max_price'] ?? null),
                fn ($query) => $query->where('price', '<=', $filters['max_price'])
            )
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        $categories = Category::query()
            ->with('children')
            ->roots()
            ->orderBy('name')
            ->get();

        return view('catalog.index', [
            'products' => $products,
            'categories' => $categories,
            'filters' => $filters,
        ]);
    }

    public function show(Request $request, Product $product): View
    {
        if (! $product->is_active && (! $request->user() || ! $request->user()->isAdmin())) {
            abort(404);
        }

        $this->recordRecentlyViewed($request, $product);

        $product->load([
            'category',
            'reviews' => fn ($query) => $query->latest()->with('user'),
        ])->loadAvg('reviews', 'rating');

        $relatedProducts = Product::query()
            ->active()
            ->where('category_id', $product->category_id)
            ->whereKeyNot($product->id)
            ->orderBy('name')
            ->limit(4)
            ->get();

        return view('catalog.show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
        ]);
    }

    protected function recordRecentlyViewed(Request $request, Product $product): void
    {
        $user = $request->user();

        if ($user) {
            RecentlyViewedProduct::query()->updateOrCreate(
                [
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                ],
                [
                    'session_id' => null,
                    'viewed_at' => now(),
                ]
            );

            $staleIds = RecentlyViewedProduct::query()
                ->where('user_id', $user->id)
                ->orderByDesc('viewed_at')
                ->skip(10)
                ->pluck('id');

            if ($staleIds->isNotEmpty()) {
                RecentlyViewedProduct::query()->whereIn('id', $staleIds)->delete();
            }

            return;
        }

        $sessionId = $request->session()->getId();

        RecentlyViewedProduct::query()->updateOrCreate(
            [
                'session_id' => $sessionId,
                'product_id' => $product->id,
            ],
            [
                'user_id' => null,
                'viewed_at' => now(),
            ]
        );

        $staleIds = RecentlyViewedProduct::query()
            ->where('session_id', $sessionId)
            ->orderByDesc('viewed_at')
            ->skip(10)
            ->pluck('id');

        if ($staleIds->isNotEmpty()) {
            RecentlyViewedProduct::query()->whereIn('id', $staleIds)->delete();
        }
    }
}