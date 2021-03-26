<div class="tab-pane fade {{ $tab == 'perfil' ? 'show active' : '' }}" id="perfil_content" role="tabpanel">
    <div class="row mt-2">
        <div class="col-sm-12 col-md-7">
            <h6 class="text-center"><b>Lista de Perfis</b></h6>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span onclick="clearPerfilSelected()" class="input-group-text" style="cursor: pointer;">
                        <i class="la la-remove la-lg"></i>
                    </span>
                </div>
                <input type="text" id="perfilName" class="form-control" autocomplete="off">
                <input type="hidden" id="perfilId">
                <div class="input-group-prepend">
                    <span wire:click="$emit('CriarPerfil', $('#perfilName').val(), $('#perfilId').val() )" class="input-group-text">
                        <i class="la la-save la-lg"></i>
                    </span>
                </div>
            </div>
            {{-- <div class="row"> --}}
                <div class="table-responsive mt-2">
                    <table id="tblPerfil"
                        class="table table-sm table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                        <thead>
                            <tr>
                                <th class="text-center">Perfil</th>
                                <th class="text-center">Qtd Usuários</th>
                                <th class="text-center">Ações</th>
                                <th class="text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($perfis as $p)
                                <tr>
                                    <td>{{ $p->name }}</td>
                                    <td class="text-center">{{ \App\User::role($p->name)->count() }}</td>
                                    <td class="text-center">
                                        <span style="cursor: pointer" onclick="showPerfil('{{ $p }}')">
                                            <i class="la la-edit la-lg text-warning"></i>
                                        </span>
                                        @if (\App\User::role($p->name)->count() <= 0)
                                        <a href="javascript:void(0)" onclick="Confirm('{{$p->id}}','destroyPerfil')"
                                        title="Delete"><i class="la la-trash la-lg text-danger"></i></a>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="n-check" id="divPerfil">
                                            <label class="new-control new-checkbox checkbox-primary">
                                                <input data-name="{{ $p->name }}"
                                                {{$p->checked == 1 ? 'checked' : ''}}
                                                type="checkbox" class="new-control-input checkbox-rol">
                                                <span class="new-control-indicator"></span>
                                                Associar
                                            </label>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            {{-- </div> --}}
        </div>
        <div class="col-sm-12 col-md-5">
            <h6 class="text-left">Selecione Usuário</h6>
            <div class="input-group">
                <select wire:model="userSelected" id="userId" class="form-control">
                    <option value="Selecione">Selecione</option>
                    @foreach ($usuarios as $u)
                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="button" onclick="AssociarPerfil()" class="btn btn-primary mt-4">Associar Perfil</button>
        </div>
    </div>
</div>