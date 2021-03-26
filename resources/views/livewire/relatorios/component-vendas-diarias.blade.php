<div id="content" class="main-content">
    {{-- <div class="layout-px-spacing"> --}}
        <div class="row layout-top-spacing">
            <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
                <div class="widget-content-area br-4">
                    <div class="widget-one">
                        <h3 class="text-center"> Relatório de Vendas Diárias</h3>
                        <div class="row">
                            <div class="col-sm-12 col-md-4 col-lg-4 text-left">
                                <b>Data da Consulta: </b>
                                {{ \Carbon\Carbon::now(new DateTimeZone('America/Sao_Paulo'))->format('d/m/Y h:m:s') }}
                                <br>
                                <b>Quantidade de Registros: </b> {{ $info->count() }}
                                <br>
                                <b>Total de Venda: </b> R$ {{ number_format($somaTotal, 2) }}
                            </div>
                            <div class="col-sm-12 col-md-8 text-right">
                                <button class="btn btn-sm btn-dark mt-4">Exportar</button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="table-responsive mt-3">
                                @if ($info->count() > 0)
                                    <table
                                        class="table table-sm table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Código</th>
                                                <th class="text-center">Veiculo</th>
                                                <th class="text-center">Entrada</th>
                                                <th class="text-center">Saída</th>
                                                <th class="text-center">Tempo</th>
                                                <th class="text-center">Tarifa</th>
                                                <th class="text-center">Total</th>
                                                <th class="text-center">Usuário</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Modal</th>
                                                <th class="text-center">Ações</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($info as $r)
                                                <tr>
                                                    <td class="text-center">{{ $r->bar_code }}</td>
                                                    <td class="text-center">{{ $r->description }}</td>
                                                    <td class="text-center">{{ $r->acceso }}</td>
                                                    <td class="text-center">{{ $r->departure }}</td>
                                                    <td class="text-center">{{ $r->hours }}</td>
                                                    <td class="text-center">R$ {{ number_format($r->tarifa, 2) }}</td>
                                                    <td class="text-center">R$ {{ number_format($r->total, 2) }}</td>
                                                    <td class="text-center">{{ $r->usuario }}</td>
                                                    <td class="text-center">{{ $r->status }}</td>
                                                    <td class="text-center">
                                                        @if ($r->carrier_id == null)
                                                            Visita
                                                        @else
                                                            Venda
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <a href="javascript:void(0)" onclick='var w = windows.open("print/order/{{ $r->id }}","_blank", "width=100, height=100");
                                                        w.close()'><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-printer">
                                                                <polyline points="6 9 6 2 18 2 18 9"></polyline>
                                                                <path
                                                                    d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2">
                                                                </path>
                                                                <rect x="6" y="14" width="12" height="8"></rect>
                                                            </svg>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th class="text-right" colspan="10">Total Venda: </th>
                                                <th class="text-center" colspan="10">R$
                                                    {{ number_format($somaTotal, 2) }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                @else
                                    <div class="alert alert-dark text-center" role="alert">
                                        <strong>Nenhum registro encontrado!</strong>
                                    </div>
                                @endif
                                {{ $info->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    {{-- </div> --}}
</div>
