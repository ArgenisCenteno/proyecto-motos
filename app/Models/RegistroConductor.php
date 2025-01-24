<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroConductor extends Model
{
    use HasFactory;

    // Definir la tabla relacionada
    protected $table = 'registro_conductor';

    // Campos que pueden ser asignados de manera masiva
    protected $fillable = [
        'user_id',
        'estado',
        'documento_conducir',
        'documento_contrato',
        'documento_propiedad'
    ];

    // Relación con el modelo User (conductor)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
