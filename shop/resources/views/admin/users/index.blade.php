@extends('layouts.app')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h1 class="text-3xl font-bold">Пользователи</h1>
    </div>

    <div class="mb-6 rounded-xl bg-white p-6 shadow">
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex gap-3">
            <input
                type="text"
                name="search"
                value="{{ $search }}"
                placeholder="Поиск по имени или email"
                class="w-full rounded-lg border border-gray-300 px-3 py-2"
            >
            <button type="submit" class="rounded-lg bg-green-600 px-4 py-2 text-white hover:bg-green-700">
                Найти
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
                        <th class="px-4 py-3">Роль</th>
                        <th class="px-4 py-3">Создан</th>
                        <th class="px-4 py-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr class="border-b">
                            <td class="px-4 py-3">{{ $user->name }}</td>
                            <td class="px-4 py-3">{{ $user->email }}</td>
                            <td class="px-4 py-3">{{ $user->role }}</td>
                            <td class="px-4 py-3">{{ $user->created_at?->format('d.m.Y H:i') }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.users.edit', $user) }}" class="text-green-700 hover:text-green-800">
                                    Изменить
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $users->links() }}
        </div>
    </div>
@endsection