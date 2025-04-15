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
        Schema::create('fallas', function (Blueprint $table) {
            $table->id();
            $table->string('clave')->unique();
            $table->string('descripcion');
            $table->enum('tipo', ['mecanica', 'electrica']);
        });
    }    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fallas');
    }
};
