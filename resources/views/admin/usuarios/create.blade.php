@extends('layouts.template')
@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
            <div class="widget-content-area br-4">
                <div class="widget-one">
                    @include('common.messages')
                    <form action="{{ route('admin.usuarios.store') }}" method="POST">
                        @csrf
                        @include('admin.usuarios._partials.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection