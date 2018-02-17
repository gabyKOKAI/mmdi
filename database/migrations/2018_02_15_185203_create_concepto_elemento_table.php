<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConceptoElementoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('concepto_elemento', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
			
			$table->float('precio')->nullable(false);
			
			$table->integer('concepto_id')->unsigned();
			$table->foreign('concepto_id')->references('id')->on('conceptos');
			
			$table->integer('elemento_id')->unsigned();
			$table->foreign('elemento_id')->references('id')->on('elementos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('concepto_elemento');
    }
}
