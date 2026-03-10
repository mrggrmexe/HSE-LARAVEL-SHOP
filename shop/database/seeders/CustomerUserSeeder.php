<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class CustomerUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'buyer1@example.com'],
            [
                'name' => 'Иван Покупатель',
                'password' => 'password',
                'role' => User::ROLE_CUSTOMER,
            ]
        );

        User::updateOrCreate(
            ['email' => 'buyer2@example.com'],
            [
                'name' => 'Мария Покупатель',
                'password' => 'password',
                'role' => User::ROLE_CUSTOMER,
            ]
        );
    }
}