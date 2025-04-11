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
            $table->boolean('registro_urdido')->default(false);
            $table->boolean('registro_engomado')->default(false);
        });
    }
    
    public function down()
    {
        Schema::table('urdido_engomado', function (Blueprint $table) {
            $table->dropColumn(['registro_urdido', 'registro_engomado']);
        });
    }
    
    
};
