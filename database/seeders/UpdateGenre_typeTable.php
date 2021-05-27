<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateGenre_typeTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('genre_type')->insert([
            [
                'genre_id'=>1,
                'type_id'=>1,
            ],
            [
                'genre_id'=>1,
                'type_id'=>2,
            ],
            [
                'genre_id'=>2,
                'type_id'=>1,
            ],
            [
                'genre_id'=>3,
                'type_id'=>2,
            ],
            [
                'genre_id'=>4,
                'type_id'=>1,
            ],
            [
                'genre_id'=>5,
                'type_id'=>2,
            ],
        ]);
    }
}
