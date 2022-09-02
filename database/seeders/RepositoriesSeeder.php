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
            'nombre_repositorio' => 'Centro de la Cultura Plurinacional',
            'sigla' => 'CCP',
            'ciudad' => 'Santa Cruz',
            'correo' => 'recepcion.ccpsc@gmail.com',
            'nombre_encargado' => 'Jhon smith',
            'ubicacion' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d121537.5776322898!2d-63.2769021310245!3d-17.836323653025318!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x93f1e812e96fe9b7%3A0x2aea81f62cf2f667!2sCentro%20de%20la%20Cultura%20Plurinacional!5e0!3m2!1ses-419!2sbo!4v1656939685264!5m2!1ses-419!2sbo" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            'direccion' => 'Calle René Moreno # 369, Santa Cruz de la Cierra',
            'horario_atencion' => 'Lunes y Viernes de 08:00 a 16:00',
            'telefono' => '(+591) 3356905 – 3356941',
            'pagina_web' => 'https://ccp.gob.bo/'
        ]);

        DB::table('repositories')->insert([
            'nombre_repositorio' => 'El Museo Nacional de Arte',
            'sigla' => 'MNA',
            'ciudad' => 'La Paz',
            'correo' => 'contacto@museonacionaldearte.gob.bo',
            'nombre_encargado' => 'Jhon smith',
            'ubicacion' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3825.5997657927073!2d-68.13650598466165!3d-16.49579158861863!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x915edf8977bba297%3A0xf7d1ea087813af63!2sMuseo%20Nacional%20de%20Arte!5e0!3m2!1ses-419!2sbo!4v1656939713137!5m2!1ses-419!2sbo" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            'direccion' => 'Calle Comercio Esq. Socabaya La Paz - Bolivia',
            'horario_atencion' => 'Lunes - Viernes: 08:30 a 16:30 Sabado - Domingos: Cerrado',
            'telefono' => '2 2408600',
            'pagina_web' => 'https://museonacionaldearte.gob.bo/'
        ]);


        DB::table('repositories')->insert([
            'nombre_repositorio' => 'Museo Nacional de Etnografía y Folklore - La Paz',
            'sigla' => 'MUSEF',
            'ciudad' => 'La Paz',
            'correo' => 'musef@musef.org.bo',
            'nombre_encargado' => 'Jhon smith',
            'ubicacion' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3825.6269006619173!2d-68.1372338846616!3d-16.49441918861951!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x915f2073a5f07245%3A0xe7056e6670b7e5d0!2sMuseo%20Nacional%20de%20Etnograf%C3%ADa%20y%20Folklore%20(MUSEF)!5e0!3m2!1ses-419!2sbo!4v1656939750777!5m2!1ses-419!2sbo" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            'direccion' => 'Calle Ingavi N° 916 - La Paz',
            'horario_atencion' => 'Lunes - Viernes: 8:30 a 16:00 ',
            'telefono' => '(591-2) 2408640- 2406030',
            'pagina_web' => 'http://musef.org.bo/'
        ]);


        // DB::table('repositories')->insert([
        //     'nombre_repositorio' => 'Museo Nacional de Etnografía y Folklore - Sucre',
        //     'sigla' => 'MUSEF',
        //     'ciudad' => 'Sucre',
        //     'correo' => 'musef@musef.org.bo',
        //     'nombre_encargado' => 'Jhon smith',
        //     'ubicacion' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d60331.86588746341!2d-65.30479159329884!3d-19.0750946469394!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x93fbcf369b4aaa19%3A0x1dbe166567373a2!2sMusef!5e0!3m2!1ses-419!2sbo!4v1656939797152!5m2!1ses-419!2sbo" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
        //     'direccion' => 'Calle España N° 74 - Sucre',
        //     'horario_atencion' => 'Lunes - Viernes: 8:30 a 16:00 ',
        //     'telefono' => '(591-4) 6455293',
        //     'pagina_web' => 'http://musef.org.bo/'
        // ]);


        DB::table('repositories')->insert([
            'nombre_repositorio' => 'Casa de la Moneda Nacional',
            'sigla' => 'CNM',
            'ciudad' => 'Potosi',
            'correo' => 'cnmfcbcb@casanacionaldemoneda.bo',
            'nombre_encargado' => 'Jhon smith',
            'ubicacion' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3758.9126967528837!2d-65.7563894846248!3d-19.588240586796072!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x93f94e7a742dc163%3A0xf0943a56bebdf962!2sCasa%20Nacional%20de%20Moneda%20de%20Potosi!5e0!3m2!1ses-419!2sbo!4v1656939826437!5m2!1ses-419!2sbo" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            'direccion' => 'Calle Ayacucho s/n, Villa Imperial de Potosí',
            'horario_atencion' => 'Lunes a Sabado 09:00 am - 15:00 pm',
            'telefono' => '(+591) 6222777 ',
            'pagina_web' => 'http://www.casanacionaldemoneda.bo/'
        ]);

        DB::table('repositories')->insert([
            'nombre_repositorio' => 'Casa de la Libertad',
            'sigla' => 'CDL',
            'ciudad' => 'Sucre',
            'correo' => 'info@casadelalibertad.org.bo',
            'nombre_encargado' => 'Jhon smith',
            'ubicacion' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3771.3689805876547!2d-65.26234868463186!3d-19.047507987104265!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x93fbcf48c19ec0d1%3A0x6db15529a97180d8!2sCasa%20De%20La%20Libertad!5e0!3m2!1ses-419!2sbo!4v1656939850616!5m2!1ses-419!2sbo" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            'direccion' => 'Plaza 25 de Mayo, Sucre',
            'horario_atencion' => 'De lunes a viernes, de 8:00 a 16:00 Domingos, de 8:00 a 12:00 Sábados y feriados el museo está cerrado. Las visitas guiadas se realizan cada hora. Última admisión : 1 Hr. antes del cierre.',
            'telefono' => '(591-4) 6454200',
            'pagina_web' => 'https://www.casadelalibertad.org.bo/'
        ]);

        DB::table('repositories')->insert([
            'nombre_repositorio' => 'Archivo y Biblioteca Nacionales de Bolivia',
            'sigla' => 'ABNB',
            'ciudad' => 'Sucre',
            'correo' => 'contacto@abnb.org.bo',
            'nombre_encargado' => 'Jhon smith',
            'ubicacion' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3771.3371657876173!2d-65.26294438463171!3d-19.048907887103468!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x93fbcf36391e3a57%3A0x7f4eb2228f30a49!2sArchivo%20y%20Biblioteca%20Nacionales%20de%20Bolivia!5e0!3m2!1ses-419!2sbo!4v1656939881156!5m2!1ses-419!2sbo" width="400" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>',
            'direccion' => 'Dalence 4, Sucre',
            'horario_atencion' => 'Lunes a Sabado 08:30 am - 18:30 pm',
            'telefono' => '(+591) 4 6452246 ',
            'pagina_web' => 'https://www.archivoybibliotecanacionales.org.bo/'
        ]);

    }
}
