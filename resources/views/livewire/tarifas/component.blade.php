<div class="row layout-top-spacing">
    <div class="col-sm-12 col-md-12 col-lg-12 layout-spacing">
        <div class="widget-content-area br-4">
            <div class="widget-header">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <h5><b>Tarifas de Sistema</b></h5>
                    </div>
                </div>
            </div>

            <div class="row justify-content-between mb-4 mt-3">
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <div class="input-group input-group-sm mb-4">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-search">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg></span>
                        </div>
                        <input type="text" wire:model="search" class="form-control" placeholder="Buscar.."
                            aria-label="notification" aria-describedby="basic-addon1">
                    </div>
                </div>
                {{-- @can($create) --}}
                <div class="col-md-2 col-lg-2 col-sm-12 mt-2 mb-2 text-right mr-2">
                    <button type="button" onclick='openModal("{{$hierarchy}}")' class="btn btn-outline-primary btn-rounded mb-2">
                        Cadastrar
                    </button>
                </div>
                {{-- @endcan --}}
            </div>

            @if ($info->count() > 0)
                <div class="table-responsive">
                    <table
                        class="table table-sm table-bordered table-hover table-striped table-checkable table-higtlight-head sm-4">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Descrição</th>
                                <th>Tempo</th>
                                <th>Valor</th>
                                <th>Hierarquia</th>
                                <th>Tipo</th>
                                <th style="width: 100px" class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($info as $r)
                                <tr>
                                    <td>{{ $r->id }}</td>
                                    <td>{{ $r->description }}</td>
                                    <td>{{ $r->time }}</td>
                                    {{-- <td>{{ $r->amount }}</td> --}}
                                    <td class="text-center">R$ {{ number_format($r->amount, 2,',','') }}</td>
                                    <td>{{ $r->hierarchy }}</td>
                                    <td>{{ $r->type }}</td>
                                    <td class="text-center">
                                        <ul class="table-controls">
                                            <li>
                                                <a href="javascript:void(0);" onclick="editTarifa('{{ $r }}')"
                                                    data-toggle="tooltip" data-placement="top" title="Editar"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-edit-2 text-success">
                                                        <path
                                                            d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z">
                                                        </path>
                                                    </svg></a>
                                            </li>
                                            <li>
                                                {{-- @if($r->rentas->count() <=0) --}}
                                                <a href="javascript:void(0);" onclick="Confirm('{{ $r->id }}')"
                                                    data-toggle="tooltip" data-placement="top" title="Excluir"><svg
                                                        xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-trash-2 text-danger">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path
                                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                        </path>
                                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                                    </svg></a>
                                                    {{-- @endif --}}
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
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

@include('livewire.tarifas.modal')
<input id="id" type="hidden" value="0">

</div>
<script type="text/javascript">

    function Confirm(id) {
        swal({
                title: 'Confirmar',
                text: 'Deseja Excluir Registro?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar',
                closeOnConfirm: false
            },
            function() {
                window.livewire.emit('deleteRow', id)
                toastr.success('info', 'Registro eliminado con éxito')
                swal.close()
            })
    }

    function editTarifa(row) {
        var info = JSON.parse(row)
        $('#id').val(info.id)
        $('#amount').val(info.amount)
        $('#description').val(info.description)
        $('#time').val(info.time)
        $('#type_id').val(info.type_id)
        $('#hierarchy').val(info.hierarchy)
        $('.modal-title').text('Editar Tarifa')
        $('#modalTarifa').modal('show')
    }

    function openModal(hierarchy) {
        $('#id').val(0)
        $('#amount').val('')
        $('#description').val('')
        $('#time').val('Selecione')
        $('#type_id').val('Selecione')
        $('#hierarchy').val(hierarchy)
        $('.modal-title').text('Criar Tarifa')
        $('#modalTarifa').modal('show')
    }

    function save() {
        if ($('#time option:selected').val() == 'Selecione') {
            toastr.error('Selecione uma opção válida para Tempo')
            return;
        }
        if ($('#type_id option:selected').val() == 'Selecione') {
            toastr.error('Selecione uma opção válida para Tipo')
            return;
        }
        /* if ($.trim($('#amount').val()) == '') {
            toastr.error('Informe um valor válido!')
            return;
        } */

        var data = JSON.stringify({
            'id': $('#id').val(),
            'time': $('#time option:selected').val(),
            'type_id': $('#type_id option:selected').val(),
            'amount': $('#amount').val(),
            'description': $('#description').val(),
            'hierarchy': $('#hierarchy').val()
        });

        window.livewire.emit('createFromModal', data)
    }

    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('msg-ok', dataMsg => {
            $('#modalTarifa').modal('hide')
        })
        window.livewire.on('msg-error', dataMsg => {
            $('#modalTarifa').modal('hide')
        })
    });

</script>
