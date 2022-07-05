<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Author;
use App\Models\Category;
use App\Models\Editorial;
use App\Models\Repository;
use Illuminate\Http\Request;

class BookController extends Controller
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
        $data['book']= Book::orderBy('id','desc')->simplepaginate(8);
        return view('book.index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
          $categories = Category::all();
          $editorials = Editorial::all();
          $authors = Author::all();
          $repositories = Repository::all();
          return view('book.create')
                    ->with('categories',$categories)
                    ->with('authors',$authors)
                    ->with('editorials',$editorials)
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

        //validacion de los inputs de la vista create de seccion "book"
        $this->validate($request,[
            'titulo' => 'required|max:255',
            'edicion' => 'required',
            'numero_paginas' => 'required',
            'fecha_publicacion' => 'required|date',
            'idioma' => 'required',
            'resumen' => 'required',
            'imagen' => 'required',
            'precio' => 'required',
            'author' => 'required',
            'cantidad' => 'required',
            'ancho',
            'alto',
            'peso',
            'grueso',
            'editorial'=> 'required',
            'category'=> 'required',
            'ubicacion'=> 'required',
        ]);

        //creacion de un nuevo libro y recibiendo datos de la vista usan las variables de request
        $book = new Book;
        $book->titulo = $request->titulo;
        $book->edicion = $request->edicion;
        $book->numero_paginas = $request->numero_paginas;
        $book->fecha_publicacion = $request->fecha_publicacion;
        $book->idioma = $request->idioma;
        $book->resumen = $request->resumen;
        $book->imagen = $request->imagen;
        $book->precio = $request->precio;
        $book->cantidad = $request->cantidad;
        $book->ancho = $request->ancho;
        $book->alto = $request->alto;
        $book->peso= $request->peso;
        $book->grueso= $request->grueso;
        $book->author_id = $request->author;
        $book->category_id = $request->category;
        $book->editorial_id = $request->editorial;
        $book->repository_id = $request->ubicacion;
        $book->save();

        return redirect()->route('books.index')->with('store','ok');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        return view('book.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
          $categories = Category::all();
          $editorials = Editorial::all();
          $authors = Author::all();
          $repositories = Repository::all();

        return view('book.edit')
        ->with('categories',$categories)
        ->with('authors',$authors)
        ->with('editorials',$editorials)
        ->with('repositories',$repositories)
        ->with('book',$book);;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Book $book)
    {
        //validacion de los inputs de la vista create de seccion "book"
        $this->validate($request,[
            'titulo' => 'required|max:255',
            'edicion' => 'required',
            'numero_paginas' => 'required',
            'fecha_publicacion' => 'required|date',
            'idioma' => 'required',
            'resumen' => 'required',
            'imagen' => 'required',
            'precio' => 'required',
            'cantidad'=> 'required',
            'ancho',
            'alto',
            'peso',
            'grueso',
            'author' => 'required',
            'editorial'=> 'required',
            'category'=> 'required',
            'ubicacion'=> 'required',
        ]);

        //creacion de un nuevo libro y recibiendo datos de la vista

        $book->titulo = $request->titulo;
        $book->edicion = $request->edicion;
        $book->numero_paginas = $request->numero_paginas;
        $book->fecha_publicacion = $request->fecha_publicacion;
        $book->idioma = $request->idioma;
        $book->resumen = $request->resumen;
        $book->imagen = $request->imagen;
        $book->precio = $request->precio;
        $book->cantidad = $request->cantidad;
        $book->ancho = $request->ancho;
        $book->alto = $request->alto;
        $book->peso= $request->peso;
        $book->grueso= $request->grueso;
        $book->author_id = $request->author;
        $book->category_id = $request->category;
        $book->editorial_id = $request->editorial;
        $book->repository_id = $request->ubicacion;
        $book->save();

        return redirect()->route('books.index')->with('update','ok');;
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')
                        ->with('eliminar','ok');
    }
}
