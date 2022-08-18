<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;


class ImagenController extends Controller
{
    public function store(Request $request)
    {
        $imagen = $request->file('file');

        //uuid para el nombre del archivo unico
        $nombreImagen = Str::uuid() . '.' . $imagen->extension();

        //almacenar la imagen en el servidor
        $imagenServidor = Image::make($imagen);

        //efectos de intervention image (ancho,alto)
        $imagenServidor->fit(750,1050);

        $imagenPath = public_path('uploads').'/'. $nombreImagen;
        //solo guarda la ruta en la base de datos y no la imagen
        $imagenServidor->save($imagenPath);


        return response()->json(['imagen'=>$nombreImagen]);
    }

}
