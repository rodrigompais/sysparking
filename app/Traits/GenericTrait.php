<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Models\Venda;
use App\Models\Tarifa;
use App\Models\Vaga;
use Spatie\Activitylog\Traits\LogsActivity;

trait GenericTrait
{
    use LogsActivity;

    protected static $logAttributes = ['*'];

    protected static $logOnlyDirty = true;
    
    public function Total($fromDate, $tarifaId, $toDate = '')
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
            if (in_array($m, range(0,5))) { // 5 minutos de tolerância para sair com o carro            

            } else if (in_array($m, range(6,30))) { // depois de 6-30 minutos se cobra média da tarifa (R$ 6,50)
                $fraccion = ($tarifa->amount / 2);
            } else if (in_array($m, range(31,59))) { //depois da primeira hora de 31-59 se cobra tarifa completa
                $fraccion = $tarifa->amount;
            }
        }

        $total = (($horasCompletas * $tarifa->amount) + $fraccion);
        return $total;
    }

    public function CalcularTempo($fechaEntrada)
    {
        $start = Carbon::parse($fechaEntrada);
        $end = new \DateTime(Carbon::now());
        $time = $start->diffInHours($end) . ':' . $start->diff($end)->format('%I:%S');
        return $time;
    }

    public function Saidas($bar_code)
    {
        $novoTotal = 0;
        
        $ticket = Venda::where('bar_code', $bar_code)->select('*')->first();
        if($ticket)
        {
            if($ticket->status == 'Fechado') //Verificar nome!
            {
                $this->emit('msg-ops', 'Esse ticket já tem registra uma saida!');
                $this->bar_code = '';
                return;
            }
        }else{
            $this->emit('msg-ops', 'Esse codigo não existe no sistema!');
                $this->bar_code = '';
                return;
        }

        $tarifa = Tarifa::where('id', $ticket->tarifa_id)->first();

        $time = $this->CalcularTempo($ticket->acceso);

        $novoTotal = $this->Total($ticket->acceso, $ticket->tarifa_id);

        $ticket->departure = Carbon::now(); // Verificar nome também
        $ticket->status = 'Fechado';
        $ticket->total = $novoTotal;
        $ticket->hours = $time;
        $ticket->save();

        $vaga = Vaga::where('id', $ticket->vacancy_id)->first();
        $vaga->status = 'Disponivel';
        $vaga->save();

        if($ticket) {
            $this->bar_code = '';
            $this->section = 1;
            $this->emit('getout-ok', 'Saida registra com sucesso!!!');
        }else{
            $this->bar_code = '';
            $this->section = 1;
            $this->emit('getout-error', 'Não foi possivel registrar a saida! :/');
        }
    }
}