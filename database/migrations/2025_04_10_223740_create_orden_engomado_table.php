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
        Schema::create('orden_engomado', function (Blueprint $table) {
            $table->id(); // ID autoincremental (puedes cambiarlo si deseas usar id2 como clave)
            $table->string('id2'); // ID personalizado
            $table->string('folio')->nullable();
            $table->date('fecha')->nullable();
            $table->string('oficial')->nullable();
            $table->string('turno')->nullable();
            $table->time('hora_inicio')->nullable();
            $table->time('hora_fin')->nullable();
            $table->string('tiempo')->nullable();
            $table->string('no_julio')->nullable();
            $table->decimal('peso_bruto', 8, 2)->nullable();
            $table->decimal('tara', 8, 2)->nullable();
            $table->decimal('peso_neto', 8, 2)->nullable();
            $table->string('metros')->nullable();
            $table->string('temp_canoa_1')->nullable();
            $table->string('temp_canoa_2')->nullable();
            $table->string('temp_canoa_3')->nullable();
            $table->string('humedad')->nullable();
            $table->string('roturas')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orden_engomado');
    }
};
