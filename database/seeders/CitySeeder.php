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
            'costo' => '0'
        ]);

        DB::table('cities')->insert([
            'nombre_ciudad'=>'Oruro',
            'costo' => '0'
        ]);

        DB::table('cities')->insert([
            'nombre_ciudad'=>'Potosi',
            'costo' => '0'
        ]);

        DB::table('cities')->insert([
            'nombre_ciudad'=>'Pando',
            'costo' => '0'
        ]);

        DB::table('cities')->insert([
            'nombre_ciudad'=>'Beni',
            'costo' => '0'
        ]);

        DB::table('cities')->insert([
            'nombre_ciudad'=>'Santa Cruz',
            'costo' => '0'
        ]);

        DB::table('cities')->insert([
            'nombre_ciudad'=>'Chuquisaca',
            'costo' => '0'
        ]);

        DB::table('cities')->insert([
            'nombre_ciudad'=>'Tarija',
            'costo' => '0'
        ]);


    }
}
