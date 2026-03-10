@extends('layouts.app')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-3xl font-bold">Товары</h1>
        <a href="{{ route('admin.products.create') }}" class="rounded-lg bg-green-600 px-4 py-2 text-white hover:bg-green-700">
            Добавить товар
        </a>
    </div>

    <div class="rounded-xl bg-white p-6 shadow">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead>
                    <tr class="border-b">
                        <th class="px-4 py-3">Название</th>
                        <th class="px-4 py-3">Категория</th>
                        <th class="px-4 py-3">Цена</th>
                        <th class="px-4 py-3">Остаток</th>
                        <th class="px-4 py-3">Активен</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr class="border-b">
                            <td class="px-4 py-3">{{ $product->name }}</td>
                            <td class="px-4 py-3">{{ $product->category?->name }}</td>
                            <td class="px-4 py-3">{{ number_format($product->price, 2, '.', ' ') }} ₽</td>
                            <td class="px-4 py-3">{{ $product->stock }}</td>
                            <td class="px-4 py-3">{{ $product->is_active ? 'Да' : 'Нет' }}</td>
                            <td class="px-4 py-3">
                                <div class="flex gap-3">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="text-green-700 hover:text-green-800">
                                        Изменить
                                    </a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}">
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
            {{ $products->links() }}
        </div>
    </div>
@endsection