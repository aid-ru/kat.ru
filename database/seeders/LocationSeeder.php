<?php

namespace Database\Seeders;  // Обязательно!

use App\Models\Location;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    public function run()
    {
        DB::table('locations')->insert([
            // Уровень 1: Страна
            [
                'parent_id' => null,
                'name' => 'Россия',
                'slug' => 'russia',
                'type' => 'country',
                'sort_order' => 1,
            ],
            // Уровень 2: Регионы
            [
                'parent_id' => 1, // Подчинён России (id=1)
                'name' => 'Ярославская область',
                'slug' => 'yaroslavl-region',
                'type' => 'region',
                'sort_order' => 2,
            ],
            [
                'parent_id' => 1, // Подчинён России (id=1)
                'name' => 'Москва',
                'slug' => 'moscow',
                'type' => 'city',
                'sort_order' => 2,
            ],
            // Уровень 3: Города/районы
            [
                'parent_id' => 2, // Подчинён Ярославской области (id=2)
                'name' => 'Ярославль',
                'slug' => 'yaroslavl',
                'type' => 'city',
                'sort_order' => 3,
            ],
            [
                'parent_id' => 3, // Подчинён Москве (id=3)
                'name' => 'Центральный административный округ',
                'slug' => 'cao',
                'type' => 'district',
                'sort_order' => 3,
            ],
            // Уровень 4: Районы
            [
                'parent_id' => 4, // Подчинён Ярославлю (id=4)
                'name' => 'Заволжский район',
                'slug' => 'zavolzhsky-district',
                'type' => 'district',
                'sort_order' => 4,
            ],
        ]);
    }
}
