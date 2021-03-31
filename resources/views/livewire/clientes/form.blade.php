<div class="row layout-top-spacing">
    <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
        <div class="widget-content-area br-4">
            <div class="widget-one">
                <div class="row">
                    {{-- @include('common.messages') --}}

                    <div class="col-xl-12">
                        <h4><b> Dados do Cliente </b></h4>
                    </div>
                    <div class="form-group col-md-6 mb-4">
                        <label>Nome</label>
                        <input wire:model.lazy="name" type="text" class="form-control text-left" autofocus>
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group col-md-4 mb-4">
                        <label>E-mail</label>
                        <input wire:model.lazy="email" maxlength="100" type="text" class="form-control text-left">

                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group col-md-2 mb-4">
                        <label>Telefone</label>
                        <input wire:model.lazy="telephone" type="text" class="form-control text-left">
                        @error('telephone') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-xl-12">
                        <h4><b> Endereço </b></h4>
                    </div>
                    <div class="form-group col-lg-2 col-md-2 col-sm-12">
                        <label>CEP</label>
                        <div class="input-group mb-2-sm-2">                            
                            <input wire:model.lazy='address_cep' id="address_cep" type="number"
                            class="form-control" size="8" maxlength="8" minlength="8" wire:keydown.enter='buscaCep'>
                            <div class="input-group-prepend">
                                <div class="input-group-text"><i wire:click='buscaCep' class="la la-search la-lg"></i></div>
                            </div>
                        </div>
                    </div>                    
                    <div class="form-group col-md-5">
                        <label>Endereço</label>
                        <input wire:model="address_full" id="address_full" type="text"
                            class="form-control text-left">
                    </div>
                    <div class="form-group col-md-2">
                        <label>Numero</label>
                        <input wire:model.lary="address_number" id="address_number" type="number"
                            class="form-control text-left">
                        @error('address_number')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label>Complemento</label>
                        <input wire:model.lary="address_complement" type="text" class="form-control text-left">
                        @error('direction') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label>Bairro</label>
                        <input wire:model.lary="address_district" id="address_district" type="text" class="form-control text-left">
                        @error('address_district')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-3">
                        <label>Cidade</label>
                        <input wire:model.lary="address_city" id="address_city" class="form-control text-left">
                        @error('address_city')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-2">
                        <label>UF</label>
                        <select wire:model.lary="address_uf" id="address_uf"
                            class="form-control @error('address_uf') is-invalid @enderror">
                            <option value="">-- Selecione --</option>
                            <option value="AC">AC</option>
                            <option value="AL">AL</option>
                            <option value="AM">AM</option>
                            <option value="AP">AP</option>
                            <option value="BA">BA</option>
                            <option value="CE">CE</option>
                            <option value="DF">DF</option>
                            <option value="ES">ES</option>
                            <option value="GO">GO</option>
                            <option value="MA">MA</option>
                            <option value="MG">MG</option>
                            <option value="MS">MS</option>
                            <option value="MT">MT</option>
                            <option value="PA">PA</option>
                            <option value="PB">PB</option>
                            <option value="PE">PE</option>
                            <option value="PI">PI</option>
                            <option value="PR">PR</option>
                            <option value="RJ">RJ</option>
                            <option value="RN">RN</option>
                            <option value="RO">RO</option>
                            <option value="RR">RR</option>
                            <option value="RS">RS</option>
                            <option value="SC">SC</option>
                            <option value="SE">SE</option>
                            <option value="SP">SP</option>
                            <option value="TO">TO</option>
                        </select>
                        @error('address_uf')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="form-group col-md-4">
                        <label>Logo</label>
                        <input type="file" class="form-control" id="image" wire:change="$emit('fileChoosen',this)"
                            accept="image/x-png,image/gif,image/jpeg,image/jpg">
                        @error('image') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                    <div class="col-sm-12">
                        <button type="button" wire:click.prevent="Salvar" class="btn btn-primary ml-2">
                            <i class="mbri-success"></i>
                            Salvar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function() {

        window.livewire.on('fileChoosen', () => {

            let inputField = document.getElementById('image')
            let file = inputField.files[0]
            let reader = new FileReader()
            reader.onloadend = () => {
                window.livewire.emit('logoUpload', reader.result)
            }
            reader.readAsDataURL(file)
        })
    })

</script>
