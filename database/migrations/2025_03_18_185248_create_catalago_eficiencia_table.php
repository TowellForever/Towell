<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('catalago_eficiencia', function (Blueprint $table) {
            $table->id(); // Clave primaria autoincremental
            $table->string('telar', 50);
            $table->string('salon', 50);
            $table->string('tipo_hilo', 100);
            $table->decimal('eficiencia', 10, 2);
            $table->string('densidad', 50);
            
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('catalago_eficiencia');
    }
};
