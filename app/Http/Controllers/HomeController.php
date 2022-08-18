<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function __invoke()
    {

        $books = Book::orderBy('id','desc')->simplepaginate(5);
        $categorias = Category::orderBy('id','desc')->simplepaginate(5);
        return view('home')->with('books',$books)
                            ->with('categorias',$categorias);
    }

}
