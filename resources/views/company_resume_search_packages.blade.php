@extends('layouts.app')
@section('content')
<!-- Header start -->
@include('includes.header')
<!-- Header end -->
<!-- Inner Page Title start -->
@include('includes.inner_page_title', ['page_title'=>__('CV Arama Paketleri')])
<!-- Inner Page Title end -->
<?php $company = Auth::guard('company')->user(); ?>

<div class="listpgWraper">
    <div class="container">@include('flash::message')
        <div class="row"> @include('includes.company_dashboard_menu')
            <div class="col-md-9 col-sm-8 company-dashboard-content">
                @if(null!==($success_package) && !empty($success_package))
                <div class="instoretxt">

<h3>Satın Alınan CV Paketi Detayları</h3>
<div class="table-responsive">
    <table class="table table-bordered mb-0">
    <thead class="table-dark">
        <tr>
        <th scope="col">Paket Adı</th>
        <th scope="col">Fiyat</th>
        <th scope="col">Mevcut CV kotası</th>
        <th scope="col">Satın Alınma Tarihi</th>
        <th scope="col">Paket Bitiş Tarihi</th>
        </tr>
    </thead>
    <tbody>
    <tr>
    <th>{{$success_package->package_title}}</th>
    <td>{{$success_package->package_price}} {{ $siteSetting->default_currency_code }}</td>
    <td><strong>{{ $company->availed_cvs_quota ?? 0 }}</strong> / <strong>{{$company->cvs_quota}}</strong></td>
    <td><strong>{{Carbon\Carbon::parse($company->cvs_package_start_date)->translatedFormat('d F Y')}}</strong></td>
    <td><strong>{{Carbon\Carbon::parse($company->cvs_package_end_date)->translatedFormat('d F Y')}}</strong></td>
</tr>

    </tbody>
    </table>
</div>
</div>
            @endif
                
                        <div class="paypackages">
    <!---four-paln-->
    <?php 
        $package = Auth::guard('company')->user()->cvs_getPackage();
     ?>
     @if(null!==($package))
       <div class="four-plan">
        <h3>{{__('CV Arama Paketlerini Yükselt')}}</h3>
        <div class="row"> @foreach($packages as $package)
        <div class="col-12 col-sm-6 col-lg-4 package-card-col">
                            <ul class="boxes">
                                <li class="plan-name">{{$package->package_title}}</li>
                                <li>
                                    <div class="main-plan">
                                        <div class="plan-price1-2 plan-price-main">{{$package->package_price}}</div>
                                        <div class="plan-price1-1">{{ $siteSetting->default_currency_code }}</div>
                                        <div class="clearfix"></div>
                                    </div>
                                </li>
                                <li class="plan-pages"><i class="far fa-check-square"></i> {{__('Aday CV Görüntüleme')}} {{$package->package_num_listings}}</li>
                                <li class="plan-pages"><i class="far fa-check-square"></i> {{__('CV Görüntüleme Erişimi')}} {{$package->package_num_days}} {{__('Gün')}}</li>
                                <li class="plan-pages"><i class="far fa-check-square"></i> {{__('Premium Destek 24/7')}}</li> 
                                
                                <li class="order paypal"><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#buypack{{$package->id}}" class="reqbtn">{{__('Şimdi Satın Al')}}</a></li>
                                
                            </ul>
                        </div>


                        <div class="modal fade" id="buypack{{$package->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                        <div class="modal-body">
                        <button type="button" class="close ms-auto" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                        </button>
                        <div class="invitereval">
                        <h3>Ödeme Yöntemini Seçin</h3>	
                            
                        <div class="totalpay">{{__('Ödenecek Toplam Tutar')}}: <strong>{{$package->package_price}} {{ $siteSetting->default_currency_code }}</strong></div>
                            
                        <ul class="btn2s">
                        
                            @if($siteSetting->is_paytr_active)
                                <li class="order p-2">
                                    <a href="{{route('paytr.order.package', ['package_id' => $package->id])}}">
                                        <i class="fas fa-credit-card" aria-hidden="true"></i> {{__('Kart ile Öde')}}
                                    </a>
                                </li>
                            @endif
                            @if($siteSetting->is_bank_transfer_active)
                                <li class="order p-2">
                                    <a href="{{route('bank.transfer.order.package', ['package_id' => $package->id])}}">
                                        <i class="fas fa-university" aria-hidden="true"></i> {{__('Havale/EFT')}}
                                    </a>
                                </li>
                            @endif

                        </ul>		
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
            @endforeach </div>
    </div>
     @else
    <div class="four-plan">
        <h3>{{__('CV Arama Paketleri')}}</h3>
        <div class="row"> @foreach($packages as $package)
        <div class="col-12 col-sm-6 col-lg-4 package-card-col">
                            <ul class="boxes">
                                <li class="plan-name">{{$package->package_title}}</li>
                                <li>
                                    <div class="main-plan">
                                        <div class="plan-price1-2 plan-price-main">{{$package->package_price}}</div>
                                        <div class="plan-price1-1">{{ $siteSetting->default_currency_code }}</div>
                                        <div class="clearfix"></div>
                                    </div>
                                </li>
                                <li class="plan-pages"><i class="far fa-check-square"></i> {{__('Aday CV Görüntüleme')}} {{$package->package_num_listings}}</li>
                                <li class="plan-pages"><i class="far fa-check-square"></i> {{__('CV Görüntüleme Erişimi')}} {{$package->package_num_days}} {{__('Gün')}}</li>
                                <li class="plan-pages"><i class="far fa-check-square"></i> {{__('Premium Destek 24/7')}}</li> 
                                
                                <li class="order paypal"><a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#buypack{{$package->id}}" class="reqbtn">{{__('Şimdi Satın Al')}}</a></li>

                            </ul>
                        </div>



                        <div class="modal fade" id="buypack{{$package->id}}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                        <div class="modal-body">
                        <button type="button" class="close ms-auto" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                        </button>
                        <div class="invitereval">
                        <h3>Ödeme Yöntemini Seçin</h3>	
                            
                        <div class="totalpay">{{__('Ödenecek Toplam Tutar')}}: <strong>{{$package->package_price}} {{ $siteSetting->default_currency_code }}</strong></div>
                            
                        <ul class="btn2s">
                        
                            @if($siteSetting->is_paytr_active)
                                <li class="order p-2">
                                    <a href="{{route('paytr.order.package', ['package_id' => $package->id])}}">
                                        <i class="fas fa-credit-card" aria-hidden="true"></i> {{__('Kart ile Öde')}}
                                    </a>
                                </li>
                            @endif
                            @if($siteSetting->is_bank_transfer_active)
                                <li class="order p-2">
                                    <a href="{{route('bank.transfer.order.package', ['package_id' => $package->id])}}">
                                        <i class="fas fa-university" aria-hidden="true"></i> {{__('Havale/EFT')}}
                                    </a>
                                </li>
                            @endif

                        </ul>		
                        </div>
                        </div>
                        </div>
                        </div>
                        </div>
            @endforeach </div>
    </div>
    @endif
    <!---end four-paln-->
</div>
            </div>
        </div>
    </div>
</div>
@include('includes.footer')
@endsection
@push('scripts')
@include('includes.immediate_available_btn')
@endpush


