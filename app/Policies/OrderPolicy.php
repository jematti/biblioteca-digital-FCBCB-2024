<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    public function verifica_usuario(User $user,Order $order)
    {
        if ($order->user_id == $user->id) {
            return true;
        } else {
            return false;
        }
    }

    public function pago(User $user,Order $order){
        if ($order->estado == 1) {
            return true;
        } else {
            return false;
        }

    }
}
