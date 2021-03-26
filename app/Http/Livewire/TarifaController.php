<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Tarifa;
use App\Models\Tipo;
use Ramsey\Uuid\Uuid;
use DB;

class TarifaController extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $time = 'Selecione', $type_id = 'Selecione', $description, $amount, $hierarchy;
    public $selected_id, $search;
    public $action = 1;
    public $pagination = 25;
    public $types;

    public function mount()
    {
        $this->getHierarchy();
    }

    public function getHierarchy()
    {
        $tarifa = Tarifa::count();
        if ($tarifa > 0) {
            $tarifa = Tarifa::select('hierarchy')->orderBy('hierarchy', 'desc')->first();
            $this->hierarchy = $tarifa->hierarchy + 1;
        }else{
            $this->hierarchy = 0;
        }
    }

    public function render()
    {
        $this->types = Tipo::all();
        if (strlen($this->search) >0 ) {
            $info = Tarifa::leftjoin('types as t', 't.id', 'tarifas.type_id')
                ->where('tarifas.description', 'like', '%' . $this->search . '%')
                ->orWhere('tarifas.time', 'like', '%' . $this->search . '%')
                ->select('tarifas.*', 't.description as type')
                ->orderBy('tarifas.time', 'desc')
                ->orderBy('t.description')
                ->paginate($this->pagination);

            return view('livewire.tarifas.component', [
                'info' => $info
            ]);
        } else {
            $info = Tarifa::leftjoin('types as t', 't.id', 'tarifas.type_id')
                ->select('tarifas.*', 't.description as type')
                ->orderBy('tarifas.time')
                ->orderBy('t.description')
                ->paginate($this->pagination);            

            return view('livewire.tarifas.component', [
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
        $this->resetInput();
        $this->action = $action;
    }

    public function resetInput()
    {
        $this->description = '';
        $this->tipe = '';
        $this->amount = '';
        $this->type_id = 'Selecione';
        $this->selected_id = null;
        $this->action = 1;
        $this->search = '';
    }

    public function edit($id)
    {
        $record = Tarifa::find($id);
        $this->selected_id = $record->id;
        $this->description = $record->description;
        $this->time = $record->time;
        $this->amount = $record->amount;
        $this->type_id = $record->type_id;
        $this->hierarchy = $record->hierarchy;
        $this->action = 2;
    }

    public function CreateOrUpdate()
    {
        $this->validate([
            'time' => 'required',
            'amount' => 'required',
            'type_id' => 'required',
            'time' => 'not_in:Selecione',
            'type_id' => 'not_in:Selecione'

        ]);

        if ($this->selected_id > 0) {
            $existe = Tarifa::where('time', $this->time)
                ->where('type_id', $this->type_id)
                ->where('id', '<>', $this->selected_id)
                ->select('time')
                ->get();
        } else {

            $existe = Tarifa::where('time', $this->time)
                ->where('type_id', $this->type_id)
                ->select('time')
                ->get();
        }

        if ($existe->count() > 0) {
            $this->emit('msg-error', 'Essa Tarifa já exite!');
            $this->resetInput();
            return;
        }

        if ($this->selected_id <= 0) {
            $tarifa = Tarifa::create([
                'time' => $this->time,
                'description' => $this->description,
                'amount' => $this->amount,
                'type_id' => $this->type_id,
                'hierarchy' => $this->hierarchy,
                'uuid' => Uuid::uuid4(),
            ]);
            $tarifa['amount'] = str_replace(",", ".", $tarifa['amount']);
        } else {
            $tarifa = Tarifa::find($this->selected_id);
            $tarifa->update([
                'time' => $this->time,
                'description' => $this->description,
                'amount' => $this->amount,
                'type_id' => $this->type_id,
                'hierarchy' => $this->hierarchy,
            ]);
            $tarifa['amount'] = str_replace(",", ".", $tarifa['amount']);
        }

        if ($this->hierarchy == 1) {
            /* Tarifa::where('id', '<>', $tarifa->id)->update([
                'hierarchy' => 0
            ]); */
        }

        if ($this->selected_id)
            $this->emit('msg-ok', 'Tarifa atualizada com Sucesso');
        else
            $this->emit('msg-ok', 'Tarifa criada com Sucesso');

        $this->resetInput();
        $this->getHierarchy();
    }

    protected $listeners = [
        'deleteRow' => 'destroy',
        'createFromModal' => 'createFromModal'
    ];

    public function createFromModal($info)

    {
        $data = json_decode($info);
        $this->selected_id = $data->id;
        $this->time = $data->time;
        $this->type_id = $data->type_id;
        $this->amount = $data->amount;
        $this->description = $data->description;
        $this->hierarchy = $data->hierarchy;

        $this->CreateOrUpdate();
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Tarifa::find($id);
            $record->delete();
            $this->resetInput();
        }
    }
}
