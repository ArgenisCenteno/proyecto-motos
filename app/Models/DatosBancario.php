<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatosBancario extends Model
{
    use HasFactory;

    // Definir los campos que se pueden asignar masivamente
    protected $fillable = [
        'user_id', 
        'banco', 
        'dni', 
        'tipo_cuenta', 
        'numero_cuenta', 
        'estatus'
    ];

    /**
     * Relación inversa: un dato bancario pertenece a un usuario.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
