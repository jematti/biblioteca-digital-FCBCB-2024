<?php

namespace App\Http\Livewire;

use Livewire\Component;

class AddCartItem extends Component
{
    public $book, $cantidad_stock;
    public $cantidad = 0;

    public function mount(){
        $this->cantidad_stock=$this->book->cantidad;
    }

    public function increment(){
        $this->cantidad = $this->cantidad+1;
    }

    public function decrement(){
        $this->cantidad = $this->cantidad-1;
    }

    public function render()
    {

        return view('livewire.add-cart-item');
    }
}
