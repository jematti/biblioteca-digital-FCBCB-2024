<?php

namespace App\Http\Livewire;

use App\Models\Author;
use App\Models\Product;
use Livewire\Component;
use App\Models\Category;
use App\Models\Repository;
use Illuminate\Database\Eloquent\Builder;
use Livewire\WithPagination;

class ProductFilter extends Component
{
    use WithPagination;


    public $category;
    public $author;
    public $repository;
    public $precio_asc,$precio_desc,$novedades;


    public $view ="grid";

    public function limpiar(){
        $this->reset(['category','author','repository','precio_asc','precio_desc','novedades']);
    }

    public function render()
    {
        $productsQuery = Product::query();
        $categories = Category::all();

        $authors = Author::all();
        $repositories = Repository::all();

        //filtro para categorias
        if ($this->category) {
            $productsQuery = $productsQuery->whereHas('category',function(Builder $query){
                $query->where('id',$this->category);
            });
        }
        //filtro para autores
        if ($this->author) {
            $productsQuery = $productsQuery->whereHas('author',function(Builder $query){
                $query->where('id',$this->author);
            });
        }
        //filtro para repositorios
        if ($this->repository) {
            $productsQuery = $productsQuery->whereHas('repository',function(Builder $query){
                $query->where('id',$this->repository);
            });
        }

        if ($this->precio_asc) {
            $productsQuery = $productsQuery->orderBy('precio','asc');
        }
        if ($this->precio_desc) {
            $productsQuery = $productsQuery->orderBy('precio','desc');
        }
        if ($this->novedades) {
            $productsQuery = $productsQuery->orderBy('fecha_publicacion','desc');
        }

        $products = $productsQuery->paginate(15);
        return view('livewire.product-filter')->with('products',$products)
                                              ->with('categories',$categories)
                                              ->with('authors',$authors)
                                              ->with('repositories',$repositories);
    }
}
