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
        Schema::create('julios', function (Blueprint $table) {
            $table->id(); // ID autoincremental
            $table->string('no_julio')->unique(); // Campo no_julio
            $table->decimal('tara', 5, 2); // Campo tara (puedes ajustar el tamaño según necesidad)
            $table->enum('tipo', ['urdido', 'engomado']); // Campo tipo, que solo puede ser 'urdido' o 'engomado'
        });
    }

    /**
     * Revierte las migraciones.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('julios');
    }
};
