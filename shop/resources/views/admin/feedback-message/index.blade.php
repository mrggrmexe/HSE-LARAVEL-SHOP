@extends('layouts.app')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-3xl font-bold">Обращения</h1>
    </div>

    <div class="mb-6 rounded-xl bg-white p-6 shadow">
        <form method="GET" action="{{ route('admin.feedback-messages.index') }}" class="flex gap-3">
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
                        <th class="px-4 py-3">Имя</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Тема</th>
                        <th class="px-4 py-3">Статус</th>
                        <th class="px-4 py-3">Дата</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($messages as $message)
                        <tr class="border-b">
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.feedback-messages.show', $message) }}" class="text-green-700 hover:text-green-800">
                                    {{ $message->name }}
                                </a>
                            </td>
                            <td class="px-4 py-3">{{ $message->email }}</td>
                            <td class="px-4 py-3">{{ $message->subject }}</td>
                            <td class="px-4 py-3">{{ $message->status }}</td>
                            <td class="px-4 py-3">{{ $message->created_at?->format('d.m.Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $messages->links() }}
        </div>
    </div>
@endsection