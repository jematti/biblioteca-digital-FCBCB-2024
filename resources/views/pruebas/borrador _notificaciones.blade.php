@php

//crear notificación de orden de compra para administración
$admin = User::find(1);
$admin->notify(new OrderNotification($order->id,1,$order->estado));
// crear notificacion para el usuario de orden recibida
$order->user->notify(new OrderNotification($order->id,$order->user_id,$order->estado));
@endphp
