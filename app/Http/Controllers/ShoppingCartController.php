<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    protected $listeners = ['render'];

    public function index()
    {

        return view('shoppingcart-index');
    }
}
