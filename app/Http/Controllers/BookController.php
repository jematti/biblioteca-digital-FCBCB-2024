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
        return view('book.create',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       // $categories = Category::all();
       // $authors = Author::all();
       // $editorials = Editorial::all();
        //$author = Author::all();
        //return view('book.create')->with('author',$author);
        //return view (('book.create'),compact ('mensaje'));

         //   ->with('categoria', $categories)
            //-> compact($mensaje);
           // ->with('editorials', $editorials)
           $author = Author::all();
           return view('book.create')->with('author',$author);

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
            'titulo' => 'required|unique:books|max:255',
            'edicion' => 'required',
            'isbn' => 'required',
            'ubicacion' => 'required',
            'numero_paginas' => 'required',
            'idioma' => 'required',
            'resumen' => 'required',
            'fecha_publicacion' => 'required|date',
        ]);
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
            'isbn' => 'required',
            'ubicacion' => 'required',
            'numero_paginas' => 'required',
            'idioma' => 'required',
            'resumen' => 'required',
            'fecha_publicacion' => 'required|date',
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
