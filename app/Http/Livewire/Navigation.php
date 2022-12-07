<?php

namespace App\Http\Livewire;

use App\Models\Order;
use App\Models\User;
use Livewire\Component;

class Navigation extends Component
{
    public function render()
    {
        $recibidos = Order::where('estado',2)->count();
        // $user = User::where('id',auth()->)
        return view('livewire.layouts.navigation', compact('recibidos'));
    }
}
