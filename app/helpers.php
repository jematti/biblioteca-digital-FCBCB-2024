<?php

use Gloudemans\Shoppingcart\Facades\Cart;
 use App\Models\Product;

 //recuperar el stock de un libro con su id
function cantidad($product_id){

    $product = Product::find($product_id);

    $cantidad = $product->cantidad;

    return $cantidad;
}

//verificar la cantidad de libro agregados en el carrito de compras
function cantidad_add($product_id){
    //recuperar la cantidad de productos añadidos al carrito de compras
    $cart= Cart::content();
    //buscar libro por id
    $item = $cart->where('id',$product_id)->first();

    if($item){
        return $item->qty;
    }else{
        return 0;
    }

}

//resta para verficar la cantidad de libros que puedo agregar a un carrito de compras

function cantidad_disponible($product_id){
    return (cantidad($product_id) - cantidad_add($product_id));
}


//descuenta la cantidad de libros que ya fueron comprados

function descontar($item) {
    $product = Product::find($item->id);

    $cantidad_disponible = cantidad_disponible($item->id);

    $product->cantidad = $cantidad_disponible;

    $product->save();

}


function incrementa($item) {

    $product = Product::find($item->id);

    $cantidad_actualizada= cantidad($item->id) + $item->qty;

    $product->cantidad = $cantidad_actualizada;

    $product->save();

}
