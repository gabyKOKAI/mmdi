<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contactos', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('nombre')->default("")->nullable(false);
			$table->string('oficina')->nullable(true);
			$table->string('celular')->nullable(true);
			$table->string('correo')->nullable(true);

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
        Schema::dropIfExists('contactos');
    }
}
