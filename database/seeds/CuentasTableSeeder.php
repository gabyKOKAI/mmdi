<?php

use Illuminate\Database\Seeder;
use mmdi\Cuenta;

class CuentasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $cuentas = [
            ['Bancomer','La que usamos para ...',0],
            ['Efectivo','El efectivo',0],
            ['Banamex','La que usamos para...',0],
            ['Proyectos','para apoyarnos en el registro de la distribución',-1],
        ];

        $count = count($cuentas);

        foreach ($cuentas as $key => $cuenta) {

            Cuenta::insert([
                'created_at' => Carbon\Carbon::now()->subDays($count)->toDateTimeString(),
                'updated_at' => Carbon\Carbon::now()->subDays($count)->toDateTimeString(),
                'nombre' => $cuenta[0],
                'descripcion' => $cuenta[1],
                'saldo' => $cuenta[2],
            ]);
            $count--;
        }
    }
}
