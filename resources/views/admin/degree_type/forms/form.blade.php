<?php
$lang = config('default_lang');
if (isset($degreeType))
    $lang = $degreeType->lang;
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
        {!! Form::select('lang', ['' => 'Dil Seçin'] + $languages, $lang, array('class' => 'form-control', 'id' => 'lang', 'onchange' => 'setLang(this.value)')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'lang') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'degree_level_id') !!}" id="degree_level_id_div">
        {!! Form::label('degree_level_id', 'Diploma Seviyesi', ['class' => 'bold']) !!}
        {!! Form::select('degree_level_id', ['' => 'Diploma Seviyesi Seçin'] + $degreeLevels, null, array('class' => 'form-control', 'id' => 'degree_level_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'degree_level_id') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'degree_type') !!}">
        {!! Form::label('degree_type', 'Diploma Türü', ['class' => 'bold']) !!}
        {!! Form::text('degree_type', null, array('class' => 'form-control', 'id' => 'degree_type', 'placeholder' => 'Diploma Türü', 'dir' => $direction)) !!}
        {!! APFrmErrHelp::showErrors($errors, 'degree_type') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_default') !!}">
        {!! Form::label('is_default', 'Varsayılan mı?', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
$is_default_1 = 'checked="checked"';
$is_default_2 = '';
if (old('is_default', ((isset($degreeType)) ? $degreeType->is_default : 1)) == 0) {
    $is_default_1 = '';
    $is_default_2 = 'checked="checked"';
}
            ?>
            <label class="radio-inline">
                <input id="default" name="is_default" type="radio" value="1" {{$is_default_1}}
                    onchange="showHideDegreeTypeId();">
                Evet </label>
            <label class="radio-inline">
                <input id="not_default" name="is_default" type="radio" value="0" {{$is_default_2}}
                    onchange="showHideDegreeTypeId();">
                Hayır </label>
        </div>
        {!! APFrmErrHelp::showErrors($errors, 'is_default') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'degree_type_id') !!}" id="degree_type_id_div">
        {!! Form::label('degree_type_id', 'Varsayılan Diploma Türü', ['class' => 'bold']) !!}
        {!! Form::select('degree_type_id', ['' => 'Varsayılan Diploma Türü Seçin'] + $degreeTypes, null, array('class' => 'form-control', 'id' => 'degree_type_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'degree_type_id') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_active') !!}">
        {!! Form::label('is_active', 'Aktif mi?', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
$is_active_1 = 'checked="checked"';
$is_active_2 = '';
if (old('is_active', ((isset($degreeType)) ? $degreeType->is_active : 1)) == 0) {
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
        function showHideDegreeTypeId() {
            $('#degree_type_id_div').hide();
            var is_default = $("input[name='is_default']:checked").val();
            if (is_default == 0) {
                $('#degree_type_id_div').show();
            }
        }
        showHideDegreeTypeId();
    </script>
@endpush