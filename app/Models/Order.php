<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    //metodos de pago

    //pago mediante la banca movil QR
    const BANCAMOVIL = 10;

    //pago mediante deposito a la cuenta del banco
    const DEPOSITO = 20;

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

    //estado de la facturacion
    const NOFACTURADO = 100;
    const FACTURADO = 200;

    // fillable inverso campo que no requieren en asignacion masiva
    protected $guarded = ['id','created_at','updated_at','status'];

    // relacion uno a muchos inversa
    public function city(){
        return $this->belongsTo(City::class);
    }

    public function  user(){
        return $this->belongsTo(User::class);
    }

}
