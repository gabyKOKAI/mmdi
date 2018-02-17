<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recursos', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->float('saldo')->default(0)->nullable(false);

            $table->string('cuenta')->default("")->nullable(false);
            $table->string('descripcion')->nullable(true);

            $table->integer('responsable_id')->unsigned();
			$table->foreign('responsable_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recursos');
    }
}
