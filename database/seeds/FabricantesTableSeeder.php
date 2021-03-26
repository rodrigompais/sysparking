<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class FabricantesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');
        DB::table('fabricantes')->insert([
            ['description' => 'Ford','uuid' => Uuid::uuid4(),'created_at' => $now,],
            ['description' => 'Honda','uuid' => Uuid::uuid4(),'created_at' => $now,],
            ['description' => 'Toyota','uuid' => Uuid::uuid4(),'created_at' => $now,],
            ['description' => 'Volkswagen','uuid' => Uuid::uuid4(),'created_at' => $now,],
            ['description' => 'Renault','uuid' => Uuid::uuid4(),'created_at' => $now,],
            ['description' => 'Nissan','uuid' => Uuid::uuid4(),'created_at' => $now,],
            ['description' => 'Peugeot','uuid' => Uuid::uuid4(),'created_at' => $now,],
            ['description' => 'Hyundai','uuid' => Uuid::uuid4(),'created_at' => $now,],
            ['description' => 'Suzuki','uuid' => Uuid::uuid4(),'created_at' => $now,],
            ['description' => 'Chevrolet','uuid' => Uuid::uuid4(),'created_at' => $now,],
            
        ]);
    }
}
