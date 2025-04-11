<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oficial extends Model
{
    protected $table = 'oficiales'; // Nombre exacto de la tabla
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['oficial', 'tipo'];
}
