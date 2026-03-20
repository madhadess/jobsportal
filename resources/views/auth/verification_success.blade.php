@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title' => __('User Verification')])
    <!-- Inner Page Title end -->
    <div class="listpgWraper">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="userccount">
                    <div class="text-center" style="padding: 40px 20px;">
                        <div style="margin-bottom: 25px;">
                            <i class="fa fa-check-circle" style="font-size: 80px; color: #5cb85c;"></i>
                        </div>
                        <h3 style="color: #333; margin-bottom: 15px;">{{__('Verification Successful')}}</h3>
                        <p class="text-success" style="font-size: 18px; margin-bottom: 20px;">
                            {{__('Your account has been verified successfully!')}}
                        </p>
                        <p class="text-muted" style="margin-bottom: 30px;">
                            {{__('Redirecting you to login page...')}}
                        </p>

                        @php
                            $loginRoute = request('role') == 'company' ? route('company.login') : route('login');
                        @endphp
                        <a href="{{ $loginRoute }}" class="btn btn-primary btn-lg px-5">
                            {{__('Login Now')}}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <script>
        setTimeout(function () {
            window.location.href = "{{ $loginRoute }}";
        }, 5000); // 5 seconds delay
    </script>
@endsection