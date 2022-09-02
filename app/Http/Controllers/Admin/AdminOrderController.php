<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminOrderController extends Controller
{
    public function index(){

        //realizamos la consulta a la base de datos segun el usuario
        $orders = Order::orderBy('id', 'desc');
        // $orders = Order::query()->where('estado','<>',1);

        //preguntamos si recibimos una variable del estado de la orden
        if (request('estado')) {
            $orders->where('estado',request('estado'));
        }

        //obtenemos la coleccion de la ordenes
        $orders=$orders->get();

        //obtenemos la cantidad de ordenes por el estado de la orden
        $pendiente = Order::where('estado',1)->count();
        $recibido = Order::where('estado',2)->count();
        $enviado = Order::where('estado',3)->count();
        $entregado = Order::where('estado',4)->count();
        $anulado = Order::where('estado',5)->count();

        return view('admin.orders.index',compact('orders','pendiente','recibido','enviado','entregado','anulado'));
    }

    public function show(Order $order){
        return view('admin.orders.show', compact('order'));

    }
}
