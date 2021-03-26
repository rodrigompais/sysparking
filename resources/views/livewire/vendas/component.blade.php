<div>
    @if ($section == 1)
        <div id="content" class="main-content">
            <div class="layout-xp-spacing">
                <div class="row" id="cancel-row">
                    <div class="col-lg-12 layout-xp-spacing layout-top-spacing">
                        <div class="statbox widget box box-shadow">
                            <div class="widget-header">
                                <div class="row">
                                    <div class="col-xl-12 col-md-12 col-sm-12 mt-3">
                                        <h3 class="text-center"> Vendas </h3>
                                    </div>
                                </div>
                            </div>
                            <div class="widget-content widget-content-area">
                                <div class="row mt-1">
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <div class="input-group mb-4">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="la la-barcode"></i></span>
                                            </div>
                                            <input type="text" id="code" wire:keydown.enter="$emit('doCheckOut','',2)"
                                                wire:model="bar_code" class="form-control" maxlength="9" autofocus>
                                            <div class="input-group-append">
                                                <span wire:click="$set('bar_code','')" class="input-group-text"
                                                    style="cursor: pointer;"><i class="la la-remove la-lg"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <button wire:click.prevent="TicketVisita()"
                                            class="btn btn-primary btn-lg btn-block">
                                            Ticket de Visita
                                        </button>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-12">
                                        <button wire:click.prevent="$set('section', 3)"
                                            class="btn btn-warning btn-lg btn-block">
                                            Ticket de Venda
                                        </button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <div class="row">
                                            @foreach ($vagas as $v)
                                                @if ($v->tarifa_id > 0)
                                                    <div class="col-lg-2 col-md-2 col-sm-6 col-xm-6">                                                    
                                                            @if ($v->status == 'Disponivel')
                                                            <span id="{{ $v->tarifa_id }}" style="cursor: pointer;"
                                                                data-status="{{ $v->status }}"
                                                                data-id="{{ $v->id }}"
                                                                onclick="openModal('{{ $v->tarifa_id }}','{{ $v->id }}')"
                                                                class="badge-chip badge-success mt-3 mb-3 ml-2 btncajon bs-popover">
                                                                {{-- </span> --}}
                                                            @else
                                                                <span id="{{ $v->tarifa_id }}" style="cursor: pointer;"
                                                                    data-status="{{ $v->status }}"
                                                                    data-id="{{ $v->id }}"
                                                                    data-bar_code="{{ $v->bar_code }}"
                                                                    onclick="eventCheckOut('doCheckOut', '{{ $v->bar_code }}','2')"
                                                                    class="badge-chip badge-danger mt-3 mb-3 ml-2 btncajon bs-popover">
                                                            @endif                                                                                                      
                                                            @if ($v->image != '')
                                                                <img src="images/{{ $v->image }}" height="96" width="96">
                                                                <span class="text">{{ $v->description }}</span>
                                                            @else
                                                                <img src="images/veiculo_sem_img.png" height="96" width="96">
                                                                <span class="text">{{ $v->description }}</span>
                                                            @endif                                                     
                                                    </div>
                                                @endif 
                                            @endforeach
                                        </div>
                                    </div>
                                    <input type="hidden" id="tarifa">
                                    <input type="hidden" id="vaga"> {{-- Entender essa informação --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Vendas Modal-->
            <div class="modal fade" id="modalVenda" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"> Descrição do Veiculo</h5>
                        </div>
                        <div class="modal-body">
                            <input type="text"
                                wire:keydown.enter="$emit('doCheckIn', $('#tarifa').val(),  $('#vaga').val(), 'Disponivel', $('#comment').val() )"
                                id="comment" maxlength="30" class="form-control" autofocus>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-outline-danger btn-rounded mr-1" data-dismiss="modal"><i
                                    class="mbri-left"></i>
                                Cancelar</button>
                            <button class="btn btn-outline-success btn-rounded saveVenda"><i class="mbri-success"></i>
                                Salvar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif($section == 2)
        @include('livewire.vendas.saidas')
    @elseif($section == 3)
        @include('livewire.vendas.ticketvenda')
    @endif
</div>

<script>
    function openModal(tarifa, vaga) {
        $('#tarifa').val(tarifa)
        $('#vaga').val(vaga)

        $('#modalVenda').modal('show')
    }

    function eventCheckOut(eventName, bar_code, actionValue) {
        console.log(eventName, bar_code, actionValue)
        window.livewire.emit(eventName, bar_code, actionValue)
        $('#modalVenda').modal('hide')
        $('#comment').val('')
    }

    document.addEventListener('DOMContentLoaded', function() {

        $('body').on('click', '.saveVenda', function() {
            var ta = $('#tarifa').val()
            var va = $('#vaga').val()
            $('#modalVenda').modal('hide')
            window.livewire.emit('doCheckIn', ta, va, 'Disponivel', $.trim($('#comment').val()))
        })

        window.livewire.on('print', ticket => {
            var rota = "{{ url('print/order') }}" + '/' + ticket
            var w = window.open(rota, "_blank", "width=100, height=100");
            w.close()
        })

        window.livewire.on('print-mensal', ticketM => {
            var rota = "{{ url('ticket/mensal') }}" + '/' + ticketM
            var w = window.open(rota, "_blank", "width=100, height=100");
            w.close()
        })

        window.livewire.on('getin-ok', resultText => {
            $('#comment').val('')
            $('#modalVenda').modal('hide')
        })

        $('body').on('click', '.la-lg', function() {
            $('#exampleModal').modal('show');
        });
        
    })

</script>
