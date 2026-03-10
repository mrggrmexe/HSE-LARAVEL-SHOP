@extends('layouts.app')

@section('content')
    <h1 class="mb-6 text-3xl font-bold">Мои заказы</h1>

    @if($orders->count())
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="rounded-xl bg-white p-5 shadow">
                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                        <div>
                            <div class="text-lg font-semibold">Заказ {{ $order->order_number }}</div>
                            <div class="mt-1 text-sm text-gray-500">
                                Дата: {{ $order->ordered_at?->format('d.m.Y H:i') }}
                            </div>
                            <div class="mt-1 text-sm text-gray-500">
                                Статус: {{ $order->status }}
                            </div>
                            <div class="mt-1 text-sm text-gray-500">
                                Позиции: {{ $order->items_count }}
                            </div>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="text-2xl font-bold">{{ number_format($order->total_amount, 2, '.', ' ') }} ₽</div>
                            <a href="{{ route('orders.show', $order) }}" class="rounded-lg bg-green-600 px-4 py-2 text-white hover:bg-green-700">
                                Открыть
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    @else
        <div class="rounded-xl bg-white p-8 text-center shadow">
            <h2 class="text-xl font-semibold">У тебя пока нет заказов</h2>
            <a href="{{ route('catalog.index') }}" class="mt-4 inline-block rounded-lg bg-green-600 px-4 py-2 text-white hover:bg-green-700">
                Перейти в каталог
            </a>
        </div>
    @endif
@endsection