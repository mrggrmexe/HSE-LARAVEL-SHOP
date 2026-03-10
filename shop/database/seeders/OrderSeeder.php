<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $customers = User::query()
            ->where('role', User::ROLE_CUSTOMER)
            ->orderBy('id')
            ->get();

        if ($customers->isEmpty()) {
            return;
        }

        $catalog = Product::query()->pluck('id', 'slug');

        $orders = [
            [
                'order_number' => 'FRUIT-1001',
                'user_id' => $customers[0]->id,
                'status' => Order::STATUS_PENDING,
                'ordered_at' => now()->subDays(3),
                'items' => [
                    ['slug' => 'apple', 'quantity' => 3],
                    ['slug' => 'banana', 'quantity' => 2],
                    ['slug' => 'orange', 'quantity' => 4],
                ],
            ],
            [
                'order_number' => 'FRUIT-1002',
                'user_id' => $customers[0]->id,
                'status' => Order::STATUS_COMPLETED,
                'ordered_at' => now()->subDays(7),
                'items' => [
                    ['slug' => 'mango', 'quantity' => 1],
                    ['slug' => 'kiwi', 'quantity' => 5],
                ],
            ],
            [
                'order_number' => 'FRUIT-1003',
                'user_id' => $customers[1]->id ?? $customers[0]->id,
                'status' => Order::STATUS_PAID,
                'ordered_at' => now()->subDays(1),
                'items' => [
                    ['slug' => 'strawberry', 'quantity' => 2],
                    ['slug' => 'pear', 'quantity' => 3],
                ],
            ],
        ];

        foreach ($orders as $orderData) {
            $order = Order::updateOrCreate(
                ['order_number' => $orderData['order_number']],
                [
                    'user_id' => $orderData['user_id'],
                    'status' => $orderData['status'],
                    'ordered_at' => $orderData['ordered_at'],
                    'total_amount' => 0,
                ]
            );

            $total = 0;

            foreach ($orderData['items'] as $itemData) {
                $productId = $catalog[$itemData['slug']] ?? null;

                if (! $productId) {
                    continue;
                }

                $product = Product::find($productId);

                $lineTotal = round((float) $product->price * $itemData['quantity'], 2);

                OrderItem::updateOrCreate(
                    [
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                    ],
                    [
                        'product_name' => $product->name,
                        'quantity' => $itemData['quantity'],
                        'unit_price' => $product->price,
                        'line_total' => $lineTotal,
                    ]
                );

                $total += $lineTotal;
            }

            $order->update([
                'total_amount' => number_format($total, 2, '.', ''),
            ]);
        }
    }
}