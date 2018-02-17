<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagosProveedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos_proveedores', function (Blueprint $table) {
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

            $table->integer('recurso_sale_id')->unsigned();
			$table->foreign('recurso_sale_id')->references('id')->on('recursos');

			$table->integer('proveedor_id')->unsigned();
			$table->foreign('proveedor_id')->references('id')->on('proveedores');

			$table->integer('cotizacion_id')->nullable()->unsigned();
			$table->foreign('cotizacion_id')->references('id')->on('cotizaciones');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pagos_proveedores');
    }
}
