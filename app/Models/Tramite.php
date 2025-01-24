<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tramite extends Model
{
    use HasFactory;

    // Definir la tabla relacionada
    protected $table = 'tramites';

    // Campos que pueden ser asignados de manera masiva
    protected $fillable = [
        'tipo',
        'descripcion',
        'user_id',
        'estado',
        'aprobado_por',
        'revisado_por'
    ];

    // Relación con el modelo User (quien creó el trámite)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con el modelo User (quien aprobó el trámite)
    public function aprobadoPor()
    {
        return $this->belongsTo(User::class, 'aprobado_por');
    }

    // Relación con el modelo User (quien revisó el trámite)
    public function revisadoPor()
    {
        return $this->belongsTo(User::class, 'revisado_por');
    }
}
