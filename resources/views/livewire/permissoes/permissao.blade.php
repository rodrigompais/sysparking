<div class="tab-pane fade {{ $tab == 'permissao' ? 'show active' : '' }}" id="permissao_content" role="tabpanel">
    <div class="row mt-2">
        <div class="col-sm-12 col-md-7">
            <h6 class="text-center"><b>Lista de Permissões</b></h6>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span onclick="clearPermissaoSelected()" class="input-group-text" style="cursor: pointer;">
                        <i class="la la-remove la-lg"></i>
                    </span>
                </div>
                <input type="text" id="permissaoName" class="form-control" autocomplete="off">
                <input type="hidden" id="permissaoId">
                <div class="input-group-prepend">
                    <span class="input-group-text"
                        wire:click="$emit('CriarPermissao', $('#permissaoName').val(), $('#permissaoId').val() )">
                        <i class="la la-save la-lg"></i>
                    </span>
                </div>
            </div>
            <div class="table-responsive mt-2">
                <table id="tblPermissao"
                    class="table table-sm table-bordered table-hover table-striped table-checkable table-highlight-head mb-4">
                    <thead>
                        <tr>
                            <th class="text-center">Permissão</th>
                            <th class="text-center">Perfil<br>com permissão</th> {{-- Avaliar Texto --}}
                            <th class="text-center">Ações</th>
                            <th class="text-center">
                                <div class="n-check">
                                    <label class="new-control new-checkbox checkbox-primary">
                                        <input type="checkbox" class="new-control-input check-all">
                                        <span class="new-control-indicator"></span>TODOS
                                    </label>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissao as $pm)
                            {{-- {{ dd($permissao) }} --}}
                            <tr>
                                <td>{{ $pm->name }}</td>
                                <td class="text-center">{{ \App\User::permission($pm->name)->count() }}</td>
                                <td class="text-center">
                                    <span style="cursor: pointer" onclick="showPermissao('{{ $pm }}')">
                                        <i class="la la-edit la-lg text-warning"></i>
                                    </span>
                                    @if (\App\User::permission($pm->name)->count() <= 0)
                                        <a href="javascript:void(0)" 
                                        onclick="Confirm('{{ $pm->id }}','destroyPermissao')"
                                        title="Eliminar Permissao"><i class="la la-trash la-lg text-danger"></i></a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="n-check" id="divPermissao">
                                        <label class="new-control new-checkbox checkbox-primary">
                                            <input id="p{{$pm->id}}" data-name="{{ $pm->name }}" type="checkbox"
                                                class="new-control-input check-permissao"
                                                {{$pm->checked == 1 ? 'checked' : '' }} >
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
        </div>
        <div class="col-sm-12 col-md-5">
            <h6 class="text-left">Selecione Perfil</h6>
            <div class="input-group">
                <select wire:model="perfilSelected" id="perfilSelected" class="form-control text-center">
                    <option value="Selecione">Selecione</option>
                    @foreach ($perfis as $p)
                        <option value="{{$p->id}}">{{$p->name}}</option>
                    @endforeach
                </select>
            </div>
            <button type="button" onclick="AssociarPermissao()" class="btn btn-primary mt-4">Associar Permissão</button>
        </div>
    </div>
</div>
