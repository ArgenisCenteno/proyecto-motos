<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ViajeSolicitadoNotification extends Notification
{
    use Queueable;

    protected $viaje;

    public function __construct($viaje)
    {
        $this->viaje = $viaje;
    }

    public function via($notifiable)
    {
        return ['database']; // Puedes agregar 'mail' si deseas enviarlo también por correo
    }

    public function toArray($notifiable)
    {
        return [
            'titulo' => 'Nueva solicitud de viaje',
            'mensaje' => 'Se ha realizado una nueva solicitud por parte de ' . auth()->user()->name,
            'viaje_id' => $this->viaje->id,
            'monto_total' => $this->viaje->precio,
            'type' => 'Solicitud de viaje',
            'url' => url('/viajes/' . $this->viaje->id . '/edit'), // Actualiza la ruta a la de edición

            'created_at' => now(),
        ];
    }
}
