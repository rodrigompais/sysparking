<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
        @if ($action == 1)

            <div class="widget-content-area br-4">
                <div class="widget-header">
                    <div class="row">
                        <div class="col-xl-12 text-center">
                            <h5><b>Tipo de Fabricantes</b></h5>
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
                                    <th style="width: 100px" class="text-center">Id</th>
                                    <th>Descrição</th>
                                    {{-- <th class="text-center">IMÁGEN</th>
                                    --}}
                                    <th style="width: 100px" class="text-center">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($info as $r)
                                    <tr>

                                        <td class="text-center">
                                            <p class="mb-0">{{ $r->id }}</p>
                                        </td>
                                        <td>{{ $r->description }}</td>
                                        {{-- <td class="text-center"><img
                                                class="avatar avatar-lg" src="images/{{ $r->imagen }}" alt=""
                                                height="40">
                                        </td> --}}
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
            @include('livewire.fabricantes.form')
        @endif
    </div>

    <script type="text/javascript">
        /* document.addEventListener('DOMContentLoaded', function() {
    window.livewire.on('fileChoosen', () => {
        let inputField = document.getElementById('image')
        let file = inputField.files[0]
        let reader = new FileReader();
        reader.onloadend = ()=> {
            window.livewire.emit('fileUpload', reader.result)
        }
        reader.readAsDataURL(file);
    }); 

}); */

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
