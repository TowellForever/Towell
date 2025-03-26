<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Requerimiento extends Model
{
    use HasFactory;

    protected $table = 'requerimiento'; // Especificamos la tabla

    // Los campos que son asignables en masa
    protected $fillable = [
        'cuenta_rizo', 
        'cuenta_pie', 
        'metros', 
        'julio_reserv',           // Añadir a $fillable
        'status', 
        'orden_prod',             // Añadir a $fillable
        'valor',
        'fecha_hora_creacion',    // Añadir a $fillable
        'fecha_hora_modificado',  // Añadir a $fillable
    ];

    // Definimos cómo se deben convertir los campos de fecha
    protected $casts = [

    ];
}
