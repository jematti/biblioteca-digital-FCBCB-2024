<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use Livewire\WithPagination;

class ProductIndex extends Component
{
    use WithPagination;
    public $search;

    public function updatingSearch(){
        $this->resetPage();
    }
    public function render()
    {
        $products = Product::join("authors","products.author_id","=","authors.id")
        ->join("repositories","products.repository_id","=","repositories.id")
        ->where('products.titulo','LIKE',"%". $this->search ."%")
        ->select('products.id','products.imagen','products.cantidad','products.titulo','products.precio','authors.nombre_autor','repositories.nombre_repositorio','repositories.sigla')
        ->orderBy('products.id','asc')
        ->paginate();

        return view('livewire.product-index', compact('products'));
    }
}
