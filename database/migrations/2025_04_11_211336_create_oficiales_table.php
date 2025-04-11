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
        Schema::create('oficiales', function (Blueprint $table) {
            $table->id(); // id autoincremental
            $table->string('oficial'); // nombre o identificador del oficial
            $table->string('tipo'); // tipo del oficial (por ejemplo: operador, supervisor, etc.)
        });
    }

    public function down()
    {
        Schema::dropIfExists('oficiales');
    }
};
