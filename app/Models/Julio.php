<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Julio extends Model
{
        // Definir los campos que son "fillable" o asignables masivamente
        protected $fillable = [
            'no_julio', 'tara', 'tipo'
        ];
}
