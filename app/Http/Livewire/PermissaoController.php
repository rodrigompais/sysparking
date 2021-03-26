<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\User;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;

class PermissaoController extends Component
{
    public $permissaoTitle = 'Criar', $perfilTitle = 'Criar', $userSelected;
    public $tab = 'perfil', $perfilSelected;
    public $perfilList;

    public function render()
    {
        $perfis = Role::select('*', DB::RAW("0 as checked"))->get();
        $permissao = Permission::select('*', DB::RAW("0 as checked"))->get();

        if ($this->userSelected != '' && $this->userSelected != 'Selecione') {
            foreach ($perfis as $p) {
                $user = User::find($this->userSelected);
                $temPerfil = $user->hasRole($p->name);
                if ($temPerfil) {
                    $p->checked = 1;
                }
            }
        }

        if ($this->perfilSelected != '' && $this->perfilSelected != 'Selecione') {
            foreach ($permissao as $pm) {
                $perfil = Role::find($this->perfilSelected);
                $temPermissao = $perfil->hasPermissionTo($pm->name);
                if ($temPermissao) {
                    $pm->checked = 1;
                }
            }
        }


        return view('livewire.permissoes.component', [
            'perfis' => $perfis,
            'permissao' => $permissao,
            'usuarios' => User::select('id', 'name')->get()
        ]);
    }

    //Perfil
    public function resetInput()
    {
        $this->perfilTitle = 'Criar';
        $this->permissaoTitle = 'Criar';
        $this->userSelected = '';
        $this->perfilSelected = '';
        $this->permissaoSelected = '';
    }

    public function CriarPerfil($perfilName, $perfilId)
    {
        if ($perfilId)
            $this->UpdatePerfil($perfilName, $perfilId);
        else
            $this->SavePerfil($perfilName);
    }

    public function SavePerfil($perfilName)
    {
        $perfil = Role::where('name', $perfilName)->first();

        if ($perfil) {
            $this->emit('msg-error', 'O perfil que deseja criar já existe!');
            return;
        }
        Role::create([
            'name' => $perfilName
        ]);

        $this->emit('msg-ok', 'Registro criado com sucesso!');
        $this->resetInput();
    }

    public function UpdatePerfil($perfilName, $perfilId)
    {
        $perfil = Role::where('name', $perfilName)->where('id', '<>', $perfilId)->first();
        if ($perfil) {
            $this->emit('msg-error', 'O perfil que deseja criar já existe!');
            return;
        }

        $perfil = Role::find($perfilId);
        $perfil->name = $perfilName;
        $perfil->save();
        $this->emit('msg-ok', 'Registro criado com Sucesso');
        $this->resetInput();
    }

    public function destroyPerfil($perfilId)
    {
        Role::find($perfilId)->delete();
        $this->emit('msg-ok', 'Registro excluido com sucesso!');
    }


    public function AssociarPerfil($perfilList)
    {
        if ($this->userSelected > 0) {
            $user = User::find($this->userSelected);
            if ($user) {
                $user->syncRoles($perfilList);
                $this->emit('msg-ok', 'Perfil associado com sucesso!');
                $this->resetInput();
            }
        }
    }

    protected $listeners = [ //listeners 
        'destroyPerfil' => 'destroyPerfil',
        'destroyPermissao' => 'destroyPermissao',
        'CriarPermissao' => 'CriarPermissao',
        'CriarPerfil' => 'CriarPerfil',
        'AssociarPerfil' => 'AssociarPerfil',
        'AssociarPermissao' => 'AssociarPermissao'
    ];

    //Permissões

    public function CriarPermissao($permissaoName, $permissaoId)
    {
        if ($permissaoId)
            $this->UpdatePermissao($permissaoName, $permissaoId);
        else
            $this->SavePermissao($permissaoName);
    }

    public function SavePermissao($permissaoName)
    {
        $permissao = Permission::where('name', $permissaoName)->first();
        if ($permissao) {
            $this->emit('msg-error', 'Já existe uma permissão cadastrada no sistema');
            return;
        }

        Permission::create([
            'name' => $permissaoName
        ]);
        $this->emit('msg-ok', 'Permissão criada com sucesso!');
        $this->resetInput();
    }

    public function UpdatePermissao($permissaoName, $permissaoId)
    {
        $permissao = Permission::where('name', $permissaoName)->where('id', '<>', $permissaoId)->first();
        if ($permissao) {
            $this->emit('msg-error', 'Já existe uma permissão cadastrada no sistema');
            return;
        }

        $permissao = Permission::find($permissaoId);
        $permissao->name = $permissaoName;
        $permissao->save();
        $this->emit('msg-ok', 'Registro atualizado com sucesso!');
        $this->resetInput();
    }

    public function destroyPermissao($permissaoId)
    {
        Permission::find($permissaoId)->delete();
        $this->emit('msg-ok', 'Registro excluido com sucesso!');
    }

    public function AssociarPermissao($permissaoList, $perfilId)
    {
        if ($perfilId > 0) {
            $perfil = Role::find($perfilId);

            if ($perfil) {
                $perfil->syncPermissions($permissaoList);
                $this->emit('msg-ok', 'Permissão associada com sucesso!');
                $this->resetInput();
            }
        }
    }
}