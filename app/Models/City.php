<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{

    use HasFactory;

    protected $fillable = ['nombre_ciudad','costo'];
    //Relacion de uno a muchos
    public function orders(){
        return $this->hasMany(Order::class);
    }
}
