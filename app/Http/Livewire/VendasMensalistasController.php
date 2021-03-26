<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Venda;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;

class VendasMensalistasController extends Component
{
    public $totalVencidos, $totalaVencer;
    private $pagination = 5;
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public function render()
    {
        $info = Venda::leftjoin('carriers as v', 'v.id', 'sales.carrier_id')
                    ->leftjoin('customercarriers as cv', 'cv.carrier_id', 'v.id')
                    ->leftjoin('users as u', 'u.id', 'cv.user_id')
                    ->where('sales.carrier_id','>', 0)
                    ->where('sales.status', 'Aberto')
                    ->select('sales.*', 'u.name as cliente', 'v.plate', 'v.model','v.brand','u.telephone',
                        DB::RAW("'' as restantemeses "),
                        DB::RAW("'' as restantedias "),
                        DB::RAW("'' as restantehoras "),
                        DB::RAW("'' as restanteyears "),
                        DB::RAW("'' as dif "),
                        DB::RAW("'' as restantemeses "),
                        DB::RAW("'' as estado "))
                    ->orderBy('sales.departure', 'asc')
                    ->paginate($this->pagination);

                    foreach ($info as $r) {
                        $start = Carbon::parse($r->acceso);
                        $end = Carbon::parse($r->departure);

                        if(Carbon::now()->greaterThan($end))
                        {
                            $r->estado = 'Vencido';
                            $years =0;
                            $months =0;
                            $days =0;
                            $hours =0;
                        }else{
                            $years = $start->diffInYears($end);
                            $months = $start->diffInMonths($end);
                            $days = $start->diffInDays($end);
                            $hours = $start->diffInHours($end);
                            $r->estado = ($days > 3 ? "Ativo" : "Proximo");
                            $r->diff = Carbon::parse($r->departure)->diffForHumans();
                        }
                        $r->restanteyears = $years;
                        $r->restantemeses = $months;
                        $r->restantedias = $days;
                        $r->restantehoras = $hours;                        

                        if($days < 1) $this->totalVencidos ++;
                        if($days > 0 && $days <=3) $this->totalaVencer ++;

                    }
        return view('livewire.relatorios.component-vendas-mensalistas',[
            'info' => $info
        ]);
    }

    protected $listeners = ['checkOutTicketMensalista' => 'checkOutTicketMensalista'];

    public function checkOutTicketMensalista($id)
    {
        $venda = Venda::find($id);
        $venda->status = 'Fechado';
        $venda->save();

        $this->emit('msg-ok', 'O Ticket do Mensalista foi finalizado com sucesso!');
    }
}
