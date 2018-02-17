<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElementosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elementos', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
			
			$table->string('nombre')->default("")->nullable(false);
			$table->string('comentario')->nullable(true);
			$table->float('costo')->nullable(false);
			$table->float('ganancia')->nullable(false);
			
			$table->string('estatus')->default("Cotizado")->nullable(false);
			$table->string('unidades')->default("")->nullable(false);
			$table->string('tipo')->default("")->nullable(false);
			$table->string('tipo_ganancia')->default("")->nullable(false);
			
			
			$table->integer('proveedor_id')->unsigned();
			$table->foreign('proveedor_id')->references('id')->on('proveedores');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('elementos');
    }
}
