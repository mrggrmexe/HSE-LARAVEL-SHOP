@extends('layouts.app')

@section('content')
    <div class="grid gap-8 lg:grid-cols-2">
        <div class="overflow-hidden rounded-xl bg-white shadow">
            <div class="aspect-square bg-gray-200">
                @if($product->image_path)
                    <img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                @else
                    <div class="flex h-full items-center justify-center text-gray-500">Нет изображения</div>
                @endif
            </div>
        </div>

        <div class="rounded-xl bg-white p-6 shadow">
            <div class="text-sm text-gray-500">{{ $product->category?->name }}</div>
            <h1 class="mt-2 text-3xl font-bold">{{ $product->name }}</h1>

            <div class="mt-4 text-3xl font-bold">{{ number_format($product->price, 2, '.', ' ') }} ₽</div>
            <div class="mt-2 text-sm text-gray-500">Остаток на складе: {{ $product->stock }}</div>

            <div class="mt-4 text-sm text-gray-700">
                Рейтинг:
                @if($product->reviews_avg_rating)
                    {{ number_format($product->reviews_avg_rating, 1) }}/5
                @else
                    Нет оценок
                @endif
            </div>

            <p class="mt-6 whitespace-pre-line text-gray-700">{{ $product->description }}</p>

            @auth
                @if(auth()->user()->isCustomer())
                    <form method="POST" action="{{ route('cart.store', $product) }}" class="mt-8 flex items-end gap-3">
                        @csrf
                        <div>
                            <label for="quantity" class="mb-2 block text-sm font-medium">Количество</label>
                            <input
                                type="number"
                                id="quantity"
                                name="quantity"
                                value="1"
                                min="1"
                                max="{{ $product->stock }}"
                                class="w-28 rounded-lg border border-gray-300 px-3 py-2"
                            >
                        </div>

                        <button type="submit" class="rounded-lg bg-green-600 px-5 py-2 text-white hover:bg-green-700">
                            В корзину
                        </button>
                    </form>
                @endif
            @else
                <div class="mt-8 rounded-lg border border-yellow-200 bg-yellow-50 px-4 py-3 text-yellow-800">
                    Чтобы оформить заказ, нужно войти в аккаунт.
                </div>
            @endauth
        </div>
    </div>

    <div class="mt-10 rounded-xl bg-white p-6 shadow">
        <h2 class="text-2xl font-bold">Отзывы</h2>

        @auth
            @if(auth()->user()->isCustomer())
                <form method="POST" action="{{ route('reviews.store', $product) }}" class="mt-6 grid gap-4">
                    @csrf

                    <div>
                        <label for="rating" class="mb-2 block text-sm font-medium">Оценка</label>
                        <select id="rating" name="rating" class="w-full rounded-lg border border-gray-300 px-3 py-2">
                            <option value="">Выберите оценку</option>
                            @for($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div>
                        <label for="comment" class="mb-2 block text-sm font-medium">Комментарий</label>
                        <textarea id="comment" name="comment" rows="4" class="w-full rounded-lg border border-gray-300 px-3 py-2"></textarea>
                    </div>

                    <div>
                        <button type="submit" class="rounded-lg bg-green-600 px-4 py-2 text-white hover:bg-green-700">
                            Сохранить отзыв
                        </button>
                    </div>
                </form>
            @endif
        @endauth

        <div class="mt-8 space-y-4">
            @forelse($product->reviews as $review)
                <div class="rounded-lg border border-gray-200 p-4">
                    <div class="flex items-center justify-between">
                        <div class="font-semibold">{{ $review->user?->name }}</div>
                        <div class="text-sm text-gray-500">{{ $review->created_at?->format('d.m.Y H:i') }}</div>
                    </div>

                    <div class="mt-2 text-sm text-gray-700">Оценка: {{ $review->rating }}/5</div>

                    @if($review->comment)
                        <p class="mt-3 text-gray-700">{{ $review->comment }}</p>
                    @endif

                    @auth
                        @if(auth()->id() === $review->user_id || auth()->user()->isAdmin())
                            <form method="POST" action="{{ route('reviews.destroy', $review) }}" class="mt-4">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600 hover:text-red-700">
                                    Удалить отзыв
                                </button>
                            </form>
                        @endif
                    @endauth
                </div>
            @empty
                <div class="text-gray-600">Пока нет отзывов.</div>
            @endforelse
        </div>
    </div>

    @if($relatedProducts->count())
        <div class="mt-10">
            <h2 class="mb-4 text-2xl font-bold">Похожие товары</h2>
            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                @foreach($relatedProducts as $relatedProduct)
                    <a href="{{ route('catalog.show', $relatedProduct) }}" class="overflow-hidden rounded-xl bg-white shadow hover:shadow-md">
                        <div class="aspect-[4/3] bg-gray-200">
                            @if($relatedProduct->image_path)
                                <img src="{{ asset('storage/'.$relatedProduct->image_path) }}" alt="{{ $relatedProduct->name }}" class="h-full w-full object-cover">
                            @endif
                        </div>
                        <div class="p-4">
                            <div class="font-semibold">{{ $relatedProduct->name }}</div>
                            <div class="mt-2 text-green-700">{{ number_format($relatedProduct->price, 2, '.', ' ') }} ₽</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif
@endsection