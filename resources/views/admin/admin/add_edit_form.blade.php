@if (count($errors) > 0)
    <div class="alert alert-danger">
        Girdiğiniz bilgilerde bazı sorunlar var.
    </div>
    @foreach ($errors->all() as $error)
        {{ $error }}<br />
    @endforeach
@endif

@include('flash::message')

<div class="form-body">
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'name') !!}">
        {!! Form::label('name', 'Ad Soyad', ['class' => 'bold']) !!}
        {!! Form::text('name', null, array('required', 'class' => 'form-control', 'placeholder' => 'Ad Soyad')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'name') !!}
    </div>

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'email') !!}">
        {!! Form::label('email', 'E-posta Adresi', ['class' => 'bold']) !!}
        {!! Form::text('email', null, array('required', 'class' => 'form-control', 'placeholder' => 'E-posta Adresi')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'email') !!}
    </div>

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'password') !!}">
        {!! Form::label('password', 'Şifre', ['class' => 'bold']) !!}
        {!! Form::password('password', array('required', 'class' => 'form-control', 'placeholder' => 'Şifre')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'password') !!}
    </div>

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'role_id') !!}">
        {!! Form::label('role', 'Rol', ['class' => 'bold']) !!}
        {!! Form::select('role_id', ['' => 'Rol Seçiniz'] + $roles, null, ['class' => 'form-control']) !!}
        {!! APFrmErrHelp::showErrors($errors, 'role_id') !!}
    </div>

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_manager') !!}">
        {!! Form::label('is_manager', 'Kullanıcı Tipi', ['class' => 'bold']) !!}
        <div class="radio-list">
            <label class="radio-inline">
                {!! Form::radio('is_manager', 0, true) !!} Personel
            </label>
            <label class="radio-inline">
                {!! Form::radio('is_manager', 1, false) !!} Yönetici / Müdür
            </label>
        </div>
        {!! APFrmErrHelp::showErrors($errors, 'is_manager') !!}
    </div>
</div>