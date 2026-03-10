@extends('layouts.app')

@section('content')
    <div class="mb-6">
        <h1 class="text-3xl font-bold">Панель администратора</h1>
        <p class="mt-2 text-gray-600">Управление пользователями, товарами, заказами и обращениями</p>
    </div>

    <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-5">
        <div class="rounded-xl bg-white p-5 shadow">
            <div class="text-sm text-gray-500">Пользователи</div>
            <div class="mt-2 text-3xl font-bold">{{ $stats['users_count'] }}</div>
        </div>
        <div class="rounded-xl bg-white p-5 shadow">
            <div class="text-sm text-gray-500">Товары</div>
            <div class="mt-2 text-3xl font-bold">{{ $stats['products_count'] }}</div>
        </div>
        <div class="rounded-xl bg-white p-5 shadow">
            <div class="text-sm text-gray-500">Категории</div>
            <div class="mt-2 text-3xl font-bold">{{ $stats['categories_count'] }}</div>
        </div>
        <div class="rounded-xl bg-white p-5 shadow">
            <div class="text-sm text-gray-500">Заказы</div>
            <div class="mt-2 text-3xl font-bold">{{ $stats['orders_count'] }}</div>
        </div>
        <div class="rounded-xl bg-white p-5 shadow">
            <div class="text-sm text-gray-500">Новые обращения</div>
            <div class="mt-2 text-3xl font-bold">{{ $stats['new_feedback_count'] }}</div>
        </div>
    </div>

    <div class="mt-8 grid gap-4 md:grid-cols-2 xl:grid-cols-5">
        <a href="{{ route('admin.users.index') }}" class="rounded-xl bg-white p-5 shadow hover:shadow-md">Пользователи</a>
        <a href="{{ route('admin.categories.index') }}" class="rounded-xl bg-white p-5 shadow hover:shadow-md">Категории</a>
        <a href="{{ route('admin.products.index') }}" class="rounded-xl bg-white p-5 shadow hover:shadow-md">Товары</a>
        <a href="{{ route('admin.orders.index') }}" class="rounded-xl bg-white p-5 shadow hover:shadow-md">Заказы</a>
        <a href="{{ route('admin.feedback-messages.index') }}" class="rounded-xl bg-white p-5 shadow hover:shadow-md">Обращения</a>
    </div>

    <div class="mt-10 rounded-xl bg-white p-6 shadow">
        <h2 class="text-2xl font-bold">Последние заказы</h2>

        <div class="mt-6 overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead>
                    <tr class="border-b">
                        <th class="px-4 py-3">Номер</th>
                        <th class="px-4 py-3">Покупатель</th>
                        <th class="px-4 py-3">Статус</th>
                        <th class="px-4 py-3">Дата</th>
                        <th class="px-4 py-3">Сумма</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentOrders as $order)
                        <tr class="border-b">
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-green-700 hover:text-green-800">
                                    {{ $order->order_number }}
                                </a>
                            </td>
                            <td class="px-4 py-3">{{ $order->user?->name }}</td>
                            <td class="px-4 py-3">{{ $order->status }}</td>
                            <td class="px-4 py-3">{{ $order->ordered_at?->format('d.m.Y H:i') }}</td>
                            <td class="px-4 py-3">{{ number_format($order->total_amount, 2, '.', ' ') }} ₽</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection