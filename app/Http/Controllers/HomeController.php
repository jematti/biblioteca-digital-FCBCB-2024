<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function __invoke()
    {
        $books = Book::orderBy('id','desc')->simplepaginate(10);
        return view('home')->with('books',$books);
    }

}
