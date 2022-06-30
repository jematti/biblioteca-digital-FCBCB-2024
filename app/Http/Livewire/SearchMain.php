<?php

namespace App\Http\Livewire;

use App\Models\Book;
use App\Models\Author;
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
            $books = Book::join("authors","books.author_id","=","authors.id")
                            ->where('books.titulo','LIKE',"%". $this->search_main ."%")
                            ->orWhere('authors.nombre_autor', 'LIKE' , '%' .$this->search_main. '%')
                            ->select('books.id','books.imagen','books.titulo','authors.nombre_autor')
                            ->take(5)
                            ->get();

            //busqueda solo titulos
            // $books = Book::where('titulo','LIKE',"%". $this->search_main ."%")
            //                ->orWhere(Author::where('titulo','LIKE',"%". $this->search_main ."%"))
            //                ->take(8)
            //                ->get();

        }
        else{
            $books=[];
        }

        return view('livewire.search-main',compact('books'));

    }
}
