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
            // Agregar la columna después de Orden_Prod
            $table->boolean('en_proceso')->default(false)->after('Orden_Prod');
        });
    }

    public function down()
    {
        Schema::table('TEJIDO_SCHEDULING', function (Blueprint $table) {
            // Eliminar la columna si se revierte la migración
            $table->dropColumn('en_proceso');
        });
    }
};
