<div class="lauout-px-spacing">
    <div class="row layout-top-spacing">
        <div class="col-sm-12 col-md-12 col-jg-12 layout-spacing">
            <div class="widget-content-area br-4">
                <div class="widget-one">
                    <ul class="nav nav-pills mt-3" role="tablist">
                        <li class="nav-item">
                            <a href="#perfil_content" class="nav-link {{ $tab == 'perfil' ? 'active' : '' }}"
                                wire:click="$set('tab', 'perfil')" data-toggle="pill" role="tab">
                                <i class="la la-user la-lg"> Perfil</i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#permissao_content" class="nav-link {{ $tab == 'permissao' ? 'active' : '' }}"
                                wire:click="$set('tab', 'permissao')" data-toggle="pill" role="tab">
                                <i class="la la-key la-lg"> Permissão</i>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        @if ($tab == 'perfil')
                            @include('livewire.permissoes.perfil')
                        @else ($tab == 'permissao')
                            @include('livewire.permissoes.permissao')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function showPerfil(perfil) {
        var data = JSON.parse(perfil)
        $('#perfilName').val(data['name'])
        $('#perfilId').val(data['id'])
    }

    function clearPerfilSelected() {
        $('#perfilName').val('')
        $('#perfilId').val(0)
        $('#perfilName').focus()
    }

    function showPermissao(permissao) {
        var data = JSON.parse(permissao)
        $('#permissaoName').val(data['name'])
        $('#permissaoId').val(data['id'])
    }

    function clearPermissaoSelected() {
        $('#permissaoId').val(0)
        $('#permissaoName').focus()
        $('#permissaoName').val('')
    }

    function Confirm(id, eventName) {

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
                window.livewire.emit(eventName, id)
                //toastr.success('info', 'Registro eliminado com sucesso!')
                $('#permissaoId').val(0)
                $('#permissaoName').val('')
                $('#perfilId').val(0)
                $('#perfilName').val('')
                swal.close()
            })
    }

    function AssociarPerfil() {
        //console.clear()

        var perfilList = []
        $('#tblPerfil').find('input[type=checkbox]:checked').each(function() {
            perfilList.push($(this).attr('data-name'));
        });

        console.log(perfilList)

        if (perfilList.length < 1) {
            toastr.error('', 'Selecione ao menos um Perfil!')
            return;
        } else if ($('#userId option:selected').val() == 'Selecione') {
            toastr.error('', 'Selecione um usuário!')
            return;
        }
        window.livewire.emit('AssociarPerfil', perfilList)
    }

    function AssociarPermissao() {
        if ($('#perfilSelected option:selected').val() == 'Selecione') {
            toastr.error('', 'Selecione uma permissão')
            return;
        }

        var permissaoList = []
        $('#tblPermissao').find('input[type=checkbox]:checked').each(function() {
            permissaoList.push(($(this).attr('data-name')));
        });

        if (permissaoList.length < 1) {
            toastr.error('', 'Selecione ao menos uma Permissão!')
            return;
        }

        window.livewire.emit('AssociarPermissao', permissaoList, $('#perfilSelected option:selected').val())
    }

    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('msg-ok', msgText => {
            $('#permissaoName').val('')
            $('#permissaoId').val(0)
            $('#perfilName').val('')
            $('#perfilId').val(0)
        })

        $('body').on('click', '.check-all', function() {
            var state = $(this).is(':checked') ? true : false
            $('#tblPermissao').find('input[type=checkbox]').each(function(e) {
                $(this).prop('checked', state)
            })
        })
    })

</script>
