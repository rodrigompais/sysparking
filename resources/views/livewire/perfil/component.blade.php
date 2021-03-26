<div class="row layout-top-spacing">
    <div class="col-sm-12 col-md-12 col-lg-12 layout-spacing">
        <div class="widget-content-area br-4">
            <div class="widget-header">
                <div class="col-xl-12">
                    <h4><b> Perfil </b></h4>
                </div>
                <div class="row mt-4">                    
                    <div class="col-sm-6 col-md-2 ml-2 text-center">
                        <img alt="avatar" src="https://designreset.com/cork/laravel/ltr/horizontal-light-menu/public/storage/img/profile-12.jpeg" class="rounded-circle" />
                    </div>
                    <div class="col-sm-6 col-md-8">
                        <h5><b>Nome: </b>{{ Auth::user()->name }}</h5>
                        <h5><b>E-mail: </b>{{ $info->email }}</h5>
                        {{-- <h5><b>Perfil: </b>{{ $info->type }}</h5> --}}
                        <h5><b>Perfil: </b>@if ($info->type == 'Admin')
                            Administrador
                        @else
                            {{ $info->type }}
                        @endif</h5>
                        <h5><b>Telefone Fixo: </b>{{ $info->telephone }}</h5>
                        <h5><b>Telefone Celular: </b>{{ $info->cellphone }}</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>