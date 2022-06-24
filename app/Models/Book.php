<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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
        'author_id',
        'editorial_id',
        'category_id',
        'repository_id',

    ];
    // relacion n a 1 un libro solo puede tener una editorial/categoria/autor/repositorio

    public function editorial()
    {
        return $this->belongsTo(Editorial::class); // FK de esta tabla
    }

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

/*
    // Obtiene la información del usuario via FK
    public function author()
    {
        return $this->belongsTo(Author::class); // FK de esta tabla
    }

    public function category()
    {
        return $this->belongsTo(Category::class); // FK de esta tabla
    }


*/


}
