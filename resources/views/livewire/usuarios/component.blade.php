<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
        @if ($action == 1)

            <div class="widget-content-area br-4">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 text-center">
                            <h5><b>Usuários de Sistema</b></h5>
                        </div>
                    </div>
                </div>
                @include('common.search', ['create' => 'tipos_create'])
                @include('common.alerts')
                @if ($info->count() > 0)
                    <div class="table-responsive">
                        <table
                            class="table table-sm table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                            <thead>
                                <tr>
                                    <th style="width: 100px">Nome</th>
                                    <th>Telefone</th>
                                    <th>Celular</th>
                                    {{-- <th>Perfil</th> --}}
                                    <th>E-mail</th>
                                    <th style="width: 100px" class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($info as $r)
                                    <tr>

                                        <td style="width: 250px">{{ $r->name }}</td>
                                        <td>{{ $r->telephone }}</td>
                                        <td>{{ $r->cellphone }}</td>
                                        {{-- <td>{{ $r->role_id }}</td> --}}
                                        <td style="width: 350px">{{ $r->email }}</td>
                                        <td class="text-center">
                                            @include('common.actions', ['edit' => 'tipos_edit', 'destroy'=>
                                            'tipos_destroy']) 
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
            </div>

        @elseif($action == 2)
            @include('livewire.usuarios.form')
        @endif
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