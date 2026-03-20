@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->

    <div class="authpages">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-5">
                    @include('flash::message')
                    <div class="useraccountwrap">
                        <div class="userccount whitebg">
                            <div class="tab-content">
                                <div id="member" class="formpanel mt-0 tab-pane active">
                                    <h3 class="text-center">{{__('Hizmet Almak İçin Kaydol')}}</h3>
                                    <p class="text-center">
                                        {{__('Hizmet taleplerinizi yönetmek için üyeliğinizi hemen oluşturun.')}}
                                    </p>

                                    <form class="form-horizontal mt-3" method="POST" action="{{ route('register') }}">
                                        @csrf
                                        <input type="hidden" name="user_type" value="member" />

                                        <div class="formrow{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                            <input type="text" name="first_name" class="form-control" required="required"
                                                placeholder="{{__('Adınız')}}" value="{{old('first_name')}}">
                                            @if ($errors->has('first_name')) <span class="help-block">
                                            <strong>{{ $errors->first('first_name') }}</strong> </span> @endif
                                        </div>

                                        <div class="formrow{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                            <input type="text" name="last_name" class="form-control" required="required"
                                                placeholder="{{__('Soyadınız')}}" value="{{old('last_name')}}">
                                            @if ($errors->has('last_name')) <span class="help-block">
                                            <strong>{{ $errors->first('last_name') }}</strong> </span> @endif
                                        </div>

                                        <div class="formrow{{ $errors->has('email') ? ' has-error' : '' }}">
                                            <input type="email" name="email" class="form-control" required="required"
                                                placeholder="{{__('E-posta Adresiniz')}}" value="{{old('email')}}">
                                            @if ($errors->has('email')) <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong> </span> @endif
                                        </div>

                                        <div class="formrow{{ $errors->has('password') ? ' has-error' : '' }}">
                                            <input type="password" name="password" class="form-control" required="required"
                                                placeholder="{{__('Şifre')}}" value="">
                                            @if ($errors->has('password')) <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong> </span> @endif
                                        </div>

                                        <div class="formrow{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                            <input type="password" name="password_confirmation" class="form-control"
                                                required="required" placeholder="{{__('Şifre Onayı')}}" value="">
                                            @if ($errors->has('password_confirmation')) <span class="help-block">
                                                <strong>{{ $errors->first('password_confirmation') }}</strong> </span>
                                            @endif
                                        </div>

                                        <div class="formrow{{ $errors->has('terms_of_use') ? ' has-error' : '' }}">
                                            <input type="checkbox" value="1" name="terms_of_use" id="terms_of_use"
                                                required />
                                            <label for="terms_of_use"><a href="{{url('cms/kullanim-kosullari')}}"
                                                    target="_blank">{{__('Kullanım Şartlarını kabul ediyorum')}}</a></label>
                                            @if ($errors->has('terms_of_use')) <span class="help-block">
                                            <strong>{{ $errors->first('terms_of_use') }}</strong> </span> @endif
                                        </div>

                                        <input type="submit" class="btn btn-primary w-100" value="{{__('Üye Ol')}}">
                                    </form>
                                </div>
                            </div>
                            <div class="newuser text-center mt-3">
                                {{__('Zaten hesabınız var mı?')}} <a href="{{route('login')}}">{{__('Giriş Yap')}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('includes.footer')
@endsection