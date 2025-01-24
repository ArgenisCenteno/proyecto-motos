<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CuentaPorCobrarNotification extends Notification
{
    use Queueable;

    protected $cuenta;

    public function __construct($cuenta)
    {
        $this->cuenta = $cuenta;
    }

    public function via($notifiable)
    {
        return ['database']; // Puedes agregar 'mail' si deseas enviar la notificación por correo también.
    }

    public function toArray($notifiable)
    {
        return [
            'titulo' => 'Cuenta por pagar',
            'mensaje' => 'Tienes una cuenta pendiente de pago por el viaje solicitado.',
            'cuenta_id' => $this->cuenta->id,
            'monto' => $this->cuenta->monto,
            'url' => url('/pagar/' . $this->cuenta->id),
            'created_at' => now(),
        ];
    }
}
