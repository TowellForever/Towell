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
        Schema::create('registro_importaciones_excel', function (Blueprint $table) {
            $table->id();
            $table->string('usuario');
            $table->unsignedInteger('total_registros');
            $table->timestamps(); // fecha y hora de la importación
        });
    }

    public function down()
    {
        Schema::dropIfExists('registro_importaciones_excel');
    }
};
