<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIncidenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('TB_INCIDENCIAS', function (Blueprint $table) {
			$table->increments('id');
	        $table->dateTime('fecha_hora_inicio');
	        $table->dateTime('fecha_hora_fin');
	        $table->text('descripcion');
	        $table->string('lugar');
	        $table->text('consecuencia');
	        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('TB_INCIDENCIAS');
    }
}
