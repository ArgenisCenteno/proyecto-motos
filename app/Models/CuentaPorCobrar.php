<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CuentaPorCobrar extends Model
{
    // Definir la tabla asociada (opcional si sigue las convenciones de nombre)
    protected $table = 'cuenta_por_cobrar';

    // Definir los campos que se pueden llenar en el modelo
    protected $fillable = [
        'descripcion',
        'monto',
        'status',
        'viaje_id',
        'user_id',
        'procesado_por'
    ];

    /**
     * Relación con el modelo User (quien generó la cuenta por cobrar).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relación con el modelo User (quien procesó la cuenta por cobrar).
     */
    public function procesadoPor()
    {
        return $this->belongsTo(User::class, 'procesado_por');
    }

    /**
     * Relación con el modelo Viaje.
     */
    public function viaje()
    {
        return $this->belongsTo(Viaje::class, 'viaje_id');
    }

    public function pago()
{
    return $this->belongsTo(Pago::class, 'pago_id');
}
}
