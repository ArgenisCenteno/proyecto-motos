<?php

namespace App\Notifications;

use App\Models\Pago;
use App\Models\CuentaPorCobrar;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PagoRealizadoNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $pago;
    protected $cuenta;

    /**
     * Create a new notification instance.
     *
     * @param Pago $pago
     * @param CuentaPorCobrar $cuenta
     */
    public function __construct(Pago $pago, CuentaPorCobrar $cuenta)
    {
        $this->pago = $pago;
        $this->cuenta = $cuenta;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'titulo' => 'Se ha realizado un pago',
            'message' => 'Se ha registrado un nuevo pago para la cuenta por cobrar del viaje ID: ' . $this->cuenta->viaje_id,
            'amount' => $this->pago->monto,
            'method' => $this->pago->metodo_pago,
            'url' => url('/cuentasPorCobrar/' . $this->cuenta->id . '/edit')
        ];
    }
}
