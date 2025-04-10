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
        Schema::create('orden_urdido', function (Blueprint $table) {
            $table->string('id2'); // Campo ID
            $table->string('fecha');
            $table->string('oficial');
            $table->string('turno');
            $table->string('hora_inicio');
            $table->string('hora_fin');
            $table->string('no_julio');
            $table->string('hilos');
            $table->string('peso_bruto', 8, 2);
            $table->string('tara', 8, 2);
            $table->string('peso_neto', 8, 2);
            $table->string('metros');
            $table->string('hilatura');
            $table->string('maquina');
            $table->string('operacion');
            $table->string('transferencia');
            $table->string('folio'); // Llave foránea que hace referencia a 'folio' en la tabla 'requerimiento'

            // Definir la llave foránea
            $table->foreign('folio')->references('folio')->on('urdido_engomado')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('orden_urdido');
    }
};
