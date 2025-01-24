<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'dni',
        'sector',
        'calle',
        'genero',
        'referencia',
        'casa',
        'status',
        'foto_perfil'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationship with Vehicle
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class, 'user_id');
    }

    // Relationship with Tramite
    public function tramites()
    {
        return $this->hasMany(Tramite::class, 'user_id');
    }

    // Relationship with RegistroConductor
    public function registroConductores()
    {
        return $this->hasMany(RegistroConductor::class, 'user_id');
    }
    // En el modelo User.php
    public function datosBancarios()
    {
        return $this->hasOne(DatosBancario::class);
    }

}
