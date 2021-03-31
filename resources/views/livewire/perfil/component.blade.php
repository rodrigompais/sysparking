<div class="row layout-top-spacing">
    <div class="col-sm-12 col-md-12 col-lg-12 layout-spacing">
        <div class="widget-content-area br-4">
            <div class="widget-header">
                <div class="col-xl-12">
                    <h4 class="text"><b> Perfil </b></h4>
                </div>
                <div class="row mt-4">
                    <div class="col-sm-6 col-md-2 ml-2 text-center">
                        <img alt="avatar"
                            src="{{ url('images/perfil/perfil.jpg') }}"
                            {{-- src="{{asset('images/perfil/perfil.jpg')}}" --}}
                            class="rounded-circle" style="max-width: 125px;"/>
                    </div>
                    <div class="col-sm-6 col-md-8">
                        <h5><b>Nome: </b>{{ Auth::user()->name }}</h5>
                        <h5><b>E-mail: </b>{{ $info->email }}</h5>
                        <h5><b>Perfil: </b>{{ $info->getRoleNames()[0] }}</h5>
                        <h5><b>Telefone Fixo: </b>{{ $info->telephone }}</h5>
                        <h5><b>Telefone Celular: </b>{{ $info->cellphone }}</h5>
                    </div>                   
                </div>
                <div class="row">
                    <div class="col-lg-5 mt-2 text-left">
                        <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-danger btn-rounded mr-1" type="submit">
                            <i class="mbri-left"></i> Voltar
                        </a>
                        <a href="{{ route('admin.usuarios.edit', $info->id) }}" class="btn btn-outline-success btn-rounded mr-1" type="submit">
                            <i class="mbri-left"></i> Editar
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
