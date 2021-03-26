<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
        <div class="widget-content-area br-4">
            <div class="widget-one">

                <h5>
                    <b>
                        @if ($selected_id == 0)
                            Criar novo Fabricantes
                        @else
                            Editar Fabricantes
                        @endif
                    </b>
                </h5>
                <div class="row">
                    <div class="col-sm-12 col-lg-8 col-md-8 ">
                        <label>Descrição</label>
                        <div class="input-group ">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1"><svg xmlns="http://www.w3.org/2000/svg"
                                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-edit-2">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg></span>
                            </div>
                            <input type="text" class="form-control" autofocus {{-- placeholder="Nome do Tipo" --}}
                                wire:model="description">
                        </div>
                        @error('description') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    {{-- <div class="form-group col-lg-4 col-md-4 col-sm-12">
                        <label>Imagem</label>
                        <input type="file" class="form-control text-center" id="image"
                            wire:change="$emit('fileChoosen',this)" accept="image/x-png, image/gif, image/jpeg">
                    </div> --}}
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
            </div>
        </div>
    </div>
</div>
