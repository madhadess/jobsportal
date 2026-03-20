{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'mail_driver') !!}">
        {!! Form::label('mail_driver', 'Mail Sürücüsü', ['class' => 'bold']) !!}                    
        {!! Form::select('mail_driver',$mail_drivers, null, array('class'=>'form-control', 'id'=>'mail_driver')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'mail_driver') !!}                                       
    </div>
    <br>
    <fieldset>
        <legend>SMTP Ayarları:</legend>    
        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'mail_host') !!}">
            {!! Form::label('mail_host', 'Mail Sunucusu', ['class' => 'bold']) !!}                    
            {!! Form::text('mail_host', null, array('class'=>'form-control', 'id'=>'mail_host', 'placeholder'=>'Mail Sunucusu')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'mail_host') !!}                                       
        </div>    
        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'mail_port') !!}">
            {!! Form::label('mail_port', 'Mail Portu', ['class' => 'bold']) !!}                    
            {!! Form::text('mail_port', null, array('class'=>'form-control', 'id'=>'mail_port', 'placeholder'=>'Mail Portu')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'mail_port') !!}                                       
        </div>    
        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'mail_encryption') !!}">
            {!! Form::label('mail_encryption', 'Mail Şifreleme', ['class' => 'bold']) !!}                    
            {!! Form::text('mail_encryption', null, array('class'=>'form-control', 'id'=>'mail_encryption', 'placeholder'=>'Mail Şifreleme')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'mail_encryption') !!}                                       
        </div>
        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'mail_username') !!}">
            {!! Form::label('mail_username', 'Mail Kullanıcı Adı', ['class' => 'bold']) !!}                    
            {!! Form::text('mail_username', null, array('class'=>'form-control', 'id'=>'mail_username', 'placeholder'=>'Mail Kullanıcı Adı')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'mail_username') !!}                                       
        </div>
        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'mail_password') !!}">
            {!! Form::label('mail_password', 'Mail Şifresi', ['class' => 'bold']) !!}                    
            {!! Form::text('mail_password', null, array('class'=>'form-control', 'id'=>'mail_password', 'placeholder'=>'Mail Şifresi')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'mail_password') !!}                                       
        </div>
    </fieldset>
    

   
   
    
</div>







