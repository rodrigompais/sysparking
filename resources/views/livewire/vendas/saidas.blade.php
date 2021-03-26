<section id="saidas">
    <div class="row layout-top-spacing">
        <div class="col-xm-12 col-lg-12 col-sm-12 col-md-12 layout-spacing">
            <div class="widget-content-area br-4">
                <div class="widget-one">
                    <div class="row">
                        <div class="col-2">
                            <button class="btn btn-dark" wire:click="$set('section', 1)">
                                <i class="la la-chevron-left"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-8">
                        <h5 class="text-center"><b>Registrar Saídas</b></h5>
                    </div>
                    <div class="col-2 text-rigth">
                        <label id='tc'></label>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        @if (count($errors) > 0)
                            @foreach ($errors->all() as $error)
                                <small class="text-danger">{{ $error }}</small>
                            @endforeach
                        @endif
                            <div class="input-group mb-4">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="la la-barcode"></i></span>
                                </div>
                                <input type="text" id="code" wire:keydows.enter="BuscarTicket()" wire:model="bar_code"
                                    class="form-control" maxlength="9" autofocus>
                                <div class="input-group-prepend">
                                    <span wire:click="BuscarTicket()" class="input-group-text" style="cursor: pointer;"><i class="la la-print la-lg"></i> Saída </span>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8 col-md-8 col-sm-12">
                        <div class="col-sm-12">
                            <h6><b>Fatura:</b> {{$obj->id}}</h6>
                            <input type="hidden" id="ticketid" value="{{$obj->id}}">
                        </div>
                        <div class="col-sm-12">
                            <h6><b>Status:</b> {{$obj->status}}</h6>                            
                        </div>
                        <div class="col-sm-12">
                            <h6><b>Tarifa:</b> {{ number_format($obj->tarifa->amount,2) }}</h6>                            
                        </div>
                        <div class="col-sm-12">
                            <h6><b>Acesso:</b> {{ \Carbon\Carbon::parse($obj->access)->format('d/m/Y h:m:s') }}</h6>                            
                        </div>
                        <div class="col-sm-12">
                            <h6><b>Código:</b> {{$obj->bar_code}}</h6>                            
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <blockquote class="blockquote text-center">
                            <h5><b>Valor até o momento</b></h5>
                            <h6>Tempo Total: {{$obj->time}}</h6>
                            <h6>Valor Total: {{ number_format($obj->total,2) }}</h6>
                        </blockquote>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
