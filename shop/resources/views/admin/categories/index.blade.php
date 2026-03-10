@extends('layouts.app')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-3xl font-bold">Категории</h1>
        <a href="{{ route('admin.categories.create') }}" class="rounded-lg bg-green-600 px-4 py-2 text-white hover:bg-green-700">
            Добавить категорию
        </a>
    </div>

    <div class="rounded-xl bg-white p-6 shadow">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead>
                    <tr class="border-b">
                        <th class="px-4 py-3">Название</th>
                        <th class="px-4 py-3">Slug</th>
                        <th class="px-4 py-3">Родитель</th>
                        <th class="px-4 py-3">Дочерние</th>
                        <th class="px-4 py-3">Товары</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr class="border-b">
                            <td class="px-4 py-3">{{ $category->name }}</td>
                            <td class="px-4 py-3">{{ $category->slug }}</td>
                            <td class="px-4 py-3">{{ $category->parent?->name ?? '—' }}</td>
                            <td class="px-4 py-3">{{ $category->children_count }}</td>
                            <td class="px-4 py-3">{{ $category->products_count }}</td>
                            <td class="px-4 py-3">
                                <div class="flex gap-3">
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="text-green-700 hover:text-green-800">
                                        Изменить
                                    </a>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-700">Удалить</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $categories->links() }}
        </div>
    </div>
@endsection