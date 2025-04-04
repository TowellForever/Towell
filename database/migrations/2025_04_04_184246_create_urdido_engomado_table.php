<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUrdidoEngomadoTable extends Migration
{
    public function up()
    {
        Schema::create('urdido_engomado', function (Blueprint $table) {
            $table->id();
            $table->string('folio')->primary(); // Define folio como la clave primaria
            $table->string('cuenta');
            $table->string('urdido');
            $table->string('proveedor')->nullable();
            $table->string('tipo');
            $table->string('destino');
            $table->float('metros')->nullable();
            $table->string('nucleo')->nullable();
            $table->string('no_telas')->nullable();
            $table->string('balonas')->nullable();
            $table->float('metros_tela')->nullable();
            $table->string('cuendados_mini')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('urdido_engomado');
    }
};
