<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    // Campos permitidos para asignación masiva
    protected $fillable = [
        'user_id',
        'tipo',
        'marca',
        'modelo',
        'color',
        'placa',
        'anio',
        'servicio_id',
        'status'
    ];

    // Relación con el usuario (dueño del vehículo)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el servicio
    public function service()
    {
        return $this->belongsTo(Servicio::class, 'servicio_id');
    }
}
