<?php echo APFrmErrHelp::showErrorsNotice($errors); ?>

<?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="form-body">        
    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'facebook_app_id'); ?>">
        <?php echo Form::label('facebook_app_id', 'Facebook App ID', ['class' => 'bold']); ?>                    
        <?php echo Form::text('facebook_app_id', null, array('class'=>'form-control', 'id'=>'facebook_app_id', 'placeholder'=>'Facebook App ID')); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'facebook_app_id'); ?>                                       
    </div>    
    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'facebeek_app_secret'); ?>">
        <?php echo Form::label('facebeek_app_secret', 'Facebeek App Secret', ['class' => 'bold']); ?>                    
        <?php echo Form::text('facebeek_app_secret', null, array('class'=>'form-control', 'id'=>'facebeek_app_secret', 'placeholder'=>'Facebeek App Secret')); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'facebeek_app_secret'); ?>                                       
    </div>    
    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'twitter_app_id'); ?>">
        <?php echo Form::label('twitter_app_id', 'Twitter App ID', ['class' => 'bold']); ?>                    
        <?php echo Form::text('twitter_app_id', null, array('class'=>'form-control', 'id'=>'twitter_app_id', 'placeholder'=>'Twitter App ID')); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'twitter_app_id'); ?>                                       
    </div>    
    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'twitter_app_secret'); ?>">
        <?php echo Form::label('twitter_app_secret', 'Twitter App Secret', ['class' => 'bold']); ?>                    
        <?php echo Form::text('twitter_app_secret', null, array('class'=>'form-control', 'id'=>'twitter_app_secret', 'placeholder'=>'Twitter App Secret')); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'twitter_app_secret'); ?>                                       
    </div>
    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'google_app_id'); ?>">
        <?php echo Form::label('google_app_id', 'Google App ID', ['class' => 'bold']); ?>                    
        <?php echo Form::text('google_app_id', null, array('class'=>'form-control', 'id'=>'google_app_id', 'placeholder'=>'Google App ID')); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'google_app_id'); ?>                                       
    </div>    
    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'google_app_secret'); ?>">
        <?php echo Form::label('google_app_secret', 'Google App Secret', ['class' => 'bold']); ?>                    
        <?php echo Form::text('google_app_secret', null, array('class'=>'form-control', 'id'=>'google_app_secret', 'placeholder'=>'Google App Secret')); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'google_app_secret'); ?>                                       
    </div>

</div>







<?php /**PATH /home/personelnoktasit/public_html/resources/views/admin/site_setting/forms/socialMediaLoginSetting_form.blade.php ENDPATH**/ ?>