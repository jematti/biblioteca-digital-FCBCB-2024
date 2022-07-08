<?php

namespace App\Http\Livewire;

use Gloudemans\Shoppingcart\Facades\Cart;
use Livewire\Component;
use phpDocumentor\Reflection\Types\This;

class UpdateCartItem extends Component
{
    public $rowId,$cantidad,$cantidad_stock;

    public function mount(){
        $item= Cart::get($this->rowId);
        $this->cantidad=$item->qty;
        $this->cantidad_stock=cantidad_disponible($item->id);
    }


    public function increment(){
        $this->cantidad = $this->cantidad+1;
        //actualizar la cantidad del libros pedidos
        Cart::update($this->rowId,$this->cantidad);
        //actualizar el carrito de compras
        $this->emit('render');

    }

    public function decrement(){
        $this->cantidad = $this->cantidad-1;
        //actualizar la cantidad del libros pedidos
        Cart::update($this->rowId,$this->cantidad);
        $this->emit('render');
    }

    public function render()
    {
        return view('livewire.update-cart-item');
    }
}
