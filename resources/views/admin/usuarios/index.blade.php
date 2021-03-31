@extends('layouts.template')
@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
            <div class="widget-content-area br-4">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 text-center">
                            <h5><b>Usuários de Sistema</b></h5>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="pull-right">
                        <a href="{{ route('admin.usuarios.create') }}" type="submit"
                            class="btn btn-outline-primary btn-rounded mb-2"><i class="fas fa-user-plus"></i> Cadastrar</a>
                    </div>
                </div>
                {{-- @include('common.alerts') --}}
                @if ($info->count() > 0)
                    <div class="table-responsive">
                        <table
                            class="table table-sm table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                            <thead>
                                <tr>
                                    <th style="width: 100px">Nome</th>
                                    <th>Telefone</th>
                                    <th>Celular</th>
                                    <th>Perfil</th>
                                    <th>E-mail</th>
                                    <th style="width: 100px" class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($info as $key => $r)
                                    <tr>
                                        <td style="width: 250px">{{ $r->name }}</td>
                                        <td>{{ $r->telephone }}</td>
                                        <td>{{ $r->cellphone }}</td>
                                        <td>
                                            @if (!empty($r->getRoleNames()))
                                                @foreach ($r->getRoleNames() as $v)
                                                    @if ($v == 'Administrador')
                                                        <label class="badge badge-success">{{ $v }}</label>
                                                    @else
                                                        <label class="badge badge-primary">{{ $v }}</label>
                                                    @endif
                                                @endforeach
                                            @endif
                                        </td>
                                        <td style="width: 350px">{{ $r->email }}</td> 
                                        <td class="text-center">
                                            <ul class="table-controls">
                                                <li>
                                                    <a href="{{ route('admin.usuarios.edit', $r->id) }}"
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
                                                    <form action="{{ route('admin.usuarios.destroy', $r->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <a href="javascript:void(0);"
                                                            onclick="Confirm('{{ $r->id }}')"
                                                            class="text-danger"><svg xmlns="http://www.w3.org/2000/svg"
                                                                width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="feather feather-trash-2 text-danger">
                                                                <polyline points="3 6 5 6 21 6"></polyline>
                                                                <path
                                                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                                </path>
                                                                <line x1="10" y1="11" x2="10" y2="17"></line>
                                                                <line x1="14" y1="11" x2="14" y2="17"></line>
                                                            </svg></a>
                                                    </form>
                                                </li>
                                            </ul>
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
        </div>
    </div>

    <script type="text/javascript">
        window.addEventListener('swal', function(e) {
            Swal.fire(e.detail);
        });

        function Confirm(id) {
            /* let me = this */
            Swal.fire({
                title: 'Confirmar!',
                text: "Deseja Excluir Registro?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                window.livewire.emit('deleteRow', id)
                if (result.isConfirmed) {
                    //toastr.success('info', 'Registro excluido com sucesso!')
                    swal.close()
                    /* Swal.fire(
                        'Excluido!',
                        'Registro excluido com sucesso!',
                        'success'
                    )  */
                }
            })
        }
        document.addEventListener('DOMContentLoaded', function() {});

    </script>
@endsection
