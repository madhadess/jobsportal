<?php
$lang = config('default_lang');
if (isset($gender))
    $lang = $gender->lang;
$lang = MiscHelper::getLang($lang);
$direction = MiscHelper::getLangDirection($lang);
$queryString = MiscHelper::getLangQueryStr();
?>
<?php echo APFrmErrHelp::showErrorsNotice($errors); ?>

<?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="form-body">
    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'lang'); ?>">
        <?php echo Form::label('lang', 'Dil', ['class' => 'bold']); ?>

        <?php echo Form::select('lang', ['' => 'Dil Seçin'] + $languages, $lang, array('class' => 'form-control', 'id' => 'lang', 'onchange' => 'setLang(this.value)')); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'lang'); ?>

    </div>
    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'gender'); ?>">
        <?php echo Form::label('gender', 'Cinsiyet', ['class' => 'bold']); ?>

        <?php echo Form::text('gender', null, array('class' => 'form-control', 'id' => 'gender', 'placeholder' => 'Cinsiyet', 'dir' => $direction)); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'gender'); ?>

    </div>
    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'is_default'); ?>">
        <?php echo Form::label('is_default', 'Varsayılan mı?', ['class' => 'bold']); ?>

        <div class="radio-list">
            <?php
$is_default_1 = 'checked="checked"';
$is_default_2 = '';
if (old('is_default', ((isset($gender)) ? $gender->is_default : 1)) == 0) {
    $is_default_1 = '';
    $is_default_2 = 'checked="checked"';
}
            ?>
            <label class="radio-inline">
                <input id="default" name="is_default" type="radio" value="1" <?php echo e($is_default_1); ?>

                    onchange="showHideGenderId();">
                Evet </label>
            <label class="radio-inline">
                <input id="not_default" name="is_default" type="radio" value="0" <?php echo e($is_default_2); ?>

                    onchange="showHideGenderId();">
                Hayır </label>
        </div>
        <?php echo APFrmErrHelp::showErrors($errors, 'is_default'); ?>

    </div>
    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'gender_id'); ?>" id="gender_id_div">
        <?php echo Form::label('gender_id', 'Varsayılan Cinsiyet', ['class' => 'bold']); ?>

        <?php echo Form::select('gender_id', ['' => 'Varsayılan Cinsiyet Seçin'] + $genders, null, array('class' => 'form-control', 'id' => 'gender_id')); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'gender_id'); ?>

    </div>
    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'is_active'); ?>">
        <?php echo Form::label('is_active', 'Aktif', ['class' => 'bold']); ?>

        <div class="radio-list">
            <?php
$is_active_1 = 'checked="checked"';
$is_active_2 = '';
if (old('is_active', ((isset($gender)) ? $gender->is_active : 1)) == 0) {
    $is_active_1 = '';
    $is_active_2 = 'checked="checked"';
}
            ?>
            <label class="radio-inline">
                <input id="Aktif" name="is_active" type="radio" value="1" <?php echo e($is_active_1); ?>>
                Aktif </label>
            <label class="radio-inline">
                <input id="not_active" name="is_active" type="radio" value="0" <?php echo e($is_active_2); ?>>
                Pasif </label>
        </div>
        <?php echo APFrmErrHelp::showErrors($errors, 'is_active'); ?>

    </div>
    <div class="form-Actionler">
        <?php echo Form::button('Güncelle <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>', array('class' => 'btn btn-large btn-primary', 'type' => 'submit')); ?>

    </div>
</div>
<?php $__env->startPush('scripts'); ?>
    <script type="text/javascript">
        function setLang(lang) {
            window.location.href = "<?php echo url(Request::url()) . $queryString; ?>" + lang;
        }
        function showHideGenderId() {
            $('#gender_id_div').hide();
            var is_default = $("input[name='is_default']:checked").val();
            if (is_default == 0) {
                $('#gender_id_div').show();
            }
        }
        showHideGenderId();
    </script>
<?php $__env->stopPush(); ?><?php /**PATH /home/personelnoktasit/public_html/resources/views/admin/gender/forms/form.blade.php ENDPATH**/ ?>