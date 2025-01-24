<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ViajeAsignacionNotification extends Notification
{
    use Queueable;

    protected $viaje;

    public function __construct($viaje)
    {
        $this->viaje = $viaje;
    }

    public function via($notifiable)
    {
        return ['database']; // También puedes agregar 'mail' si necesitas notificación por correo.
    }

    public function toArray($notifiable)
    {
        return [
            'titulo' => 'Viaje Asignado',
            'mensaje' => 'Se le ha asignado el viaje nro: ' . $this->viaje->id,
            'viaje_id' => $this->viaje->id,
            'estado' => $this->viaje->estado,
            'vehiculo_id' => $this->viaje->vehiculo_id,
            'hora_salida' => $this->viaje->hora_salida,
            'hora_llegada' => $this->viaje->hora_llegada,
            'url' => url('/viajes/' . $this->viaje->id . '/edit'),
            'created_at' => now(),
        ];
    }
}
