@extends('layouts.app')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-3xl font-bold">Заказ {{ $order->order_number }}</h1>
        <a href="{{ route('orders.index') }}" class="rounded-lg bg-gray-200 px-4 py-2 text-gray-800 hover:bg-gray-300">
            Назад
        </a>
    </div>

    <div class="grid gap-8 lg:grid-cols-[1fr_320px]">
        <div class="rounded-xl bg-white p-6 shadow">
            <h2 class="text-xl font-semibold">Позиции заказа</h2>

            <div class="mt-6 space-y-4">
                @foreach($order->items as $item)
                    <div class="flex items-center justify-between border-b pb-4">
                        <div>
                            <div class="font-medium">{{ $item->product_name }}</div>
                            <div class="text-sm text-gray-500">{{ $item->quantity }} × {{ number_format($item->unit_price, 2, '.', ' ') }} ₽</div>
                        </div>
                        <div class="font-semibold">
                            {{ number_format($item->line_total, 2, '.', ' ') }} ₽
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="rounded-xl bg-white p-6 shadow">
            <h2 class="text-xl font-semibold">Информация</h2>

            <div class="mt-6 space-y-3 text-sm">
                <div class="flex justify-between">
                    <span>Статус</span>
                    <span>{{ $order->status }}</span>
                </div>
                <div class="flex justify-between">
                    <span>Дата</span>
                    <span>{{ $order->ordered_at?->format('d.m.Y H:i') }}</span>
                </div>
                <div class="flex justify-between font-bold text-lg">
                    <span>Итого</span>
                    <span>{{ number_format($order->total_amount, 2, '.', ' ') }} ₽</span>
                </div>
            </div>
        </div>
    </div>
@endsection