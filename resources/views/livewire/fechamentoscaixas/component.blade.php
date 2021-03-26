<div class="main-content">
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
            <div class="widget-content-area">
                <div class="widget-one">
                    <h3 class="text-center"> Fechamento de Caixa </h3>
                    <div class="row">
                        <div class="col-sm-12 col-md-2 col-lg-2">
                            Selecione uma Data
                            <div class="form-group">
                                <input wire:model.lary="fecha" type="text"
                                    class="form-control flatpickr flarpickr-input active">
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-3 col-lg-3">
                            <div class="form-group"> Selecione o Usuário
                                <select wire:model="user" class="form-control">
                                    <option value="todos">Todos</option>
                                    @foreach ($users as $u)
                                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-2 col-lg-2">
                            @if ($fecha != '')
                                <button wire:click.prevent="Consultar()" class="btn btn-info mt-4">Consultar</button>
                            @endif
                        </div>
                        <div class="col-sm-12 col-md-2 col-lg-2 text-center">
                            <button type="button" wire:click.prevent="Balance()" class="btn btn-dark mt-4">Fechamento do
                                Dia</button>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12 col-md-5 col-lg-5">
                            <div class="row">
                                <div class="col-sm-12 col-sm-8 col-lg-8 layout-spacing">
                                    <div class="color-box">
                                        <span class="cl-example text-center"
                                            style="background-color:#8dbf42; font-size: 3rem; color:white">+</span>
                                        <div class="cl-info">
                                            <h1 class="cl-title">Vendas</h1>
                                            @if ($vendas > 0)
                                                <span>R$ {{ number_format($vendas, 2) }}</span>
                                            @else
                                                <span>Não há dados</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-sm-8 col-lg-8 layout-spacing">
                                    <div class="color-box">
                                        <span class="cl-example text-center"
                                            style="background-color:#8dbf42; font-size: 3rem; color:white">+</span>
                                        <div class="cl-info">
                                            <h1 class="cl-title">Entradas</h1>
                                            @if ($vendas > 0)
                                                <span>R$ {{ number_format($entradas, 2) }}</span>
                                            @else
                                                <span>Não há dados</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-sm-8 col-lg-8 layout-spacing">
                                    <div class="color-box">
                                        <span class="cl-example text-center"
                                            style="background-color:#8dbf42; font-size: 3rem; color:white">-</span>
                                        <div class="cl-info">
                                            <h1 class="cl-title">Saídas</h1>
                                            @if ($vendas > 0)
                                                <span>R$ {{ number_format($saidas, 2) }}</span>
                                            @else
                                                <span>Não há dados</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-7 col-lg-7">
                            <h4>=== Saldo ====</h4>
                            <h4 class="mt-4">R$ {{ number_format($balanco, 2) }}</h4>
                            @if ($balanco > 0)
                                <button
                                    wire:click.prevent="$emit('info2PrintFechamento', {{ $vendas }},{{ $entradas }},{{ $saidas }},{{ $balanco }} )"
                                    class="btn btn-outline-primary mt-5">Imprimir Fechamento</button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
