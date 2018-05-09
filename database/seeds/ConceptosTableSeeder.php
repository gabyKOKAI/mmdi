<?php

use Illuminate\Database\Seeder;
use mmdi\Proyecto;
use mmdi\Concepto;

class ConceptosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $conceptos = [
            ['concepto1',1,false, 'comentario 1','Cotizado','pza','proyecto1','2018-12-20'],
            ['concepto2',2,true, 'comentario 2','En Proceso','pza','proyecto1','2018-12-20'],
            ['concepto6',2,true, 'comentario 2','En Proceso','pza','proyecto1','2018-12-20'],
            ['concepto7',2,true, 'comentario 2','En Proceso','pza','proyecto1','2018-12-20'],
            ['concepto8',2,true, 'comentario 2','En Proceso','pza','proyecto1','2018-12-20'],
            ['concepto9',2,true, 'comentario 2','En Proceso','pza','proyecto1','2018-12-20'],
            ['concepto10',2,true, 'comentario 2','En Proceso','pza','proyecto1','2018-12-20'],
            ['concepto11',2,true, 'comentario 2','En Proceso','pza','proyecto1','2018-12-20'],
            ['concepto12',2,true, 'comentario 2','En Proceso','pza','proyecto1','2018-12-20'],
            ['concepto13',2,true, 'comentario 2','En Proceso','pza','proyecto1','2018-12-20'],
            ['concepto14',2,true, 'comentario 2','En Proceso','pza','proyecto1','2018-12-20'],
            ['concepto15',2,true, 'comentario 2','En Proceso','pza','proyecto1','2018-12-20'],
            ['concepto16',2,true, 'comentario 2','En Proceso','pza','proyecto1','2018-12-20'],
            ['concepto17',2,true, 'comentario 2','En Proceso','pza','proyecto1','2018-12-20'],
            ['concepto18',2,true, 'comentario 2','En Proceso','pza','proyecto1','2018-12-20'],
            ['concepto19',2,true, 'comentario 2','En Proceso','pza','proyecto1','2018-12-20'],
            ['concepto20',2,true, 'comentario 2','En Proceso','pza','proyecto1','2018-12-20'],
            ['concepto21',2,true, 'comentario 2','En Proceso','pza','proyecto1','2018-12-20'],
            ['concepto22',2,true, 'comentario 2','En Proceso','pza','proyecto1','2018-12-20'],
            ['concepto23',2,true, 'comentario 2','En Proceso','pza','proyecto1','2018-12-20'],
            ['concepto24',2,true, 'comentario 2','En Proceso','pza','proyecto1','2018-12-20'],
            ['concepto25',2,true, 'comentario 2','En Proceso','pza','proyecto1','2018-12-20'],
            ['concepto26',2,true, 'comentario 2','En Proceso','pza','proyecto1','2018-12-20'],
            ['concepto27',2,true, 'comentario 2','En Proceso','pza','proyecto1','2018-12-20'],
            ['concepto28',2,true, 'comentario 2','En Proceso','pza','proyecto1','2018-12-20'],
            ['concepto29',2,true, 'comentario 2','En Proceso','pza','proyecto1','2018-12-20'],

            ['concepto3',2,false, 'comentario 3','Entregado','m3','proyecto3','2018-12-20'],
            ['concepto4',1,false, 'comentario 4','Cancelado','m2','proyecto4','2018-12-20'],
            ['concepto5',1,false, 'comentario 5','Cotizado','pza','proyecto5','2018-12-20'],
        ];

        $count = count($conceptos);

        foreach ($conceptos as $key => $concepto) {

            $proyecto_id = Proyecto::where('nombre', '=', $concepto[6])->pluck('id')->first();

            Concepto::insert([
                'created_at' => Carbon\Carbon::now()->subDays($count)->toDateTimeString(),
                'updated_at' => Carbon\Carbon::now()->subDays($count)->toDateTimeString(),
                'nombre' => $concepto[0],
                'cantidad' => $concepto[1],
                'adicional' => $concepto[2],
                'comentario' => $concepto[3],
                'estatus' => $concepto[4],
                'unidades' => $concepto[5],
                'fecha' => $concepto[7],
                'proyecto_id' => $proyecto_id

            ]);
            $count--;
        }
    }
}
