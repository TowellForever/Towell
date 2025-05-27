<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('TWDISPONIBLEURDENG2', function (Blueprint $table) {
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
            $table->unsignedBigInteger('reqid'); //
            $table->bigInteger('dis_id')->nullable();
        });

        // 🔗 Agregamos la llave foránea manualmente (compatible con SQL Server)
        DB::statement("
            ALTER TABLE TWDISPONIBLEURDENG2
            ADD CONSTRAINT fk_reqid FOREIGN KEY (reqid)
            REFERENCES Produccion.dbo.requerimiento(id)
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('TWDISPONIBLEURDENG2');
    }
};
