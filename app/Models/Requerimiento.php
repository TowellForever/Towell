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
        'fecha', 
        'turno', 
        'metros', 
        'status', 
        'julio_reserv',           // Añadir a $fillable
        'orden_prod',             // Añadir a $fillable
        'fecha_hora_creacion',    // Añadir a $fillable
        'fecha_hora_modificado',  // Añadir a $fillable
        'ck_A1', 
        'ck_A2', 
        'ck_A3', 
        'ck_A4', 
        'ck_A5', 
        'ck_A6', 
        'ck_B1', 
        'ck_B2', 
        'ck_B3', 
        'ck_B4', 
        'ck_B5', 
        'ck_B6', 
        'ck_C1', 
        'ck_C2', 
        'ck_C3', 
        'ck_C4', 
        'ck_C5', 
        'ck_C6', 
        'ck_D1', 
        'ck_D2', 
        'ck_D3', 
        'ck_D4', 
        'ck_D5', 
        'ck_D6', 
        'ck_E1', 
        'ck_E2', 
        'ck_E3', 
        'ck_E4', 
        'ck_E5', 
        'ck_E6',
        'ck_F1', 
        'ck_F2', 
        'ck_F3', 
        'ck_F4', 
        'ck_F5', 
        'ck_F6',
        'ck_G1', 
        'ck_G2', 
        'ck_G3', 
        'ck_G4', 
        'ck_G5', 
        'ck_G6'
    ];

    // Definimos cómo se deben convertir los campos de fecha
    protected $casts = [
        'fecha' => 'date',
        'fecha1' => 'date',
        'fecha2' => 'date',
        'fecha3' => 'date',
    ];
}
