<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class VagaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');
        DB::table('vacancies')->insert([
            ['description' => 'C1','status' => 'Disponivel','type_id' => '1','uuid' => Uuid::uuid4(),'created_at' => $now,],
            ['description' => 'C2','status' => 'Disponivel','type_id' => '1','uuid' => Uuid::uuid4(),'created_at' => $now,],
            ['description' => 'C3','status' => 'Disponivel','type_id' => '1','uuid' => Uuid::uuid4(),'created_at' => $now,],
            ['description' => 'C4','status' => 'Disponivel','type_id' => '1','uuid' => Uuid::uuid4(),'created_at' => $now,],
            ['description' => 'C5','status' => 'Disponivel','type_id' => '1','uuid' => Uuid::uuid4(),'created_at' => $now,],
            ['description' => 'M1','status' => 'Disponivel','type_id' => '2','uuid' => Uuid::uuid4(),'created_at' => $now,],
            ['description' => 'M2','status' => 'Disponivel','type_id' => '2','uuid' => Uuid::uuid4(),'created_at' => $now,],
            ['description' => 'M3','status' => 'Disponivel','type_id' => '2','uuid' => Uuid::uuid4(),'created_at' => $now,],
            ['description' => 'M4','status' => 'Disponivel','type_id' => '2','uuid' => Uuid::uuid4(),'created_at' => $now,],
            ['description' => 'M5','status' => 'Disponivel','type_id' => '2','uuid' => Uuid::uuid4(),'created_at' => $now,],
            ['description' => 'B1','status' => 'Disponivel','type_id' => '3','uuid' => Uuid::uuid4(),'created_at' => $now,],
            ['description' => 'B2','status' => 'Disponivel','type_id' => '3','uuid' => Uuid::uuid4(),'created_at' => $now,],
            ['description' => 'B3','status' => 'Disponivel','type_id' => '3','uuid' => Uuid::uuid4(),'created_at' => $now,],
        ]);
    }
}
