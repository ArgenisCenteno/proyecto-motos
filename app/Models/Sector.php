<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'parroquia_id', 'estado'];

    public function parish()
    {
        return $this->belongsTo(Parish::class, 'parroquia_id');
    }
}
