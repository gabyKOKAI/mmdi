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
            ['MMDI','Empresa',100000,0],
            ['AME','Andrea',15000,0],
            ['MME','Marcela M',1500,0],
            ['AMM','AMM',20000,0],
            ['MEG','Marcela E',10000,0],
        ];

        $count = count($recursos);

        foreach ($recursos as $key => $recurso) {

            Recurso::insert([
                'created_at' => Carbon\Carbon::now()->subDays($count)->toDateTimeString(),
                'updated_at' => Carbon\Carbon::now()->subDays($count)->toDateTimeString(),
                'nombre' => $recurso[0],
                'descripcion' => $recurso[1],
                'distribuido' => $recurso[2],
                'saldo_gasto' => $recurso[3],
            ]);
            $count--;
        }
    }
}
