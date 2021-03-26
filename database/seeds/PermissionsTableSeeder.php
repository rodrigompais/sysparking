<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Lista de Permissões
        Permission::create(['name' => 'tarifas_index']);
        Permission::create(['name' => 'tarifas_create']);
        Permission::create(['name' => 'tarifas_edit']);
        Permission::create(['name' => 'tarifas_destroy']);

        //Lista de Roles
        $admin = Role::create(['name' => 'Admin']);
        $colaborador = Role::create(['name' => 'Colaborador']);
        $cliente = Role::create(['name' => 'Cliente']);

        //
        $admin->givePermissionTo([
            'tarifas_index',
            'tarifas_create',
            'tarifas_edit',
            'tarifas_destroy'
        ]);

        $user = User::find(1);
        $user->assignRole('Admin');
    }
}
