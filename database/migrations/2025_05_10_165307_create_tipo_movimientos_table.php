<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('tipo_movimientos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->date('fecha');
            $table->decimal('fraccion_dia',8,2);
            $table->decimal('pzas',8,2);
            $table->decimal('kilos', 8, 2);
            $table->decimal('rizo', 8, 2)->nullable();
            $table->decimal('cambio', 8, 2)->nullable();
            $table->decimal('trama', 8, 2)->nullable();
            $table->decimal('combinacion1', 8, 2)->nullable();
            $table->decimal('combinacion2', 8, 2)->nullable();
            $table->decimal('combinacion3', 8, 2)->nullable();
            $table->decimal('combinacion4', 8, 2)->nullable();
            $table->decimal('piel1', 8, 2)->nullable();
            $table->decimal('riso', 8, 2)->nullable();
            $table->integer('tej_num');

            // Relación con TEJIDO_SCHEDULING (campo num_registro)
            $table->foreign('tej_num')
                ->references('num_registro')
                ->on('TEJIDO_SCHEDULING')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tipo_movimientos');
    }
};
