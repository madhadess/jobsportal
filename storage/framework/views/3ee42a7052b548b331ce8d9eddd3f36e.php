<?php echo APFrmErrHelp::showErrorsNotice($errors); ?>

<?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="form-body">
    <fieldset>
        <legend>Ana Sayfa Slider:</legend>
        <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'is_slider_active'); ?>">
            <?php echo Form::label('is_slider_active', 'Ana Sayfa Slider Aktif mi?', ['class' => 'bold']); ?>

            <div class="radio-list">
                <label
                    class="radio-inline"><?php echo Form::radio('is_slider_active', 1, null, ['id' => 'is_slider_active_yes']); ?>

                    Evet </label>
                <label
                    class="radio-inline"><?php echo Form::radio('is_slider_active', 0, true, ['id' => 'is_slider_active_no']); ?>

                    Hayır </label>
            </div>
            <?php echo APFrmErrHelp::showErrors($errors, 'is_slider_active'); ?>

        </div>
    </fieldset>

</div><?php /**PATH /home/personelnoktasit/public_html/resources/views/admin/site_setting/forms/homePageSliderSetting_form.blade.php ENDPATH**/ ?>