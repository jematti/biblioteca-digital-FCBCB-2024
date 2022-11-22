<?php

namespace App\Http\Livewire;

use App\Models\City;
use App\Models\Order;
use App\Models\Sale;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Intervention\Image\Facades\Image;
use Gloudemans\Shoppingcart\Facades\Cart;

class CreateOrder extends Component
{
    use WithFileUploads;

   public $tipo_pago=1;

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



    public function render()
    {
        return view('livewire.create-order');
    }

    public $rules =[
        'nombre_contacto'=> 'required',
        'correo_contacto' => 'required|email',
        'telefono_contacto' => 'required',
        'tipo_pago' => 'required',
        'imagen_deposito' => 'required',
        'nombre_factura' => 'required',
        'nit_factura' => 'required',
        'ciudad_id'=> 'required',
        'direccion'=> 'required',

    ];

    public function mount(){
        $this->ciudades = City::all();
        $this->correo_contacto = auth()->user()->email;
    }


    public function updatedCiudadId($value)
    {
        $city = City::find($value);

        $this->costo_envio = $city->costo;
    }

    public function create_order(){
        $rules = $this->rules;

        $this->validate($rules);
        //crear orden de compra
        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->nombre_contacto = $this->nombre_contacto;
        $order->telefono_contacto = $this->telefono_contacto;
        $order->nombre_factura = $this->nombre_factura;
        $order->nit_factura = $this->nit_factura;
        $order->tipo_pago = $this->tipo_pago;
        $order->costo_envio = 0;
        $order->total = $this->costo_envio + str_replace( ',', '', Cart::subtotal() );
        $order->content = Cart::content();
        // si se selecciona el envio a domicilio se guarda los siguienes datos
        $order->city_id = $this->ciudad_id;
        $order->direccion = $this->direccion;
        $order->costo_envio = $this->costo_envio;


        //Seccion guardar imagen

        $imagen = $this->imagen_deposito;

        //uuid para el nombre del archivo unico
        $nombreImagen = Str::uuid() . '.' . $imagen->extension();

        //almacenar la imagen en el servidor
        $imagenServidor = Image::make($imagen);

        $imagenPath = public_path('depositos').'/'. $nombreImagen;
        //solo guarda la ruta en la base de datos y no la imagen
        $imagenServidor->save($imagenPath);

        // fin de seccion guardar imagen

        //guardar ruta de la imagen en la base de datos
        $order->imagen_deposito = $nombreImagen;

        //guardar orden en la base de datos
        $order->save();


        //guardamos en la tabla de ventas (sale)
        foreach (Cart::content() as $item) {
            $sale = new Sale();
            $sale->product_id = $item->id;
            $sale->order_id = $order->id;
            $sale->qty = $item->qty;
            $sale->repositorio = $item->options->repositorio;
            $sale->autor = $item->options->autor;
            $sale->categoria= $item->options->categoria;
            $sale->save();
            descontar($item);
        }


        //limpiar carrito
        Cart::destroy();

        return redirect()->route('orders.payment',$order);
    }




}
