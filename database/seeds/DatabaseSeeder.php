<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Development
        // $this->call(UsersTableSeeder::class);
        $this->call(ClientesTableSeeder::class);
        $this->call(ProveedoresTableSeeder::class);
        $this->call(ProyectosTableSeeder::class);
        $this->call(ConceptosTableSeeder::class);
        $this->call(ElementosTableSeeder::class);
        $this->call(ConceptosElementosTableSeeder::class);

        // Production
        // $this->call(UsersTableSeeder::class);
        //$this->call(ClientesTableSeeder::class);

    }
}
