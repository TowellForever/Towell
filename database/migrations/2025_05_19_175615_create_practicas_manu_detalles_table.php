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
        Schema::create('practicas_manu_detalles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('practicas_manu_id')->constrained('practicas_manu')->onDelete('cascade');
            $table->string('criterio');        // Ej. "Papeleta de modelo y marbetes correctos."
            $table->string('telar');           // Ej. "A1", "B2", etc.
            $table->unsignedTinyInteger('turno'); // 1, 2, o 3
            $table->unsignedTinyInteger('valor'); // 0 = ⬜, 1 = ✅, 2 = ❌
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('practicas_manu_detalles');
    }
};
