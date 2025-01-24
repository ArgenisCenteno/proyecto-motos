<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo',
        'status',
        'banco_origen',
        'banco_destino',
        'numero_referencia',
        'viaje_id',
        'fecha_pago',
        'monto_total',
        'monto_neto',
        'referencia',
        'descuento',
        'tasa_dolar',
        'forma_pago',
        'comprobante_archivo',
        'creado_id',
        'porcentaje_descuento',
        'impuestos'
    ];


    public function recibos()
    {
        return $this->hasMany(Recibo::class, 'pago_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'creado_id');
    }

    public function viaje()
    {
        return $this->belongsTo(Viaje::class, 'viaje_id');
    }
}
