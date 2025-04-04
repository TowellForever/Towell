<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConstruccionUrdidoTable extends Migration
{
    public function up()
    {
        Schema::create('construccion_urdido', function (Blueprint $table) {
            $table->id();
            $table->string('folio'); // Referencia a la tabla urdido_engomado
            $table->string('no_julios')->nullable();
            $table->string('hilos')->nullable();
            $table->timestamps();

            // Foreign key relation to urdido_engomado table
            $table->foreign('folio')->references('folio')->on('urdido_engomado')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('construccion_urdido');
    }
}
