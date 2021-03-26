@extends('layouts.template')
@section('content')

    <div id="content" class="main-content">
        <div class="row mt-4">
            <div class="col-lg-8">
                <div class="layout-px">
                    <div class="widget-content-area">
                        <div class="widget-one">
                            {!! $chartVendasxMensal->container() !!}

                            <script src="{{ @asset('vendor/larapex-charts/apexcharts.js') }}"></script>

                            {{ $chartVendasxMensal->script() }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="layout-px">
                    <div class="widget-content-area">
                        <div class="widget-one">
                            {!! $chartVendaxSemanal->container() !!}

                            <script src="{{ @asset('vendor/larapex-charts/apexcharts.js') }}"></script>

                            {{ $chartVendaxSemanal->script() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-lg-12">
                <div class="layout-px">
                    <div class="widget-content-area">
                        <div class="widget-one">
                            {!! $chartBalancoxMeses->container() !!}

                            <script src="{{ @asset('vendor/larapex-charts/apexcharts.js') }}"></script>

                            {{ $chartBalancoxMeses->script() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
