<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Ramsey\Uuid\Uuid;
use App\Models\{
    Tipo,
    Vaga
};
//use RealRashid\SweetAlert\Facades\Alert;

class VagasController extends Component
{
    use WithPagination;

    public $type = 'Selecione', $description, $status = 'Disponivel', $types;
    public $selected_id, $search;
    public $action = 1;
    private $pagination = 50;
    protected $paginationTheme = 'bootstrap';
    /* public $tipos; */

    public function render()
    {
        /* if(session('success_message')){
            Alert::success(session('success_message'));
        } */

        $this->types = Tipo::all();

        if (strlen($this->search) > 0) {
            $info = Vaga::leftjoin('types as t', 't.id', 'vacancies.type_id')
                ->select('vacancies.*', 't.description as type')
                ->where('vacancies.description', 'like', '%' . $this->search . '%')
                ->orWhere('vacancies.status', 'like', '%' . $this->search . '%')
                ->paginate($this->pagination);

            return view('livewire.vagas.component', [
                'info' => $info
            ]);
        } else {
            $info = Vaga::leftjoin('types as t', 't.id', 'vacancies.type_id')
                ->select('vacancies.*', 't.description as type')
                ->orderby('vacancies.id', 'desc')
                ->paginate($this->pagination);

            return view('livewire.vagas.component', [
                'info' => $info
            ]);
        }
    }

    public function updatingSearch()
    {
        $this->gotoPage(1);
    }

    public function doAction($action)
    {
        $this->action = $action;
    }

    public function resetInput()
    {
        $this->description = '';
        $this->type = 'Selecione';
        $this->status = 'Disponivel';
        $this->selected_id = null;
        $this->action = 1;
        $this->search = '';
    }

    public function edit($id)
    {
        $record = Vaga::find($id);
        //dd($record);
        $this->selected_id = $id;
        $this->type = $record->type_id;
        $this->description = $record->description;
        $this->status = $record->status;
        $this->action = 2;
    }

    public function StoreOrUpdate()
    {
        $this->validate([
            'type' => 'not_in:Selecione'
        ]);

        $this->validate([
            'type' => 'required',
            'description' => 'required',
            'status' => 'required'
        ]);

        if ($this->selected_id <= 0) {
            $vaga = Vaga::create([
                'description' => $this->description,
                'type_id' => $this->type,
                'status' => $this->status,
                'uuid' => Uuid::uuid4()
            ]);
        } else {
            $record = Vaga::find($this->selected_id);
            $record->update([
                'description' => $this->description,

            ]);
        }

        if ($this->selected_id) 
            $this->emit('msgok', 'Vaga Atualizada com Sucesso!');
         else
            $this->emit('msgok', 'Vaga Atualizada com Sucesso!');
            //return redirect()->back()->with('success_message','Vaga criada com sucesso, agora você tem que criar uma Tarifa para ela!');
        
        $this->resetInput();
    }

    public function destroy($id)
    {
        if($id)
        {
            $record = Vaga::where('id', $id);
            $record->delete();
            $this->resetInput();
            $this->emit('msgok', 'Registro Excluido com Sucesso!');
        }
    }

    protected $listeners = [
        'deleteRow' => 'destroy'
    ];
}
