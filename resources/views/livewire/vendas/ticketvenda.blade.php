<section id="saidas">
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 layout-spacing" x-data="{ isOpen: true }" @click.away="isOpen = false">
            <div class="widget-content-area br-4">
                <div class="widget-one">
                    <div class="row">
                        @include('common.messages')
                        <div class="col-2">
                            <button class="btn btn-dark" wire:click="$set('section', 1)"><i
                                    class="la la-chevron-left"></i></button>
                        </div>
                        <div class="col-6">
                            <h5 class="text-center"><b>Ticket Mensalista</b></h5>
                        </div>
                        <div class="col-4 text-rigth" x-data="{ isOpen : true }" @click.away="isOpen = false">
                            {{-- <div class="row mt-3" x-data="{ isOpen : true }" @click.away="isOpen = false"> --}}
                                {{-- <div class="col-md-4 ml-auto"> --}}
                                    <div class="input-group mb-2 mr-sm-2">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text"><i class="la la-search la-lg"></i></div>
                                        </div>
                                        <input type="text" class="form-control" placeholder="Buscar..."
                                            wire:model="buscarCliente"
                                            @focus="isOpen = true" 
                                            @keydown.escape.window="isOpen = false"
                                            @keydown.shift.tab="isOpen = false">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text"><i wire:click.prevent="limparCliente()" class="la la-trash la-lg"></i></div>
                                            </div>
                                    </div>                            
                                    <ul class="list-group" x-show.transition.opacity="isOpen">                                                               
                                        @if($buscarCliente !='')                                
                                            @foreach($clientes as $r)                                    
                                                <li wire:click="mostrarCliente('{{$r}}')" class="list-group-item list-group-item-action">
                                                    <b>{{$r->name}}</b> - <h6 class="text-info">Placa:</h6>
                                                    {{$r->plate}} - <h6 class="text-success">Marca:</h6>
                                                    {{$r->brand}} - <h6 class="text-success">Color:</h6>
                                                    {{$r->color}}
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                {{-- </div> --}}
                            {{-- </div> --}}
                        </div>
                    </div>
                    {{-- Dados dos Clientes --}}
                    <div class="row mt-4">
                        <h5 class="col-sm-12">Dados do Cliente</h5>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12">
                            <h6 class="text-info">Name*</h6>
                            <div class="input-group mb-2-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="la la-user la-lg"></i></div>
                                </div>
                                <input type="text" class="form-control" wire:model="name" maxlength="100">
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-md-2 col-sm-12">
                            <h6 class="text-info">Telefone Fixo</h6>
                            <div class="input-group mb-2-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="la la-phone la-lg"></i></div>
                                </div>
                                <input type="text" class="form-control" wire:model="telephone" maxlength="12">
                            </div>
                        </div>
                        <div class="form-group col-lg-2 col-md-2 col-sm-12">
                            <h6 class="text-info">Celular</h6>
                            <div class="input-group mb-2-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="la la-mobile la-lg"></i></div>
                                </div>
                                <input type="text" class="form-control" wire:model="cellphone" maxlength="12">
                            </div>
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12">
                            <h6 class="text-info">E-mail*</h6>
                            <div class="input-group mb-2-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="la la-envelope la-lg"></i></div>
                                </div>
                                <input type="text" class="form-control" wire:model="email" maxlength="100">
                            </div>
                        </div>
                    </div>
                    {{-- Dados do Veiculo --}}
                    <div class="row">
                        <h5 class="col-sm-12">Dados do Veiculo</h5>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12">
                            <h6 class="text-info">Placa*</h6>
                            <div class="input-group mb-2-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="la la-car la-lg"></i></div>
                                </div>
                                <input type="text" class="form-control" wire:model="plate" maxlength="7">
                            </div>
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12">
                            <h6 class="text-info">Descrição</h6>
                            <div class="input-group mb-2-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="la la-car la-lg"></i></div>
                                </div>
                                <input type="text" class="form-control" wire:model="nota" maxlength="30">
                            </div>
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12">
                            <h6 class="text-info">Modelo</h6>
                            <div class="input-group mb-2-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="la la-calendar la-lg"></i></div>
                                </div>
                                <input type="text" class="form-control" wire:model="model" maxlength="30">
                            </div>
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12">
                            <h6 class="text-info">Marca</h6>
                            <div class="input-group mb-2-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="la la-copyright la-lg"></i></div>
                                </div>
                                <input type="text" class="form-control" wire:model="brand" maxlength="30">
                            </div>
                        </div>
                        <div class="form-group col-lg-4 col-md-4 col-sm-12">
                            <h6 class="text-info">Cor</h6>
                            <div class="input-group mb-2-sm-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text"><i class="la la-tint la-lg"></i></div>
                                </div>
                                <input type="text" class="form-control" wire:model="color" maxlength="30">
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-3 col-lg-3 col-sm-12">
                            Tempo
                            <select wire:model="time" wire:change="getSaida()" class="form-control text-center">
                                <option value="0">Selecione</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    @if ($i === 1) 
                                        <option value="{{$i}}">{{$i}} Mês</option>
                                    @else
                                        <option value="{{$i}}">{{$i}} Meses</option>
                                    @endif
                                @endfor
                            </select>
                        </div>
                        <div class="col-md-2 col-lg-2 col-sm-12">
                            <div class="form-group mb-0"> Data de entrada
                                <input type="text" class="form-control" value="{{ \Carbon\Carbon::now()->format('d-m-Y') }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-2 col-lg-2 col-sm-12">
                            <div class="form-group mb-0"> Data de saída
                                <input type="text" wire:model="fecha_fim" class="form-control" value="{{ \Carbon\Carbon::now()->format('d-m-Y') }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-2 col-lg-2 col-sm-12">
                            <div class="form-group mb-0"> Total Calculado
                                <input type="text" class="form-control" value="R$ {{ $total }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-2 col-lg-2 col-sm-12">
                            <div class="form-group mb-0"> Total Manual
                                <input type="number" wire:model="total" class="form-control" type="number" min="0"
                                {{-- value="{{ number_format($total,2) }}" disabled --}}>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-between">
                        <div class="col-md-4 col-lg-4 col-sm-12">
                            @if ($time > 0)
                                <button wire:click.prevent="RegistrarTicketVenda()" class="btn btn-success mt-4"> Registrar Entrada</button>
                            @endif
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
