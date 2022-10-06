<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'edicion',
        'numero_paginas',
        'fecha_publicacion',
        'idioma',
        'resumen',
        'imagen',
        'precio',
        'ancho',
        'alto',
        'grueso',
        'peso',
        'cantidad',
        'author_id',
        'editorial_id',
        'category_id',
        'repository_id',
        'isbn',

    ];
    // relacion n a 1 un libro solo puede tener una editorial/categoria/autor/repositorio



    public function category()
    {
        return $this->belongsTo(Category::class); // FK de esta tabla
    }

    public function author()
    {
        return $this->belongsTo(Author::class); // FK de esta tabla
    }

    public function repository()
    {
        return $this->belongsTo(Repository::class); // FK de esta tabla
    }

}
