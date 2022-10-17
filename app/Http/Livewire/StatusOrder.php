<?php

namespace App\Http\Livewire;


use Livewire\Component;
use App\Notifications\OrderNotification;

class StatusOrder extends Component
{

    public $order, $estado;

    public $observacion;
    public $estado_facturacion;
    public $nro_factura;

    public $rules = [
        'nro_factura' => 'required',
    ];

    public function facturacion()
    {
        $rules = $this->rules;
        $this->validate($rules);

        $this->order->nro_factura = $this->nro_factura;
        $this->order->estado_facturacion = '200';
        $this->order->save();

    }

    public function mount()
    {
        $this->estado = $this->order->estado;
        $this->observacion = $this->order->observacion;
        $this->nro_factura = $this->order->nro_factura;
    }

    public function actualizar(){
        $rules = $this->rules;

        $this->order->estado = $this->estado;

        $rules['nro_factura'] = '';

        $this->validate($rules);
        $this->order->observacion = $this->observacion;
        $this->order->save();
        $this->order->user->notify(new OrderNotification($this->order->id,$this->order->user_id));
        // session()->flash('message', $this->order->estado);

    }
    public function render()
    {
        //recuperamos la información que contiene la orden
        $items = json_decode($this->order->content);

        return view('livewire.status-order', compact('items'));
    }
}
