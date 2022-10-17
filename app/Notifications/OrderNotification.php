<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($id_order, $usuario_id)
    {
        $this->id_order = $id_order;
        $this->usuario_id = $usuario_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $url = url('/candidatos/'.$this->id_order);
        return (new MailMessage)
                    ->line('Has recibido una nueva orden de compra en la tienda.')
                    ->action('Ver Notificaciones',$url)
                    ->line('Gracias por utilizar la Tienda Virtual de la FC-BCB');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    //almacena las notificaciones en la base de datos
    public function toDatabase($notifiable)
    {
        return [
            'id_order' => $this->id_order,
            'usuario_id' => $this->usuario_id
        ];
    }
}
