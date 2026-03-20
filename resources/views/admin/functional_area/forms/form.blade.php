<?php
$lang = config('default_lang');
if (isset($functionalArea))
    $lang = $functionalArea->lang;
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
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'functional_area') !!}">
        {!! Form::label('functional_area', 'Fonksiyonel Alan', ['class' => 'bold']) !!}
        {!! Form::text('functional_area', null, array('class' => 'form-control', 'id' => 'functional_area', 'placeholder' => 'Fonksiyonel Alan', 'dir' => $direction)) !!}
        {!! APFrmErrHelp::showErrors($errors, 'functional_area') !!}
    </div>
    <div class="form-group">
        <label class="control-label" for="Upload Image">Resim</label>
        <input type="file" class="form-control" name="image" id="image" autofocus>
        <div class="image_append" id="image_append">
            @if((isset($functionalArea)) && $functionalArea->image != '')
                <br>
                <div class='featured-images-main' id='listing_img_{{$functionalArea->id}}'><img
                        src="{{asset('uploads/functional_area/thumbnail/')}}/{{$functionalArea->image}}"></div>
            @endif
        </div>
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_default') !!}">
        {!! Form::label('is_default', 'Varsayılan mı?', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
$is_default_1 = 'checked="checked"';
$is_default_2 = '';
if (old('is_default', ((isset($functionalArea)) ? $functionalArea->is_default : 1)) == 0) {
    $is_default_1 = '';
    $is_default_2 = 'checked="checked"';
}
            ?>
            <label class="radio-inline">
                <input id="default" name="is_default" type="radio" value="1" {{$is_default_1}}
                    onchange="showHideFunctionalAreaId();">
                Evet </label>
            <label class="radio-inline">
                <input id="not_default" name="is_default" type="radio" value="0" {{$is_default_2}}
                    onchange="showHideFunctionalAreaId();">
                Hayır </label>
        </div>
        {!! APFrmErrHelp::showErrors($errors, 'is_default') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'functional_area_id') !!}" id="functional_area_id_div">
        {!! Form::label('functional_area_id', 'Varsayılan Fonksiyonel Alan', ['class' => 'bold']) !!}
        {!! Form::select('functional_area_id', ['' => 'Varsayılan Fonksiyonel Alan Seçin'] + $functionalAreas, null, array('class' => 'form-control', 'id' => 'functional_area_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'functional_area_id') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_active') !!}">
        {!! Form::label('is_active', 'Aktif mi?', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
$is_active_1 = 'checked="checked"';
$is_active_2 = '';
if (old('is_active', ((isset($functionalArea)) ? $functionalArea->is_active : 1)) == 0) {
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
        function showHideFunctionalAreaId() {
            $('#functional_area_id_div').hide();
            var is_default = $("input[name='is_default']:checked").val();
            if (is_default == 0) {
                $('#functional_area_id_div').show();
            }
        }
        showHideFunctionalAreaId();
    </script>
@endpush