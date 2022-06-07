<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Editorial;

class EditorialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['editorial']= Editorial::orderBy('id','desc')->paginate(5);
        return view('editorial.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('editorial.create');
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
            'nombre_editorial' => 'required|unique:editorials|max:255',
            'direccion' => 'required',
            'contacto' => 'required'
        ]);

        Editorial::create($request->all());

        return redirect()->route('editorial.index')
                        ->with('success','Post has been created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Editorial $editorial)
    {
        return view('editorial.show',compact('editorial'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Editorial $editorial)
    {
        return view('editorial.edit',compact('editorial'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Editorial $editorial)
    {
        $request->validate([
            'nombre_editorial' => 'required|unique:editorials|max:255',
            'direccion' => 'required',
            'contacto' => 'required'
        ]);

        $editorial->update($request->all());

        return redirect()->route('editorial.index')
                        ->with('success','Post has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Editorial $editorial)
    {
        $editorial->delete();
        return redirect()->route('editorial.index')
                        ->with('success','Post has been deleted successfully.');
    }
}
