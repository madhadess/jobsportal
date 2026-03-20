@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title' => __('Ödeme Yöntemi Seçin')])
    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <div class="container">
            <div class="row">
                @if(Auth::guard('company')->check())
                    @include('includes.company_dashboard_menu')
                @else
                    @include('includes.user_dashboard_menu')
                @endif
                <div class="col-md-9 col-sm-8">
                    <div class="userccount">
                        <div class="row">
                            <div class="col-md-12">
                                <h3>{{__('Ödeme Yöntemi Seçin')}}</h3>
                                <div class="alert alert-info">
                                    {{__('Paket')}}: <strong>{{ $package->package_title }}</strong> |
                                    {{__('Tutar')}}: <strong>{{ $package->package_price }}
                                        {{ $siteSetting->default_currency_code }}</strong>
                                </div>
                                <hr>
                                <div class="row">
                                    @if($siteSetting->is_paytr_active)
                                        <div class="col-md-6">
                                            <div class="well text-center">
                                                <h4>{{__('Kredi / Banka Kartı')}}</h4>
                                                <p>{{__('PayTR iFrame ile güvenli ödeme yapın.')}}</p>
                                                <a href="{{ route('paytr.order.package', ['package_id' => $package->id]) }}"
                                                    class="btn btn-success btn-block">{{__('Kart ile Öde')}}</a>
                                            </div>
                                        </div>
                                    @endif

                                    @if($siteSetting->is_bank_transfer_active)
                                        <div class="col-md-6">
                                            <div class="well text-center">
                                                <h4>{{__('Havale / EFT')}}</h4>
                                                <p>{{__('Banka hesabımıza havale yaparak ödeyin.')}}</p>
                                                <a href="{{ route('bank.transfer.order.package', ['package_id' => $package->id]) }}"
                                                    class="btn btn-primary btn-block">{{__('Havale ile Öde')}}</a>
                                            </div>
                                        </div>
                                    @endif

                                    @if(!$siteSetting->is_paytr_active && !$siteSetting->is_bank_transfer_active)
                                        <div class="col-md-12">
                                            <div class="alert alert-warning">
                                                {{__('Şu anda aktif bir ödeme yöntemi bulunmamaktadır. Lütfen yönetici ile iletişime geçin.')}}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('includes.footer')
@endsection