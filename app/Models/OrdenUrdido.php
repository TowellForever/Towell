<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenUrdido extends Model
{
    use HasFactory;
    protected $table = 'orden_urdido'; // Nombre exacto de la tabla

    // Desactivar los timestamps automáticos
    public $timestamps = false;

    protected $fillable = [
        'id',
        'folio',
        'fecha',
        'oficial',
        'turno',
        'hora_inicio',
        'hora_fin',
        'no_julio',
        'hilos',
        'peso_bruto',
        'tara',
        'peso_neto',
        'metros',
        'hilatura',
        'maquina',
        'operacion',
        'transferencia',
    ];
}
