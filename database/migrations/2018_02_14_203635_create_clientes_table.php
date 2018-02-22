<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('nombre')->default("")->nullable(false);
            $table->string('descripcion')->nullable(true);
            $table->string('razon_social')->nullable(true);
            $table->string('rfc')->nullable(true);
            $table->string('correo_factura')->nullable(true);
            $table->string('comentarios')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clientes');
    }
}
