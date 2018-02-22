<?php

use Illuminate\Database\Seeder;
use mmdi\Cliente;

class ClientesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clientes = [
            ['cliente1','descripcion cliente 1','razon social cliente 1', 'rfc cliente 1', 'correo factura cliente 1', 'comentarios cliente 1'],
            ['cliente2','descripcion cliente 2','razon social cliente 2', 'rfc cliente 2', 'correo factura cliente 2', 'comentarios cliente 2'],
            ['cliente3','descripcion cliente 3','razon social cliente 3', 'rfc cliente 3', 'correo factura cliente 3', 'comentarios cliente 3'],
            ['cliente4','descripcion cliente 4','razon social cliente 4', 'rfc cliente 4', 'correo factura cliente 4', 'comentarios cliente 4'],
            ['cliente5','descripcion cliente 5','razon social cliente 5', 'rfc cliente 5', 'correo factura cliente 5', 'comentarios cliente 5'],
        ];

        $count = count($clientes);

        foreach ($clientes as $key => $cliente) {
            Cliente::insert([
                'created_at' => Carbon\Carbon::now()->subDays($count)->toDateTimeString(),
                'updated_at' => Carbon\Carbon::now()->subDays($count)->toDateTimeString(),
                'nombre' => $cliente[0],
                'descripcion' => $cliente[1],
                'razon_social' => $cliente[2],
                'rfc' => $cliente[3],
                'correo_factura' => $cliente[4],
                'comentarios' => $cliente[5]
            ]);
            $count--;
        }
    }
}
