@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-3xl rounded-xl bg-white p-6 shadow">
        <h1 class="text-3xl font-bold">Новая категория</h1>

        <form method="POST" action="{{ route('admin.categories.store') }}" class="mt-8 space-y-5">
            @csrf

            <div>
                <label for="name" class="mb-2 block text-sm font-medium">Название</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="w-full rounded-lg border border-gray-300 px-3 py-2">
            </div>

            <div>
                <label for="slug" class="mb-2 block text-sm font-medium">Slug</label>
                <input type="text" id="slug" name="slug" value="{{ old('slug') }}" class="w-full rounded-lg border border-gray-300 px-3 py-2">
            </div>

            <div>
                <label for="parent_id" class="mb-2 block text-sm font-medium">Родительская категория</label>
                <select id="parent_id" name="parent_id" class="w-full rounded-lg border border-gray-300 px-3 py-2">
                    <option value="">Без родителя</option>
                    @foreach($parents as $parent)
                        <option value="{{ $parent->id }}" @selected((string) old('parent_id') === (string) $parent->id)>{{ $parent->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="description" class="mb-2 block text-sm font-medium">Описание</label>
                <textarea id="description" name="description" rows="4" class="w-full rounded-lg border border-gray-300 px-3 py-2">{{ old('description') }}</textarea>
            </div>

            <div class="flex gap-3">
                <button type="submit" class="rounded-lg bg-green-600 px-5 py-2 text-white hover:bg-green-700">
                    Сохранить
                </button>
                <a href="{{ route('admin.categories.index') }}" class="rounded-lg bg-gray-200 px-5 py-2 text-gray-800 hover:bg-gray-300">
                    Назад
                </a>
            </div>
        </form>
    </div>
@endsection