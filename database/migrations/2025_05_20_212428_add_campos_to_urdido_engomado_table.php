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
            $table->string('lmaturdido')->nullable()->default(null)->after('ultimo_campo_existente');
            $table->string('maquinaEngomado')->nullable()->default(null)->after('lmaturdido');
            $table->string('lmatengomado')->nullable()->default(null)->after('engomado');
        });
    }

    public function down()
    {
        Schema::table('urdido_engomado', function (Blueprint $table) {
            $table->dropColumn(['lmaturdido', 'engomado', 'lmatengomado']);
        });
    }
};
