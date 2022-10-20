<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class OrderNotification extends Notification  implements ShouldQueue
{
    use Queueable;

    public $id_order,$usuario_id,$estado;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($id_order, $usuario_id,$estado)
    {
        $this->id_order = $id_order;
        $this->usuario_id = $usuario_id;
        $this->estado = $estado;
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
        if ($this->usuario_id == 1) {
            $url = url('/admin/orders/'.$this->id_order);
        }else{
            $url = url('/orders/'.$this->id_order);
        }



        switch ($this->estado) {
                case 1:
                    //pendiente
                    return (new MailMessage)
                        ->line('Tiene una notificación de Orden de Compra pendiente')
                        ->action('Ver Estado de Orde de Compra',$url)
                        ->line('Gracias por utilizar la Tienda Virtual de la FC-BCB');
                    break;

                case 2:
                    //recibido
                    return (new MailMessage)
                        ->line('Se ha recibido una nueva orden de compra en la Tienda Virtual de la FC-BCB.')
                        ->action('Ver Estado de Orden de Compra',$url)
                        ->line('Gracias por utilizar la Tienda Virtual de la FC-BCB');
                    break;
                case 3:
                    //enviado
                    return (new MailMessage)
                        ->line('¡Su orden de compra ha sido enviada!')
                        ->action('Ver Estado de Orden de Compra',$url)
                        ->line('Gracias por utilizar la Tienda Virtual de la FC-BCB');
                    break;
                case 5:
                    //anulado
                    return (new MailMessage)
                        ->line('¡Su orden de Compra ha sido Cancelada!')
                        ->action('Ver Estado de Orden de Compra',$url)
                        ->line('Gracias por utilizar la Tienda Virtual de la FC-BCB');
                     break;
            default:
                break;
        }

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
            'usuario_id' => $this->usuario_id,
            'estado' => $this->estado
        ];
    }
}
