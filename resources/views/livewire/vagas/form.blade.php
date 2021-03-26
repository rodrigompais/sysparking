<div class="widget-content-area">
    <div class="widget-one">
        @include('common.messages')
        <div class="row">
            <div class="form-group col-lg-4 col-md-4 col-sm-12">
                <label>Nome</label>
                <input type="text" wire:model.lary="description" class="form-control" autofocus>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12">
                <label>Tipo</label>
                <select wire:model="type" class="form-control text-center">
                    <option value="Selecione" disabled="">Selecione</option>
                    @foreach ($types as $t)
                        <option value="{{ $t->id }}">{{ $t->description }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-lg-4 col-md-4 col-sm-12">
                <label>Status</label>
                <select wire:model="status" class="form-control text-center">
                    <option value="Selecione" disabled="">Selecione</option>
                        <option value="Disponivel">Disponivel</option>
                        <option value="Ocupado">Ocupado</option>
                </select>
            </div>
            <div class="row">

            </div>
            <div class="col-lg-5 mt-2 text-left">
                <button type="button" class="btn btn-dark mr-1" wire:click="doAction(1)">
                    <i class="mbri-left">Voltar</i>
                </button>
                <button type="button" class="btn btn-primary ml-2" wire:click.prevent="StoreOrUpdate()">
                    <i class="mbri-success">Salvar</i>
                </button>
            </div>
        </div>
    </div>
</div>
