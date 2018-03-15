<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->float('monto')->default(0)->nullable(false);
            $table->date('fecha')->timestamps();
            $table->string('descripcion')->default("")->nullable(false);
            $table->string('tipo')->default("")->nullable(false);

            $table->integer('recurso_id')->unsigned();
            $table->foreign('recurso_id')->references('id')->on('recursos');

            $table->integer('cuenta_id')->unsigned();
            $table->foreign('cuenta_id')->references('id')->on('cuentas');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historico_movimientos');
    }
}
