@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title' => __('Pay with PayTR')])
    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <div class="container">
            <div class="row">
                @include('includes.company_dashboard_menu')
                <div class="col-md-9 col-sm-8">
                    <div class="userccount">
                        <div class="row">
                            <div class="col-md-12">
                                <h3>{{__('PayTR iFrame Ödeme')}}</h3>
                                <p>{{__('Paket')}}: <strong>{{$package->package_title}}</strong></p>
                                <p>{{__('Tutar')}}: <strong>{{$package->package_price}}
                                        {{ $siteSetting->default_currency_code }}</strong></p>
                                <hr>
                                <script src="https://www.paytr.com/js/iframeResizer.min.js"></script>
                                <iframe src="https://www.paytr.com/odeme/guvenli/{{$token}}" id="paytriframe"
                                    frameborder="0" scrolling="no" style="width: 100%;"></iframe>
                                <script>iFrameResize({}, '#paytriframe');</script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('includes.footer')
@endsection