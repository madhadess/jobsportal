@if((bool) config('jobseeker.is_jobseeker_package_active') && $packages->count())
    <div class="paypackages">
        <!---four-paln-->
        <div class="four-plan">
            <h3>{{__('Upgrade Jobseeker Packages')}}</h3>
            <div class="row">
                @foreach($packages as $package)
                    <div class="col-md-4 col-sm-6 col-xs-12">
                        <ul class="boxes">
                            <li class="icon"><i class="fa fa-paper-plane" aria-hidden="true"></i></li>
                            <li class="plan-name">{{$package->package_title}}</li>
                            <li>
                                <div class="main-plan">
                                    @if($package->package_price == 0)
                                        <div class="plan-price1-2">ÜCRETSİZ</div>
                                    @else
                                        <div class="plan-price1-2">{{$package->package_price}}</div>
                                        <div class="plan-price1-1">₺</div>
                                    @endif
                                    <div class="clearfix"></div>
                                </div>
                            </li>
                            <li class="plan-pages">{{__('Can apply on jobs')}} : {{$package->package_num_listings}}</li>
                            <li class="plan-pages">{{__('Package Duration')}} : {{$package->package_num_days}} {{__('Days')}}</li>
                            @if($package->package_price > 0)
                                <li class="order paypal"><a href="{{route('order.upgrade.package', $package->id)}}"><i
                                            class="fas fa-credit-card" aria-hidden="true"></i> {{__('Upgrade Now')}}</a></li>
                            @else
                                <li class="order paypal"><a href="{{route('order.free.package', $package->id)}}"><i class="fas fa-check" aria-hidden="true"></i> {{__('Upgrade Free')}}</a></li>
                            @endif
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
        <!---end four-paln-->
    </div>
@endif