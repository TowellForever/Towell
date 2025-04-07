<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConstruccionUrdido extends Model
{
    use HasFactory;

    // Nombre de la tabla (si no es el plural del nombre del modelo)
    protected $table = 'construccion_urdido';

    // Si el modelo tiene una clave primaria diferente a 'id', la definimos aquí
    // protected $primaryKey = 'nombre_de_tu_clave_primaria';

    // Definir si la tabla usa o no timestamps
    public $timestamps = true;

    // Los campos que se pueden llenar de forma masiva
    protected $fillable = [
        'folio',
        'no_julios',
        'hilos',
    ];

    // Si se desea definir el tipo de dato de los campos, se puede hacer
    // protected $casts = [
    //     'created_at' => 'datetime',
    //     'updated_at' => 'datetime',
    // ];
}
