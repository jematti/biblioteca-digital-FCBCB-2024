<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //Categoria habilitado en la tienda
    const HABILITADO = 1;

    //Categoria no habilitado o eliminado de la tienda virtual
    const INHABILITADO = 0;
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre_categoria',
    ];
    // relacion 1 a n una Categoria puede tener varios libro
    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
