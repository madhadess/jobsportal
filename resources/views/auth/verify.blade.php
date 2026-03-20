@extends('layouts.app')
@section('content')
<!-- Header start -->
@include('includes.header')
<!-- Header end --> 
<!-- Header start -->
@include('includes.inner_page_title', ['page_title'=>__('E-posta Doğrulama')])
<!-- Header end -->



<div class="authpages">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="useraccountwrap">
                    <div class="userccount whitebg">
                   

                    <div class="card-body text-center">
                         <h3>{{ __('E-posta Adresinizi Doğrulayın') }}</h3>
                         
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('Doğrulama e-postası yeniden gönderildi, lütfen e-postanızı kontrol edin.') }}
                            </div>
                        @endif

                        <p>{{ __('Devam etmeden önce, lütfen e-postanızda doğrulama bağlantısını kontrol edin.') }} <br>
                        {{ __('E-postayı almadıysanız') }},
                        </p>
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-primary mt-3">{{ __('yeni bir tane istemek için tıklayın') }}</button>.
                        </form>
                    </div>
                     </div>
                </div>
            </div>
        </div>
    </div>
</div> 
    
    
@include('includes.footer')
@endsection


