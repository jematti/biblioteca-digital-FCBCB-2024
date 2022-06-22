<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'nombre_categoria' => 'Revista',
            'descripcion' => 'Una revista es una publicación impresa que es editada de manera periódica (por lo general, semanal o mensual). Al igual que los diarios, las revistas forman parte de los medios gráficos, aunque también pueden tener su versión digital o haber nacido directamente en Internet.'
        ]);

        DB::table('categories')->insert([
            'nombre_categoria' => 'Boletin',
            'descripcion' => 'El Boletín Bibliográfico reúne todos los registros ingresados en el período consignado: publicaciones monográficas, trabajos de investigación y extensión de investigadores del CURZA, trabajos finales y tesis de alumnos, además de las publicaciones periódicas recibidas.'
        ]);
    }
}
