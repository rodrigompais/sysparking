<div class="row layout-top-spacing">
    <div class="col col-sm-12 col-md-12 col-lg-12">
        <div class="widget-content-area">
            <div class="widget-header">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <h4><b>Tickets Extraviados</b></h4>
                    </div>
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-md-4 col-lg-4 col-sm-12">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="la la-search la-lg"></i></span>
                        </div>
                        <input type="text" wire:model="search" class="form-control ">
                    </div>
                </div>
            </div>
            @if ($info->count() > 0)
                <div class="table-responsive">
                    <table
                        class="table table-sm table-bordered table-hover table-striped table-checkble table-highlight mb-4">
                        <thead>
                            <tr>
                                <th class="text-center">Código</th>
                                <th class="text-center">Entrada</th>
                                <th class="text-center">Nº Vaga</th>
                                <th class="text-center">Veiculo</th>
                                <th class="text-center">Placa</th>
                                <th class="text-center">Tipo</th>
                                <th class="text-center">Tarifa</th>
                                <th class="text-center">Valor</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($info as $r)
                                <tr>
                                    <td class="text-center">{{ $r->bar_code }}</td>
                                    <td class="text-center">
                                        {{ \Carbon\Carbon::parse($r->acceso)->format('d-m-Y H:m:s') }}</td>
                                    <td class="text-center">{{ $r->vacancy_id }}</td>
                                    <td class="text-center">{{ $r->description }}</td>
                                    <td class="text-center">{{ $r->plate }}</td>
                                    <td class="text-center">
                                        @if ($r->carrier_id == null)
                                            Visita
                                        @else
                                            Venda
                                        @endif
                                    </td>
                                    <td class="text-center">R$ {{ $r->pago }} + R$ 50,00 multa</td>
                                    <td class="text-center">
                                        <a href="javascript:void(0);" onclick="Confirm('{{ $r->bar_code }}')"
                                            data-toggle="tooltip" data-placement="top" title="Editar"><svg
                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"
                                                class="feather feather-edit-2 text-success rounded bs-tooltip">
                                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
                                                </path>
                                            </svg></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-dark text-center" role="alert">
                    <strong>Nenhum registro encontrado!</strong>
                </div>
            @endif
            {{ $info->links() }}
            <input type="hidden" id="bar_code">
        </div>
    </div>
</div>
<script type="text/javascript">
    function Confirm(bar_code) {
        /* let me = this */
        Swal.fire({
            title: 'Confirmar!',
            text: "Cobrar e dar Saída no Veiculo?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            window.livewire.emit('doCheckOut', bar_code, 2)
            if (result.isConfirmed) {
               /*  toastr.success('Baixa realizada com sucesso!') */
                swal.close()
            }
        })
    }

    document.addEventListener('DOMContentLoaded', function() {

    });

</script>
