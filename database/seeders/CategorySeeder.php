<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Физические товары
            ['name' => 'Электроника', 'type' => 'product', 'parent_id' => null],
            ['name' => 'Одежда и обувь', 'type' => 'product', 'parent_id' => null],
            ['name' => 'Домены и IT-активы', 'type' => 'product', 'parent_id' => null],
            
            // Услуги и обучение
            ['name' => 'Обучение и курсы', 'type' => 'service', 'parent_id' => null],
            ['name' => 'Бытовые услуги', 'type' => 'service', 'parent_id' => null],
            
            // Некоммерческое / Работа
            ['name' => 'Работа и вакансии', 'type' => 'job', 'parent_id' => null],
            ['name' => 'Знакомства', 'type' => 'person', 'parent_id' => null],
        ];

        foreach ($categories as $cat) {
            Category::create([
                'name' => $cat['name'],
                'slug' => Str::slug($cat['name']),
                'type' => $cat['type'],
                'parent_id' => $cat['parent_id'],
            ]);
        }
    }
}
