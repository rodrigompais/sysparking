<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class TipoVeiculosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');
        DB::table('types')->insert([
            ['description' => 'Carro','image' => '1612911045.jpeg','uuid' => Uuid::uuid4(),'created_at' => $now,],
            ['description' => 'Moto','image' => '1612989880.jpeg','uuid' => Uuid::uuid4(),'created_at' => $now,],
            ['description' => 'Bicicleta','image' => '1612989880.jpeg','uuid' => Uuid::uuid4(),'created_at' => $now,],
            ['description' => 'Caminhão','image' => '1612870032.jpeg','uuid' => Uuid::uuid4(),'created_at' => $now,],
            ['description' => 'SUV','image' => '1612989880.jpeg','uuid' => Uuid::uuid4(),'created_at' => $now,],
            ['description' => 'Micro-Ônibus','image' => '1612989880.jpeg','uuid' => Uuid::uuid4(),'created_at' => $now,],
            ['description' => 'Ônibus','image' => '1612989880.jpeg','uuid' => Uuid::uuid4(),'created_at' => $now,],
        ]);
    }
}