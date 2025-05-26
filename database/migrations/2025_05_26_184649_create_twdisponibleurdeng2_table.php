<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'sqlsrv_ti'; // conexión ya creada
    public function up(): void
    {
        Schema::connection($this->connection)->create('TWDISPONIBLEURDENG2', function (Blueprint $table) {
            $table->id();
            $table->string('articulo', 40)->nullable();
            $table->string('tipo', 20)->nullable();
            $table->integer('cantidad')->nullable();
            $table->string('hilo', 20)->nullable();
            $table->string('cuenta', 20)->nullable();
            $table->string('color', 30)->nullable();
            $table->string('almacen', 30)->nullable();
            $table->string('orden', 40)->nullable();
            $table->string('localidad', 20)->nullable();
            $table->string('no_julio', 40)->nullable();
            $table->decimal('metros', 10, 2)->nullable();
            $table->dateTime('fecha')->nullable();
            $table->string('twdis_key', 10)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('TWDISPONIBLEURDENG2');
    }
};
