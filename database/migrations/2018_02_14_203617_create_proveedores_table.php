<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProveedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->string('nombre')->default("")->nullable(false);
            $table->string('descripcion')->nullable(true);
            $table->string('rfc')->nullable(true);
            $table->string('calle')->nullable(true);
            $table->string('delegacion_municipio')->nullable(true);
            $table->string('colonia')->nullable(true);
            $table->string('ciudad')->nullable(true);
            $table->char('cp',5)->nullable(true);
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
        Schema::dropIfExists('proveedores');
    }
}
