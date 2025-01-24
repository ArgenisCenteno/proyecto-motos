<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Viaje extends Model
{
    use HasFactory;

    // Campos que pueden ser asignados masivamente
    protected $fillable = [
        'vehiculo_id',
        'user_id',
        'origen',
        'destino',
        'distancia_km',
        'precio',
        'estado',
        'hora_salida',
        'hora_llegada',
        'direccion',
        'sector_id',
        'conductor_id',
    ];
    protected $casts = [
        'hora_salida' => 'datetime',
        'hora_llegada' => 'datetime',
    ];
    
    // Relación con el modelo User (asumiendo que un viaje pertenece a un usuario)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el modelo Vehiculo (asumiendo que un viaje pertenece a un vehículo)
    public function vehiculo()
    {
        return $this->belongsTo(Vehicle::class);
    }


    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    public function conductor()
    {
        return $this->belongsTo(User::class, 'conductor_id');
    }
}
