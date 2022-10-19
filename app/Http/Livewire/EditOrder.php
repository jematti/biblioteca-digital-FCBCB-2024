<?php

namespace App\Http\Livewire;

use App\Models\City;
use App\Models\User;
use App\Models\Order;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image;
use App\Notifications\OrderNotification;

class EditOrder extends Component
{
    use WithFileUploads;

    public $order_id;//nombre interno de nuestro componente

    public $subtotal;

    public $tipo_pago;

    public $costo_envio=0;

    public $ciudades="";

    public $ciudad_id="";

    //public $city_id="";

    //datos para realizar la orden de compra
    public $nombre_contacto,$correo_contacto,$telefono_contacto,$direccion,$total,$costo_envio_edit;

    //datos para la facturacion
    public $nombre_factura,$nit_factura;

    //img del deposito
    public $imagen;

    public $imagen_nueva;

    public $rules =[
        'nombre_contacto'=> 'required',
        'correo_contacto' => 'required|email',
        'telefono_contacto' => 'required',
        'tipo_pago' => 'required',
        'nombre_factura' => 'required',
        'nit_factura' => 'required',
        'ciudad_id'=> 'required',
        'direccion'=> 'required',
        'imagen_nueva' => 'nullable|image'
    ];

    public function mount(Order $order){

        $this->order_id = $order->id;
        $this->ciudades = City::all();
        $this->nombre_contacto = $order->nombre_contacto;
        $this->correo_contacto = auth()->user()->email;
        $this->telefono_contacto = $order->telefono_contacto;
        $this->nombre_factura = $order->nombre_factura;
        $this->nit_factura = $order->nit_factura;
        $this->tipo_pago = $order->tipo_pago;
        $this->costo_envio_edit = $order->costo_envio;
        $this->total = $order->total;
        $this->content = $order->content;
        $this->ciudad_id = $order->city_id ;
        $this->direccion = $order->direccion ;
        $this->costo_envio = $order->costo_envio ;
        $this->imagen_deposito= $order->imagen_deposito;

        $this->subtotal= $order->total - $order->costo_envio;
    }
    public function updatedCiudadId($value)
    {
        $city = City::find($value);

        $this->costo_envio = $city->costo;
    }

    public function editOrder(){
        $rules = $this->rules;

        $datos = $this->validate($rules);

        //encontrar la vacante a editar
        $order = Order::find($this->order_id);

        //asignar los valores
        $order->nombre_contacto = $datos['nombre_contacto'];
        $order->telefono_contacto = $datos['telefono_contacto'];
        $order->nombre_factura = $datos['nombre_factura'];
        $order->nit_factura = $datos['nit_factura'];
        $order->tipo_pago = $datos['tipo_pago'];
        $order->costo_envio = $this->costo_envio;
        $order->total = $this->subtotal + $this->costo_envio;
        $order->city_id = $datos['ciudad_id'];
        $order->direccion = $datos['direccion'];

        if ($this->imagen_nueva) {
         // si hay una nueva imagen
         $imagen=$this->imagen_nueva;

         //uuid para el nombre del archivo unico
         $datos['imagen_nueva'] = Str::uuid() . '.' . $imagen->extension();

         //almacenar la imagen en el servidor
         $imagenServidor = Image::make($imagen);


         $imagenPath = public_path('depositos').'/'. $datos['imagen_nueva'];
         //solo guarda la ruta en la base de datos y no la imagen
         $imagenServidor->save($imagenPath);
         // fin de seccion guardar imagen
        }

        //guardar ruta de la imagen en la base de datos
        $order->imagen_deposito = $datos['imagen_nueva'] ?? $order->imagen_deposito;

        //cambiar el estado del pedido a recibido
        $order->estado = 2;

        $order->save();

        //actualizar correo si es necesario
        $usuario = User::find(auth()->user()->id);
        $usuario->email = $datos['correo_contacto'];;
        $usuario->save();
        //redireccionar
        return redirect()->route('orders.index');
        //crear notificación de orden de compra para administración
        $admin = User::find(1);
        $admin->notify(new OrderNotification($order->id,1,$order->estado));
        // crear notificacion para el usuario de orden recibida
        $order->user->notify(new OrderNotification($order->id,$order->user_id,$order->estado));
    }

    public function render()
    {
        //recuperamos la información que contiene la orden
        $items = json_decode($this->content);
        $ciudades = City::all();
        return view('livewire.edit-order',['ciudaddes' => $ciudades,'items' => $items ]);
    }


}
