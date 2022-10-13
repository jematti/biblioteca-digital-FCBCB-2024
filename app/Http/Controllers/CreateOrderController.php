<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class CreateOrderController extends Controller
{
    public function index()
    {

        return view('createorder-index');
    }

    public function edit(Order $order)
    {
       return view('updateorder-edit',['order' => $order]);
    }
}
