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
        Schema::table('catalago_telares', function (Blueprint $table) {
            // Renombrar columnas
            $table->renameColumn('piel', 'pie');
            $table->renameColumn('cuenta', 'rizo');

            // Agregar nuevas columnas
            $table->string('calibre_rizo')->nullable();
            $table->string('calibre_pie')->nullable();
        });
    }

    public function down()
    {
        Schema::table('catalago_telares', function (Blueprint $table) {
            // Restaurar los nombres originales
            $table->renameColumn('pie', 'piel');
            $table->renameColumn('rizo', 'cuenta');

            // Eliminar las nuevas columnas
            $table->dropColumn('calibre_rizo');
            $table->dropColumn('calibre_pie');
        });
    }
};
