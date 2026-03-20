<?php
$lang = config('default_lang');
if (isset($country))
    $lang = $country->lang;
$lang = MiscHelper::getLang($lang);
$direction = MiscHelper::getLangDirection($lang);
$queryString = MiscHelper::getLangQueryStr();
?>
{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'lang') !!}">
        {!! Form::label('lang', 'Dil', ['class' => 'bold']) !!}
        {!! Form::select('lang', ['' => 'Dil Seçin'] + $languages, $lang, array('class' => 'form-control', 'id' => 'lang', 'onchange' => 'setLang(this.value)')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'lang') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'country') !!}">
        {!! Form::label('country', 'Ülke', ['class' => 'bold']) !!}
        {!! Form::text('country', null, array('class' => 'form-control', 'id' => 'country', 'placeholder' => 'Ülke', 'dir' => $direction)) !!}
        {!! APFrmErrHelp::showErrors($errors, 'country') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'nationality') !!}">
        {!! Form::label('nationality', 'Uyruk', ['class' => 'bold']) !!}
        {!! Form::text('nationality', null, array('class' => 'form-control', 'id' => 'nationality', 'placeholder' => 'Uyruk', 'dir' => $direction)) !!}
        {!! APFrmErrHelp::showErrors($errors, 'nationality') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_default') !!}">
        {!! Form::label('is_default', 'Varsayılan mı?', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
$is_default_1 = 'checked="checked"';
$is_default_2 = '';
if (old('is_default', ((isset($country)) ? $country->is_default : 1)) == 0) {
    $is_default_1 = '';
    $is_default_2 = 'checked="checked"';
}
            ?>
            <label class="radio-inline">
                <input id="default" name="is_default" type="radio" value="1" {{$is_default_1}}
                    onchange="showHideCountryId();">
                Evet </label>
            <label class="radio-inline">
                <input id="not_default" name="is_default" type="radio" value="0" {{$is_default_2}}
                    onchange="showHideCountryId();">
                Hayır </label>
        </div>
        {!! APFrmErrHelp::showErrors($errors, 'is_default') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'country_id') !!}" id="country_id_div">
        {!! Form::label('country_id', 'Varsayılan Ülke', ['class' => 'bold']) !!}
        {!! Form::select('country_id', ['' => 'Varsayılan Ülke Seçin'] + $countries, null, array('class' => 'form-control', 'id' => 'country_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'country_id') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_active') !!}">
        {!! Form::label('is_active', 'Aktif', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
$is_active_1 = 'checked="checked"';
$is_active_2 = '';
if (old('is_active', ((isset($country)) ? $country->is_active : 1)) == 0) {
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
        function showHideCountryId() {
            $('#country_id_div').hide();
            var is_default = $("input[name='is_default']:checked").val();
            if (is_default == 0) {
                $('#country_id_div').show();
            }
        }
        showHideCountryId();
    </script>
@endpush