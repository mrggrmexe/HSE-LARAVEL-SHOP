@extends('layouts.app')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-3xl font-bold">Корзина</h1>

        @if($cartCount > 0)
            <form method="POST" action="{{ route('cart.clear') }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="rounded-lg bg-red-600 px-4 py-2 text-white hover:bg-red-700">
                    Очистить корзину
                </button>
            </form>
        @endif
    </div>

    @if($cartCount > 0)
        <div class="space-y-4">
            @foreach($cart as $item)
                <div class="rounded-xl bg-white p-5 shadow">
                    <div class="grid gap-4 md:grid-cols-[120px_1fr_auto] md:items-center">
                        <div class="h-28 w-28 overflow-hidden rounded-lg bg-gray-200">
                            @if($item['image_path'])
                                <img src="{{ asset('storage/'.$item['image_path']) }}" alt="{{ $item['name'] }}" class="h-full w-full object-cover">
                            @endif
                        </div>

                        <div>
                            <div class="text-xl font-semibold">{{ $item['name'] }}</div>
                            <div class="mt-2 text-gray-600">Цена: {{ number_format($item['price'], 2, '.', ' ') }} ₽</div>
                            <div class="text-gray-600">Количество: {{ $item['quantity'] }}</div>
                            <div class="text-gray-600">Сумма: {{ number_format($item['price'] * $item['quantity'], 2, '.', ' ') }} ₽</div>
                        </div>

                        <div class="space-y-3">
                            <form method="POST" action="{{ route('cart.update', $item['slug']) }}" class="flex items-center gap-2">
                                @csrf
                                @method('PATCH')
                                <input
                                    type="number"
                                    name="quantity"
                                    value="{{ $item['quantity'] }}"
                                    min="1"
                                    max="{{ $item['stock'] }}"
                                    class="w-24 rounded-lg border border-gray-300 px-3 py-2"
                                >
                                <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
                                    Обновить
                                </button>
                            </form>

                            <form method="POST" action="{{ route('cart.destroy', $item['slug']) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-lg bg-red-600 px-4 py-2 text-white hover:bg-red-700">
                                    Удалить
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8 rounded-xl bg-white p-6 shadow">
            <div class="flex items-center justify-between">
                <div>
                    <div class="text-lg font-semibold">Итого товаров: {{ $cartCount }}</div>
                    <div class="mt-2 text-3xl font-bold">{{ number_format($cartTotal, 2, '.', ' ') }} ₽</div>
                </div>

                <a href="{{ route('orders.checkout') }}" class="rounded-lg bg-green-600 px-5 py-3 text-white hover:bg-green-700">
                    Перейти к оформлению
                </a>
            </div>
        </div>
    @else
        <div class="rounded-xl bg-white p-8 text-center shadow">
            <h2 class="text-xl font-semibold">Корзина пуста</h2>
            <p class="mt-2 text-gray-600">Добавь товары из каталога, чтобы оформить заказ.</p>
            <a href="{{ route('catalog.index') }}" class="mt-4 inline-block rounded-lg bg-green-600 px-4 py-2 text-white hover:bg-green-700">
                Перейти в каталог
            </a>
        </div>
    @endif
@endsection