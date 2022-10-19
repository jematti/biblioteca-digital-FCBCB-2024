<?php

namespace App\Http\Livewire;


use App\Models\User;
use Livewire\Component;
use App\Notifications\OrderNotification;

class StatusOrder extends Component
{

    public $order, $estado,$usuario_id;

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
        $this->usuario_id= $this->order->user_id;
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
        session()->flash('message', $this->order->estado);
        //buscar notificacion y enviar al usuario correspondiente
        if ($this->order->estado != 4) {
        $usuario = User::find($this->usuario_id);
        $usuario->notify(new OrderNotification($this->order->id,$this->usuario_id,$this->order->estado));
        }

    }
    public function render()
    {
        //recuperamos la información que contiene la orden
        $items = json_decode($this->order->content);

        return view('livewire.status-order', compact('items'));
    }
}
