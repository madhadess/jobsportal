<?php echo APFrmErrHelp::showErrorsNotice($errors); ?>

<?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="form-body">
    <fieldset>
        <legend>Analytics Kodu Girin:</legend>
        <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'ganalytics'); ?>">

            <?php echo Form::textarea('ganalytics', null, array('class' => 'form-control', 'contenteditable' => 'true', 'id' => 'ganalytics', 'placeholder' => 'Analytics Kodunu Buraya Ekleyin')); ?>



            <?php echo APFrmErrHelp::showErrors($errors, 'ganalytics'); ?>

        </div>
    </fieldset>


    <fieldset>
        <legend>Head İçin Google Tag Manager:</legend>
        <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'google_tag_manager_for_head'); ?>">

            <?php echo Form::textarea('google_tag_manager_for_head', null, array('class' => 'form-control', 'contenteditable' => 'true', 'id' => 'google_tag_manager_for_head', 'placeholder' => 'Head için Google Tag Manager Kodunu Buraya Ekleyin')); ?>



            <?php echo APFrmErrHelp::showErrors($errors, 'google_tag_manager_for_head'); ?>

        </div>
    </fieldset>

    <fieldset>
        <legend>Body İçin Google Tag Manager:</legend>
        <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'google_tag_manager_for_body'); ?>">

            <?php echo Form::textarea('google_tag_manager_for_body', null, array('class' => 'form-control', 'contenteditable' => 'true', 'id' => 'google_tag_manager_for_body', 'placeholder' => 'Body için Google Tag Manager Kodunu Buraya Ekleyin')); ?>



            <?php echo APFrmErrHelp::showErrors($errors, 'google_tag_manager_for_body'); ?>

        </div>
    </fieldset>

</div><?php /**PATH /home/personelnoktasit/public_html/resources/views/admin/site_setting/forms/googleAnalytics_form.blade.php ENDPATH**/ ?>