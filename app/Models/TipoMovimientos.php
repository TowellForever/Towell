<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoMovimientos extends Model
{
     use HasFactory;

    protected $table = 'tipo_movimientos';

    protected $fillable = [
        'fecha_inicio',
        'fecha_fin',
        'fecha',
        'fraccion_dia',
        'pzas',
        'kilos',
        'rizo',
        'cambio',
        'trama',
        'combinacion1',
        'combinacion2',
        'combinacion3',
        'combinacion4',
        'piel1',
        'tej_num',
    ];

    public function tejido()
    {
        return $this->belongsTo(Planeacion::class, 'tej_num', 'num_registro');
    }
}
