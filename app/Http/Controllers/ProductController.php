<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Category;
use App\Models\Repository;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct() {
        $this->middleware('auth', ['except' => ['show']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['product']= Product::orderBy('id','asc')->simplepaginate(8);
        return view('product.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $authors = Author::all();
        $repositories = Repository::all();
        return view('product.create')
                  ->with('categories',$categories)
                  ->with('authors',$authors)
                  ->with('repositories',$repositories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
          //validacion de los inputs de la vista create de seccion "product"
          $this->validate($request,[
            'titulo' => 'required|max:255',
            'edicion' => 'required',
            'numero_paginas' => 'required|numeric|regex:/^\d+$/',
            'fecha_publicacion' => 'required|date',
            'idioma' => 'required',
            'resumen' => 'required',
            'imagen' => 'required',
            'precio' => 'required|numeric|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/',
            'cantidad'=> 'required|numeric|regex:/^\d+$/',
            'isbn',
            'ancho',
            'alto',
            'peso',
            'grueso',
            'author' => 'required',
            'category'=> 'required',
            'ubicacion'=> 'required',
        ]);

        //creacion de un nuevo libro y recibiendo datos de la vista usan las variables de request
        $product = new Product;
        $product->titulo = $request->titulo;
        $product->edicion = $request->edicion;
        $product->numero_paginas = $request->numero_paginas;
        $product->fecha_publicacion = $request->fecha_publicacion;
        $product->idioma = $request->idioma;
        $product->resumen = $request->resumen;
        $product->imagen = $request->imagen;
        $product->precio = $request->precio;
        $product->cantidad = $request->cantidad;
        $product->isbn = $request->isbn;
        $product->ancho = $request->ancho;
        $product->alto = $request->alto;
        $product->peso= $request->peso;
        $product->grueso= $request->grueso;
        $product->author_id = $request->author;
        $product->category_id = $request->category;
        $product->repository_id = $request->ubicacion;
        $product->save();

        return redirect()->route('products.index')->with('store','ok');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('product.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
          $authors = Author::all();
          $repositories = Repository::all();

        return view('product.edit')
        ->with('categories',$categories)
        ->with('authors',$authors)
        ->with('repositories',$repositories)
        ->with('product',$product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
         //validacion de los inputs de la vista create de seccion "product"
         $this->validate($request,[
            'titulo' => 'required|max:255',
            'edicion' => 'required',
            'numero_paginas' => 'required|numeric|regex:/^\d+$/',
            'fecha_publicacion' => 'required|date',
            'idioma' => 'required',
            'resumen' => 'required',
            'imagen' => 'required',
            'precio' => 'required|numeric|regex:/^[\d]{0,11}(\.[\d]{1,2})?$/',
            'cantidad'=> 'required|numeric|regex:/^\d+$/',
            'isbn',
            'ancho',
            'alto',
            'peso',
            'grueso',
            'author' => 'required',
            'category'=> 'required',
            'ubicacion'=> 'required',
        ]);

        //editar producto y recibiendo datos de la vista

        $product->titulo = $request->titulo;
        $product->edicion = $request->edicion;
        $product->numero_paginas = $request->numero_paginas;
        $product->fecha_publicacion = $request->fecha_publicacion;
        $product->idioma = $request->idioma;
        $product->resumen = $request->resumen;
        $product->imagen = $request->imagen;
        $product->precio = $request->precio;
        $product->cantidad = $request->cantidad;
        $product->isbn = $request->isbn;
        $product->ancho = $request->ancho;
        $product->alto = $request->alto;
        $product->peso= $request->peso;
        $product->grueso= $request->grueso;
        $product->author_id = $request->author;
        $product->category_id = $request->category;
        $product->repository_id = $request->ubicacion;
        $product->save();

        return redirect()->route('products.index')->with('update','ok');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
         // $product->delete();
        // return redirect()->route('products.index')
        //                 ->with('eliminar','ok');
    }
}
