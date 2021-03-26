<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'uuid' => Uuid::uuid4(),
            'name' => 'Administrador',
            /* 'type' => 'Admin', */
            'email' => 'admin@mysysparking.com.br',
            'password' => bcrypt('password'),
        ]);
        DB::table('users')->insert([
            'uuid' => Uuid::uuid4(),
            'name' => 'Demo',
            /* 'type' => 'Admin', */
            'email' => 'demo@mysysparking.com.br',
            'password' => bcrypt('password'),
        ]);
    }
}
//Colaborador