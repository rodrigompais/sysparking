<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Intervention\Image\ImageManagerStatic as Image;
use Livewire\Component;
use Livewire\WithPagination;
use Ramsey\Uuid\Uuid;
use App\Models\{
    Movimiento
};


class MovimientosController extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $type = 'Selecione', $description, $amount, $receipt;
    public $selected_id, $search;
    public $action = 1;
    private $pagination = 50;


    public function render()
    {
        if (strlen($this->search) > 0) {
            return view('livewire.movimientos.component', [
                'info' => Movimiento::where('type', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->paginate($this->pagination),
            ]);
        } else {
            $caixa = Movimiento::leftjoin('users as u', 'u.id', 'cashdesk.user_id')
                ->select('cashdesk.*', 'u.name')
                ->orderBy('id', 'DESC')
                ->paginate($this->pagination);

            return view('livewire.movimientos.component', [
                'info' => $caixa,
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
        $this->description = '';
        $this->type = 'Selecione';
        $this->amount = '';
        $this->receipt = '';
        $this->selected_id = null;
        $this->action = 1;
        $this->search = '';
    }

    public function edit($id)
    {
        $record = Movimiento::findOrFail($id);
        $this->selected_id = $id;
        $this->type = $record->type;
        $this->description = $record->description;
        $this->amount = $record->amount;
        $this->receipt = $record->receipt;
        $this->action = 3;
    }

    public function StoreOrUpdate()
    {
        $this->validate([
            'type' => 'not_in:Selecione'
        ]);

        $this->validate([
            'type' => 'required',
            'amount' => 'required',
            'description' => 'required'
        ]);

        if ($this->selected_id <= 0) {
            $caixa = Movimiento::create([
                'amount' => $this->amount, 
                'type' => $this->type,
                'description' => $this->description,
                'user_id' => Auth::user()->id,
                'uuid' => Uuid::uuid4()
            ]);
            $caixa['amount'] = str_replace(",", ".", $caixa['amount']);

            if ($this->receipt) {
                $image = $this->receipt;
                $fileName = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                $moved = Image::make($image)->save('images/movs/' . $fileName);
                if ($moved) {
                    $caixa->receipt = $fileName;
                    $caixa->save();
                }
            }
        } else {
            $record = Movimiento::find($this->selected_id);
            $record->update([
                'amount' => $this->amount,
                'type' => $this->type,
                'description' => $this->description,
                'user_id' => Auth::user()->id,
            ]);
            $record['amount'] = str_replace(",", ".", $record['amount']);

            if ($this->receipt) {
                $image = $this->receipt;
                $fileName = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
                $moved = Image::make($image)->save('images/movs/' . $fileName);
                if ($moved) {
                    $record->receipt = $fileName;
                    $record->save();
                }
            }
        }
        if ($this->selected_id)
            $this->emit('msgok', 'Movimento de Caixa Atualizado com Sucesso!');
        else
            $this->emit('msgok', 'Movimento de Caixa foi Criado com Sucesso!');

        $this->resetInput();
    }

    protected $listeners = [
        'deleteRow' => 'destroy',
        'fileUpload' => 'handleFileUpload'
    ];

    public function handleFileUpload($imageData)
    {
        $this->receipt = $imageData;
    }

    public function destroy($id)
    {
        if ($id) {
            $record = Movimiento::find($id);
            $record->delete();
            $this->resetInput();
        }
    }
}
