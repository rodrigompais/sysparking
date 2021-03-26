<div class="main-content">
    {{-- <div class="layout-px-spacing"> --}}
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
            <div class="widget-content-area br-4">
                <div class="widget-one">
                    <h3 class="text-danger text-center">Vendas Mensalista à Vencer</h3>
                    <div class="row">
                        <div class="col-sm-12 col-md-4 col-lg-4 text-left">
                            <b>Data da Consulta: </b>{{ \Carbon\Carbon::now()->format('d-m-Y H:m:s') }}
                            <br>
                            <b>Quantidade de Registro:</b> {{ $info->count() }}
                        </div>
                        <div class="col-sm-12 col-md-8 text-right">
                            <a href="#" class="btn btn-sm btn-dark mt-4" target="_blank">Exportar</a>
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
                                            <th class="text-center">Cliente</th>
                                            <th class="text-center">Telefone</th>
                                            <th class="text-center">Acesso</th>
                                            <th class="text-center">Tempo Restante</th>
                                            <th class="text-center">Saida</th>
                                            <th class="text-center">Veiculo</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Saida</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($info as $r)
                                            <tr>
                                                <td class="text-center">{{ $r->bar_code }}</td>
                                                <td class="text-center">{{ $r->cliente }}</td>
                                                <td class="text-center">{{ $r->telephone }}</td>
                                                <td class="text-center">
                                                    {{ \Carbon\Carbon::parse($r->acceso)->format('d-m-Y H:m:s') }}
                                                </td>
                                                <td class="text-center">
                                                    @if ($r->restantedias < 31)
                                                        <h6 class="text-danger">Dias:{{ $r->restantedias }}</h6>
                                                        {{-- <h6 class="text-info">Meses:{{ $r->restantemeses }}</h6> --}}
                                                    @else
                                                        <h6 class="text-info">Meses:{{ $r->restantemeses }}</h6>
                                                        <h6 class="text-danger">Dias:{{ $r->restantedias }}</h6>
                                                    @endif
                                                    {{-- <h6 class="text-info">Anos:{{ $r->restanteyears }}</h6> --}}
                                                    {{-- <h6 class="text-default">Horas:{{ $r->restantehoras }}</h6> --}}
                                                </td>
                                                <td class="text-center">
                                                    {{ \Carbon\Carbon::parse($r->departure)->format('d-m-Y H:m:s') }}
                                                </td>
                                                <td class="text-left">
                                                    <h7 class="text-info">{{ $r->plate }}</h7>
                                                    <h7 class="text-success">{{ $r->model }}</h7>
                                                    <h7 class="text-danger">{{ $r->brand }}</h7>
                                                </td>
                                                <td class="text-center">
                                                    @if ($r->status == 'Vencido')
                                                        <h6 class="text-danger">{{ $r->status }}</h6>
                                                    @else
                                                        @if ($r->restantedias > 0)
                                                            @if ($r->restantedias > 0 && $r->restantedias <= 3)
                                                                <h6 class="text-warning">{{ $r->status }}</h6>
                                                            @else
                                                                <h6 class="text-success">{{ $r->status }}</h6>
                                                            @endif
                                                        @else
                                                            <h6 class="text-danger">Vencido</h6>
                                                        @endif
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a wire:click.prevent="$emit('checkOutTicketMensalista', {{ $r->id }})"
                                                        href="javascript:void(0)" class="btn btn-outline-dark btn-sm"><i
                                                            class="la la-check la-2x text-success"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="7"></th>
                                            <th class="text-left" colspan="2">
                                                <h6 class="text-danger">Vendas Vencidas: {{ $totalVencidos }}
                                                </h6>
                                                <h6 class="text-danger">Próximo à Vencer: {{ $totalaVencer }}
                                                </h6>
                                            </th>
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
