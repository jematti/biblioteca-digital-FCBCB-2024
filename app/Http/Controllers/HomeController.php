<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Repository;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function __invoke()
    {

        session()->flash('message', 'Post successfully updated.');
        $books = Book::orderBy('id','desc')->simplepaginate(5);
        $categories = Category::orderBy('id','desc')->simplepaginate(5);
        $repositories = Repository::orderBy('id','desc')->get();
        return view('home')->with('books',$books)
                            ->with('categories',$categories)
                            ->with('repositories',$repositories);
    }

}
