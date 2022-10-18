<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;

class Navigation extends Component
{
    public function render()
    {
        $recibidos = Order::where('estado',2)->count();
        return view('livewire.layouts.navigation', compact('recibidos'));
    }
}
