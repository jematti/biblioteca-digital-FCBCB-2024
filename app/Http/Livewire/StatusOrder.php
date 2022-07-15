<?php

namespace App\Http\Livewire;

use Livewire\Component;

class StatusOrder extends Component
{

    public $order, $estado;

    public function mount()
    {
        $this->estado = $this->order->estado;
    }

    public function actualizar(){
        $this->order->estado = $this->estado;
        $this->order->save();
    }
    public function render()
    {
        //recuperamos la información que contiene la orden
        $items = json_decode($this->order->content);

        return view('livewire.status-order', compact('items'));
    }
}
