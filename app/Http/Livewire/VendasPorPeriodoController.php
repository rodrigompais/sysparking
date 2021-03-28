<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Venda;
use Carbon\Carbon;
use Livewire\WithPagination;

class VendasPorPeriodoController extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $fecha_ini, $fecha_fim, $pagination = 25;

    public function render()
    {
        $fi = Carbon::parse(Carbon::now())->format('Y-m-d'). ' 00:00:00';
        $ff = Carbon::parse(Carbon::now())->format('Y-m-d'). ' 23:59:59';

        if($this->fecha_ini !='')
        {
            $fi = Carbon::parse($this->fecha_ini)->format('Y-m-d'). ' 00:00:00';
            $ff = Carbon::parse($this->fecha_fim)->format('Y-m-d'). ' 23:59:59';   
        }

        $vendas = Venda::leftjoin('tarifas as t','t.id', 'sales.tarifa_id')
                        ->leftjoin('users as u', 'u.id', 'sales.user_id')
                        ->select('sales.*', 't.amount as tarifa', 't.description as veiculo', 'u.name as usuario')
                        ->whereBetween('sales.created_at', [$fi, $ff] )
                        ->paginate($this->pagination);
        
        $total = Venda::whereBetween('created_at',[$fi, $ff])->where('status', 'Fechado')->sum('total');

        return view('livewire.relatorios.component-vendas-por-periodo' ,[
            'info' => $vendas,
            'somaTotal' => $total
        ]);
    }
}
