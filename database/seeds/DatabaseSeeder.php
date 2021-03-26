<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserTableSeeder::class,
            TipoVeiculosTableSeeder::class,
            FabricantesTableSeeder::class,
            ModeloVeiculosTableSeeder::class,
            VagaTableSeeder::class,
            TarifaTableSeeder::class,
            PermissionsTableSeeder::class,
        ]);
    }
}
