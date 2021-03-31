<?php

namespace App\Http\Livewire;

use App\Models\Tarifa;
use Livewire\Component;
use Ramsey\Uuid\Uuid;
use App\Models\Tipo;
use Illuminate\Support\Facades\Storage;
use Livewire\WithPagination;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\File;

class TiposController extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $description, $image;
    public $selected_id, $search;
    public $action = 1;
    private $pagination = 20;
    protected $listeners = [
        'deleteRow' => 'destroy',
        'fileUpload' => 'handleFileUpload'
    ];

    public function mount()
    {
    }

    public function render()
    {
        if (strlen($this->search) > 0) {
            $info = Tipo::where('description', 'like', '%' . $this->search . '%')->orderBy('id', 'asc')->paginate($this->pagination);
            return view('livewire.tipos.component', [
                'info' => $info,
            ]);
        } else {
            $info = Tipo::paginate($this->pagination);
            return view('livewire.tipos.component', [
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
        $record = Tipo::findOrFail($id);
        $this->description = $record->description;
        $this->selected_id = $record->id;
        $this->action = 2;
    }

    public function StoreOrUpdate()
    {
        $this->validate([
            'description'   => 'required|min:3',
            /* 'image'         => 'required|file', */
        ]);

        //$this->validate($rules);

        if ($this->selected_id > 0) {
            $existe = Tipo::where('description', $this->description)
                ->where('id', '<>', $this->selected_id)
                ->select('description')
                ->get();
            if ($existe->count() > 0) {
                session()->flash('msg-error', 'Já existe outro registro com a mesma descrição');
                $this->resetInput();
                return;
            }
        } else {
            $existe = Tipo::where('description', $this->description)
                ->select('description')
                ->get();
            if ($existe->count() > 0) {
                session()->flash('msg-error', 'Já existe outro registro com a mesma descrição');
                $this->resetInput();
                return;
            }
        }

        if ($this->selected_id <= 0) {
            $record = Tipo::create([
                'description' => $this->description,
                'uuid' => Uuid::uuid4()
            ]);

            if ($this->image) {
                $image = $this->image;
                $fileName = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1]; //Para criar o nome do arquivo
                $moved = Image::make($image)->save('images/tipos/' . $fileName);

                if ($moved) {
                    $record->image = $fileName;
                    $record->save();
                }
            }
        } else {

            $record = Tipo::find($this->selected_id);
            $record->update([
                'description' => $this->description
            ]);
            File::delete([
                public_path('images/tipos/' . $record->image)
            ]);
            if ($this->image) {
                $image = $this->image;
                $fileName = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1]; //Para criar o nome do arquivo          
                $moved = Image::make($image)->save('images/tipos/' . $fileName);

                if ($moved) {
                    $record->image = $fileName;
                    $record->save();
                }
            }
        }
        if ($this->selected_id)
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Sucesso!',
                'text' => 'Registro atualizado com sucesso!',
                'icon' => 'info'
            ]);
        else
            $this->dispatchBrowserEvent('swal', [
                'title' => 'Sucesso!',
                'text' => 'Registro criado com sucesso!',
                'icon' => 'success'
            ]);

        $this->resetInput();
    }

    public function handleFileUpload($imageData)
    {
        $this->image = $imageData;
    }

    public function destroy($id)
    {
        if ($id) {
            $records = Tarifa::where('type_id', $id)->count();
            if ($records > 0) {
                $this->emit('msg-error', "No es posible eliminar el registro porque existen tarifas asociadas a este tipo");
            } else {
                $tipo = Tipo::where('id', $id);
                //dd($tipo);
                /* File::delete([
                    public_path('images/tipos/' . $tipo->image)
                ]); */
                $tipo->delete();
                $this->emit('msg-ok', 'Registro Excluido com Sucesso!');
                $this->resetInput();
            }
        }
    }
}
