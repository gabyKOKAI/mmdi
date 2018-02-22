<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConceptosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conceptos', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
			
			$table->string('nombre')->default("")->nullable(false);
			$table->integer('cantidad')->default(1)->nullable(false);
			$table->boolean('adicional')->default(False)->nullable(false);
			$table->string('comentario')->nullable(true);
			
			$table->string('estatus')->default("Cotizado")->nullable(false);
			$table->string('unidades')->default("")->nullable(false);
			$table->date('fecha')->nullable(false);
			
			$table->integer('proyecto_id')->unsigned();
			$table->foreign('proyecto_id')->references('id')->on('proyectos');
			
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conceptos');
    }
}
