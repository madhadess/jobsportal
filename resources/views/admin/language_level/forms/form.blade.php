<?php
$lang = config('default_lang');
if (isset($languageLevel))
    $lang = $languageLevel->lang;
$lang = MiscHelper::getLang($lang);
$direction = MiscHelper::getLangDirection($lang);
$queryString = MiscHelper::getLangQueryStr();
?>
{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    {!! Form::hidden('id', null) !!}
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'lang') !!}" id="lang_div">
        {!! Form::label('lang', 'Dil', ['class' => 'bold']) !!}
        {!! Form::select('lang', ['' => 'Dil Seçin'] + $languages, $lang, array('class' => 'form-control', 'id' => 'lang')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'lang') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'language_level') !!}">
        {!! Form::label('language_level', 'Dil Seviyesi', ['class' => 'bold']) !!}
        {!! Form::text('language_level', null, array('class' => 'form-control', 'id' => 'language_level', 'placeholder' => 'Dil Seviyesi', 'dir' => $direction)) !!}
        {!! APFrmErrHelp::showErrors($errors, 'language_level') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_default') !!}">
        {!! Form::label('is_default', 'Varsayılan mı?', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
$is_default_1 = 'checked="checked"';
$is_default_2 = '';
if (old('is_default', ((isset($languageLevel)) ? $languageLevel->is_default : 1)) == 0) {
    $is_default_1 = '';
    $is_default_2 = 'checked="checked"';
}
            ?>
            <label class="radio-inline">
                <input id="default" name="is_default" type="radio" value="1" {{$is_default_1}}
                    onchange="showHideLanguageLevelId();">
                Evet </label>
            <label class="radio-inline">
                <input id="not_default" name="is_default" type="radio" value="0" {{$is_default_2}}
                    onchange="showHideLanguageLevelId();">
                Hayır </label>
        </div>
        {!! APFrmErrHelp::showErrors($errors, 'is_default') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'language_level_id') !!}" id="language_level_id_div">
        {!! Form::label('language_level_id', 'Varsayılan Dil Seviyesi', ['class' => 'bold']) !!}
        {!! Form::select('language_level_id', ['' => 'Varsayılan Dil Seviyesi Seçin'] + $languageLevels, null, array('class' => 'form-control', 'id' => 'language_level_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'language_level_id') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_active') !!}">
        {!! Form::label('is_active', 'Aktif mi?', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
$is_active_1 = 'checked="checked"';
$is_active_2 = '';
if (old('is_active', ((isset($languageLevel)) ? $languageLevel->is_active : 1)) == 0) {
    $is_active_1 = '';
    $is_active_2 = 'checked="checked"';
}
            ?>
            <label class="radio-inline">
                <input id="Aktif" name="is_active" type="radio" value="1" {{$is_active_1}}>
                Aktif </label>
            <label class="radio-inline">
                <input id="not_active" name="is_active" type="radio" value="0" {{$is_active_2}}>
                Pasif </label>
        </div>
        {!! APFrmErrHelp::showErrors($errors, 'is_active') !!}
    </div>
    <div class="form-Actionler">
        {!! Form::button('Güncelle <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>', array('class' => 'btn btn-large btn-primary', 'type' => 'submit')) !!}
    </div>
</div>
@push('scripts')
    <script type="text/javascript">
        function setLang(lang) {
            window.location.href = "<?php echo url(Request::url()) . $queryString; ?>" + lang;
        }
        function showHideLanguageLevelId() {
            $('#language_level_id_div').hide();
            var is_default = $("input[name='is_default']:checked").val();
            if (is_default == 0) {
                $('#language_level_id_div').show();
            }
        }
        showHideLanguageLevelId();
    </script>
@endpush