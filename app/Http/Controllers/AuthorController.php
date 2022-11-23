<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
class AuthorController extends Controller
{
    public function __construct() {
        $this->middleware('can:admin.categories.index')->only('index');
        $this->middleware('can:admin.categories.create')->only('create');
        $this->middleware('can:admin.categories.edit')->only('edit','update');
        $this->middleware('can:admin.categories.destroy')->only('destroy');
    }

    public function index()
    {
        $data['author']= Author::orderBy('id','asc')->simplepaginate(5);
        return view('author.index',$data);

    }


    public function create()
    {
        return view('author.create');
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre_autor' => 'required|unique:authors|max:255',
            'biografia' => 'required'
        ]);

        Author::create($request->all());

        return redirect()->route('author.index')
                         ->with('store','ok');
    }


    public function show(Author $author)
    {
        return view('author.show',compact('author'));
    }


    public function edit(Author $author)
    {
        return view('author.edit',compact('author'));
    }


    public function update(Request $request, Author $author)
    {
        $request->validate([
            'nombre_autor' => 'required',
            'biografia' => 'required'
        ]);

        $author->update($request->all());

        return redirect()->route('author.index')
                         ->with('update','ok');
    }


    public function destroy(Author $author)
    {
        $author->delete();
        return redirect()->route('author.index')
                        ->with('eliminar','ok');
    }
}
