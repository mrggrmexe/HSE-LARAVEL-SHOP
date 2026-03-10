@extends('layouts.app')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-3xl font-bold">Заказы</h1>
    </div>

    <div class="mb-6 rounded-xl bg-white p-6 shadow">
        <form method="GET" action="{{ route('admin.orders.index') }}" class="flex gap-3">
            <select name="status" class="w-full rounded-lg border border-gray-300 px-3 py-2">
                <option value="">Все статусы</option>
                @foreach($statuses as $status)
                    <option value="{{ $status }}" @selected($selectedStatus === $status)>{{ $status }}</option>
                @endforeach
            </select>

            <button type="submit" class="rounded-lg bg-green-600 px-4 py-2 text-white hover:bg-green-700">
                Фильтр
            </button>
        </form>
    </div>

    <div class="rounded-xl bg-white p-6 shadow">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead>
                    <tr class="border-b">
                        <th class="px-4 py-3">Номер</th>
                        <th class="px-4 py-3">Покупатель</th>
                        <th class="px-4 py-3">Статус</th>
                        <th class="px-4 py-3">Позиции</th>
                        <th class="px-4 py-3">Дата</th>
                        <th class="px-4 py-3">Сумма</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="border-b">
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-green-700 hover:text-green-800">
                                    {{ $order->order_number }}
                                </a>
                            </td>
                            <td class="px-4 py-3">{{ $order->user?->name }}</td>
                            <td class="px-4 py-3">{{ $order->status }}</td>
                            <td class="px-4 py-3">{{ $order->items_count }}</td>
                            <td class="px-4 py-3">{{ $order->ordered_at?->format('d.m.Y H:i') }}</td>
                            <td class="px-4 py-3">{{ number_format($order->total_amount, 2, '.', ' ') }} ₽</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    </div>
@endsection