<div class="instoretxt">
    <div class="credit">{{__('Your Package is')}}: <strong>{{$package->package_title}} -
            {{$package->package_price}} {{ $siteSetting->default_currency_code ?? '₺' }}</strong></div>
    <div class="credit">{{__('Package Duration')}} :
        <strong>{{ \Carbon\Carbon::parse(Auth::user()->package_start_date)->translatedFormat('d F Y') }}</strong> -
        <strong>{{ \Carbon\Carbon::parse(Auth::user()->package_end_date)->translatedFormat('d F Y') }}</strong></div>

    <div class="credit">Kullanılan kota : <strong>{{Auth::user()->availed_jobs_quota}}</strong> /
        <strong>{{Auth::user()->jobs_quota}}</strong></div>

</div>