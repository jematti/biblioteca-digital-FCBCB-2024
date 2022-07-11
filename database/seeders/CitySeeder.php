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
            'nombre_ciudad'=>'La Paz',
            'costo' => '5'
        ]);

        DB::table('cities')->insert([
            'nombre_ciudad'=>'Oruro',
            'costo' => '10'
        ]);

        DB::table('cities')->insert([
            'nombre_ciudad'=>'Potosi',
            'costo' => '10'
        ]);

        DB::table('cities')->insert([
            'nombre_ciudad'=>'Cobija',
            'costo' => '10'
        ]);

        DB::table('cities')->insert([
            'nombre_ciudad'=>'Beni',
            'costo' => '20'
        ]);

        DB::table('cities')->insert([
            'nombre_ciudad'=>'Santa Cruz',
            'costo' => '20'
        ]);

        DB::table('cities')->insert([
            'nombre_ciudad'=>'chuquisaca',
            'costo' => '10'
        ]);

        DB::table('cities')->insert([
            'nombre_ciudad'=>'Sucre',
            'costo' => '5'
        ]);

        DB::table('cities')->insert([
            'nombre_ciudad'=>'tarija',
            'costo' => '20'
        ]);


    }
}
