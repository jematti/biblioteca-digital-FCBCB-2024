<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Repository;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class RepositoryController extends Controller
{
    public function __construct() {
        $this->middleware('can:admin.repositories.index')->only('index');
        $this->middleware('can:admin.repositories.create')->only('create');
        $this->middleware('can:admin.repositories.edit')->only('edit','update');
        $this->middleware('can:admin.repositories.destroy')->only('destroy');
    }
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['repository']= Repository::orderBy('id','asc')->where('habilitado',1)->paginate(15);
        return view('repository.index',$data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('repository.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre_repositorio' => 'required',
            'sigla',
            'ciudad' => 'required',
            'correo' => 'required|email',
            'nombre_encargado' => 'required',
            'direccion' => 'required',
            'ubicacion',
            'horario_atencion' => 'required',
            'telefono' => 'required',
            'pagina_web' => 'required',
            'imagen_repositorio' => 'required'
        ]);

        //creacion de repositorio
        $repository = new Repository;

        $repository->nombre_repositorio = $request->nombre_repositorio;
        $repository->sigla = $request->sigla;
        $repository->ciudad = $request->ciudad;
        $repository->correo = $request->correo;
        $repository->nombre_encargado = $request->nombre_encargado;
        $repository->direccion = $request->direccion;
        $repository->ubicacion = $request->ubicacion;
        $repository->horario_atencion = $request->horario_atencion;
        $repository->telefono = $request->telefono;
        $repository->pagina_web = $request->pagina_web;


        //seccion guardar imagen
        $imagen = $request->file('imagen_repositorio');
        //uuid para el nombre del archivo unico
        $nombreImagen = Str::uuid() . '.' . $imagen->extension();

        //almacenar la imagen en el servidor
        $imagenServidor = Image::make($imagen);

        //efectos de intervention image (ancho,alto)
        $imagenServidor->fit(750,1050);

        $imagenPath = public_path('img/repositorio').'/'. $nombreImagen;
        //solo guarda la ruta en la base de datos y no la imagen
        $imagenServidor->save($imagenPath);

        //fin de seccion guardar imagen

        //guardar datos
        $repository->imagen_repositorio = $nombreImagen;
        $repository->save();

        return redirect()->route('repository.index')
                         ->with('store','ok');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Repository $repository)
    {
        $products = Product::join("repositories","products.repository_id","=","repositories.id")
        ->where('products.repository_id',$repository->id)
        ->where('products.habilitado',1)
        ->select('products.id','products.imagen','products.titulo','products.precio','repositories.nombre_repositorio')
        ->orderBy('id','desc')
        ->paginate(10);
        return view('repository.show',compact('repository','products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Repository $repository)
    {
        return view('repository.edit',compact('repository'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Repository $repository)
    {
        $request->validate([
            'nombre_repositorio' => 'required',
            'sigla',
            'ciudad' => 'required',
            'correo' => 'required|email',
            'nombre_encargado' => 'required',
            'direccion' => 'required',
            'ubicacion',
            'horario_atencion' => 'required',
            'telefono' => 'required',
            'pagina_web' => 'required'
        ]);

        //Editar repositorio

        $repository->nombre_repositorio = $request->nombre_repositorio;
        $repository->sigla = $request->sigla;
        $repository->ciudad = $request->ciudad;
        $repository->correo = $request->correo;
        $repository->nombre_encargado = $request->nombre_encargado;
        $repository->direccion = $request->direccion;
        $repository->ubicacion = $request->ubicacion;
        $repository->horario_atencion = $request->horario_atencion;
        $repository->telefono = $request->telefono;
        $repository->pagina_web = $request->pagina_web;

        //seccion guardar imagen
        if ($request->imagen_repositorio) {
            $imagen = $request->file('imagen_repositorio');

            //uuid para el nombre del archivo unico
            $nombreImagen = Str::uuid() . '.' . $imagen->extension();

            //almacenar la imagen en el servidor
            $imagenServidor = Image::make($imagen);

            //efectos de intervention image (ancho,alto)
            $imagenServidor->fit(750,1050);

            $imagenPath = public_path('img/repositorio').'/'. $nombreImagen;
            //solo guarda la ruta en la base de datos y no la imagen
            $imagenServidor->save($imagenPath);

            //fin de seccion guardar imagen

            //guardar datos
            $repository->imagen_repositorio = $nombreImagen;
        }

        $repository->save();

        return redirect()->route('repository.index')
                         ->with('update','ok');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Repository $repository)
    {
        $repository->habilitado = '0';
        $repository->save();
        return redirect()->route('repository.index')
                        ->with('eliminar','ok');
    }
}
