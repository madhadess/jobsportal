@extends('layouts.app')

@section('content')

    <!-- Header start -->

    @include('includes.header')

    <!-- Header end -->

    <!-- Inner Page Title start -->

    @include('includes.inner_page_title', ['page_title' => __('İş Verici Paneline Hoş Geldiniz')])

    <!-- Inner Page Title end -->

    <div class="listpgWraper">

        <div class="container">@include('flash::message')

            <div class="row"> @include('includes.company_dashboard_menu')
                <?php $company = auth()->guard('company')->user(); ?>

                <div class="col-md-9 col-sm-8 company-dashboard-content">
                    <?php
    $hasUnlimitedFreeQuota = method_exists($company, 'hasUnlimitedFreeJobPostingQuota')
        ? $company->hasUnlimitedFreeJobPostingQuota()
        : false;
    if (
        $company->is_active == 1 && (($company->package_end_date === null) ||
            (\Carbon\Carbon::parse($company->package_end_date)->lt(\Carbon\Carbon::now())) ||
            (!$hasUnlimitedFreeQuota && $company->jobs_quota <= $company->availed_jobs_quota))
    ) { ?>

                    <div class="userprofilealert">
                        <h5>
                            <i class="fas fa-check"></i>
                            {{__('Hesabınız artık aktif, İş İlanı yayınlamaya başlayın.')}}
                        </h5>
                    </div>

                    <?php } elseif ($company->is_active != 1) { ?>
                    <div class="userprofilealert">
                        <h5>
                            <i class="fas fa-times"></i>
                            {{__('Hesabınız doğrulama beklediği için şu anda pasif durumda.')}}
                        </h5>
                    </div>
                    <?php } ?>




                    @include('includes.company_dashboard_stats')

                    @if(
                        $company->getPackage('package_price') !== null &&
                        (float)$company->getPackage('package_price') <= 0 &&
                        $company->package_end_date !== null &&
                        Carbon\Carbon::parse($company->package_end_date)->gt(Carbon\Carbon::now()) &&
                        ($hasUnlimitedFreeQuota || $company->jobs_quota > $company->availed_jobs_quota)
                    )
                        <div class="freepackagebox">
                            <div class="frpkgct">
                                <h5>{{__('Tebrikler! Hesabınız artık aktif')}}</h5>
                                <p>
                                    @if($hasUnlimitedFreeQuota)
                                        {{ __('Ücretsiz paketiniz aktif. İlan yayınlama limitiniz bulunmuyor.') }}
                                    @else
                                        {{__('Elde ettiniz')}} {{ $company->jobs_quota - $company->availed_jobs_quota }}
                                        {{__('ücretsiz ilan yayınlama, geçerli')}} {{__('48 saat. Bitmeden acele edin')}}
                                    @endif
                                </p>
                            </div>
                            <a href="{{url('/post-job')}}">{{__('İlan Yayınla')}}</a>
                        </div>
                    @endif



                    <?php
    if ((bool) config('company.is_company_package_active')) {
        $packages = App\Package::where('package_for', 'like', 'employer')->get();
        $package = Auth::guard('company')->user()->getPackage();
                    ?>



                    <?php    if (null !== $package) { ?>
                    @include('includes.company_package_msg')
                    @include('includes.company_packages_upgrade')
                    <?php    } elseif (null !== $packages) { ?>
                    @include('includes.company_packages_new')
                    <?php    }
    } ?>



                    <div class="paypackages mt-5">
                        <!---four-plan-->
                        <?php 
                    $company = Auth::guard('company')->user();
    $currentPackage = $company->cvs_getPackage(); 
                ?>
                        @if(null !== $currentPackage)
                            @if(null !== ($currentPackage) && !empty($currentPackage))
                                <div class="instoretxt">

                                    <h3>{{__('Satın Alınan CV Paketi Detayları')}}</h3>
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th scope="col">{{ __('Paket Adı') }}</th>
                                                    <th scope="col">{{ __('Fiyat') }}</th>
                                                    <th scope="col">{{ __('Mevcut CV Kotası') }}</th>
                                                    <th scope="col">{{ __('Satın Alınma Tarihi') }}</th>
                                                    <th scope="col">{{ __('Paket Süresi Doldu') }}</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th>{{$currentPackage->package_title}}</th>
                                                    <td><strong>{{$currentPackage->package_price}} ₺</strong></td>
                                                    <td><strong>{{ $company->availed_cvs_quota ?? 0 }}</strong> /
                                                        <strong>{{$company->cvs_quota}}</strong>
                                                    </td>
                                                    <td><strong>{{Carbon\Carbon::parse($company->cvs_package_start_date)->translatedFormat('d F Y')}}</strong>
                                                    </td>
                                                    <td><strong>{{Carbon\Carbon::parse($company->cvs_package_end_date)->translatedFormat('d F Y')}}</strong>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>





                            @endif
                            <div class="four-plan">
                                <h3>{{__('CV Arama Paketini Yükselt')}}</h3>
                                <div class="row">
                                    <?php    $packages = App\Package::get(); ?>
                                    @foreach($packages as $package)
                                        @if($package->package_for == 'cv_search')
                                            <div class="col-12 col-sm-6 col-lg-4 package-card-col">
                                                <ul class="boxes">
                                                    <li class="plan-name">{{$package->package_title}}</li>
                                                    <li>
                                                        <div class="main-plan">
                                                            <div class="plan-price1-2">{{$package->package_price}} ₺</div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </li>
                                                    <li class="plan-pages"><i class="far fa-check-circle"></i>
                                                        {{__('Başvuran CV Görüntüleme')}} {{$package->package_num_listings}}</li>
                                                    <li class="plan-pages"><i class="far fa-check-circle"></i>
                                                        {{__('CV Görüntüleme Erişimi')}} {{$package->package_num_days}} {{__('Gün')}}
                                                    </li>
                                                    <li class="plan-pages"><i class="far fa-check-circle"></i>
                                                        {{__('Premium Destek 7/24')}}</li>

                                                    <li class="order paypal"><a href="javascript:void(0)" data-bs-toggle="modal"
                                                            data-bs-target="#buypack{{$package->id}}"
                                                            class="reqbtn">{{__('Şimdi Satın Al')}} <i
                                                                class="fas fa-arrow-right"></i></a></li>

                                                </ul>
                                            </div>


                                            <div class="modal fade" id="buypack{{$package->id}}" tabindex="-1" role="dialog"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">{{__('Şimdi Satın Al')}}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <div class="invitereval">
                                                                <h3>{{__('Ödeme Yönteminizi Seçin')}}</h3>

                                                                <div class="totalpay">{{__('Ödenecek Toplam Tutar')}}:
                                                                    <strong>{{$package->package_price}} ₺</strong>
                                                                </div>

                                                                <ul class="btn2s">

                                                                    @if((bool) $siteSetting->is_paytr_active)
                                                                        <li class="order p-2">
                                                                            <a href="{{route('paytr.order.package', ['package_id' => $package->id])}}">
                                                                                <i class="fas fa-credit-card" aria-hidden="true"></i>
                                                                                {{__('PayTR ile Öde')}}
                                                                            </a>
                                                                        </li>
                                                                    @endif
                                                                    @if((bool) $siteSetting->is_bank_transfer_active)
                                                                        <li class="order p-2">
                                                                            <a href="{{route('bank.transfer.order.package', ['package_id' => $package->id])}}">
                                                                                <i class="fas fa-university" aria-hidden="true"></i>
                                                                                {{__('Havale/EFT')}}
                                                                            </a>
                                                                        </li>
                                                                    @endif

                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="four-plan">
                                <h3>{{__('CV Arama Paketini Yükselt')}}</h3>
                                <div class="row">
                                    <?php    $packages = App\Package::get(); ?>
                                    @foreach($packages as $package)
                                        @if($package->package_for == 'cv_search')
                                            <div class="col-12 col-sm-6 col-lg-4 package-card-col">
                                                <ul class="boxes">
                                                    <li class="plan-name">{{$package->package_title}}</li>
                                                    <li>
                                                        <div class="main-plan">
                                                            <div class="plan-price1-2">{{$package->package_price}} ₺</div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </li>
                                                    <li class="plan-pages"><i class="far fa-check-circle"></i>
                                                        {{__('Başvuran CV Görüntüleme')}} {{$package->package_num_listings}}</li>
                                                    <li class="plan-pages"><i class="far fa-check-circle"></i>
                                                        {{__('CV Görüntüleme Erişimi')}} {{$package->package_num_days}} {{__('Gün')}}
                                                    </li>
                                                    <li class="plan-pages"><i class="far fa-check-circle"></i>
                                                        {{__('Premium Destek 7/24')}}</li>

                                                    <li class="order paypal"><a href="javascript:void(0)" data-bs-toggle="modal"
                                                            data-bs-target="#buypack{{$package->id}}"
                                                            class="reqbtn">{{__('Şimdi Satın Al')}} <i
                                                                class="fas fa-arrow-right"></i></a></li>

                                                </ul>
                                            </div>



                                            <div class="modal fade" id="buypack{{$package->id}}" tabindex="-1" role="dialog"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">{{__('Şimdi Satın Al')}}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <div class="invitereval">
                                                                <h3>{{__('Ödeme Yönteminizi Seçin')}}</h3>

                                                                <div class="totalpay">{{__('Ödenecek Toplam Tutar')}}:
                                                                    <strong>{{$package->package_price}} ₺</strong>
                                                                </div>

                                                                <ul class="btn2s">

                                                                    @if((bool) $siteSetting->is_paytr_active)
                                                                        <li class="order p-2">
                                                                            <a href="{{route('paytr.order.package', ['package_id' => $package->id])}}">
                                                                                <i class="fas fa-credit-card" aria-hidden="true"></i>
                                                                                {{__('PayTR ile Öde')}}
                                                                            </a>
                                                                        </li>
                                                                    @endif
                                                                    @if((bool) $siteSetting->is_bank_transfer_active)
                                                                        <li class="order p-2">
                                                                            <a href="{{route('bank.transfer.order.package', ['package_id' => $package->id])}}">
                                                                                <i class="fas fa-university" aria-hidden="true"></i>
                                                                                {{__('Havale/EFT')}}
                                                                            </a>
                                                                        </li>
                                                                    @endif

                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <!---end four-plan-->
                    </div>




                </div>
            </div>
        </div>
    </div>




    @include('includes.footer')

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @include('includes.immediate_available_btn')

@endpush