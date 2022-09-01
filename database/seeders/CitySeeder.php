<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities')->insert([
            'nombre_ciudad'=>'la-paz',
            'costo' => '5'
        ]);

        DB::table('cities')->insert([
            'nombre_ciudad'=>'oruro',
            'costo' => '10'
        ]);

        DB::table('cities')->insert([
            'nombre_ciudad'=>'potosi',
            'costo' => '10'
        ]);

        DB::table('cities')->insert([
            'nombre_ciudad'=>'pando',
            'costo' => '10'
        ]);

        DB::table('cities')->insert([
            'nombre_ciudad'=>'beni',
            'costo' => '20'
        ]);

        DB::table('cities')->insert([
            'nombre_ciudad'=>'santa-cruz',
            'costo' => '20'
        ]);

        DB::table('cities')->insert([
            'nombre_ciudad'=>'chuquisaca',
            'costo' => '10'
        ]);

        DB::table('cities')->insert([
            'nombre_ciudad'=>'tarija',
            'costo' => '20'
        ]);


    }
}
