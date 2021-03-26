<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\User;
use Livewire\WithPagination;
use Ramsey\Uuid\Uuid;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;

class UsuariossController extends Component
{
    use WithPagination;

    public $role_id = 'Selecione', $name, $telephone, $cellphone, $email, $password;
    public $selected_id /* < id na tabela */, $search;
    public $action = 1, $pagination = 20;

    /* protected $rules = [

        'name' => 'required|min:3|max:250',
        'password' => 'required|string|min:6|max:10',
        'cellphone' => 'required|min:10',
        'telephone' => 'required|min:10',
        'email' => 'required|email',
        'role_id' => 'not_in:Selecione',
        'role_id' => 'required'
    ]; */

    public function render()
    {
        $perfis = Role::select('*', DB::RAW("0 as checked"))->get();

        if (strlen($this->search) > 0) {
            $info = User::where('name', 'like', '%' . $this->search . '%')
                ->orWhere('telephone', 'like', '%' . $this->search . '%')
                ->paginate($this->pagination);

            return view('livewire.usuarios.component', [
                'info' => $info
            ]);
        } else {
            $infor = User::orderBy('id', 'desc')
                ->paginate($this->pagination);

            return view('livewire.usuarios.component', [
                'info' => $infor,
                'perfis' => $perfis
            ]);
        }
    }

    public function updatingSearch()
    {
        $this->gotoPage(1);
    }

    public function doAction($action)
    {
        $this->resetInput();
        $this->action = $action;
    }

    public function resetInput()
    {
        $this->name = '';
        /* $this->role_id = 'Selecione'; */
        $this->telephone = '';
        $this->cellphone = '';
        $this->email = '';
        $this->password = '';
        $this->selected_id = null;
        $this->action = 1;
        $this->search = '';
    }

    public function edit($id)
    {
        $record = User::find($id);

        $this->name = $record->name;
        $this->telephone = $record->telephone;
        $this->cellphone = $record->cellphone;
        $this->email = $record->email;
        //$this->password = $record->password;
        $this->selected_id = $record->id;
        /* $this->role_id = $record->role_id; */
        $this->action = 2;
    }

    public function StoreOrUpdate()
    {        
        if ($this->selected_id <= 0) {
            $this->validate([
                'name' => 'required|min:3|max:250',
                'password' => 'required|string|min:6|max:10',
                'cellphone' => 'required|min:10',
                'telephone' => 'required|min:10',
                'email' => 'required|email'
                /* 'role_id' => 'not_in:Selecione',
                'role_id' => 'required' */
            ]);
            $user = User::create([
                'name' => $this->name,
                'uuid' => Uuid::uuid4(),
                'telephone' => $this->telephone,
                'cellphone' => $this->cellphone,
                'email' => $this->email,
                'password' => bcrypt($this->password)
                /* 'role_id' => $this->role_id */
            ]);
        } else {

            $user = User::find($this->selected_id);

            $data = [
                'name' => $this->name,
                'telephone' => $this->telephone,
                'cellphone' => $this->cellphone,
                'email' => $this->email
                /* 'role_id' => $this->role_id */
            ];

            if ($this->password <> '') {
                $data['password'] =  bcrypt($this->password);
            }

            $user->update($data);
        }

        if ($this->selected_id)
            session()->flash('message', 'Usuário Atualizado com Sucesso!');
        else
            session()->flash('message', 'Usuário Criado com Sucesso!');

        $this->resetInput();
    }

    public function destroy($id)
    {
        if ($id) {
            $record = User::find($id);
            $record->delete();
            $this->resetInput();
        }
    }

    protected $listeners = [
        'deleteRow' => 'destroy'
    ];
}
