<?php

namespace App\Http\Livewire;

use App\Models\City;
use App\Models\Order;
use Livewire\Component;
use Gloudemans\Shoppingcart\Facades\Cart;

class CreateOrder extends Component
{
    public $tipo_envio=1;

    public $tipo_pago=1;

    public $costo_envio=0;

    public $ciudades="";

    public $ciudad_id="";

    public $nombre_contacto,$correo_contacto,$factura,$telefono_contacto,$direccion;

    public $rules =[
        'nombre_contacto'=> 'required',
        'correo_contacto' => 'required|email',
        'telefono_contacto' => 'required',
        'factura' => 'required',
        'tipo_envio' => 'required',
        'tipo_pago' => 'required'
    ];

    public function mount(){
        $this->ciudades = City::all();
    }



    // resetar validacion de envios de productos

    public function updatedTipoEnvio($value)
    {
        if ($value == 1) {
            $this->resetValidation([
                'ciudad_id' ,
                'direccion'
            ]);

        }
        $this->tipo_envio=$value;
    }

    public function updatedCiudadId($value)
    {
        $city = City::find($value);

        $this->costo_envio = $city->costo;
    }

    public function create_order(){
        $rules = $this->rules;

        if($this->tipo_envio == 1){
            $rules['ciudad_id'] = 'required';
            $rules['direccion'] = 'required';
        }

        $this->validate($rules);
        //crear orden de compra
        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->nombre_contacto = $this->nombre_contacto;
        $order->correo_contacto = $this->correo_contacto;
        $order->telefono_contacto = $this->telefono_contacto;
        $order->factura = $this->factura;
        $order->tipo_pago = $this->tipo_pago;
        $order->tipo_envio = $this->tipo_envio;
        $order->costo_envio = 0;
        $order->total = $this->costo_envio + Cart::subtotal();
        $order->content = Cart::content();

        // si se selecciona el envio a domicilio se guarda los siguienes datos
        if ($this->tipo_envio == 1) {
            $order->city_id = $this->ciudad_id;
            $order->direccion = $this->direccion;
            $order->costo_envio = $this->costo_envio;
        }

        $order->save();

        foreach (Cart::content() as $item) {
            descontar($item);
        }
        //limpiar carrito
        Cart::destroy();

        return redirect()->route('orders.payment',$order);


    }

    public function render()
    {
        return view('livewire.create-order');
    }
}
