<?php

namespace App\Http\Livewire;

use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Venda;
use Carbon\Carbon;

class VendasDiariasController extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    
     public $fech_ini, $fech_fin, $pagination = 10;


    public function render()
    {
        $vendas = Venda::leftjoin('tarifas as t', 't.id', 'sales.tarifa_id')
                        ->leftjoin('users as u', 'u.id', 'sales.user_id')
                        ->select('sales.*', 't.amount as tarifa', 't.description as veiculo', 'u.name as usuario')
                        ->whereDate('sales.created_at', Carbon::today())
                        ->orderBy('id','desc')
                        ->paginate($this->pagination);
        
        $total = Venda::whereDate('sales.created_at', Carbon::today())->where('status','Fechado')->sum('total');

        return view('livewire.relatorios.component-vendas-diarias', [
            'info' => $vendas,
            'somaTotal' => $total
        ]);
    }
}
