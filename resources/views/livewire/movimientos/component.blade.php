<div id="content" class="main-content">
    @if ($action == 1)
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing">
                <div class="col-xs-12 col-lg-12 col-md-12 col-12 layout-spacing">
                    <div class="widget-content-area br-4">
                        <div class="widget-one">
                            <h3 class="text-center">Movimento do Caixa</h3>
                            @include('common.search', ['create' => 'movimientos_create'])
                            @include('common.alerts')
                            @if ($info->count() > 0)
                                <div class="table-resposive">
                                    <table
                                        class="table table-bordered table-hover tabler-striped table-checkable tablehighlight-head md-4">
                                        <thead>
                                            <tr>
                                                <th>DESCRIÇÃO</th>
                                                <th class="text-center">TIPO</th>
                                                <th class="text-center">VALOR</th>
                                                <th class="text-center">COMPROVANTE</th>
                                                <th class="text-center">DATA</th>
                                                <th class="text-center">AÇÕES</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($info as $r)
                                                <tr>
                                                    <td>{{ $r->description }}</td>
                                                    <td class="text-center">{{ $r->type }}</td>
                                                    <td class="text-center">R$
                                                        {{ number_format($r->amount, 2, ',', '') }}</td>
                                                    <td class="text-center">
                                                        <img class="rounded" src="images/movs/{{ $r->receipt }}"
                                                            alt="" height="40">
                                                    </td>
                                                    <td class="text-center">
                                                        {{ date('d/m/Y H:i', strtotime($r->created_at)) }}</td>
                                                    <td class="text-center">
                                                        @include('common.actions', ['edit' => 'tipos_edit',
                                                        'destroy'=>
                                                        'tipos_destroy'])
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
            </div>
        </div>
</div>
@elseif($action > 1)
@include('livewire.movimientos.form')
@endif
</div>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('fileChoosen', () => {
            console.log($(this))
            let inputField = document.getElementById('image')
            let file = inputField.files[0]
            let reader = new FileReader();
            reader.onloadend = () => {
                window.livewire.emit('fileUpload', reader.result)
            }
            reader.readAsDataURL(file);
        });
    });

    function Confirm(id) {

        let me = this
        swal({
                title: 'CONFIRMAR!',
                text: 'Deseja excluir registro?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Confirmar',
                cancelButtonText: 'Cancelar',
                closeOnConfirm: false
            },
            function() {
                console.log('ID', id);
                window.livewire.emit('deleteRow', id)
                toastr.success('info', 'Registro excluido com sucesso!')
                swal.close()
            })
    }
    /* document.addEventListener('DOMContentLoaded', function() {

    }); */

</script>
