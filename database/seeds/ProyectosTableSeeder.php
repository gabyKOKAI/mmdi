<?php

use Illuminate\Database\Seeder;
use mmdi\Proyecto;
use mmdi\Cliente;

class ProyectosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $proyectos = [
            ['proyecto1','descripcion 1','direccion 1', 'comentario 1', 1,2,3,4,5,6,7,8,9,'Prospecto','cliente1'],
            ['proyecto2','descripcion 2','direccion 2', 'comentario 2', 1,2,3,4,5,6,7,8,9,'Cotizado','cliente2'],
            ['proyecto3','descripcion 3','direccion 3', 'comentario 3', 1,2,3,4,5,6,7,8,9,'Aprobado','cliente3'],
            ['proyecto4','descripcion 4','direccion 4', 'comentario 4', 1,2,3,4,5,6,7,8,9,'En Proceso (Carpeta)','cliente4'],
            ['proyecto5','descripcion 5','direccion 5', 'comentario 5', 1,2,3,4,5,6,7,8,9,'En Proceso','cliente5'],
        ];

        $count = count($proyectos);

        foreach ($proyectos as $key => $proyecto) {

            $cliente_id = Cliente::where('nombre', '=', $proyecto[14])->pluck('id')->first();

            Proyecto::insert([
                'created_at' => Carbon\Carbon::now()->subDays($count)->toDateTimeString(),
                'updated_at' => Carbon\Carbon::now()->subDays($count)->toDateTimeString(),
                'nombre' => $proyecto[0],
                'descripcion' => $proyecto[1],
                'direccion' => $proyecto[2],
                'comentario' => $proyecto[3],
                'gasto_viaticos' => $proyecto[4],
                'gasto_IMSS' => $proyecto[5],
                'gasto_porc_honorarios' => $proyecto[6],
                'gasto_porc_ganancias_MMDI' => $proyecto[7],
                'gasto_porc_errores' => $proyecto[8],
                'ganancia_MEG' => $proyecto[9],
                'ganancia_AMM' => $proyecto[10],
                'ganancia_MME' => $proyecto[11],
                'ganancia_AME' => $proyecto[12],
                'estatus' => $proyecto[13],
                'cliente_id' =>  $cliente_id

            ]);
            $count--;
        }
    }
}
