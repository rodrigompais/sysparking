<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Venda;
use Illuminate\Support\Facades\DB;
use App\Traits\GenericTrait;


class TicketExtraviadosController extends Component
{
    use WithPagination;
    use GenericTrait;
    protected $paginationTheme = 'bootstrap';
    private $pagination = 25;
    public $search;

    public function render()
    {
        
        if(strlen($this->search) > 0)
        {
        $vendas = Venda::leftjoin('tarifas as t', 't.id','sales.tarifa_id')
                    ->leftjoin('users as u', 'u.id', 'sales.user_id')
                    /* ->leftjoin('vacancies as v', 'v.id', 'sales.vacancy_id') */
                    ->select('sales.*','t.amount as tarifa', 't.description as veiculo', 'u.name as usuario',
                    DB::RAW("0 as pago"))
                    ->where('status', 'Aberto')->where('sales.description','like',"%". $this->search. "%")->where('carrier_id', null)
                    ->orderBy('id', 'desc')
                    ->paginate($this->pagination);
        }else{
        $vendas = Venda::leftjoin('tarifas as t', 't.id','sales.tarifa_id')
                    ->leftjoin('users as u', 'u.id', 'sales.user_id')
                    /* ->leftjoin('vacancies as v', 'v.id', 'sales.vacancy_id') */
                    ->select('sales.*','t.amount as tarifa', 't.description as veiculo', 'u.name as usuario',
                    DB::RAW("0 as pago"))
                    ->where('status', 'Aberto')->where('carrier_id', null)
                    ->orderBy('id', 'desc')
                    ->paginate($this->pagination);
        }

        foreach ($vendas as $r) {
            $total = $this->Total($r->acceso, $r->tarifa_id);
            $r->pago = number_format($total,2);
        }

        return view('livewire.extraviados.component-ticket-extraviados',[
            'info' => $vendas
        ]);
    }

    public function updatingSearch()
    {
        $this->gotoPage(1);
    }

    public function SaidaVeiculo($bar_code)
    {
        $this->Saidas($bar_code);
    }

    protected $listeners = [
        'doCheckOut' => 'SaidaVeiculo'
    ];
}
