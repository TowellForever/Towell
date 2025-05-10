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
        'fraccion_dia',
        'pzas',
        'kilos',
        'tej_num',
    ];

    public function tejido()
    {
        return $this->belongsTo(Planeacion::class, 'tej_num', 'num_registro');
    }
}
