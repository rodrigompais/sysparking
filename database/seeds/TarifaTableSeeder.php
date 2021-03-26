<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

class TarifaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now()->format('Y-m-d H:i:s');
        DB::table('tarifas')->insert([
            ['description' => 'Carro','time' => 'Mensal','type_id' => '1','amount' => '250','hierarchy' => '0','uuid' => Uuid::uuid4(),'created_at' => $now,],
            ['description' => 'Carro','time' => 'Hora','type_id' => '1','amount' => '2.5','hierarchy' => '1','uuid' => Uuid::uuid4(),'created_at' => $now,],
            ['description' => 'Carro','time' => 'Diaria','type_id' => '1','amount' => '25','hierarchy' => '2','uuid' => Uuid::uuid4(),'created_at' => $now,],
            ['description' => 'Carro','time' => 'Semanal','type_id' => '1','amount' => '100','hierarchy' => '3','uuid' => Uuid::uuid4(),'created_at' => $now,],
            ['description' => 'Moto','time' => 'Mensal','type_id' => '2','amount' => '150','hierarchy' => '4','uuid' => Uuid::uuid4(),'created_at' => $now,],
            ['description' => 'Moto','time' => 'Hora','type_id' => '2','amount' => '1.5','hierarchy' => '5','uuid' => Uuid::uuid4(),'created_at' => $now,],
            ['description' => 'Moto','time' => 'Diaria','type_id' => '2','amount' => '15','hierarchy' => '6','uuid' => Uuid::uuid4(),'created_at' => $now,],
            ['description' => 'Moto','time' => 'Semanal','type_id' => '2','amount' => '50','hierarchy' => '7','uuid' => Uuid::uuid4(),'created_at' => $now,],
        ]);
    }
}