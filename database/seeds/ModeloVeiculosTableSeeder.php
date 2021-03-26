<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class ModeloVeiculosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');
        DB::table('modelos')->insert([
            ['description' => 'KA','uuid' => Uuid::uuid4(),'fabricante_id' => 1, 'created_at' => $now,],
            ['description' => 'Gol','uuid' => Uuid::uuid4(),'fabricante_id' => 4, 'created_at' => $now,],
            ['description' => 'Corsa','uuid' => Uuid::uuid4(),'fabricante_id' => 10, 'created_at' => $now,],
            ['description' => 'Civic','uuid' => Uuid::uuid4(),'fabricante_id' => 2, 'created_at' => $now,],
            ['description' => 'Corolla','uuid' => Uuid::uuid4(),'fabricante_id' => 3, 'created_at' => $now,],
            ['description' => 'Jeep','uuid' => Uuid::uuid4(),'fabricante_id' => 4, 'created_at' => $now,],
            ['description' => 'Fusca','uuid' => Uuid::uuid4(),'fabricante_id' => 4, 'created_at' => $now,],
            ['description' => 'Nissan March','uuid' => Uuid::uuid4(),'fabricante_id' => 6, 'created_at' => $now,],
            ['description' => 'Nissan Versa','uuid' => Uuid::uuid4(),'fabricante_id' => 6, 'created_at' => $now,],
            ['description' => 'HB20','uuid' => Uuid::uuid4(),'fabricante_id' => 8, 'created_at' => $now,],
            ['description' => 'Clio','uuid' => Uuid::uuid4(),'fabricante_id' => 5, 'created_at' => $now,],
            ['description' => 'Jimmy','uuid' => Uuid::uuid4(),'fabricante_id' => 9, 'created_at' => $now,],
        ]);
    }
}
