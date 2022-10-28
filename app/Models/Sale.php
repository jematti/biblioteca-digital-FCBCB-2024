<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;
    //estado del producto en pendiente hasta que se ejecute el pago / errores de deposito o datos incorrectos
    const PENDIENTE = 1;
    //el usuario ha generado la orden y lo ha pagado
    const RECIBIDO = 2;
    // el producto esta en camino
    const ENVIADO = 3;
    // cuando se entrego el producto
    const ENTREGADO = 4;
    // producto que se ha generado la orden pero nose a pagado (Pasa de Pendiente a Anulado)
    const ANULADO = 5;

    protected $guarded = ['id','created_at','updated_at'];

    public function order(){
        return $this->belongsTo(Order::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
}
