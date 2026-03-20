@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title' => __('Havale / EFT ile Ödeme')])
    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <div class="container">
            <div class="row">
                @include('includes.company_dashboard_menu')
                <div class="col-md-9 col-sm-8">
                    <div class="userccount">
                        <div class="row">
                            <div class="col-md-12">
                                <h3>{{__('Banka Havalesi / EFT')}}</h3>
                                <p>{{__('Paket')}}: <strong>{{$package->package_title}}</strong></p>
                                <p>{{__('Tutar')}}: <strong>{{$package->package_price}}
                                        {{ $siteSetting->default_currency_code }}</strong></p>
                                <hr>
                                <div class="alert alert-info">
                                    <strong>{{__('Banka Hesap Bilgileri')}}:</strong><br>
                                    {!! nl2br(e($siteSetting->bank_details)) !!}
                                </div>
                                <p>{{__('Ödemeyi yaptıktan sonra lütfen destek ekibimizle iletişime geçin veya ödeme bildirimi yapın. Ödemeniz onaylandıktan sonra paketiniz aktif edilecektir.')}}
                                </p>
                                <a href="{{route('company.home')}}" class="btn btn-primary">{{__('Panelime Dön')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('includes.footer')
@endsection