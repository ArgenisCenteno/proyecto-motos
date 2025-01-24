<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    // Campos permitidos para asignación masiva
    protected $fillable = [
        'state',
        'iso_3166_2',
    ];

    // Relación con los municipios
    public function municipalities()
    {
        return $this->hasMany(Municipality::class);
    }
}
