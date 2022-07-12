<?php

namespace App\Http\Livewire;

use Livewire\Component;

class CreateOrder extends Component
{
    public $tipo_envio=1;

    public $tipo_pago;

    public $nombre_contacto,$correo_contacto,$telfono_contacto,$ciudad_entrega,$direccion;

    public function render()
    {
        return view('livewire.create-order');
    }
}
