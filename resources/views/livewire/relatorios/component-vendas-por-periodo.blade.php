<div class="main-content">
    {{-- <div class="layout-px-spacing"> --}}
        <div class="row layout-top-spacing">
            <div class="col-12 layout-spacing">
                <div class="widget-content-area">
                    <div class="widget-one">
                        <h4 class="text-center">Relatório de Vendas por Data</h4>
                        <div class="row">
                            <div class="col-sm-12 col-md-2 col-lg-2">
                                Data Inicial
                                <div class="form-group">
                                    <input wire:model.lary="fecha_ini" type="text"
                                        class="form-control flatpickr flatpickr-input active">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-2 col-lg-2">
                                Data Final
                                <div class="form-group">
                                    <input wire:model.lary="fecha_fim" type="text"
                                        class="form-control flatpickr flatpickr-input active">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-1 col-lg-1 text-left">
                                <button type="submit" class="btn btn-success mt-4 mobile-only">Ver</button>
                            </div>
                            <div class="col-sm-12 col-md-1 col-lg-1 text-left">
                                <button type="submit" class="btn btn-dark mt-4 mobile-only">Exportar</button>
                            </div>
                            <div class="col-sm-12 col-md-3 col-lg-3 offset-lg-3">
                                <b>Data da Consulta</b> {{ \Carbon\Carbon::now()->format('d-m-Y') }}
                                <br>
                                <b>Quantidade de Registros</b> {{ $info->count() }}
                                <br>
                                <b>Total de Vendas</b>R$ {{ number_format($somaTotal, 2) }}
                            </div>
                        </div>
                    </div>
                    @if ($info->count() > 0)
                        <div class="row">
                            <div class="table-responsive mt-3">
                                <table
                                    class="table table-sm table-bordered table-hover table-striped table-checkble table-highlight mb-4">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Código</th>
                                            <th class="text-center">Veiculo</th>
                                            <th class="text-center">Entrada</th>
                                            <th class="text-center">Saída</th>
                                            <th class="text-center">Tempo</th>
                                            <th class="text-center">Tarifa</th>
                                            <th class="text-center">Valor</th>
                                            <th class="text-center">Usuário</th>
                                            <th class="text-center">Tipo</th>
                                            <th class="text-center">Fechamento</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($info as $r)
                                            <tr>
                                                <td class="text-center">{{ $r->bar_code }}</td>
                                                <td class="text-center">
                                                    {{ $r->veiculo }}
                                                    @if ($r->description != null)
                                                        <br>"{{ $r->description }}"
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    {{ \Carbon\Carbon::parse($r->acceso)->format('d/m/Y h:m:s') }}
                                                </td>
                                                <td class="text-center">
                                                    {{ \Carbon\Carbon::parse($r->departure)->format('d/m/Y h:m:s') }}
                                                </td>
                                                <td class="text-center">{{ $r->hours }}</td>
                                                <td class="text-center">R$ {{ number_format($r->tarifa, 2) }}</td>
                                                <td class="text-center">R$ {{ number_format($r->total, 2) }}</td>
                                                <td class="text-center">{{ $r->usuario }}</td>
                                                <td class="text-center">
                                                    @if ($r->carrier_id == null)
                                                        Visita
                                                    @else
                                                        Mensalista
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    {{ \Carbon\Carbon::parse($r->created_at)->format('d/m/Y h:m:s') }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-right" colspan="9">Total Venda: </th>
                                            <th class="text-center" colspan="1">R$ {{ number_format($somaTotal, 2) }}
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
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
    {{-- </div> --}}
</div>
