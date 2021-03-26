<div class="row layout-top-spacing">
    <div class="col-sm-12 col-md-12 col-lg-12 layout-spacing">
        @if ($action == 1)
            <div class="widget-content-area br-4">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <h5><b>Vagas do Estacionamento</b></h5>
                        </div>
                    </div>
                </div>

                @include('common.search', ['create' => 'tipos_create'])
                {{-- @if (session('success_message'))
                <div class="alert alert-success">
                    {{ session('success_message') }}
                </div>                    
                @endif --}}

                <div class="table-responsive">
                    <table
                        class="table table-sm table-bordered table-hover table-striped table-checkable table-higtlight-head md-4">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Descrição</th>
                                <th>Status</th>
                                <th>Tipo</th>
                                <th style="width: 100px" class="text-center">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($info as $r)
                                <tr>
                                    <td>{{ $r->id }}</td>
                                    <td>{{ $r->description }}</td>
                                    <td>
                                        @if ($r->status == 'Disponivel')
                                            <span class="badge badge-success">{{ $r->status }}</span>
                                        @else
                                            <span class="badge badge-danger">{{ $r->status }}</span>
                                        @endif
                                    </td>
                                    {{-- <td>{{ $r->status }}</td> --}}
                                    <td>{{ $r->type }}</td>
                                    <td class="text-center">
                                        @if ($r->status != 'Ocupado')
                                            @include('common.actions', ['edit' => 'tipos_edit', 'destroy'=>
                                            'tipos_destroy'])
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $info->links() }}
                </div>
            </div>
        @elseif($action ==2)
            @include('livewire.vagas.form')
        @endif
    </div>
</div>
<script>
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
