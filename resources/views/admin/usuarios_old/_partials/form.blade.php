<div class="row">
    <div class="form-group col-lg-4 col-md-4 col-sm-12">
        <label>Nome</label>
        <input type="text" wire:model.lary="name" class="form-control" autofocus>
    </div>
    <div class="form-group col-lg-4 col-md-4 col-sm-12">
        <label>Telefone</label>
        <input type="text" maxlength="12" wire:model.lary="telephone" class="form-control">
    </div>
    <div class="form-group col-lg-4 col-md-4 col-sm-12">
        <label>Celular</label>
        <input type="text" maxlength="12" wire:model.lary="cellphone" class="form-control">
    </div>
    <div class="form-group col-lg-4 col-md-4 col-sm-12">
        <label>Perfil</label>
        <select wire:model="type" class="form-control text-center">
            <option value="Selecione">Selecione</option>
            <option value="Admin">Admin</option>
            <option value="Colaborador">Colaborador</option>
            <option value="Cliente">Cliente</option>
        </select>
    </div>
    <div class="form-group col-lg-4 col-md-4 col-sm-12">
        <label>E-mail</label>
        <input type="email" wire:model.lary="email" class="form-control">
    </div>
    <div class="form-group col-lg-4 col-md-4 col-sm-12">
        <label>Senha</label>
        <input type="password" wire:model.lary="password" class="form-control">
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
