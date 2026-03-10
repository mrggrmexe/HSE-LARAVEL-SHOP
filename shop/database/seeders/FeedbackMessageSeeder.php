<?php

namespace Database\Seeders;

use App\Models\FeedbackMessage;
use App\Models\User;
use Illuminate\Database\Seeder;

class FeedbackMessageSeeder extends Seeder
{
    public function run(): void
    {
        $buyer = User::query()->where('role', User::ROLE_CUSTOMER)->first();

        FeedbackMessage::updateOrCreate(
            ['email' => 'guest@example.com', 'subject' => 'Есть ли доставка сегодня?'],
            [
                'user_id' => null,
                'name' => 'Гость',
                'message' => 'Подскажите, доступна ли доставка фруктов сегодня вечером?',
                'status' => FeedbackMessage::STATUS_NEW,
                'admin_reply' => null,
            ]
        );

        FeedbackMessage::updateOrCreate(
            ['email' => 'buyer1@example.com', 'subject' => 'Вопрос по заказу'],
            [
                'user_id' => $buyer?->id,
                'name' => $buyer?->name ?? 'Покупатель',
                'message' => 'Можно ли изменить состав уже оформленного заказа?',
                'status' => FeedbackMessage::STATUS_IN_PROGRESS,
                'admin_reply' => null,
            ]
        );
    }
}