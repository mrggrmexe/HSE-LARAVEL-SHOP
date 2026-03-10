@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-3xl rounded-xl bg-white p-6 shadow">
        <h1 class="text-3xl font-bold">Редактирование товара</h1>

        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data" class="mt-8 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="mb-2 block text-sm font-medium">Название</label>
                <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}" class="w-full rounded-lg border border-gray-300 px-3 py-2">
            </div>

            <div>
                <label for="slug" class="mb-2 block text-sm font-medium">Slug</label>
                <input type="text" id="slug" name="slug" value="{{ old('slug', $product->slug) }}" class="w-full rounded-lg border border-gray-300 px-3 py-2">
            </div>

            <div>
                <label for="description" class="mb-2 block text-sm font-medium">Описание</label>
                <textarea id="description" name="description" rows="5" class="w-full rounded-lg border border-gray-300 px-3 py-2">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div>
                    <label for="price" class="mb-2 block text-sm font-medium">Цена</label>
                    <input type="number" step="0.01" id="price" name="price" value="{{ old('price', $product->price) }}" class="w-full rounded-lg border border-gray-300 px-3 py-2">
                </div>

                <div>
                    <label for="stock" class="mb-2 block text-sm font-medium">Остаток</label>
                    <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" class="w-full rounded-lg border border-gray-300 px-3 py-2">
                </div>
            </div>

            <div>
                <label for="category_id" class="mb-2 block text-sm font-medium">Категория</label>
                <select id="category_id" name="category_id" class="w-full rounded-lg border border-gray-300 px-3 py-2">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected((string) old('category_id', $product->category_id) === (string) $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="image" class="mb-2 block text-sm font-medium">Изображение</label>
                <input type="file" id="image" name="image" class="w-full rounded-lg border border-gray-300 px-3 py-2">
            </div>

            @if($product->image_path)
                <div class="h-40 w-40 overflow-hidden rounded-lg bg-gray-200">
                    <img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                </div>
            @endif

            <div class="flex items-center gap-3">
                <input type="checkbox" id="is_active" name="is_active" value="1" @checked(old('is_active', $product->is_active))>
                <label for="is_active" class="text-sm font-medium">Активный товар</label>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="rounded-lg bg-green-600 px-5 py-2 text-white hover:bg-green-700">
                    Сохранить
                </button>
                <a href="{{ route('admin.products.index') }}" class="rounded-lg bg-gray-200 px-5 py-2 text-gray-800 hover:bg-gray-300">
                    Назад
                </a>
            </div>
        </form>
    </div>
@endsection