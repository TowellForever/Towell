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
        Schema::create('reportes_temporales', function (Blueprint $table) {
            $table->id();
            $table->integer('telar');
            $table->string('tipo');
            $table->string('clave_falla');
            $table->string('descripcion')->nullable();
            $table->date('fecha_reporte');
            $table->time('hora_reporte');
            $table->string('operador')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reportes_temporales');
    }
};
