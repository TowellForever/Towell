<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoMovimientos extends Model
{
    public $timestamps = false; // Si tu tabla no tiene timestamps, pon esto

    protected $fillable = [
        'fecha','tipo_mov','cantidad','tej_num'
    ];
}
