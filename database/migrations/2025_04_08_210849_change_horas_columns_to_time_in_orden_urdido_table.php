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
        Schema::table('orden_urdido', function (Blueprint $table) {
            $table->time('hora_inicio')->change();
            $table->time('hora_fin')->change();
        });
    }

    public function down()
    {
        Schema::table('orden_urdido', function (Blueprint $table) {
            $table->string('hora_inicio')->change();
            $table->string('hora_fin')->change();
        });
    }
};
