<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateGenresTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genres')->insert([
            [
                'alias'=>'portraits',
                'title'=>'portrait',
                'rus_title'=>'портрет',
                'chego_title'=>'портреты',
                'description'=>'Портретный жанр',
            ],
            [
                'alias'=>'landscapes',
                'title'=>'landscape',
                'rus_title'=>'пейзаж',
                'chego_title'=>'пейзажи',
                'description'=>'Изображение природных и других ландшафтов',
            ],
            [
                'alias'=>'handmade',
                'title'=>'handmade',
                'rus_title'=>'ручная работа',
                'chego_title'=>'ручная работа',
                'description'=>'Сувениры и прочие изделия, изготовленные вручную',
            ],
            [
                'alias'=>'painting',
                'title'=>'paintings',
                'rus_title'=>'живопись',
                'chego_title'=>'живопись',
                'description'=>'Живопись',
            ],
            [
                'alias'=>'sculpture',
                'title'=>'sculptures',
                'rus_title'=>'скульптура',
                'chego_title'=>'скульптуры',
                'description'=>'Скульптуры и статуэтки, изготовленные из различных материалов',
            ],
        ]);
    }
}
