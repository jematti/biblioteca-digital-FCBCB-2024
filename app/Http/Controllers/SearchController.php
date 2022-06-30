<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $name = $request->name;

        $books =  Book::join("authors","books.author_id","=","authors.id")
                                    ->where('books.titulo','LIKE',"%". $name."%")
                                    ->orWhere('authors.nombre_autor', 'LIKE' , '%' .$name. '%')
                                    ->take(5)
                                    ->get();

        return view('search',compact('books'));
    }
}
