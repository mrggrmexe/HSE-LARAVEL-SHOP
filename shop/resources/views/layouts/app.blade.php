<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Fruit Shop' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-100 text-gray-900">
    <header class="border-b bg-white">
        <div class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4">
            <a href="{{ route('home') }}" class="text-2xl font-bold">Fruit Shop</a>

            <nav class="flex items-center gap-4 text-sm">
                <a href="{{ route('catalog.index') }}" class="hover:text-green-700">Каталог</a>
                <a href="{{ route('feedback.create') }}" class="hover:text-green-700">Обратная связь</a>

                @auth
                    @if(auth()->user()->isCustomer())
                        <a href="{{ route('cart.index') }}" class="hover:text-green-700">Корзина</a>
                        <a href="{{ route('orders.index') }}" class="hover:text-green-700">Мои заказы</a>
                    @endif

                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-green-700">Дашборд</a>
                    @endif

                    <span class="text-gray-500">{{ auth()->user()->name }}</span>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rounded bg-red-600 px-3 py-2 text-white hover:bg-red-700">
                            Выйти
                        </button>
                    </form>
                @endauth

                @guest
                    <a href="{{ route('login') }}" class="hover:text-green-700">Войти</a>
                    <a href="{{ route('register') }}" class="rounded bg-green-600 px-3 py-2 text-white hover:bg-green-700">
                        Регистрация
                    </a>
                @endguest
            </nav>
        </div>
    </header>

    <main class="mx-auto max-w-7xl px-4 py-6">
        @if(session('status'))
            <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-800">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-800">
                <ul class="space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{ $slot ?? '' }}
        @yield('content')
    </main>
</body>
</html>