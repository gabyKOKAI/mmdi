<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCotizacionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cotizaciones', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('nombre')->nullable(false);
            $table->string('descripcion')->nullable(true);
            $table->float('monto')->default(0)->nullable(false);
            $table->boolean('con_iva')->default(False)->nullable(false);

            $table->string('estatus')->default("Pendiente Cotizar")->nullable(false);

            $table->integer('proveedor_id')->unsigned();
			$table->foreign('proveedor_id')->references('id')->on('proveedores');

			$table->integer('proyecto_id')->nullable()->unsigned();
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
        Schema::dropIfExists('cotizaciones');
    }
}
