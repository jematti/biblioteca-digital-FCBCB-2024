<?php

namespace App\Http\Livewire;


use Livewire\Component;

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

        if($this->estado == 5 || $this->estado == 1){
            $rules['observacion'] = 'required';
        }
        $this->validate($rules);
        $this->order->observacion = $this->observacion;
        $this->order->save();
    }
    public function render()
    {
        //recuperamos la información que contiene la orden
        $items = json_decode($this->order->content);

        return view('livewire.status-order', compact('items'));
    }
}
