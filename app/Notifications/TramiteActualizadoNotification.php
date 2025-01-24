<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TramiteActualizadoNotification extends Notification
{
    use Queueable;

    protected $tramite;

    public function __construct($tramite)
    {
        $this->tramite = $tramite;
    }

    public function via($notifiable)
    {
        return ['database']; // Puedes agregar 'mail' si deseas enviar también por correo
    }

    public function toArray($notifiable)
    {
        return [
            'titulo' => 'Actualización de Estado del Trámite',
            'mensaje' => 'El estado de su trámite ha sido actualizado a: ' . $this->tramite->estado,
            'estado' => $this->tramite->estado,
            'tramite_id' => $this->tramite->id,
            'observacion' => $this->tramite->observacion ?? null,
            'url' => url('/tramites/' . $this->tramite->id),
            'created_at' => now(),
        ];
    }
}
