@extends('layouts.app')

@section('content')
    <h1 class="mb-6 text-3xl font-bold">Оформление заказа</h1>

    <div class="grid gap-8 lg:grid-cols-[1fr_360px]">
        <div class="rounded-xl bg-white p-6 shadow">
            <h2 class="text-xl font-semibold">Состав заказа</h2>

            <div class="mt-6 space-y-4">
                @foreach($cart as $item)
                    <div class="flex items-center justify-between border-b pb-4">
                        <div>
                            <div class="font-medium">{{ $item['name'] }}</div>
                            <div class="text-sm text-gray-500">{{ $item['quantity'] }} × {{ number_format($item['price'], 2, '.', ' ') }} ₽</div>
                        </div>
                        <div class="font-semibold">
                            {{ number_format($item['price'] * $item['quantity'], 2, '.', ' ') }} ₽
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="rounded-xl bg-white p-6 shadow">
            <h2 class="text-xl font-semibold">Подтверждение</h2>

            <div class="mt-6 space-y-3">
                <div class="flex justify-between">
                    <span>Количество товаров</span>
                    <span>{{ $cartCount }}</span>
                </div>
                <div class="flex justify-between text-xl font-bold">
                    <span>Итого</span>
                    <span>{{ number_format($cartTotal, 2, '.', ' ') }} ₽</span>
                </div>
            </div>

            <form method="POST" action="{{ route('orders.store') }}" class="mt-6">
                @csrf
                <button type="submit" class="w-full rounded-lg bg-green-600 px-4 py-3 text-white hover:bg-green-700">
                    Подтвердить заказ
                </button>
            </form>
        </div>
    </div>
@endsection