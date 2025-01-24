<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parish extends Model
{
    use HasFactory;

    // Campos permitidos para asignación masiva
    protected $fillable = [
        'municipality_id',
        'parish',
    ];

    // Definir la relación con el modelo Municipality
    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }
}
