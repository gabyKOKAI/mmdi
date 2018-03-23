<?php

use Illuminate\Database\Seeder;
use mmdi\Concepto;
use mmdi\Elemento;

class ConceptosElementosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $conceptos =[
                'concepto1' => ['elemento1', 'elemento2', 'elemento3', 'elemento4'],
                'concepto2' => ['elemento1', 'elemento3', 'elemento5'],
                'concepto3' => ['elemento2', 'elemento4'],
                'concepto4' => ['elemento1', 'elemento2', 'elemento3', 'elemento4', 'elemento5'],
                'concepto5' => ['elemento1'],
    ];

     $preciosElementos =[
                'elemento1' => 110,
                'elemento2' => 220,
                'elemento3' => 330,
                'elemento4' => 440,
                'elemento5' => 550,

    ];

    $costosElementos =[
                'elemento1' => 10,
                'elemento2' => 20,
                'elemento3' => 30,
                'elemento4' => 40,
                'elemento5' => 50,

    ];

    # Now loop through the above array, creating a new pivot for each book to tag
    foreach ($conceptos as $concepto => $elementos) {

        $concepto = Concepto::where('nombre', 'like', $concepto)->first();
        $count = count($conceptos);

        # Now loop through each tag for this book, adding the pivot
        foreach ($elementos as $nombreElemento) {
            $elemento = Elemento::where('nombre', 'LIKE', $nombreElemento)->first();

            ##$concepto->elementos()->save($elemento);
            DB::table('concepto_elemento')->insert([
            'created_at' => Carbon\Carbon::now()->subDays($count)->toDateTimeString(),
            'updated_at' => Carbon\Carbon::now()->subDays($count)->toDateTimeString(),
            'concepto_id' => $concepto->id,
            'elemento_id' => $elemento->id,
            'precio' => $preciosElementos[$nombreElemento],
            'costo' => $costosElementos[$nombreElemento],
            ]);
            $count--;
        }
    }
    }
}
