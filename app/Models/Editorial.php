<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Editorial extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre_editorial',
        'direccion',
        'contacto'
    ];

    // relacion 1 a n una Editorial puede tener varios libros
    public function books()
    {
        return $this->hasMany(Book::class);
    }

}
