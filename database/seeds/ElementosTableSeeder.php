<?php

use Illuminate\Database\Seeder;
use mmdi\Proveedore;
use mmdi\Elemento;

class ElementosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $elementos = [
            ['elemento1','comentario 1',100,10,'pza','Material','%','proveedor2'],
            ['elemento2','comentario 2',200,20,'pza','Mano de Obra','$','proveedor2'],
            ['elemento3','comentario 3',300,30,'pza','Mueble','%','proveedor3'],
            ['elemento4','comentario 4',400,40,'pza','Viaticos','$','proveedor4'],
            ['elemento5','comentario 5',500,50,'pza','Otro','%','proveedor5'],
        ];

        $count = count($elementos);

        foreach ($elementos as $key => $elemento) {

            $proveedor_id = Proveedore::where('nombre', '=', $elemento[7])->pluck('id')->first();

            Elemento::insert([
                'created_at' => Carbon\Carbon::now()->subDays($count)->toDateTimeString(),
                'updated_at' => Carbon\Carbon::now()->subDays($count)->toDateTimeString(),
                'nombre' => $elemento[0],
                'comentario' => $elemento[1],
                'costo' => $elemento[2],
                'ganancia' => $elemento[3],
                'unidades' => $elemento[4],
                'tipo' => $elemento[5],
                'tipo_ganancia' => $elemento[6],
                'proveedor_id' => $proveedor_id
            ]);
            $count--;
        }
    }
}
