<!-- resources/views/company/auth/verify.blade.php -->

@extends('layouts.app')
@section('content')
<!-- Header start -->
@include('includes.header')
<!-- Header end --> 
<!-- Header start -->
@include('includes.inner_page_title', ['page_title'=>__('E-posta Doğrulama')])
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('E-posta Adresinizi Doğrulayın') }}</div>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('Yeni bir doğrulama bağlantısı e-posta adresinize gönderildi.') }}
                            </div>
                        @endif

                        {{ __('Devam etmeden önce, lütfen e-postanızda doğrulama bağlantısını kontrol edin.') }}
                        {{ __('E-postayı almadıysanız') }},
                        <form class="d-inline" method="POST" action="{{ route('company.verification.resend') }}">
                            @csrf
                            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('yeni bir tane istemek için tıklayın') }}</button>.
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


