<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('requerimiento', function (Blueprint $table) {
            $table->id();
            $table->string('cuenta_rizo')->nullable();
            $table->string('cuenta_pie')->nullable();
            $table->date('fecha')->nullable();
            $table->string('turno')->nullable();
            $table->string('metros')->nullable();
            $table->string('julio_reserv')->nullable();
            $table->string('status')->nullable();
            $table->string('orden_prod')->nullable();
            $table->datetime('fecha_hora_creacion')->nullable();
            $table->datetime('fecha_hora_modificado')->nullable();

            // Campos para los checkboxes
            $table->boolean('ck_A1')->default(false)->nullable();
            $table->boolean('ck_A2')->default(false)->nullable();
            $table->boolean('ck_A3')->default(false)->nullable();
            $table->boolean('ck_A4')->default(false)->nullable();
            $table->boolean('ck_A5')->default(false)->nullable();
            $table->boolean('ck_A6')->default(false)->nullable();
            $table->boolean('ck_B1')->default(false)->nullable();
            $table->boolean('ck_B2')->default(false)->nullable();
            $table->boolean('ck_B3')->default(false)->nullable();
            $table->boolean('ck_B4')->default(false)->nullable();
            $table->boolean('ck_B5')->default(false)->nullable();
            $table->boolean('ck_B6')->default(false)->nullable();
            $table->boolean('ck_C1')->default(false)->nullable();
            $table->boolean('ck_C2')->default(false)->nullable();
            $table->boolean('ck_C3')->default(false)->nullable();
            $table->boolean('ck_C4')->default(false)->nullable();
            $table->boolean('ck_C5')->default(false)->nullable();
            $table->boolean('ck_C6')->default(false)->nullable();
            $table->boolean('ck_D1')->default(false)->nullable();
            $table->boolean('ck_D2')->default(false)->nullable();
            $table->boolean('ck_D3')->default(false)->nullable();
            $table->boolean('ck_D4')->default(false)->nullable();
            $table->boolean('ck_D5')->default(false)->nullable();
            $table->boolean('ck_D6')->default(false)->nullable();
            $table->boolean('ck_E1')->default(false)->nullable();
            $table->boolean('ck_E2')->default(false)->nullable();
            $table->boolean('ck_E3')->default(false)->nullable();
            $table->boolean('ck_E4')->default(false)->nullable();
            $table->boolean('ck_E5')->default(false)->nullable();
            $table->boolean('ck_E6')->default(false)->nullable();
            $table->boolean('ck_F1')->default(false)->nullable();
            $table->boolean('ck_F2')->default(false)->nullable();
            $table->boolean('ck_F3')->default(false)->nullable();
            $table->boolean('ck_F4')->default(false)->nullable();
            $table->boolean('ck_F5')->default(false)->nullable();
            $table->boolean('ck_F6')->default(false)->nullable();
            $table->boolean('ck_G1')->default(false)->nullable();
            $table->boolean('ck_G2')->default(false)->nullable();
            $table->boolean('ck_G3')->default(false)->nullable();
            $table->boolean('ck_G4')->default(false)->nullable();
            $table->boolean('ck_G5')->default(false)->nullable();
            $table->boolean('ck_G6')->default(false)->nullable();

            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('requerimiento');
    }
};
