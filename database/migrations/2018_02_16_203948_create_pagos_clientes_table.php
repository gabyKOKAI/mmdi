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
        Schema::create('pago_clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->float('monto')->default(0)->nullable(false);
            $table->date('fecha_pago')->timestamps();
            $table->boolean('con_iva')->default(False)->nullable(false);
            $table->string('numero_factura')->default("")->nullable(true);
            $table->date('fecha_factura')->nullable(true);
            $table->string('entrega')->default("")->nullable(false);
            $table->string('recibe')->default("")->nullable(false);
            $table->string('descripcion')->nullable(false);

            $table->string('tipo')->default("")->nullable(false);
            $table->string('estatus')->default("")->nullable(false);

            $table->integer('cuenta_id')->unsigned();
			$table->foreign('cuenta_id')->references('id')->on('cuentas');

			$table->integer('cli_prov_id')->unsigned();
			$table->foreign('cli_prov_id')->references('id')->on('clientes');

			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');

			$table->integer('proy_coti_id')->nullable(true)->unsigned();
			$table->foreign('proy_coti_id')->references('id')->on('proyectos');


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

        $table->dropColumn('user_id');
    }
}
