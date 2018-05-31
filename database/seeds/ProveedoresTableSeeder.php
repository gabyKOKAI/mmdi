<?php
use Illuminate\Database\Seeder;
use mmdi\Proveedore;
class ProveedoresTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $proveedores = [
            ['Proveedor Viaticos','descripcion 1', 'rfc 1', 'Razon social 1', 'calle 1', 'delegacion_municipio 1','colonia 1','ciudad 1','cp 1','comentarios 1'],
            ['proveedor2','descripcion 2', 'rfc 2', 'Razon social 2','calle 2', 'delegacion_municipio 2','colonia 2','ciudad 2','cp 2','comentarios 2'],
            ['proveedor3','descripcion 3', 'rfc 3', 'Razon social 3','calle 3', 'delegacion_municipio 3','colonia 3','ciudad 3','cp 3','comentarios 3'],
            ['proveedor4','descripcion 4', 'rfc 4', 'Razon social 4','calle 4', 'delegacion_municipio 4','colonia 4','ciudad 4','cp 4','comentarios 4'],
            ['proveedor5','descripcion 5', 'rfc 5', 'Razon social 5','calle 5', 'delegacion_municipio 5','colonia 5','ciudad 5','cp 5','comentarios 5'],
        ];
        $count = count($proveedores);
        foreach ($proveedores as $key => $proveedor) {
            Proveedore::insert([
                'created_at' => Carbon\Carbon::now()->subDays($count)->toDateTimeString(),
                'updated_at' => Carbon\Carbon::now()->subDays($count)->toDateTimeString(),
                'nombre' => $proveedor[0],
                'descripcion' => $proveedor[1],
                'rfc' => $proveedor[2],
                'razon_social' => $proveedor[3],
                'calle' => $proveedor[4],
                'delegacion_municipio' => $proveedor[5],
                'colonia' => $proveedor[6],
                'ciudad' => $proveedor[7],
                'cp' => $proveedor[8],
                'comentarios' => $proveedor[9]
            ]);
            $count--;
        }
    }
}
