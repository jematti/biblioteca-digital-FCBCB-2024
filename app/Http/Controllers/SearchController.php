<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $book_search = $request->book_search;

        // $books =  Book::join("authors","books.author_id","=","authors.id")
        //                             ->where('books.titulo','LIKE',"%". $book_search."%")
        //                             ->orWhere('authors.nombre_autor', 'LIKE' , '%' .$book_search. '%')
        //                             ->take(5)
        //                             ->distinct()
        //                             ->get();
        $books = Book::join("authors","books.author_id","=","authors.id")
                            ->where('books.titulo','LIKE',"%". $book_search ."%")
                            ->orWhere('authors.nombre_autor', 'LIKE' , '%' .$book_search. '%')
                            ->select('books.id','books.imagen','books.titulo','books.precio','authors.nombre_autor')
                            ->take(5)
                            ->get();

        // busqueda solo titulos
        // $books = Book::where('titulo', 'LIKE' ,'%' . $book_search . '%')
        // ->paginate(5);

        return view('search',compact('books'));
    }
}
