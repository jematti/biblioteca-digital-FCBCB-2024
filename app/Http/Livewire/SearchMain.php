<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class SearchMain extends Component
{
    public $search_main;
    public $open=false;

    //verificar si hay contenido en la variable search_main -> SearchMain (update)
    public function updatedSearchMain($value){
        if ($value) {
            $this->open=true;
        }else{
            $this->open=false;
        }
    }


    public function render()
    {
        if ($this->search_main) {

            //busqueda titulo y autor
            // $products = product::join("authors","products.author_id","=","authors.id")
            //                 ->where('products.titulo','LIKE',"%". $this->search_main ."%")
            //                 ->orWhere('authors.nombre_autor', 'LIKE' , '%' .$this->search_main. '%')
            //                 ->select('products.id','products.imagen','products.titulo','authors.nombre_autor')
            //                 ->take(5)
            //                 ->get();

            //busqueda solo titulos
            $products = product::where('titulo','LIKE',"%". $this->search_main ."%")
                           ->take(8)
                           ->get();

        }
        else{
            $products=[];
        }

        return view('livewire.search-main',compact('products'));

    }
}
