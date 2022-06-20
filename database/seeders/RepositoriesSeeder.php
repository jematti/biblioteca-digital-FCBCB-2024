<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RepositoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('repositories')->insert([
            'nombre_repositorio' => 'Repositorio prueba',
            'sigla' => 'R1',
            'ciudad' => 'Ciudad 1',
            'correo' => '4@4.com',
            'ubicacion' => 'Ubicacion 1',
            'horario_atencion' => 'Horario 1',
            'telefono' => 'Telefono 1',
            'pagina_web' => 'Pagina web 1'
          ]);
    }
}
