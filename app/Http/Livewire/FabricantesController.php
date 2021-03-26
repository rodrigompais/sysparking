<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Ramsey\Uuid\Uuid;
use App\Models\Fabricante;
use Livewire\WithPagination;

class FabricantesController extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $description;
    public $selected_id, $search;
    public $action = 1;
    private $pagination = 20;

    public function mount()
    {
    }

    public function render()
    {
        if (strlen($this->search) > 0) {
            $info = Fabricante::where('description', 'like', '%' . $this->search . '%')->orderBy('id', 'asc')->paginate($this->pagination);
            return view('livewire.fabricantes.component', [
                'info' => $info,
            ]);
        } else {
            $info = Fabricante::paginate($this->pagination);
            return view('livewire.fabricantes.component', [
                'info' => $info,
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
        $this->selected_id = null;
        $this->action = 1;
        $this->search = '';
    }

    public function edit($id)
    {
        $record = Fabricante::findOrFail($id);
        $this->description = $record->description;
        $this->selected_id = $record->id;
        $this->action = 2;
    }

    public function StoreOrUpdate()
    {
        $this->validate([
            'description' => 'required|min:3|max:50'
        ]);

        if ($this->selected_id > 0) {
            $existe = Fabricante::where('description', $this->description)
                ->where('id', '<>', $this->selected_id)
                ->select('description')
                ->get();
            if ($existe->count() > 0) {
                session()->flash('msg-error', 'Já existe outro registro com a mesma descrição');
                $this->resetInput();
                return;
            }
        } else {
            $existe = Fabricante::where('description', $this->description)
                ->select('description')
                ->get();
            if ($existe->count() > 0) {
                session()->flash('msg-error', 'Já existe outro registro com a mesma descrição');
                $this->resetInput();
                return;
            }
        }

        if ($this->selected_id <= 0) {
            $record = Fabricante::create([
                'description' => $this->description,
                'uuid' => Uuid::uuid4()
            ]);
        } else {
            $record = Fabricante::find($this->selected_id);
            $record->update([
                'description' => $this->description
            ]);
        }

        if ($this->selected_id)
            session()->flash('message', 'Fabricante Atualizado com Sucesso!');
        else
            session()->flash('message', 'Fabricante Criado com Sucesso!');

        $this->resetInput();
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Fabricante::find($id);
            $record->delete();
            $this->resetInput();
        }
    }

    protected $listeners = [
        'deleteRow' => 'destroy'
    ];
}