<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('catalago_telares', function (Blueprint $table) {
            $table->id(); // Clave primaria autoincremental
            $table->string('salon', 50);
            $table->string('telar', 50);
            $table->string('nombre', 100);
            $table->string('cuenta', 50);
            $table->string('pie', 50);
            $table->decimal('ancho', 8, 2)->nullable();// Número decimal para ancho
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catalago_telares');
    }
};
