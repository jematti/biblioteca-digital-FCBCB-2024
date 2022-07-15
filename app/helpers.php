<?php

use Gloudemans\Shoppingcart\Facades\Cart;
 use App\Models\Book;

 //recuperar el stock de un libro con su id
function cantidad($book_id){

    $book = Book::find($book_id);

    $cantidad = $book->cantidad;

    return $cantidad;
}

//verificar la cantidad de libro agregados en el carrito de compras
function cantidad_add($book_id){
    //recuperar la cantidad de productos añadidos al carrito de compras
    $cart= Cart::content();
    //buscar libro por id
    $item = $cart->where('id',$book_id)->first();

    if($item){
        return $item->qty;
    }else{
        return 0;
    }

}

//resta para verficar la cantidad de libros que puedo agregar a un carrito de compras

function cantidad_disponible($book_id){
    return (cantidad($book_id) - cantidad_add($book_id));
}


//descuenta la cantidad de libros que ya fueron comprados

function descontar($item) {
    $book = Book::find($item->id);

    $cantidad_disponible = cantidad_disponible($item->id);

    $book->cantidad = $cantidad_disponible;

    $book->save();

}


function incrementa($item) {

    $book = Book::find($item->id);

    $cantidad_actualizada= cantidad($item->id) + $item->qty;

    $book->cantidad = $cantidad_actualizada;

    $book->save();

}
