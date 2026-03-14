@extends('layouts.app')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold">Каталог фруктов</h1>
            <p class="mt-1 text-sm text-gray-600">Поиск и просмотр товаров интернет-магазина</p>
        </div>
    </div>

    <div class="mb-8 rounded-xl bg-white p-6 shadow">
        <form method="GET" action="{{ route('catalog.index') }}" class="grid gap-4 md:grid-cols-4">
            <div>
                <label for="search" class="mb-2 block text-sm font-medium">Поиск</label>
                <input
                    type="text"
                    id="search"
                    name="search"
                    value="{{ $filters['search'] ?? '' }}"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2"
                    placeholder="Например, яблоко"
                >
            </div>

            <div>
                <label for="category" class="mb-2 block text-sm font-medium">Категория</label>
                <select id="category" name="category" class="w-full rounded-lg border border-gray-300 px-3 py-2">
                    <option value="">Все категории</option>
                    @foreach($categories as $rootCategory)
                        @foreach($rootCategory->children as $childCategory)
                            <option value="{{ $childCategory->slug }}" @selected(($filters['category'] ?? '') === $childCategory->slug)>
                                {{ $childCategory->name }}
                            </option>
                        @endforeach
                    @endforeach
                </select>
            </div>

            <div>
                <label for="min_price" class="mb-2 block text-sm font-medium">Цена от</label>
                <input
                    type="number"
                    step="0.01"
                    id="min_price"
                    name="min_price"
                    value="{{ $filters['min_price'] ?? '' }}"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2"
                >
            </div>

            <div>
                <label for="max_price" class="mb-2 block text-sm font-medium">Цена до</label>
                <input
                    type="number"
                    step="0.01"
                    id="max_price"
                    name="max_price"
                    value="{{ $filters['max_price'] ?? '' }}"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2"
                >
            </div>

            <div class="md:col-span-4 flex gap-3">
                <button type="submit" class="rounded-lg bg-green-600 px-4 py-2 text-white hover:bg-green-700">
                    Найти
                </button>
                <a href="{{ route('catalog.index') }}" class="rounded-lg bg-gray-200 px-4 py-2 text-gray-800 hover:bg-gray-300">
                    Сбросить
                </a>
            </div>
        </form>
    </div>

    @if($recentlyViewedProducts->count())
        <div class="mb-10">
            <h2 class="mb-4 text-2xl font-bold">Недавно просмотренные</h2>

            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach($recentlyViewedProducts as $recentProduct)
                    <div class="overflow-hidden rounded-xl bg-white shadow">
                        <div class="aspect-[4/3] bg-gray-200">
                            @if($recentProduct->image_path)
                                <img src="{{ asset('storage/'.$recentProduct->image_path) }}" alt="{{ $recentProduct->name }}" class="h-full w-full object-cover">
                            @else
                                <div class="flex h-full items-center justify-center text-gray-500">Нет изображения</div>
                            @endif
                        </div>

                        <div class="p-5">
                            <div class="mb-2 text-sm text-gray-500">{{ $recentProduct->category?->name }}</div>
                            <h3 class="text-xl font-semibold">{{ $recentProduct->name }}</h3>
                            <div class="mt-4 flex items-center justify-between">
                                <div class="text-2xl font-bold">{{ number_format((float) $recentProduct->price, 2, '.', ' ') }} ₽</div>
                                <a href="{{ route('catalog.show', $recentProduct) }}" class="rounded-lg bg-green-600 px-4 py-2 text-white hover:bg-green-700">
                                    Открыть
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if($products->count())
        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach($products as $product)
                <div class="overflow-hidden rounded-xl bg-white shadow">
                    <div class="aspect-[4/3] bg-gray-200">
                        @if($product->image_path)
                            <img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                        @else
                            <div class="flex h-full items-center justify-center text-gray-500">Нет изображения</div>
                        @endif
                    </div>

                    <div class="p-5">
                        <div class="mb-2 text-sm text-gray-500">{{ $product->category?->name }}</div>
                        <h2 class="text-xl font-semibold">{{ $product->name }}</h2>
                        <p class="mt-2 text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($product->description, 120) }}</p>

                        <div class="mt-4 flex items-center justify-between">
                            <div>
                                <div class="text-2xl font-bold">{{ number_format((float) $product->price, 2, '.', ' ') }} ₽</div>
                                <div class="text-sm text-gray-500">Остаток: {{ $product->stock }}</div>
                            </div>
                            <a href="{{ route('catalog.show', $product) }}" class="rounded-lg bg-green-600 px-4 py-2 text-white hover:bg-green-700">
                                Открыть
                            </a>
                        </div>

                        <div class="mt-3 text-sm text-gray-600">
                            Рейтинг:
                            @if($product->reviews_avg_rating)
                                {{ number_format((float) $product->reviews_avg_rating, 1) }}/5
                            @else
                                Нет оценок
                            @endif
                            · Отзывов: {{ $product->reviews_count }}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    @else
        <div class="rounded-xl bg-white p-8 text-center shadow">
            <h2 class="text-xl font-semibold">Товары не найдены</h2>
            <p class="mt-2 text-gray-600">Попробуй изменить параметры поиска.</p>
        </div>
    @endif
@endsection