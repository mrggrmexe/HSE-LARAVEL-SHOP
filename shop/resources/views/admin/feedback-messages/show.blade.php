@extends('layouts.app')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-3xl font-bold">Обращение</h1>
        <a href="{{ route('admin.feedback-messages.index') }}" class="rounded-lg bg-gray-200 px-4 py-2 text-gray-800 hover:bg-gray-300">
            Назад
        </a>
    </div>

    <div class="grid gap-8 lg:grid-cols-[1fr_360px]">
        <div class="rounded-xl bg-white p-6 shadow">
            <div class="space-y-3">
                <div><span class="font-semibold">Имя:</span> {{ $message->name }}</div>
                <div><span class="font-semibold">Email:</span> {{ $message->email }}</div>
                <div><span class="font-semibold">Тема:</span> {{ $message->subject }}</div>
                <div><span class="font-semibold">Дата:</span> {{ $message->created_at?->format('d.m.Y H:i') }}</div>
            </div>

            <div class="mt-6">
                <h2 class="text-xl font-semibold">Сообщение</h2>
                <p class="mt-3 whitespace-pre-line text-gray-700">{{ $message->message }}</p>
            </div>
        </div>

        <div class="rounded-xl bg-white p-6 shadow">
            <h2 class="text-xl font-semibold">Обработка</h2>

            <form method="POST" action="{{ route('admin.feedback-messages.update', $message) }}" class="mt-5 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="status" class="mb-2 block text-sm font-medium">Статус</label>
                    <select id="status" name="status" class="w-full rounded-lg border border-gray-300 px-3 py-2">
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" @selected($message->status === $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="admin_reply" class="mb-2 block text-sm font-medium">Ответ администратора</label>
                    <textarea id="admin_reply" name="admin_reply" rows="6" class="w-full rounded-lg border border-gray-300 px-3 py-2">{{ old('admin_reply', $message->admin_reply) }}</textarea>
                </div>

                <button type="submit" class="w-full rounded-lg bg-green-600 px-4 py-2 text-white hover:bg-green-700">
                    Сохранить
                </button>
            </form>
        </div>
    </div>
@endsection