<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConstruccionJulios extends Model
{
    use HasFactory;

    // Si el nombre de la tabla no sigue la convención (en plural), se especifica
    protected $table = 'construccion_urdido';

    // Si quieres proteger ciertas columnas de la asignación masiva:
    protected $fillable = ['folio','no_julios','hilos'];
}
