<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAnunciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('advertisement', function (Blueprint $table) {
            $table->increments('id');
	        $table->time('start_hour');
	        $table->time('end_hour');
	        $table->integer('lector_id');
			$table->boolean('monday');
	        $table->boolean('tuesday');
	        $table->boolean('wednesday');
	        $table->boolean('thursday');
	        $table->boolean('friday');
	        $table->boolean('saturday');
	        $table->boolean('sunday');
            $table->timestamps();
        });

	    Schema::create('advertisement_pictures', function (Blueprint $table) {
	    	$table->increments('id');
		    $table->integer('advertisement_id')->unsigned();
		    $table->foreign('advertisement_id')->references('id')->on('advertisement');
		    $table->string('path');
			$table->string('code');
		    $table->string('description');
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
        Schema::drop('anuncios');
    }
}
