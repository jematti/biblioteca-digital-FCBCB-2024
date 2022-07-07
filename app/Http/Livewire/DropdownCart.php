<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DropdownCart extends Component
{
    //escuchar el evento enviado desde add-item-cart
    protected $listeners = ['render'];
    public function render()
    {
        return view('livewire.dropdown-cart');
    }
}
