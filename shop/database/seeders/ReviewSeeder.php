<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $buyers = User::query()
            ->where('role', User::ROLE_CUSTOMER)
            ->orderBy('id')
            ->get();

        if ($buyers->isEmpty()) {
            return;
        }

        $products = Product::query()->pluck('id', 'slug');

        $reviews = [
            [
                'user_id' => $buyers[0]->id,
                'product_slug' => 'apple',
                'rating' => 5,
                'comment' => 'Очень свежее и хрустящее яблоко.',
            ],
            [
                'user_id' => $buyers[0]->id,
                'product_slug' => 'mango',
                'rating' => 4,
                'comment' => 'Манго вкусное, но хотелось бы чуть мягче.',
            ],
            [
                'user_id' => $buyers[1]->id ?? $buyers[0]->id,
                'product_slug' => 'strawberry',
                'rating' => 5,
                'comment' => 'Клубника сладкая и ароматная.',
            ],
        ];

        foreach ($reviews as $data) {
            $productId = $products[$data['product_slug']] ?? null;

            if (! $productId) {
                continue;
            }

            Review::updateOrCreate(
                [
                    'user_id' => $data['user_id'],
                    'product_id' => $productId,
                ],
                [
                    'rating' => $data['rating'],
                    'comment' => $data['comment'],
                ]
            );
        }
    }
}