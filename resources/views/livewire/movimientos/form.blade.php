<div class="widget-content-area">
    <div class="widget-one">
        <form>
            <h3 class="text-center">Criar e Editar Movimentos</h3>
            {{-- @include('common.messages') --}}
            <div class="row">
                <div class="form-group col-lg-4 col-md-4 col-sm-12">
                    <label>Tipo</label>
                    <select wire:model.lary="type" class="form-control text-center">
                        <option value="Selecione" disabled>Selecione</option>
                        <option value="Entrada">Entrada</option>
                        <option value="Saida">Saida</option>
                        {{-- <option value="Pagamento de Aluguel">Pagamento de Aluguel</option> --}}
                    </select>
                    @error('type') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group col-lg-4 col-md-4 col-sm-12">
                    <label>Valor</label>
                    <input type="number" wire:model.lazy="amount" class="form-control text-center">
                    @error('amount') <span class="text-danger">{{ $message }}</span> @enderror
                </div>
                <div class="form-group col-lg-4 col-md-4 col-sm-12">
                    <label >Comprovante</label>
                 <input  id="image" wire:change="$emit('fileChoosen',this)" accept="image/x-png,image/gif,image/jpeg"
                 type="file" class="form-control text-center" >
               </div>
                <div class="form-group col-lg-12 col-md-4 mb-8">
                    <label>Observação</label>
                    <input type="text" class="form-control" wire:model.lazy="description">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 mt-2 text-left">
                    <button type="button" wire:click="doAction(1)" class="btn btn-outline-danger btn-rounded mr-1">
                        <i class="mbri-left"></i> Voltar
                    </button>
                    <button type="button" wire:click="StoreOrUpdate() " class="btn btn-outline-success btn-rounded">
                        <i class="mbri-success"></i> Salvar
                    </button>
                </div>            
            </div>
        </form>
    </div>
</div>
