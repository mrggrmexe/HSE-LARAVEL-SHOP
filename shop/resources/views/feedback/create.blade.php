@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-3xl rounded-xl bg-white p-6 shadow">
        <h1 class="text-3xl font-bold">Форма обратной связи</h1>
        <p class="mt-2 text-gray-600">Администратор получит твое сообщение в панели управления.</p>

        <form method="POST" action="{{ route('feedback.store') }}" class="mt-8 space-y-5">
            @csrf

            <div>
                <label for="name" class="mb-2 block text-sm font-medium">Имя</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', auth()->user()->name ?? '') }}"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2"
                >
            </div>

            <div>
                <label for="email" class="mb-2 block text-sm font-medium">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', auth()->user()->email ?? '') }}"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2"
                >
            </div>

            <div>
                <label for="subject" class="mb-2 block text-sm font-medium">Тема</label>
                <input
                    type="text"
                    id="subject"
                    name="subject"
                    value="{{ old('subject') }}"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2"
                >
            </div>

            <div>
                <label for="message" class="mb-2 block text-sm font-medium">Сообщение</label>
                <textarea
                    id="message"
                    name="message"
                    rows="6"
                    class="w-full rounded-lg border border-gray-300 px-3 py-2"
                >{{ old('message') }}</textarea>
            </div>

            <div>
                <button type="submit" class="rounded-lg bg-green-600 px-5 py-2 text-white hover:bg-green-700">
                    Отправить
                </button>
            </div>
        </form>
    </div>
@endsection