<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ViajeCanceladoNotification extends Notification
{
    use Queueable;

    protected $viaje;

    public function __construct($viaje)
    {
        $this->viaje = $viaje;
    }

    public function via($notifiable)
    {
        return ['database']; // También puedes agregar 'mail' si deseas enviar la notificación por correo.
    }

    public function toArray($notifiable)
    {
        return [
            'titulo' => 'Viaje Cancelado',
            'mensaje' => 'El viaje con ID ' . $this->viaje->id . ' ha sido cancelado.',
            'viaje_id' => $this->viaje->id,
            'estado' => $this->viaje->estado,
            'url' => url('/viajes/' . $this->viaje->id . '/edit'),
            'created_at' => now(),
        ];
    }
}
