<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {

        $notifications = auth()->user()->unreadNotifications;

        //limpiar notificaciones
        auth()->user()->unreadNotifications->markAsRead();

        return view('notifications.index',[
            'notifications' => $notifications
        ]);
    }
}
