<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
     //pago mediante la banca movil QR
     const HABILITADO = 1;

     //pago mediante deposito a la cuenta del banco
     const INHABILITADO = 0;

    use HasFactory;

    protected $guarded = ['id','created_at','updated_at','habilitado'];

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
