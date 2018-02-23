<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyectosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proyectos', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
			
			$table->string('nombre')->default("")->nullable(false);
			$table->string('descripcion')->nullable(true);
			$table->string('direccion')->nullable(true);
			$table->string('comentario')->nullable(true);
			$table->float('gasto_viaticos')->default(0)->nullable(false);
			$table->float('gasto_IMSS')->default(0)->nullable(false);
			$table->integer('gasto_porc_honorarios')->default(0)->nullable(false);
			$table->integer('gasto_porc_ganancias_MMDI')->default(0)->nullable(false);
			$table->integer('gasto_porc_errores')->default(0)->nullable(false);
			$table->integer('ganancia_MEG')->default(0)->nullable(false);
			$table->integer('ganancia_AMM')->default(0)->nullable(false);
			$table->integer('ganancia_MME')->default(0)->nullable(false);
			$table->integer('ganancia_AME')->default(0)->nullable(false);
			$table->boolean('distribuido')->default(0)->nullable(false);
			$table->boolean('adicionalesDistribuido')->default(0)->nullable(false);
			
			$table->string('estatus')->default("Prospecto")->nullable(false);
			
			# Add a new INT field called `cliente_id` that has to be unsigned (i.e. positive)
			$table->integer('cliente_id')->unsigned();

			# This field `cliente_id` is a foreign key that connects to the `id` field in the `authors` table
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
        Schema::dropIfExists('proyectos');
    }
}
