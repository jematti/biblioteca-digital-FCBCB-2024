<?php

use App\Models\Order;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('nombre_contacto');
            $table->string('correo_contacto');
            $table->string('telefono_contacto');
            $table->enum('tipo_pago', [Order::BANCAMOVIL,Order::DEPOSITO]);
            $table->enum('estado',[Order::PENDIENTE,Order::RECIBIDO,Order::ENVIADO,Order::ENTREGADO,Order::ANULADO])->default(Order::PENDIENTE);
            $table->enum('tipo_envio',[1,2]);
            $table->float('costo_final');
            $table->float('total');
            $table->json('content');
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->string('direccion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
