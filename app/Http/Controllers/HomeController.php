<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Repository;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function __invoke()
    {

        session()->flash('message', 'Post successfully updated.');
        $products = Product::orderBy('id','desc')->paginate(10);
        $categories = Category::orderBy('id','desc')->simplepaginate(10);
        $repositories = Repository::orderBy('id','desc')->get();
        return view('home')->with('products',$products)
                            ->with('categories',$categories)
                            ->with('repositories',$repositories);
    }

}
