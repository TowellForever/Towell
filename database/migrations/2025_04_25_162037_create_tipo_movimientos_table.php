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
        Schema::create('tipo_movimientos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->string('tipo_mov');
            $table->decimal('cantidad',8,2); 
            $table->integer('tej_num');

            // Relación con TEJIDO_SCHEDULING (campo num_registro)
            $table->foreign('tej_num')
                  ->references('num_registro')
                  ->on('TEJIDO_SCHEDULING')
                  ->onDelete('cascade');
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('tipo_movimientos');
    }
};
