<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use Illuminate\Http\Request;

class RepositoryController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['repository']= Repository::orderBy('id','asc')->simplepaginate(5);
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
        $data = $request->validate([
            'nombre_repositorio' => 'required',
            'sigla' => 'required',
            'ciudad' => 'required',
            'correo' => 'required|email',
            'nombre_encargado' => 'required',
            'direccion' => 'required',
            'ubicacion',
            'horario_atencion' => 'required',
            'telefono' => 'required',
            'pagina_web' => 'required'
        ]);

        Repository::create($request->all());

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
        return view('repository.show',compact('repository'));
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
            'sigla' => 'required',
            'ciudad' => 'required',
            'correo' => 'required|email',
            'nombre_encargado' => 'required',
            'direccion' => 'required',
            'ubicacion',
            'horario_atencion' => 'required',
            'telefono' => 'required',
            'pagina_web' => 'required'
        ]);

        $repository->update($request->all());

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
        // $repository->delete();
        // return redirect()->route('repository.index')
        //                 ->with('eliminar','ok');
    }
}
