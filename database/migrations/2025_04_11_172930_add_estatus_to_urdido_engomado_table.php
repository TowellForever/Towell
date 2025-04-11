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
        Schema::table('urdido_engomado', function (Blueprint $table) {
            $table->string('estatus_urdido')->default('en_proceso'); // cambia 'columna_anterior_urdido' si quieres posicionarlo
            $table->string('estatus_engomado')->default('en_proceso');
            $table->string('engomado')->default('');
            $table->string('color')->default('');
            $table->string('solidos')->default('');

        });
    }
    
    public function down()
    {
        Schema::table('urdido_engomado', function (Blueprint $table) {
            $table->dropColumn(['estatus_urdido', 'estatus_engomado']);
        });
    }
    
};
