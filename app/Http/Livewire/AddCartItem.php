<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Storage;

class AddCartItem extends Component
{
    public $book, $cantidad_stock;

    public $cantidad=1;

    //array de variables para agregar al carrito de compras
    public $options = [];


    public function mount(){
        $this->cantidad_stock = cantidad_disponible($this->book->id);
        $this->options['imagen'] = $this->book->imagen;
    }

    public function increment(){
        $this->cantidad = $this->cantidad+1;
    }

    public function decrement(){
        $this->cantidad = $this->cantidad-1;
    }

    public function addItem(){

        Cart::add([ 'id' => $this->book->id,
                     'name' => $this->book->titulo,
                     'qty' => $this->cantidad,
                     'price' => $this->book->precio,
                     'weight' => 550,
                     'options'=> $this->options
                  ]);

        //actualizar la cantida de productos disponibles
        $this->cantidad_stock=cantidad_disponible($this->book->id);
        //resetear la variable cantidad
        $this->reset('cantidad');
        //renderizar el componente dropdown para actualizar con el item agregado
        $this->emitTO('dropdown-cart','render');
   }

    public function render()
    {

        return view('livewire.add-cart-item');
    }
}
