<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fallas extends Model
{
    // Deshabilitar los timestamps (created_at, updated_at)
    public $timestamps = false;

    // Si es necesario, puedes definir los atributos que son asignables masivamente
    protected $fillable = [
        'clave', 'descripcion', 'tipo'
    ];
}
