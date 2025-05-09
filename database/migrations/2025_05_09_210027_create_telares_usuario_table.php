<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('telares_usuario', function (Blueprint $table) {
            $table->id();
            $table->string('usuario_id');
            $table->unsignedBigInteger('telar_id');

            // Llaves foráneas
            $table->foreign('usuario_id')->references('numero_empleado')->on('usuarios')->onDelete('cascade');
            $table->foreign('telar_id')->references('id')->on('catalago_telares')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telares_usuario');
    }
};
