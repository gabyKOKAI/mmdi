<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHistoricoMovimientosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historico_movimientos', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->float('monto')->default(0)->nullable(false);
            $table->date('fecha_pago')->timestamps();
            $table->string('descripcion')->default("")->nullable(false);

            $table->integer('recurso_sale_id')->unsigned();
			$table->foreign('recurso_sale_id')->references('id')->on('recursos');

			$table->integer('recurso_entra_id')->unsigned();
			$table->foreign('recurso_entra_id')->references('id')->on('recursos');

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
        Schema::dropIfExists('historico_movimientos');
    }
}
