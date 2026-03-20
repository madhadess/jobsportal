<?php echo APFrmErrHelp::showErrorsNotice($errors); ?>

<?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="form-body">
    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'mail_driver'); ?>">
        <?php echo Form::label('mail_driver', 'Mail Sürücüsü', ['class' => 'bold']); ?>                    
        <?php echo Form::select('mail_driver',$mail_drivers, null, array('class'=>'form-control', 'id'=>'mail_driver')); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'mail_driver'); ?>                                       
    </div>
    <br>
    <fieldset>
        <legend>SMTP Ayarları:</legend>    
        <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'mail_host'); ?>">
            <?php echo Form::label('mail_host', 'Mail Sunucusu', ['class' => 'bold']); ?>                    
            <?php echo Form::text('mail_host', null, array('class'=>'form-control', 'id'=>'mail_host', 'placeholder'=>'Mail Sunucusu')); ?>

            <?php echo APFrmErrHelp::showErrors($errors, 'mail_host'); ?>                                       
        </div>    
        <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'mail_port'); ?>">
            <?php echo Form::label('mail_port', 'Mail Portu', ['class' => 'bold']); ?>                    
            <?php echo Form::text('mail_port', null, array('class'=>'form-control', 'id'=>'mail_port', 'placeholder'=>'Mail Portu')); ?>

            <?php echo APFrmErrHelp::showErrors($errors, 'mail_port'); ?>                                       
        </div>    
        <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'mail_encryption'); ?>">
            <?php echo Form::label('mail_encryption', 'Mail Şifreleme', ['class' => 'bold']); ?>                    
            <?php echo Form::text('mail_encryption', null, array('class'=>'form-control', 'id'=>'mail_encryption', 'placeholder'=>'Mail Şifreleme')); ?>

            <?php echo APFrmErrHelp::showErrors($errors, 'mail_encryption'); ?>                                       
        </div>
        <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'mail_username'); ?>">
            <?php echo Form::label('mail_username', 'Mail Kullanıcı Adı', ['class' => 'bold']); ?>                    
            <?php echo Form::text('mail_username', null, array('class'=>'form-control', 'id'=>'mail_username', 'placeholder'=>'Mail Kullanıcı Adı')); ?>

            <?php echo APFrmErrHelp::showErrors($errors, 'mail_username'); ?>                                       
        </div>
        <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'mail_password'); ?>">
            <?php echo Form::label('mail_password', 'Mail Şifresi', ['class' => 'bold']); ?>                    
            <?php echo Form::text('mail_password', null, array('class'=>'form-control', 'id'=>'mail_password', 'placeholder'=>'Mail Şifresi')); ?>

            <?php echo APFrmErrHelp::showErrors($errors, 'mail_password'); ?>                                       
        </div>
    </fieldset>
    

   
   
    
</div>







<?php /**PATH /home/personelnoktasit/public_html/resources/views/admin/site_setting/forms/siteEmailSetting_form.blade.php ENDPATH**/ ?>