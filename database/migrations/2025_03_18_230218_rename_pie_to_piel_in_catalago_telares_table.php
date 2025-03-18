<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenamePieToPielInCatalagoTelaresTable extends Migration
{
    public function up()
    {
        Schema::table('catalago_telares', function (Blueprint $table) {
            $table->renameColumn('pie', 'piel');
        });
    }

    public function down()
    {
        Schema::table('catalago_telares', function (Blueprint $table) {
            $table->renameColumn('piel', 'pie');
        });
    }
}
