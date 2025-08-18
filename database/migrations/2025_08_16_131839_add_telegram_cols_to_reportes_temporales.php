<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reportes_temporales', function (Blueprint $table) {
            // SQL Server: evita usar "after()"
            $table->boolean('enviado_telegram')->default(false);
            $table->timestamp('enviado_telegram_at')->nullable();
            $table->string('telegram_message_id', 64)->nullable();

            // Opcional: índice para acelerar el worker que busca pendientes
            $table->index('enviado_telegram');
        });
    }

    public function down(): void
    {
        Schema::table('reportes_temporales', function (Blueprint $table) {
            // Si agregaste el índice, elimínalo primero
            $table->dropIndex(['enviado_telegram']);

            $table->dropColumn([
                'enviado_telegram',
                'enviado_telegram_at',
                'telegram_message_id',
            ]);
        });
    }
};
