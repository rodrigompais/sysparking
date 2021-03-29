<div class="row">
    <div class="form-group col-lg-4 col-md-4 col-sm-12">
        <label>Nome</label>
        <input type="text" name="name" class="form-control" value="{{ $user->name ?? old('name') }}" autofocus>
    </div>
    <div class="form-group col-lg-4 col-md-4 col-sm-12">
        <label>Telefone</label>
        <input type="text" maxlength="12" name="telephone" value="{{ $user->telephone ?? old('telephone') }}" class="form-control">
    </div>
    <div class="form-group col-lg-4 col-md-4 col-sm-12">
        <label>Celular</label>
        <input type="text" maxlength="12" name="cellphone" value="{{ $user->cellphone ?? old('cellphone') }}" class="form-control">
    </div>
    <div class="form-group col-lg-4 col-md-4 col-sm-12">
        <label>Perfil</label>
        <select class="form-control text-center" name="roles" id="roles">
            <option value="Selecione" disabled="">Selecione</option>
            @foreach ($roles as $id => $name)
                <option value="{{ $id }}"
                    @if (isset($userRole) && $userRole[0] == $id || old('roles') == $id)
                        selected
                    @endif 
                    >{{ $name }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-lg-4 col-md-4 col-sm-12">
        <label>E-mail</label>
        <input type="email" name="email" value="{{ $user->email ?? old('email') }}" class="form-control">
    </div>
    <div class="form-group col-lg-4 col-md-4 col-sm-12">
        <label>Senha</label>
        <input type="password" name="password" class="form-control">
    </div>
</div>
<div class="row">
    <div class="col-lg-5 mt-2 text-left">
        <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-danger btn-rounded mr-1" type="submit">
            <i class="mbri-left"></i> Voltar
        </a>
        <button type="submit" class="btn btn-outline-success btn-rounded">
            <i class="mbri-success"></i> Salvar
        </button>
    </div>
</div>