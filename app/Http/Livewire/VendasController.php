<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\CustomerCarrier;
use App\Models\Vaga;
use App\Models\Tarifa;
use App\Models\Tipo;
use App\Models\Veiculo;
use App\Models\Venda;
use App\User;
use Carbon\Carbon;
use Ramsey\Uuid\Uuid;
//use DB;
use Illuminate\Support\Facades\DB;

class VendasController extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $selected_id, $search, $buscarCliente, $bar_code, $obj, $clientes, $clienteSelected;
    public $acceso, $name, $telephone, $cellphone, $email, $plate, $type, $total, $time, $brand, $model, $color, $carrier, $veiculo, $nota, $fecha_ini, $fecha_fim, $description, $arrayTarifas, $tarifaSelected;
    private $pagination = 5;
    public $section = 1;
    public $totalCalculado, $carrier_id;

    public function mount()
    {
        $this->arrayTarifas = Tarifa::all();
        if ($this->arrayTarifas->count() > 0) $this->tarifaSelected = $this->arrayTarifas[0]->id;
    }

    public function render()
    {
        $clientes = null;
        $vagas = Vaga::join('types as t', 't.id', 'vacancies.type_id')
            ->select(
                'vacancies.*',
                't.description as type',
                't.id as type_id',
                't.image',
                DB::RAW("'' as tarifa_id"),
                DB::RAW("'' as bar_code"),
                DB::RAW("0 as folio"),
                DB::RAW("'' as description_carrier")
            )
            ->get();

        //buscar clientes    
        if (strlen($this->buscarCliente) > 0) {
            $clientes = CustomerCarrier::leftjoin('users as u', 'u.id', 'customercarriers.user_id')
                ->leftjoin('carriers as v', 'v.id', 'customercarriers.carrier_id')
                ->select('v.id as carrier_id', 'v.plate', 'v.brand', 'v.color', 'v.nota', 'v.model', 'u.id as cliente_id', 'name', 'telephone', 'cellphone', 'email')
                ->where('name', 'like', '%' . $this->buscarCliente . '%')
                ->get();
        } else {
            $clientes = User::where('type', '<>', '1')
                ->select('id', 'name', 'telephone', 'cellphone', 'email', DB::RAW("'' as carriers "))
                ->take(1)->get();
        }
        //Permission::where('name', $permissaoName)

        $this->clientes = $clientes;

        foreach ($vagas as $g) {
            $tarifa = Tarifa::where('type_id', $g->type_id)->select('id')->first();
            $g->tarifa_id = $tarifa['id'];

            $venda = Venda::where('vacancy_id', $g->id)->select('bar_code', 'id', 'description as description_carrier')
                ->where('status', 'Aberto')
                ->orderBy('id', 'desc')
                ->first();
            $g->bar_code = ($venda['bar_code'] == null ? '' : $venda['bar_code']);
            $g->folio = ($venda['id'] ?? '');
            $g->description_carrier = ($venda['description_carrier'] ?? '');
        }

        if ($this->total == null) {
            $this->totalCalculado = 0;
        } else {
            $this->totalCalculado = $this->total;
        }

        return view('livewire.vendas.component', [
            'vagas' => $vagas,
            'clientes' => $clientes
        ]);
    }

    protected $listeners = [
        'RegistrarEntrada' => 'RegistrarEntrada',
        'doCheckOut' => 'doCheckOut',
        'doCheckIn' => 'RegistrarEntrada'
    ];

    public function doCheckOut($bar_code, $section = 2)
    {
        $bar_code = ($bar_code == '' ? $this->bar_code : $bar_code);
        $obj = Venda::where('bar_code', $bar_code)->select('*', DB::RAW("'' as time"), DB::RAW("'' as total"))->first();

        if ($obj != null) {
            $this->section = $section;
            $this->bar_code = $bar_code;

            $start = Carbon::parse($obj->acceso);
            $end = new \DateTime(Carbon::now());
            $obj->time = $start->diffInHours($end) . ':' . $start->diff($end)->format('%I:%S');

            $obj->total = $this->calculateTotal($obj->acceso, $obj->tarifa_id);
            $this->obj = $obj;
        } else {
            $this->emit('msg-ok', 'Não existe código de Barras');
            $this->bar_code = '';
            return;
        }
    }

    public function calculateTotal($fromDate, $tarifaId, $toDate = '')
    {
        $fraccion = 0;
        $tarifa = Tarifa::where('id', $tarifaId)->first();
        $start = Carbon::parse($fromDate);
        $end = new \DateTime(Carbon::now());

        if (!$toDate == '') $end = Carbon::parse($toDate);

        $time = $start->diffInHours($end) . ':' . $start->diff($end)->format('%I:%S');
        $minutos = $start->diffInMinutes($end);
        $horasCompletas = $start->diffInHours($end);

        if ($minutos <= 65) // de 0 a 65 minutos se cobra tarifa completa R$ 13,00
        {
            $fraccion = $tarifa->amount;
        } else {
            $m = ($minutos % 60);
            if (in_array($m, range(0, 5))) { // 5 minutos de tolerância para sair com o carro            

            } else if (in_array($m, range(6, 30))) { // depois de 6-30 minutos se cobra média da tarifa (R$ 6,50)
                $fraccion = ($tarifa->amount / 2);
            } else if (in_array($m, range(31, 59))) { //depois da primeira hora de 31-59 se cobra tarifa completa
                $fraccion = $tarifa->amount;
            }
        }

        $total = (($horasCompletas * $tarifa->amount) + $fraccion);
        return $total;
    }

    public function RegistrarEntrada($tarifa_id, $vacancy_id, $status = '', $comment = '')
    {
        if ($status == 'Ocupado') {
            $this->emit('msg-ok', 'Essa vaga esta ocupada!');
            return;
        }

        $vaga = Vaga::where('id', $vacancy_id)->first();
        $vaga->status =  'Ocupado';
        $vaga->save();

        $venda = Venda::create([
            'acceso' => Carbon::now(),
            'uuid' => Uuid::uuid4(),
            'user_id' => auth()->user()->id,
            'tarifa_id' => $tarifa_id,
            'vacancy_id' => $vacancy_id,
            'description' => $comment
        ]);

        $venda->bar_code = sprintf('%07d', $venda->id);
        $venda->save();

        $this->bar_code = '';
        $this->emit('getin-ok', 'Entrada Registrada com Sucesso!');
        $this->emit('print', $venda->id);
    }

    public function TicketVisita()
    {
        $tarifas = Tarifa::select('hierarchy', 'type_id', 'id')->orderBy('hierarchy', 'desc')->get();
        $tarifaId;

        foreach ($tarifas as $j) {
            $vaga = Vaga::where('status', 'Disponivel')->where('type_id', $j->type_id)->first();
            if ($vaga) {
                $tarifaId = $j->id;
                break;
            }
        }

        if ($vaga == null) {
            $this->emit('msg-ops', 'Todas as vagas já estão ocupadas!');
            return;
        }

        $vaga->status = 'Ocupado';
        $vaga->save();

        $venda = Venda::create([
            'acceso' => Carbon::now(),
            'uuid' => Uuid::uuid4(),
            'user_id' => auth()->user()->id,
            'tarifa_id' => $tarifaId,
            'vacancy_id' => $vaga->id
        ]);

        //Gerar codigo de barra com 7 digitos
        $venda->bar_code = sprintf('%07d', $venda->id);
        $venda->save();

        $this->bar_code = '';
        $this->emit('getin-ok', 'Entrada Registrada com Sucesso!');
    }

    public function doCheckIn($tarifa_id, $vacancy_id, $status = '')
    {
        $this->emit('checkin-ok', 'Entrada Registrada no Sistema!');
    }


    public function RegistrarTicketVenda()
    {
        $rules = [
            'name' => 'required|min:3',
            'plate' => 'required|min:3',
            'email' => 'nullable|email'
        ];

        $customMessages = [
            'name.required' => 'Campo obrigatório!',
            'plate.required' => 'Campo obrigatório!'
        ];

        $this->validate($rules, $customMessages);

        $existe = Venda::where('plate', $this->plate)->where('carrier_id', '>', 0)->where('status', 'Aberto')->count();
        if ($existe > 0) {
            $this->emit('msg-error', "Essa placa $this->plate já tem um ticket em aberto!");
            return;
        }
        //dd($existe);

        DB::beginTransaction();
        try {
            if ($this->clienteSelected > 0) {
                $cliente = User::find($this->clienteSelected);
            } else {
                if (empty($this->email)) $this->email = uniqid() . '@sysparking.com.br';
                $cliente = User::create([
                    'uuid' => Uuid::uuid4(),
                    'name' => $this->name,
                    'telephone' => $this->telephone,
                    'cellphone' => $this->cellphone,
                    'type' => 'Cliente',
                    'email' => $this->email,
                    'password' => bcrypt('password')
                ]);
                //dd($cliente);
            }

            if ($this->clienteSelected == null) {
                $carrier = Veiculo::create([
                    'uuid' => Uuid::uuid4(),
                    'plate' => $this->plate,
                    'model' => $this->model,
                    'brand' => $this->brand,
                    'color' => $this->color,
                    'nota' => $this->nota
                ]);
                // dd($carrier);
            }

            if ($this->clienteSelected == null) {
                $cv = CustomerCarrier::create([
                    'uuid' => Uuid::uuid4(),
                    'user_id' => $cliente->id,
                    'carrier_id' => $carrier->id
                ]);
                //dd($cv);
            }

            $venda = Venda::create([
                'uuid' => Uuid::uuid4(),
                'acceso' => Carbon::parse($this->fecha_ini),
                'departure' => Carbon::parse($this->fecha_fim),
                'user_id' => auth()->user()->id,
                'tarifa_id' => $this->tarifaSelected,
                'plate' => $this->plate,
                'model' => $this->model,
                'brand' => $this->brand,
                'color' => $this->color,
                'description' => $this->nota,
                'carrier_id' => $carrier->id,
                'total' => $this->total,
                'hours' => $this->time
            ]);
            //dd($venda);

            $venda->bar_code = sprintf('%07d', $venda->id);
            $venda->save();

            $this->bar_code = '';
            $this->emit('getin-ok', 'Realizado o registro do cliente e da venda no sistema!');
            $this->emit('print-mensal', $venda->id);
            $this->action = 1;
            $this->limparCliente();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            $status = $e->getMessage();
            dd($e);
        }
    }

    public function CalcularTempo($fechaEntrada)
    {
        $start = Carbon::parse($fechaEntrada);
        $end = new \DateTime(Carbon::now());
        $time = $start->diffInHours($end) . ':' . $start->diff($end)->format('%I:%S');
        return $time;
    }

    public function BuscarTicket()
    {
        $novoTotal = 0;

        $rules = ['bar_code' => 'required'];

        $customMessages = ['bar_code.required' => 'Informa o código de barra!'];

        $this->validate($rules, $customMessages);

        $ticket = Venda::where('bar_code', $this->bar_code)->select('*')->first();
        if ($ticket) {
            if ($ticket->status == 'Fechado') //Verificar nome!
            {
                $this->emit('msg-ops', 'Esse ticket já tem registra uma saida!');
                $this->bar_code = '';
                return;
            }
        } else {
            $this->emit('msg-ops', 'Esse codigo não existe no sistema!');
            $this->bar_code = '';
            return;
        }

        $tarifa = Tarifa::where('id', $ticket->tarifa_id)->first();

        $time = $this->CalcularTempo($ticket->acceso);

        $novoTotal = $this->calculateTotal($ticket->acceso, $ticket->tarifa_id);

        $ticket->departure = Carbon::now(); // Verificar nome também
        $ticket->status = 'Fechado';
        $ticket->total = $novoTotal;
        $ticket->hours = $time;
        $ticket->save();

        $vaga = Vaga::where('id', $ticket->vacancy_id)->first();
        $vaga->status = 'Disponivel';
        $vaga->save();

        if ($ticket) {
            $this->bar_code = '';
            $this->section = 1;
            $this->emit('getout-ok', 'Saida registrada com sucesso!');
        } else {
            $this->bar_code = '';
            $this->section = 1;
            $this->emit('getout-error', 'Não foi possivel registrar a saida! :/');
        }
    }

    public function getSaida()
    {
        if ($this->time <= 0) {
            $this->total = number_format(0, 2);
            $this->fecha_fim = '';
        } else {
            $this->fecha_fim = Carbon::now()->addMonths($this->time)->format('d-m-Y');
            $tarifa = Tarifa::where('time', 'Mensal')->select('amount')->first();

            if ($tarifa->count()) {
                $this->total = $this->time * $tarifa->amount;
            }
        }
    }

    public function mostrarCliente($cliente)
    {
        $this->clientes = '';
        $this->buscarCliente = '';
        $clienteJson = json_decode($cliente);

        $this->name = $clienteJson->name;
        $this->telephone = $clienteJson->telephone;
        $this->cellphone = $clienteJson->cellphone;
        $this->email = $clienteJson->email;

        $this->plate = $clienteJson->plate;
        $this->model = $clienteJson->model;
        $this->color = $clienteJson->color;
        $this->brand = $clienteJson->brand;
        $this->nota = $clienteJson->nota; //Verificar esse item.
        $this->carrier_id = $clienteJson->carrier_id;
        $this->clienteSelected = $clienteJson->cliente_id;
    }

    public function limparCliente()
    {
        $this->name = '';
        $this->telephone = '';
        $this->cellphone = '';
        $this->email = '';
        $this->plate = '';
        $this->model = '';
        $this->color = '';
        $this->brand = '';
        //$this->description = '';
        $this->nota = ''; //Verificar
        $this->clienteSelected = null;
        $this->time = 'Selecione';
        $this->total = ''; //\Carbon\Carbon::now()->format('d/m/Y')
        $this->fecha_ini = ''; //Carbon::now()->format('d/m/Y');
        $this->fecha_fim = '';
    }
}
