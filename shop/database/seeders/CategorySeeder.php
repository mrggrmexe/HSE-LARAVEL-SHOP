<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $root = Category::updateOrCreate(
            ['slug' => 'fruits'],
            [
                'name' => 'Фрукты',
                'description' => 'Основная категория фруктов',
                'parent_id' => null,
            ]
        );

        $categories = [
            [
                'name' => 'Цитрусовые',
                'slug' => 'citrus',
                'description' => 'Апельсины, лимоны, лаймы, мандарины',
            ],
            [
                'name' => 'Тропические',
                'slug' => 'tropical',
                'description' => 'Бананы, манго, ананасы, папайя',
            ],
            [
                'name' => 'Ягоды',
                'slug' => 'berries',
                'description' => 'Клубника, малина, голубика',
            ],
            [
                'name' => 'Семечковые',
                'slug' => 'pome',
                'description' => 'Яблоки, груши, айва',
            ],
            [
                'name' => 'Косточковые',
                'slug' => 'stone-fruits',
                'description' => 'Персики, сливы, абрикосы',
            ],
            [
                'name' => 'Экзотические',
                'slug' => 'exotic',
                'description' => 'Драгонфрут, маракуйя, кивано',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                [
                    'name' => $category['name'],
                    'description' => $category['description'],
                    'parent_id' => $root->id,
                ]
            );
        }
    }
}