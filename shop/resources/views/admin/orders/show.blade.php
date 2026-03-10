@extends('layouts.app')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-3xl font-bold">Заказ {{ $order->order_number }}</h1>
        <a href="{{ route('admin.orders.index') }}" class="rounded-lg bg-gray-200 px-4 py-2 text-gray-800 hover:bg-gray-300">
            Назад
        </a>
    </div>

    <div class="grid gap-8 lg:grid-cols-[1fr_340px]">
        <div class="rounded-xl bg-white p-6 shadow">
            <h2 class="text-2xl font-bold">Позиции заказа</h2>

            <div class="mt-6 space-y-4">
                @foreach($order->items as $item)
                    <div class="flex items-center justify-between border-b pb-4">
                        <div>
                            <div class="font-medium">{{ $item->product_name }}</div>
                            <div class="text-sm text-gray-500">{{ $item->quantity }} × {{ number_format($item->unit_price, 2, '.', ' ') }} ₽</div>
                        </div>
                        <div class="font-semibold">{{ number_format($item->line_total, 2, '.', ' ') }} ₽</div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-xl bg-white p-6 shadow">
                <h2 class="text-xl font-semibold">Покупатель</h2>
                <div class="mt-4 space-y-2 text-sm">
                    <div>{{ $order->user?->name }}</div>
                    <div>{{ $order->user?->email }}</div>
                    <div>{{ $order->ordered_at?->format('d.m.Y H:i') }}</div>
                    <div class="text-lg font-bold">{{ number_format($order->total_amount, 2, '.', ' ') }} ₽</div>
                </div>
            </div>

            <div class="rounded-xl bg-white p-6 shadow">
                <h2 class="text-xl font-semibold">Статус заказа</h2>

                <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="mt-5 space-y-4">
                    @csrf
                    @method('PUT')

                    <select name="status" class="w-full rounded-lg border border-gray-300 px-3 py-2">
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" @selected($order->status === $status)>{{ $status }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="w-full rounded-lg bg-green-600 px-4 py-2 text-white hover:bg-green-700">
                        Обновить статус
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection