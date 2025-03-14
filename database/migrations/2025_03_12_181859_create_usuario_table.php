<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('numero_empleado')->unique();
            $table->string('nombre');
            $table->string('contrasenia');
            $table->string('area');
            $table->string('foto')->nullable();
            $table->boolean('almacen')->default(false);
            $table->boolean('urdido')->default(false);
            $table->boolean('engomado')->default(false);
            $table->boolean('tejido')->default(false);
            $table->boolean('atadores')->default(false);
            $table->boolean('tejedores')->default(false);
            $table->boolean('mantenimiento')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
};
