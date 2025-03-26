<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('requerimiento', function (Blueprint $table) {
            $table->id();
            $table->string('telar')->nullable();
            $table->string('cuenta_rizo')->nullable();
            $table->string('cuenta_pie')->nullable();
            $table->string('metros')->nullable();
            $table->string('julio_reserv')->nullable();
            $table->string('status')->nullable();
            $table->string('orden_prod')->nullable();
            $table->integer('rizo')->nullable();
            $table->integer('pie')->nullable();
            $table->string('valor')->nullable();
            $table->string('fecha')->nullable();
            $table->string('metros_pie')->nullable();
            $table->string('julio_reserv_pie')->nullable();
            $table->datetime('fecha_hora_creacion')->nullable();
            $table->datetime('fecha_hora_modificado')->nullable();

            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('requerimiento');
    }
};
