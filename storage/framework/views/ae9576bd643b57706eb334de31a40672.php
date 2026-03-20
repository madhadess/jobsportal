<?php
$lang = config('default_lang');
if (isset($state))
    $lang = $state->lang;
$lang = MiscHelper::getLang($lang);
$direction = MiscHelper::getLangDirection($lang);
$queryString = MiscHelper::getLangQueryStr();
?>
<?php echo APFrmErrHelp::showErrorsNotice($errors); ?>

<?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="form-body">
    <?php echo Form::hidden('id', null); ?>

    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'lang'); ?>" id="lang_div">
        <?php echo Form::label('lang', 'Dil', ['class' => 'bold']); ?>

        <?php echo Form::select('lang', ['' => 'Dil Seçin'] + $languages, $lang, array('class' => 'form-control', 'id' => 'lang', 'onchange' => 'setLang(this.value);')); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'lang'); ?>

    </div>
    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'country_id'); ?>" id="country_id_div">
        <?php echo Form::label('country_id', 'Ülke', ['class' => 'bold']); ?>

        <?php echo Form::select('country_id', ['' => 'Ülke Seçin'] + $countries, old('country_id', (isset($state)) ? $state->country_id : $siteSetting->default_country_id), array('class' => 'form-control', 'id' => 'country_id', 'onchange' => 'filterDefaultStates(0);')); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'country_id'); ?>

    </div>
    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'state'); ?>">
        <?php echo Form::label('state', 'Eyalet', ['class' => 'bold']); ?>

        <?php echo Form::text('state', null, array('class' => 'form-control', 'id' => 'state', 'placeholder' => 'Eyalet', 'dir' => $direction)); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'state'); ?>

    </div>
    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'is_default'); ?>">
        <?php echo Form::label('is_default', 'Varsayılan mı?', ['class' => 'bold']); ?>

        <div class="radio-list">
            <?php
$is_default_1 = 'checked="checked"';
$is_default_2 = '';
if (old('is_default', ((isset($state)) ? $state->is_default : 1)) == 0) {
    $is_default_1 = '';
    $is_default_2 = 'checked="checked"';
}
            ?>
            <label class="radio-inline">
                <input id="default" name="is_default" type="radio" value="1" <?php echo e($is_default_1); ?>

                    onchange="showHideStateId();">
                Evet </label>
            <label class="radio-inline">
                <input id="not_default" name="is_default" type="radio" value="0" <?php echo e($is_default_2); ?>

                    onchange="showHideStateId();">
                Hayır </label>
        </div>
        <?php echo APFrmErrHelp::showErrors($errors, 'is_default'); ?>

    </div>
    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'state_id'); ?>" id="state_id_div">
        <?php echo Form::label('state_id', 'Varsayılan Eyalet', ['class' => 'bold']); ?>

        <span id="default_state_dd">
            <?php echo Form::select('state_id', ['' => 'Varsayılan Eyalet Seçin'], null, array('class' => 'form-control', 'id' => 'state_id')); ?>

        </span>
        <?php echo APFrmErrHelp::showErrors($errors, 'state_id'); ?>

    </div>
    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'is_active'); ?>">
        <?php echo Form::label('is_active', 'Aktif mi?', ['class' => 'bold']); ?>

        <div class="radio-list">
            <?php
$is_active_1 = 'checked="checked"';
$is_active_2 = '';
if (old('is_active', ((isset($state)) ? $state->is_active : 1)) == 0) {
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
        function showHideStateId() {
            $('#state_id_div').hide();
            var is_default = $("input[name='is_default']:checked").val();
            if (is_default == 0) {
                $('#state_id_div').show();
            }
        }
        showHideStateId();
        function filterDefaultStates(state_id) {
            var country_id = $('#country_id').val();
            if (country_id != '') {
                $.post("<?php echo e(route('filter.default.states.dropdown')); ?>", { country_id: country_id, state_id: state_id, _method: 'POST', _token: '<?php echo e(csrf_token()); ?>' })
                    .done(function (response) {
                        $('#default_state_dd').html(response);
                    });
            }
        }
        filterDefaultStates(<?php echo old('state_id', (isset($state)) ? $state->state_id : 0); ?>);
    </script>
<?php $__env->stopPush(); ?><?php /**PATH /home/personelnoktasit/public_html/resources/views/admin/state/forms/form.blade.php ENDPATH**/ ?>