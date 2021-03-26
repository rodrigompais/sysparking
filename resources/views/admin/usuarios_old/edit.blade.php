@extends('layouts.template')
@section('content')
    <div class="row layout-top-spacing">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12 layout-spacing">
            <div class="widget-content-area br-4">
                <div class="widget-one">
                    @include('common.messages')
                    {{-- <form action="{{ route('admin.usuarios.update', $user->uuid) }}" method="POST"> --}}
                    {{-- @csrf --}}
                    {{-- @method('PUT') --}}
                    @include('admin.usuarios._partials.form')
                    {{-- </form> --}}
                </div>
                {{-- <form action="{{ route('admin.usuarios.update', $user->id) }}" method="POST">
                    <div class="row mb-4">
                        <div class="col">
                            <input type="text" class="form-control" placeholder="First name">
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Last name">
                        </div>
                    </div>
                    <input type="submit" name="time" class="btn btn-primary">
                </form> --}}
            </div>
        </div>
    </div>
@endsection
