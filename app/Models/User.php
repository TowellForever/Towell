<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    // Indicar que la tabla es 'usuarios' en lugar de 'users'
    protected $table = 'usuarios';

    protected $fillable = [
        'numero_empleado', 'contrasenia', 'name', 'area', 'foto'
    ];

    protected $hidden = [
        'contrasenia', 'remember_token',
    ];

    protected $casts = [
        'contrasenia' => 'hashed',
    ];

    // Usar el numero_empleado como username
    public function getAuthIdentifierName()
    {
        return 'numero_empleado';
    }
}
