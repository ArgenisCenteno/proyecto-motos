<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PagoActualizadoNotification extends Notification
{
    use Queueable;

    protected $pago;

    public function __construct($pago)
    {
        $this->pago = $pago;
    }

    public function via($notifiable)
    {
        return ['database']; // Puedes añadir 'mail' si deseas enviar por correo también
    }

    public function toArray($notifiable)
    {
        return [
            'titulo' => 'Actualización del estado de pago',
            'mensaje' => 'El estado de su pago ha sido actualizado a: ' . $this->pago->status,
            'pago_id' => $this->pago->id,
            'status' => $this->pago->status,
            'tipo' => $this->pago->tipo,
            'url' => url('/cuentasPorCobrar/' . $this->pago->id . '/edit'),
            'created_at' => now(),
        ];
    }
}
