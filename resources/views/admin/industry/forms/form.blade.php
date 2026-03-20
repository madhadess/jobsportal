<?php
$lang = config('default_lang');
if (isset($industry))
    $lang = $industry->lang;
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
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'industry') !!}">
        {!! Form::label('industry', 'Sektör', ['class' => 'bold']) !!}
        {!! Form::text('industry', null, array('class' => 'form-control', 'id' => 'industry', 'placeholder' => 'Sektör', 'dir' => $direction)) !!}
        {!! APFrmErrHelp::showErrors($errors, 'industry') !!}
    </div>




    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_default') !!}">
        {!! Form::label('is_default', 'Varsayılan mı?', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
$is_default_1 = 'checked="checked"';
$is_default_2 = '';
if (old('is_default', ((isset($industry)) ? $industry->is_default : 1)) == 0) {
    $is_default_1 = '';
    $is_default_2 = 'checked="checked"';
}
            ?>
            <label class="radio-inline">
                <input id="default" name="is_default" type="radio" value="1" {{$is_default_1}}
                    onchange="showHideIndustryId();">
                Evet </label>
            <label class="radio-inline">
                <input id="not_default" name="is_default" type="radio" value="0" {{$is_default_2}}
                    onchange="showHideIndustryId();">
                Hayır </label>
        </div>
        {!! APFrmErrHelp::showErrors($errors, 'is_default') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'industry_id') !!}" id="industry_id_div">
        {!! Form::label('industry_id', 'Varsayılan Sektör', ['class' => 'bold']) !!}
        {!! Form::select('industry_id', ['' => 'Varsayılan Sektör Seçin'] + $industries, null, array('class' => 'form-control', 'id' => 'industry_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'industry_id') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_active') !!}">
        {!! Form::label('is_active', 'Aktif', ['class' => 'bold']) !!}
        <div class="radio-list"><?php
$is_active_1 = 'checked="checked"';
$is_active_2 = '';
if (old('is_active', ((isset($industry)) ? $industry->is_active : 1)) == 0) {
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
        function showHideIndustryId() {
            $('#industry_id_div').hide();
            var is_default = $("input[name='is_default']:checked").val();
            if (is_default == 0) {
                $('#industry_id_div').show();
            }
        }
        showHideIndustryId();
    </script>
@endpush