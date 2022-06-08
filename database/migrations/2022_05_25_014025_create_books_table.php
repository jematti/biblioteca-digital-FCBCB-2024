<?php

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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('edicion');
            $table->string('ubicacion');
            $table->integer('numero_paginas');
            $table->date('fecha_publicacion');
            $table->string('idioma');
            $table->text('resumen');
            $table->string('imagen');
            $table->foreignId('author_id')->constrained()->onDelete('cascade');
            $table->foreignId('editorial_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('books');
    }
};
