<?php

use App\Models\Repository;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repositories', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_repositorio');
            $table->string('sigla')->nullable();
            $table->string('ciudad');
            $table->string('correo');
            $table->string('nombre_encargado');
            $table->string('direccion');
            $table->text('ubicacion')->nullable();
            $table->string('horario_atencion');
            $table->string('telefono');
            $table->string('pagina_web');
            $table->string('imagen_repositorio')->nullable();
            $table->enum('habilitado', [Repository::HABILITADO,Repository::INHABILITADO])->default(Repository::HABILITADO);
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
        Schema::dropIfExists('repositories');
    }
};
