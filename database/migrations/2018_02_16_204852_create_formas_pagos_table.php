<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormasPagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('formas_pagos', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->boolean('principal')->default(False)->nullable(false);
            $table->string('banco')->default("")->nullable(true);
            $table->string('informacion_adicional')->nullable(true);

            $table->string('tipo')->default("")->nullable(false);

            $table->integer('proveedor_id')->nullable()->unsigned();
			$table->foreign('proveedor_id')->references('id')->on('proveedores');

			$table->integer('cliente_id')->nullable()->unsigned();
			$table->foreign('cliente_id')->references('id')->on('clientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('formas_pagos');
    }
}
