<?php

namespace App\Http\Livewire;

use App\Models\Fabricante;
use Livewire\Component;
use App\Models\Modelo;
use Livewire\WithPagination;
use Ramsey\Uuid\Uuid;

class ModelosController extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $description, $fabricante_id = 'Selecione';
    public $producer;
    public $selected_id, $search;
    public $action = 1;
    private $pagination = 20;

    public function mount()
    {

    }

    public function render()
    {
        $this->producer = Fabricante::all()->sortBy('description');//$this->producer = Fabricante::orderBy('description', 'desc')->get();
        
        if (strlen($this->search) >0 ) {
            $info = Modelo::leftjoin('fabricantes as f', 'f.id', 'modelos.fabricante_id')
                ->where('modelos.description', 'like', '%' . $this->search . '%')                
                ->select('modelos.*', 'f.description as fabricante')
                ->orderBy('f.description', 'ASC')
                ->paginate($this->pagination);

            return view('livewire.modelos.component', [
                'info' => $info
            ]);
        } else {
            $info = Modelo::leftjoin('fabricantes as f', 'f.id', 'modelos.fabricante_id')
                ->select('modelos.*', 'f.description as fabricante')
                ->orderBy('f.description', 'ASC')
                ->paginate($this->pagination);            

            return view('livewire.modelos.component', [
                'info' => $info
            ]);
        }
    }

    public function updatingSearch(): void
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
        $this->fabricante_id = 'Selecione';
        $this->selected_id = null;
        $this->action = 1;
        $this->search = '';
    }
    public function edit($id)
    {
        $record = Modelo::findOrFail($id);
        $this->description = $record->description;
        $this->selected_id = $record->id;
        $this->fabricante_id = $record->fabricante_id;
        $this->action = 2;
    }

    public function StoreOrUpdate()
    {
        $this->validate([
            'description' => 'required|min:2|max:50',
            'fabricante_id' => 'required',
            'fabricante_id' => 'not_in:Selecione'
            
        ]);

        if ($this->selected_id > 0) {
            $existe = Modelo::where('description', $this->description)
                ->where('fabricante_id', $this->fabricante_id)
                ->where('id', '<>', $this->selected_id)
                ->select('description')
                ->get();
            if ($existe->count() > 0) {
                session()->flash('msg-error', 'Já existe outro registro com a mesma descrição');
                $this->resetInput();
                return;
            }
        } else {
            $existe = Modelo::where('description', $this->description)
                ->where('fabricante_id', $this->fabricante_id)
                ->select('description')
                ->get();
            if ($existe->count() > 0) {
                session()->flash('msg-error', 'Já existe outro registro com a mesma descrição');
                $this->resetInput();
                return;
            }
        }

        if ($this->selected_id <= 0) {
            $record = Modelo::create([
                'description' => $this->description,
                'fabricante_id' => $this->fabricante_id,
                'uuid' => Uuid::uuid4()
            ]);
            //dd($record);
        } else {
            $record = Modelo::find($this->selected_id);
            $record->update([
                'description' => $this->description,
                'fabricante_id' => $this->fabricante_id
            ]);
        }

        if ($this->selected_id)
            session()->flash('message', 'Modelo Atualizado com Sucesso!');
        else
            session()->flash('message', 'Modelo Criado com Sucesso!');

        $this->resetInput();
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Modelo::find($id);
            $record->delete();
            $this->resetInput();
        }
    }

    protected $listeners = [
        'deleteRow' => 'destroy'
    ];
}