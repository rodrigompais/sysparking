<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;

use App\User;
use App\Models\Venda;
use App\Models\Cajas;
use Carbon\Carbon;
use Livewire\WithPagination;

class FechamentosCaixasController extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $fecha, $user, $vendas, $entradas, $saidas, $balanco;

    public function mount()
    {
        $this->vendas = 0;
        $this->entradas = 0;
        $this->saidas = 0;
        $this->balanco = ($this->vendas + $this->entradas) - $this->saidas;
    }

    public function render()
    {
        $users = User::where('type', '=', '1')->select('name','id')->get();

        return view('livewire.fechamentoscaixas.component',[
            'users' => $users
        ]);
    }

    public function Balance()
    {
        if($this->user == 0)
        {
            $this->vendas = Venda::whereDate('created_at', Carbon::today())->sum('total');

            $this->entradas = Cajas::whereDate('created_at', Carbon::today())->where('type','Ingreso')->sum('amount');

            $this->saidas = Cajas::whereDate('created_at', Carbon::today())->where('type','<>','Ingreso')->sum('amount');
        }else{
            $this->vendas = Venda::where('user_id', $this->user)->whereDate('created_at', Carbon::today())->sum('total');

            $this->entradas = Cajas::where('user_id', $this->user)->whereDate('created_at', Carbon::today())->where('type','Ingreso')->sum('amount');

            $this->saidas = Cajas::where('user_id', $this->user)->whereDate('created_at', Carbon::today())->where('type','<>','Ingreso')->sum('amount');
        }

        $this->balanco = ($this->vendas + $this->entradas) - $this->saidas;
    }

    public function Consultar()
    {
        $fi = Carbon::parse($this->fecha)->format('Y-m-d') . ' 00:00:00';
        $ff = Carbon::parse($this->fecha)->format('Y-m-d') . ' 23:59:59';

        if($this->user == 0)
        {
            $this->vendas = Venda::whereBetween('created_at', [$fi, $ff])->sum('total');
            $this->entradas = Cajas::whereBetween('created_at', [$fi, $ff])->where('type', 'Ingresso')->sum('amount');
            $this->saidas = Cajas::whereBetween('created_at', [$fi, $ff])->where('type', '<>', 'Ingresso')->sum('amount');
        }else{
            $this->vendas = Venda::where('user_id', $this->user)->whereBetween('created_at', [$fi, $ff])->sum('total');
            $this->entradas = Cajas::where('user_id', $this->user)->whereBetween('created_at', [$fi, $ff])->where('type', 'Ingresso')->sum('amount');
            $this->saidas = Cajas::where('user_id', $this->user)->whereBetween('created_at', [$fi, $ff])->where('type', '<>', 'Ingresso')->sum('amount');
        }

        $this->balanco = ($this->vendas + $this->entradas) - $this->saidas;
    }

    protected $listeners = [
        'info2PrintFechamento' => 'PrintFechamento'
    ];

    public function PrintFechamento($vendas, $entradas, $saidas, $balanco)
    {
        $nomeImpressora = "eQual";
        $connector = new WindowsPrintConnector($nomeImpressora);
        $impressora = new Printer($connector);

        $impressora->setJustification(Printer::JUSTIFY_CENTER);
        $impressora->setTextSize(2,2);

        $impressora->text("MYCONTROLE PARKING \n");
        $impressora->setTextSize(1,1);
        $impressora->text("** Fechamento de Caixa ** \n\n");

        $impressora->setJustification(Printer::JUSTIFY_LEFT);
        $impressora->text("================================\n");
        $impressora->text("Usuário: ". ($this->user == null ? 'Todos' : $this->user) . "\n");
        $impressora->text("Fechamento: ". ($this->fecha == null ? date('m/d/Y h:i:s a', time()) : Carbon::parse($this->fecha)->format('d-m-Y')) . "\n");

        $impressora->text("---------------------");
        $impressora->text("Vendas: R$". number_format($this->vendas,2) . "\n" );
        $impressora->text("Entradas: R$". number_format($this->entradas,2) . "\n" );
        $impressora->text("Saídas: R$". number_format($this->saidas,2) . "\n" );
        $impressora->text("Fechamento: R$". number_format($this->balanco,2) . "\n" );
        $impressora->text("================================\n");

        $impressora->feed(3);
        $impressora->cut();
        $impressora->close();
    }
}
