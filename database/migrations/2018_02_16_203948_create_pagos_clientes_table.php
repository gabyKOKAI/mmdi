<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagosClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos_clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->float('monto')->default(0)->nullable(false);
            $table->date('fecha_pago')->timestamps();
            $table->boolean('con_iva')->default(False)->nullable(false);
            $table->string('numero_factura')->default("")->nullable(false);
            $table->date('fecha_factura')->nullable(true);
            $table->string('entrega')->default("")->nullable(false);
            $table->string('recibe')->default("")->nullable(false);
            $table->string('comentario')->nullable(true);

            $table->string('tipo')->default("")->nullable(false);

            $table->integer('recurso_entra_id')->unsigned();
			$table->foreign('recurso_entra_id')->references('id')->on('recursos');

			$table->integer('cliente_id')->unsigned();
			$table->foreign('cliente_id')->references('id')->on('clientes');

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
        Schema::dropIfExists('pagos_clientes');
    }
}
