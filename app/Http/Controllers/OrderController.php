<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class OrderController extends Controller
{
    public function index()
    {
        //realizamos la consulta a la base de datos segun el usuario
        $orders = Order::query()->where('user_id', auth()->id());
        // $orders = Order::query()->orderBy('id','desc')->where('user_id', auth()->id());

        //preguntamos si recibimos una variable del estado de la orden
        if (request('estado')) {
            $orders->where('estado',request('estado'));
        }

        //obtenemos la coleccion de la ordenes
        $orders=$orders->get();

        //obtenemos la cantidad de ordenes por el estado de la orden
        $pendiente = Order::where('estado',1)->where('user_id', auth()->id())->count();
        $recibido = Order::where('estado',2)->where('user_id', auth()->id())->count();
        $enviado = Order::where('estado',3)->where('user_id', auth()->id())->count();
        $entregado = Order::where('estado',4)->where('user_id', auth()->id())->count();
        $anulado = Order::where('estado',5)->where('user_id', auth()->id())->count();

        return view('orders.index', compact('orders','pendiente','recibido','enviado','entregado','anulado'));
    }

    public function show(Order $order)
    {
        $this->authorize('verifica_usuario',$order);

        $items = json_decode($order->content);
        return view('orders.show', compact('order','items'));
    }

    public function payment(Order $order){

        $this->authorize('verifica_usuario',$order);
        $this->authorize('pago',$order);
        $items = json_decode($order->content);
        return view('orders.payment',compact('order','items'));

    }

    public function pay(Order $order){

        $order->estado = 2;

        $order->save();
        return redirect()->route('orders.show',$order);
    }

    public function download($file){
        $pathtoFile = public_path('depositos'.'/'.$file);
        return response()->download($pathtoFile);
    }
}
