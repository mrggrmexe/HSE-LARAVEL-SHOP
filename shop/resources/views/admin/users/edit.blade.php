@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-3xl rounded-xl bg-white p-6 shadow">
        <h1 class="text-3xl font-bold">Редактирование пользователя</h1>

        <form method="POST" action="{{ route('admin.users.update', $user) }}" class="mt-8 space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="mb-2 block text-sm font-medium">Имя</label>
                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-lg border border-gray-300 px-3 py-2">
            </div>

            <div>
                <label for="email" class="mb-2 block text-sm font-medium">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="w-full rounded-lg border border-gray-300 px-3 py-2">
            </div>

            <div>
                <label for="role" class="mb-2 block text-sm font-medium">Роль</label>
                <select id="role" name="role" class="w-full rounded-lg border border-gray-300 px-3 py-2">
                    @foreach($roles as $role)
                        <option value="{{ $role }}" @selected(old('role', $user->role) === $role)>{{ $role }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="rounded-lg bg-green-600 px-5 py-2 text-white hover:bg-green-700">
                    Сохранить
                </button>
                <a href="{{ route('admin.users.index') }}" class="rounded-lg bg-gray-200 px-5 py-2 text-gray-800 hover:bg-gray-300">
                    Назад
                </a>
            </div>
        </form>
    </div>
@endsection