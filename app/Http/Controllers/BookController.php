<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Category;
use App\Models\Editorial;
use App\Models\Book;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['book']= Book::orderBy('id','desc')->paginate(5);
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
          return view('book.create')
                    ->with('categories',$categories)
                    ->with('authors',$authors)
                    ->with('editorials',$editorials);
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
            'titulo' => 'required|unique:books|max:255',
            'edicion' => 'required',
            'ubicacion' => 'required',
            'numero_paginas' => 'required',
            'fecha_publicacion' => 'required|date',
            'idioma' => 'required',
            'resumen' => 'required',
            'imagen' => 'required',
            'author' => 'required',
            'editorial'=> 'required',
            'category'=> 'required',
        ]);

        //creacion de un nuevo libro y recibiendo datos de la vista
        $book = new Book;
        $book->titulo = $request->titulo;
        $book->edicion = $request->edicion;
        $book->ubicacion = $request->ubicacion;
        $book->numero_paginas = $request->numero_paginas;
        $book->fecha_publicacion = $request->fecha_publicacion;
        $book->idioma = $request->idioma;
        $book->resumen = $request->resumen;
        $book->imagen = $request->imagen;
        $book->author_id = $request->author;
        $book->category_id = $request->category;
        $book->editorial_id = $request->editorial;
        $book->save();

        return redirect()->route('books.index')->with('success','Libro creado correctamente');
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
        return view('book.edit', compact('book'));
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
        $data = $request->validate([
            'titulo' => 'required|unique:books|max:255',
            'edicion' => 'required',
            'ubicacion' => 'required',
            'numero_paginas' => 'required',
            'idioma' => 'required',
            'resumen' => 'required',
            'fecha_publicacion' => 'required|date',
            'imagen' => 'required'
        ]);
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
        return redirect()->route('book.index')
                        ->with('success','Post deleted successfully');
    }
}
