<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
            <div class="widget-content-area br-4">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 text-center">
                            <h5><b>Lista de Clientes</b></h5>
                        </div>
                    </div>
                </div>
                @include('common.search', ['create' => 'tipos_create'])
                @include('common.alerts')
                {{-- @if ($info->count() > 0) --}}
                    <div class="table-responsive">
                        <table
                            class="table table-sm table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                            <thead>
                                <tr>                                    
                                    <th>Nome/Razão Social</th>
                                    <th>CPF/CNPJ</th>
                                    <th>Tipo</th>
                                    <th>Situação</th>
                                    <th>Telefone</th>
                                    <th>Celular</th>
                                    <th style="width: 100px" class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- @foreach ($info as $r)
                                    <tr>

                                        <td class="text-center">
                                            <p class="mb-0">{{ $r->id }}</p>
                                        </td>
                                        <td>{{ $r->description }}</td>
                                        <td class="text-center">
                                            @include('common.actions', ['edit' => 'tipos_edit', 'destroy'=>
                                            'tipos_destroy'])
                                        </td>
                                    </tr>
                                @endforeach --}}
                            </tbody>
                        </table>
                    </div>
                {{-- @else
                    <div class="alert alert-dark text-center" role="alert">
                        <strong>Nenhum registro encontrado!</strong>
                    </div>
                @endif --}}

                {{-- {{ $info->links() }} --}}
            </div>
    </div>

    <script type="text/javascript">

        function Confirm(id) {
            let me = this
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
                    console.log('ID', id)
                    window.livewire.emit('deleteRow', id)
                    toastr.success('info', 'Registro eliminado con éxito')
                    swal.close()
                })

        }

        document.addEventListener('DOMContentLoaded', function() {

        });

    </script>
