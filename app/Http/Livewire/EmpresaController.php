<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Empresa;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Http;

class EmpresaController extends Component
{
    public $name, $telephone, $email, $direction, $logo, $event;
    public $address_cep, $address_full, $address_number, $address_complement, $address_district, $address_city, $address_uf;

    public function mount()
    {
        $this->event = false;
        $empresa = Empresa::all();

        if ($empresa->count() > 0) {
            $this->name = $empresa[0]->name;
            $this->telephone = $empresa[0]->telephone;
            $this->email = $empresa[0]->email;
            $this->direction = $empresa[0]->direction;
            $this->logo = $empresa[0]->logo;
            $this->address_cep = $empresa[0]->address_cep;
            $this->address_full = $empresa[0]->address_full;
            $this->address_number = $empresa[0]->address_number;
            $this->address_complement = $empresa[0]->address_complement;
            $this->address_district = $empresa[0]->address_district;
            $this->address_city = $empresa[0]->address_city;
            $this->address_uf = $empresa[0]->address_uf;
        }
    }

    public function buscaCep()
    {
        $response = Http::get('https://viacep.com.br/ws/'. $this->address_cep .'/json/');

        $dadosApi = $response->json();

        $this->address_full = $dadosApi['logradouro'];
        $this->address_district = $dadosApi['bairro'];
        $this->address_city = $dadosApi['localidade'];
        $this->address_uf = $dadosApi['uf'];
    }

    public function render()
    {
        return view('livewire.empresa.component');
    }    
 
    protected $listeners = [
        'logoUpload' => 'logoUpload'
    ];

    public function logoUpload($imageData)
    {
        $this->logo = $imageData;
        $this->event = true;
    }

    public function Salvar()
    {
        $rules = [
            'name' => 'required',
            'telephone' => 'required',
            'email' => 'required'
        ];

        $customMessages = [
            'name.required' => 'Campo obrigatório!',
            'telephone.required' => 'Campo obrigatório!',
            'email.required' => 'Campo obrigatório!'
        ];

        $this->validate($rules, $customMessages);

        DB::table('companies')->truncate();

        $empresa =  Empresa::create([
            'name' => $this->name,
            'telephone' => $this->telephone,
            'email' => $this->email,
            'address_cep' => $this->address_cep,
            'address_full' => $this->address_full,
            'address_district' => $this->address_district,
            'address_city' => $this->address_city,
            'address_uf' => $this->address_uf,
            'address_complement' => $this->address_complement,
            'address_number' => $this->address_number,
            'uuid' => Uuid::uuid4()
        ]);
        //dd($empresa);

        if ($this->logo != null && $this->event) {
            $image = $this->logo;
            $fileName = time() . '.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
            $moved = Image::make($image)->save('images/logo/' . $fileName);

            if ($moved) {
                $empresa->logo = $fileName;
                $empresa->save();
            }
        }
        $this->emit('msg-ok', 'Empresa registrada com sucesso!');
    }    
}