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
        Schema::create('atadores', function (Blueprint $table) {
            $table->id();
            $table->string('estatus_atado')->nullable();
            $table->date('fecha_atado')->nullable();
            $table->tinyInteger('turno')->nullable();
            $table->string('clave_atador')->nullable();
            $table->string('no_julio')->nullable();
            $table->string('orden')->nullable();
            $table->string('tipo')->nullable();
            $table->decimal('metros', 10, 2)->nullable();
            $table->integer('telar')->nullable();
            $table->string('proveedor')->nullable();
            $table->decimal('merma_kg', 10, 2)->nullable();
            $table->time('hora_paro')->nullable();
            $table->time('hora_arranque')->nullable();
            $table->boolean('grua_hubtex')->nullable();
            $table->boolean('atadora_staubli')->nullable();
            $table->boolean('atadora_uster')->nullable();
            $table->integer('calidad_atado')->nullable();
            $table->integer('5_s_orden_limpieza')->nullable();
            $table->string('firma_tejedor')->nullable();
            $table->text('obs')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('atadores');
    }
};
