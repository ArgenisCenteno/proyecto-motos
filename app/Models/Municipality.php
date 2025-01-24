<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    use HasFactory;

    // Campos permitidos para asignación masiva
    protected $fillable = [
        'state_id',
        'municipality',
    ];

    // Definir la relación con el modelo State
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    // Relación con las parroquias
    public function parishes()
    {
        return $this->hasMany(Parish::class);
    }
}
