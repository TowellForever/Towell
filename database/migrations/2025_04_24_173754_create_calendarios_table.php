<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCalendariosTable extends Migration
{
    public function up()
    {
        Schema::create('calendarios', function (Blueprint $table) {
            $table->integer('cal_id')->primary()->default(1); // PK y FK
            $table->dateTime('fecha_inicio')->nullable();
            $table->dateTime('fecha_fin')->nullable();
            $table->decimal('total_horas', 10, 2)->nullable();
            
            // Relación FK con TEJIDO_SCHEDULING
            //$table->bigInteger('num_registro')->unsigned()->default(1);
            $table->foreign('cal_id')->references('num_registro')->on('TEJIDO_SCHEDULING')->onDelete('cascade');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('calendarios');
    }
}
