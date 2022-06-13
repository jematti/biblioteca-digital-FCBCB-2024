<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function __invoke()
    {
        $books = Book::all();
        return view('home')->with('books',$books);;
    }

}
