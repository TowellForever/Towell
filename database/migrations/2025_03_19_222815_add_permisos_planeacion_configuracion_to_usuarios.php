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
        Schema::table('usuarios', function (Blueprint $table) {
            // Agregar los nuevos campos para los permisos
            $table->boolean('planeacion')->default(0);
            $table->boolean('configuracion')->default(0);
        });
    }
    
    public function down()
    {
        Schema::table('usuarios', function (Blueprint $table) {
            // Eliminar los nuevos campos si se revierte la migración
            $table->dropColumn('planeacion');
            $table->dropColumn('configuracion');
        });
    }
    
};
