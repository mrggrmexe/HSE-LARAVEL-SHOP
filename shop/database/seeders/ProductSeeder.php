<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categoryIds = Category::query()->pluck('id', 'slug');

        $products = [
            [
                'name' => 'Апельсин',
                'slug' => 'orange',
                'description' => 'Сочный сладкий апельсин',
                'price' => 129.90,
                'stock' => 120,
                'category_slug' => 'citrus',
                'image_path' => 'products/orange.jpg',
            ],
            [
                'name' => 'Лимон',
                'slug' => 'lemon',
                'description' => 'Свежий лимон с ярким вкусом',
                'price' => 99.90,
                'stock' => 90,
                'category_slug' => 'citrus',
                'image_path' => 'products/lemon.jpg',
            ],
            [
                'name' => 'Мандарин',
                'slug' => 'mandarin',
                'description' => 'Сладкий мандарин без косточек',
                'price' => 149.90,
                'stock' => 100,
                'category_slug' => 'citrus',
                'image_path' => 'products/mandarin.jpg',
            ],
            [
                'name' => 'Банан',
                'slug' => 'banana',
                'description' => 'Спелый банан',
                'price' => 119.90,
                'stock' => 140,
                'category_slug' => 'tropical',
                'image_path' => 'products/banana.jpg',
            ],
            [
                'name' => 'Манго',
                'slug' => 'mango',
                'description' => 'Ароматное манго премиум',
                'price' => 279.90,
                'stock' => 45,
                'category_slug' => 'tropical',
                'image_path' => 'products/mango.jpg',
            ],
            [
                'name' => 'Ананас',
                'slug' => 'pineapple',
                'description' => 'Сладкий ананас',
                'price' => 349.90,
                'stock' => 30,
                'category_slug' => 'tropical',
                'image_path' => 'products/pineapple.jpg',
            ],
            [
                'name' => 'Клубника',
                'slug' => 'strawberry',
                'description' => 'Свежая клубника',
                'price' => 259.90,
                'stock' => 60,
                'category_slug' => 'berries',
                'image_path' => 'products/strawberry.jpg',
            ],
            [
                'name' => 'Голубика',
                'slug' => 'blueberry',
                'description' => 'Отборная голубика',
                'price' => 319.90,
                'stock' => 35,
                'category_slug' => 'berries',
                'image_path' => 'products/blueberry.jpg',
            ],
            [
                'name' => 'Малина',
                'slug' => 'raspberry',
                'description' => 'Свежая малина',
                'price' => 299.90,
                'stock' => 40,
                'category_slug' => 'berries',
                'image_path' => 'products/raspberry.jpg',
            ],
            [
                'name' => 'Яблоко',
                'slug' => 'apple',
                'description' => 'Хрустящее яблоко',
                'price' => 89.90,
                'stock' => 200,
                'category_slug' => 'pome',
                'image_path' => 'products/apple.jpg',
            ],
            [
                'name' => 'Груша',
                'slug' => 'pear',
                'description' => 'Сочная груша',
                'price' => 109.90,
                'stock' => 110,
                'category_slug' => 'pome',
                'image_path' => 'products/pear.jpg',
            ],
            [
                'name' => 'Айва',
                'slug' => 'quince',
                'description' => 'Ароматная айва',
                'price' => 139.90,
                'stock' => 50,
                'category_slug' => 'pome',
                'image_path' => 'products/quince.jpg',
            ],
            [
                'name' => 'Персик',
                'slug' => 'peach',
                'description' => 'Нежный спелый персик',
                'price' => 179.90,
                'stock' => 75,
                'category_slug' => 'stone-fruits',
                'image_path' => 'products/peach.jpg',
            ],
            [
                'name' => 'Слива',
                'slug' => 'plum',
                'description' => 'Сладкая слива',
                'price' => 159.90,
                'stock' => 80,
                'category_slug' => 'stone-fruits',
                'image_path' => 'products/plum.jpg',
            ],
            [
                'name' => 'Абрикос',
                'slug' => 'apricot',
                'description' => 'Солнечный абрикос',
                'price' => 189.90,
                'stock' => 70,
                'category_slug' => 'stone-fruits',
                'image_path' => 'products/apricot.jpg',
            ],
            [
                'name' => 'Драгонфрут',
                'slug' => 'dragonfruit',
                'description' => 'Экзотический драгонфрут',
                'price' => 399.90,
                'stock' => 20,
                'category_slug' => 'exotic',
                'image_path' => 'products/dragonfruit.jpg',
            ],
            [
                'name' => 'Маракуйя',
                'slug' => 'passion-fruit',
                'description' => 'Кисло-сладкая маракуйя',
                'price' => 359.90,
                'stock' => 25,
                'category_slug' => 'exotic',
                'image_path' => 'products/passion-fruit.jpg',
            ],
            [
                'name' => 'Киви',
                'slug' => 'kiwi',
                'description' => 'Свежий киви',
                'price' => 149.90,
                'stock' => 95,
                'category_slug' => 'exotic',
                'image_path' => 'products/kiwi.jpg',
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['slug' => $product['slug']],
                [
                    'name' => $product['name'],
                    'description' => $product['description'],
                    'price' => $product['price'],
                    'stock' => $product['stock'],
                    'category_id' => $categoryIds[$product['category_slug']] ?? null,
                    'image_path' => $product['image_path'],
                    'is_active' => true,
                ]
            );
        }
    }
}