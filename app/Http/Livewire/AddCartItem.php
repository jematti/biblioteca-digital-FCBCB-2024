<?php

namespace App\Http\Livewire;

use App\Models\Product;
use Livewire\Component;
use App\Models\Repository;
use Illuminate\Support\Facades\Storage;
use Gloudemans\Shoppingcart\Facades\Cart;

class AddCartItem extends Component
{
    public $product, $cantidad_stock;

    public $cantidad=1;

    //array de variables para agregar al carrito de compras
    public $options = [];

    public $ubicacion=[];

    public $cantidad_libro=[];


    public function mount(){
        $this->cantidad_stock = cantidad_disponible($this->product->id);
        $this->options['imagen'] = $this->product->imagen;
        $this->ubicacion[]=Repository::select('nombre_repositorio','sigla')
                   ->where('id',$this->product->repository_id)
                   ->first();
        $this->cantidad_libro[]=Product::select('cantidad')
                   ->where('id',$this->product->id)
                   ->first();
        $this->options['ubicacion'] = $this->ubicacion[0]->nombre_repositorio;
        $this->options['cantidad_libro'] = $this->cantidad_libro[0]->cantidad;
    }

    public function increment(){
        $this->cantidad = $this->cantidad+1;
    }

    public function decrement(){
        $this->cantidad = $this->cantidad-1;
    }

    public function addItem(){

        Cart::add([ 'id' => $this->product->id,
                     'name' => $this->product->titulo,
                     'qty' => $this->cantidad,
                     'price' => $this->product->precio,
                     'weight' => 550,
                     'options'=> $this->options
                  ]);

        //actualizar la cantida de productos disponibles
        $this->cantidad_stock=cantidad_disponible($this->product->id);
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
