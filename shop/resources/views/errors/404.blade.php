@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-2xl rounded-xl bg-white p-10 text-center shadow">
        <div class="text-6xl font-bold text-gray-700">404</div>
        <h1 class="mt-4 text-3xl font-bold">Страница не найдена</h1>
        <p class="mt-3 text-gray-600">Возможно, ссылка устарела или такой страницы больше нет.</p>
        <a href="{{ route('home') }}" class="mt-6 inline-block rounded-lg bg-green-600 px-5 py-2 text-white hover:bg-green-700">
            На главную
        </a>
    </div>
@endsection