<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $product_search = $request->product_search;


        // $products =  product::join("authors","products.author_id","=","authors.id")
        //                             ->where('products.titulo','LIKE',"%". $product_search."%")
        //                             ->orWhere('authors.nombre_autor', 'LIKE' , '%' .$product_search. '%')
        //                             ->take(5)
        //                             ->distinct()
        //                             ->get();

        // busqueda solo titulos
        // $products = product::where('titulo', 'LIKE' ,'%' . $product_search . '%')
        // ->paginate(5);

        $products = product::join("authors","products.author_id","=","authors.id")
                            ->where('products.titulo','LIKE',"%". $product_search ."%")
                            ->orWhere('authors.nombre_autor', 'LIKE' , '%' .$product_search. '%')
                            ->select('products.id','products.imagen','products.titulo','products.precio','authors.nombre_autor')
                            ->take(10)
                            ->get();


        return view('search',compact('products'));
    }
}
