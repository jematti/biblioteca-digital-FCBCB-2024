<?php

namespace App\Http\Livewire;

use App\Models\City;
use App\Models\Order;
use Livewire\Component;

class EditOrder extends Component
{
    public $tipo_pago;

    public $costo_envio=0;

    public $ciudades="";

    public $ciudad_id="";

    public $order_id;
    //datos para realizar la orden de compra
    public $nombre_contacto,$correo_contacto,$telefono_contacto,$direccion;

    //datos para la facturacion
    public $nombre_factura,$nit_factura;

    //img del deposito
    public $imagen_deposito;


    public function mount(Order $order){

        $this->ciudades = City::all();
        $this->nombre_contacto = $order->nombre_contacto;
        $this->correo_contacto = $order->correo_contacto;
        $this->telefono_contacto = $order->telefono_contacto;
        $this->nombre_factura = $order->nombre_factura;
        $this->nit_factura = $order->nit_factura;
        $this->tipo_pago= $order->tipo_pago;
        // if ($this->tipo_pago === "10") {
        //     $this->tipo_pago = 1;
        // }
        // if ($this->tipo_pago === "20") {
        //     $this->tipo_pago = 2;
        // }
        // ;
        $this->costo_envio = $order->costo_envio;
        $this->total = $order->costo_total;
        $this->content = $order->content;
        $this->ciudad_id = $order->city_id ;
        $this->direccion = $order->direccion ;
        $this->costo_envio = $order->costo_envio ;
    }
    public function updatedCiudadId($value)
    {
        $city = City::find($value);

        $this->costo_envio = $city->costo;
    }

    public function render()
    {
        $ciudades = City::all();
        return view('livewire.edit-order',['ciudaddes' => $ciudades]);
    }
}
