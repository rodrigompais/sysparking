<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\User;
use App\Models\Venda;
use App\Models\Movimiento;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public $listBalanco, $listGastos, $listVendas;

    public function data()
    {        

        //Gráfico de Vendas da Semana atual

        $currentYear = date("Y");
        $start = date('Y-m-d', strtotime('monday this week'));
        //dd($start);
        $finish = date('Y-m-d', strtotime('sunday this week'));

        $d1 = strtotime($start);
        $d2 = strtotime($finish);
        $array = array();

        for ($currentDate = $d1; $currentDate <= $d2; $currentDate += (86400)) {
            $dia = date('Y-m-d', $currentDate);
            $array[] = $dia;
        }

        $sql = "SELECT c.dias, IFNULL(c.total,0) as total FROM (
            SELECT '$array[0]' as dias
            UNION
            SELECT '$array[1]' as dias
            UNION
            SELECT '$array[2]' as dias
            UNION
            SELECT '$array[3]' as dias
            UNION
            SELECT '$array[4]' as dias
            UNION
            SELECT '$array[5]' as dias
            UNION
            SELECT '$array[6]' as dias
            ) d
            LEFT JOIN(
            SELECT SUM(total) as total, DATE(created_at) as dias FROM sales WHERE created_at BETWEEN '$start-00:00:00' AND '$finish-23:59:59' AND status = 'Fechado' GROUP BY DATE(
            created_at)
            )c ON d.dias = c.dias";        

        $weekVendas = DB::select(DB::RAW($sql));
        //dd($weekVendas);

        //dd($weekVendas);

        $chartVendaxSemanal = (new LarapexChart)->donutChart()
            ->setTitle('Vendas da Semana Atual')
            ->setLabels(['Segunda,', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado', 'Domingo'])
            ->setDataset([
                intval($weekVendas[0]->total),
                intval($weekVendas[1]->total),
                intval($weekVendas[2]->total),
                intval($weekVendas[3]->total),
                intval($weekVendas[4]->total),
                intval($weekVendas[5]->total),
                intval($weekVendas[6]->total)
            ]);

        //Gráfico de Vendas Mensal

        $vendasMensal = DB::select(DB::raw(
            "SELECT m.MONTH AS MES, IFNULL(c.vendas,0) AS VENDAS, IFNULL(c.rentas,0) AS TRANSACCIONES FROM(
            SELECT 'January' AS MONTH UNION SELECT 'February' AS MONTH UNION
            SELECT 'March' AS MONTH UNION SELECT 'April' AS MONTH UNION
            SELECT 'May' AS MONTH UNION SELECT 'June' AS MONTH UNION
            SELECT 'July' AS MONTH UNION SELECT 'August' AS MONTH UNION
            SELECT 'September' AS MONTH UNION SELECT 'October' AS MONTH UNION
            SELECT 'November' AS MONTH UNION SELECT 'December' AS MONTH) m
            LEFT JOIN(
            SELECT MONTHNAME(acceso) AS MONTH, COUNT(*) AS rentas, SUM(total) AS vendas
            FROM sales
            WHERE YEAR(acceso) = $currentYear
            GROUP BY MONTHNAME(acceso), MONTH(acceso)
            ORDER BY MONTH(acceso)
            ) c ON m.MONTH = c.MONTH
        "
        ));

        $chartVendasxMensal = (new LarapexChart)->areaChart()
            ->setTitle('Vendas Anual')
            ->setSubtitle('Por Mês')
            ->setGrid(true)
            ->setXAxis(['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'])
            ->setMarkers(['#FF5722', '#E040FB'], 7, 10)
            ->setDataset([
                [
                    'name' => 'Vendas',
                    'data' =>
                    [
                        $vendasMensal[0]->VENDAS,
                        $vendasMensal[1]->VENDAS,
                        $vendasMensal[2]->VENDAS,
                        $vendasMensal[3]->VENDAS,
                        $vendasMensal[4]->VENDAS,
                        $vendasMensal[5]->VENDAS,
                        $vendasMensal[6]->VENDAS,
                        $vendasMensal[7]->VENDAS,
                        $vendasMensal[8]->VENDAS,
                        $vendasMensal[9]->VENDAS,
                        $vendasMensal[10]->VENDAS,
                        $vendasMensal[11]->VENDAS
                    ]
                ]
            ]);

        ///Grafico para Balanço Anual

        $listVendas;

        for ($i = 0; $i < 12; $i++) {
            $listVendas[$i] = Venda::whereMonth('acceso', $i + 1)->whereYear('acceso', $currentYear)->sum('total');
        }

        $listGastos;

        for ($i = 0; $i < 12; $i++) {
            $listGastos[$i] = Movimiento::where('type', '<>', 'Entrada')->whereMonth('created_at', $i + 1)
            ->whereYear('created_at', $currentYear)->sum('amount');
        }

        $listBalanco;

        for ($i = 0; $i < 12; $i++) {
            $listBalanco[$i] = $listVendas[$i] - $listGastos[$i];
        }

        $chartBalancoxMeses = (new LarapexChart)
        ->setTitle('Balanço Anual')
        ->setType('bar')
        ->setXAxis(['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'])
        ->setGrid(true)
        ->setDataset([
            [
              'name'  => 'Entradas',
              'data'  =>  $listVendas
            ],
            [
              'name'  => 'Saidas',
              'data'  => $listGastos
            ],
            [
              'name'  => 'Balanço',
              'data'  => $listBalanco
            ]
            
          ])
          ->setStroke(1);
          //->setColors(['#32CD32', '#191970', '#FFFF00']);


        return view('dashboard', compact('chartVendaxSemanal', 'chartVendasxMensal','chartBalancoxMeses'));
    }
}
