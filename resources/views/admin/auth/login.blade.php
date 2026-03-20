@extends('admin.layouts.login_layout')
@section('content')
<div class="login-title">
    <h2>Hoş Geldiniz</h2>
    <p>Devam etmek için giriş yapın</p>
</div>

@if ($errors->has('email'))
<div class="alert alert-danger">
    <i class="fa fa-exclamation-circle"></i> {{ $errors->first('email') }}
</div>
@endif

@if ($errors->has('password'))
<div class="alert alert-danger">
    <i class="fa fa-exclamation-circle"></i> {{ $errors->first('password') }}
</div>
@endif

<form method="POST" action="{{ route('admin.login') }}">
    {{ csrf_field() }}
    
    <div class="form-group">
        <label for="email">E-Posta Adresi</label>
        <div class="input-icon">
            <i class="fa fa-envelope"></i>
            <input type="email" class="form-control" id="email" name="email" placeholder="ornek@email.com" value="{{ old('email') }}" required autofocus>
        </div>
    </div>
    
    <div class="form-group">
        <label for="password">Şifre</label>
        <div class="input-icon">
            <i class="fa fa-lock"></i>
            <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
        </div>
    </div>
    
    <button type="submit" class="btn-login">
        <i class="fa fa-sign-in"></i> Giriş Yap
    </button>
    
    <div class="form-footer">
        <label class="remember-me">
            <input type="checkbox" name="remember"> Beni Hatırla
        </label>
        <a href="{{ route('admin.password.request') }}" class="forgot-password">Şifremi Unuttum?</a>
    </div>
</form>
@endsection







