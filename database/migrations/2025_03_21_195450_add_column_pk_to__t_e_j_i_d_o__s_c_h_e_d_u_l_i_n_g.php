<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('TEJIDO_SCHEDULING', function (Blueprint $table) {
            // Paso 1: Agregar campo id
            $table->id()->first(); // Esto crea un campo 'id' autoincremental como primary key
        });
    }

    public function down()
    {
        Schema::table('TEJIDO_SCHEDULING', function (Blueprint $table) {
            // Paso 2: Eliminar la columna 'id' si necesitas revertir
            $table->dropColumn('id');
        });
    }
};
