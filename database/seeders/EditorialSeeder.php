<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EditorialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('editorials')->insert([
            'nombre_editorial'=>'Revista Cultural Piedra de Agua',
            'direccion'=>'Fundación Cultural del Banco Central de Bolivia. Calle Ingavi Nº 1005 esq. Yanacocha',
            'contacto' => 'Telfs.: 2408951 - 2408981 / Pág. Web: www.culturabcb.org.bo'
        ]);

        DB::table('editorials')->insert([
            'nombre_editorial'=>'Editorial Anonima (fase de prueba)',
            'direccion'=>'Avenida Caller Nro 0',
            'contacto' => 'Telfs.: 123456789 / prueba@gmail.com'
        ]);
    }
}
