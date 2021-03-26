<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\FilePrintConnector;

use App\User;
use App\Models\Empresa;
use App\Models\Venda;
use App\Models\Tarifa;
use Carbon\Carbon;

class PrinterController extends Controller
{
    
    public function TicketVisita(Request $request)
    {
        $fatura = str_pad($request->id, 7, "0", STR_PAD_LEFT); //0000001
        $nomeImpressora = "PDF417_STANDARD";
        $connector = new WindowsPrintConnector($nomeImpressora);
        $impressora = new Printer($connector);

        $empresa = Empresa::all();
        $venda = Venda::find($request->id);
        $tarifa = Tarifa::where('time','Mensal')->select('amount')->first();
        $cliente = Venda::leftjoin('customercarriers as cv', 'cv.carrier.id', 'sales.carrier_id')
                    ->leftjoin('users as u', 'u.id', 'cv.user_id')->select('u.name')
                    ->where('sales.id', $venda->id)->first();
        
        $impressora->setJustification(Printer::JUSTIFY_CENTER);
        $impressora->setTextSize(2,2);
        $impressora->text(strtoupper($empresa[0]->name) . "\n");
        $impressora->setTextSize(1,1);
        $impressora->text("** Recibo de Mensalista ** \n\n");

        $impressora->setJustification(Printer::JUSTIFY_LEFT);
        $impressora->text("===============================================\n");
        $impressora->text("Cliente: ". $cliente->name ."\n");
        $impressora->text("Entrada: ". Carbon::parse($venda->created_at)->format('d/m/Y h:m:s') . "\n");
        $impressora->text("Saída: ". Carbon::parse($venda->departure)->format('d/m/Y h:m:s') . "\n");
        $impressora->text("Tempo: ". $venda->hours . 'Mes(es)' . "\n");
        $impressora->text("Tarifa: R$". number_format($tarifa->amount,2) . "\n");
        $impressora->text("Placa:".$venda->plate. 'Marca:' .$venda->brand . 'Cor:'.$venda->color. "\n");
        $impressora->text("===============================================");

        $impressora->setJustification(Printer::JUSTIFY_CENTER);
        $impressora->text("Por favor guardar o ticket, em caso de extravio pagará um multa de R$ 100,00!\n");

        $impressora->selectPrintMode();
        $impressora->setBarcodeHeight(80);
        $impressora->barcode($fatura, Printer::BARCODE_CODE39);
        $impressora->feed(2);

        $impressora->text("Obrigado pela preferência!");
        $impressora->text("www.mycontrole.com.br \n");
        $impressora->feed(3);
        $impressora->cut();
        $impressora->close();

    }

    public function TicketMensal(Request $request)
    {
        $fatura = str_pad($request->id, 7, "0", STR_PAD_LEFT); //0000001
        $nomeImpressora = "EPSON L395 Series";
        $connector = new WindowsPrintConnector($nomeImpressora);
        $impressora = new Printer($connector);

        $empresa = Empresa::all();
        $venda = Venda::find($request->id);
        $tarifa = Tarifa::find($venda->tarifa_id);
        
        $impressora->setJustification(Printer::JUSTIFY_CENTER);
        $impressora->setTextSize(2,2);
        $impressora->text(strtoupper($empresa[0]->name) . "\n");
        $impressora->setTextSize(1,1);
        $impressora->text("** Recibo de Venda ** \n\n");

        $impressora->setJustification(Printer::JUSTIFY_LEFT);
        $impressora->text("===============================================");
        $impressora->text("Entrada: ". Carbon::parse($venda->created_at)->format('d/m/Y h:m:s') . "\n");
        $impressora->text("Tarifa por Hora: R$". number_format($tarifa->amount,2) . "\n");
        if(!empty($venda->description)) $impressora->text("Desc: ". $venda->description . "\n");
        $impressora->text("===============================================");

        $impressora->setJustification(Printer::JUSTIFY_CENTER);
        $impressora->text("Por favor guardar o ticket, em caso de extravio pagará um multa de R$ 100,00!");

        $impressora->selectPrintMode();
        $impressora->setBarcodeHeight(80);
        $impressora->barcode($fatura, Printer::BARCODE_CODE39);
        $impressora->feed(2);

        $impressora->text("Obrigado pela preferência!");
        $impressora->text("www.mycontrole.com.br \n");
        $impressora->cut();
        $impressora->close();

    }
}