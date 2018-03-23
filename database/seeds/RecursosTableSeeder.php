<?php

use Illuminate\Database\Seeder;
use mmdi\Recurso;

class RecursosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $recursos = [
            ['MMDI','Empresa',0,0],
            ['AME','Andrea Mora E',0,0],
            ['MME','Marcela Mora E',0,0],
            ['AMM','Agustin Mora M',0,0],
            ['MEG','Marcela E G',0,0],
            ['Proyectos','para apoyarnos en el registro de los pagos',-1,-1],
        ];

        $count = count($recursos);

        foreach ($recursos as $key => $recurso) {

            Recurso::insert([
                'created_at' => Carbon\Carbon::now()->subDays($count)->toDateTimeString(),
                'updated_at' => Carbon\Carbon::now()->subDays($count)->toDateTimeString(),
                'nombre' => $recurso[0],
                'descripcion' => $recurso[1],
                'ingreso' => $recurso[2],
                'saldo_gasto' => $recurso[3],
            ]);
            $count--;
        }
    }
}
