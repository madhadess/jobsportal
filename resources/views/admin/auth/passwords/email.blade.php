@extends('admin.layouts.login_layout')
@section('content') 
<!-- BEGIN LOGIN -->
<div class="content"> 
    <!-- BEGIN FORGOT PASSWORD FORM --> 
    @if (session('status'))
    <div class="note note-info">
        <h4 class="block">E-posta Gönderildi!</h4>
        <p> Şifre sıfırlama bağlantısı içeren bir e-posta, verdiğiniz e-posta adresine gönderildi. </p>
    </div>
    @else
    <form class="form-horizontal forget-form" role="form" method="POST" Action="{{ route('admin.password.email') }}" style="display:block;">
        {{ csrf_field() }}
        <h3 class="font-green">Şifrenizi mi Unuttunuz?</h3>
        <p> Şifrenizi sıfırlamak için aşağıya e-posta adresinizi girin. </p>
        <div class="alert alert-danger display-hide">
            <button class="close" data-close="alert"></button>
            <span> Lütfen e-posta girin. </span> </div>
        @if ($errors->has('email'))
        <div class="alert alert-danger">
            <button class="close" data-close="alert"></button>
            <span>{{ $errors->first('email') }}</span> </div>
        @endif
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}"> 
            <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
            <label class="control-label visible-ie8 visible-ie9">E-posta Adresi</label>
            <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="E-posta Adresi" name="email" value="{{old('email')}}" />
        </div>
        <div class="form-Actionler">
            <button type="submit" class="btn btn-success uppercase pull-right">Şifre Sıfırlama Bağlantısı Gönder</button>
        </div>
    </form>
    @endif 
    <!-- END FORGOT PASSWORD FORM --> 
</div>
@endsection







