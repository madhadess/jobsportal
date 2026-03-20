@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <main>
        <!-- Inner Page Title start -->
        @include('includes.inner_page_title', ['page_title' => __('User Verification')])
        <!-- Inner Page Title end -->
        <!-- Page Title start -->
        <!-- Page Title End -->
        <div class="listpgWraper">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-md-offset-3">
                        <div class="userccount">
                            @if (session('resent'))
                                <div class="alert alert-success" role="alert">
                                    <i class="fa fa-check-circle"></i>
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </div>
                            @endif

                            <div class="text-center" style="margin-bottom: 30px;">
                                <i class="fa fa-envelope-o" style="font-size: 60px; color: #2e6da4;"></i>
                                <h3 style="margin-top: 20px;">{{ __('User Verification') }}</h3>
                                <p class="text-muted">{{ __('Verify your email address to access all features.') }}</p>
                            </div>

                            <div class="formpanel">
                                <div class="formrow text-center">
                                    <p style="font-size: 15px; color: #555;">
                                        {{ __('For your account security, a verification link has been sent to:') }}
                                        <br>
                                        <strong
                                            style="color: #333; font-size: 16px;">{{ optional(auth()->user())->email ?? optional(auth()->guard('company')->user())->email }}</strong>
                                    </p>
                                    <p class="text-muted">
                                        {{ __('If you have not received the email, please check your spam folder or click the button below.') }}
                                    </p>
                                </div>
                                <div class="formrow text-center">
                                    <form method="POST" action="{{ route('verification.resend') }}">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-block"
                                            style="padding: 12px 30px; font-size: 16px; font-weight: 600;">
                                            <i class="fa fa-paper-plane"></i> {{ __('Resend Verification Email') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection