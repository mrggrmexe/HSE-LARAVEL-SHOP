<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::query()
            ->with(['parent'])
            ->withCount(['children', 'products'])
            ->orderBy('name')
            ->paginate(15);

        return view('admin.categories.index', [
            'categories' => $categories,
        ]);
    }

    public function create(): View
    {
        $parents = Category::query()
            ->orderBy('name')
            ->get();

        return view('admin.categories.create', [
            'parents' => $parents,
        ]);
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        Category::query()->create($request->validated());

        return redirect()->route('admin.categories.index')->with('status', 'Категория создана.');
    }

    public function edit(Category $category): View
    {
        $parents = Category::query()
            ->whereKeyNot($category->id)
            ->orderBy('name')
            ->get();

        return view('admin.categories.edit', [
            'category' => $category,
            'parents' => $parents,
        ]);
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $validated = $request->validated();

        if (($validated['parent_id'] ?? null) === $category->id) {
            return back()->withErrors([
                'parent_id' => 'Категория не может быть родителем самой себя.',
            ]);
        }

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('status', 'Категория обновлена.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->children()->exists()) {
            return back()->withErrors([
                'category' => 'Нельзя удалить категорию, у которой есть дочерние категории.',
            ]);
        }

        if ($category->products()->exists()) {
            return back()->withErrors([
                'category' => 'Нельзя удалить категорию, в которой есть товары.',
            ]);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('status', 'Категория удалена.');
    }
}