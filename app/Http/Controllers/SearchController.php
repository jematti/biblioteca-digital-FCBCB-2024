<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $book_search = $request->book_search;

        $books =  Book::join("authors","books.author_id","=","authors.id")
                                    ->where('books.titulo','LIKE',"%". $book_search."%")
                                    ->orWhere('authors.nombre_autor', 'LIKE' , '%' .$book_search. '%')
                                    ->take(5)
                                    ->get();

        return view('search',compact('books'));
    }
}
