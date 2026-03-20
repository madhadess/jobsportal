<?php
$lang = config('default_lang');
if (isset($video))
    $lang = $video->lang;
$lang = MiscHelper::getLang($lang);
$direction = MiscHelper::getLangDirection($lang);
$queryString = MiscHelper::getLangQueryStr();
?>
{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    {!! Form::hidden('id', null) !!}
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'lang') !!}" id="lang_div">
        {!! Form::select('lang', ['' => 'Dil Seçin'] + $languages, $lang, ['class' => 'form-control', 'id' => 'lang', 'onchange' => 'setLang(this.value);']) !!}
        {!! APFrmErrHelp::showErrors($errors, 'lang') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'video_title') !!}">
        {!! Form::label('video_title', 'Video Başlığı', ['class' => 'bold']) !!}
        {!! Form::text('video_title', null, array('class' => 'form-control', 'id' => 'video_title', 'placeholder' => 'Video Başlığı', 'dir' => $direction)) !!}
        {!! APFrmErrHelp::showErrors($errors, 'video_title') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'video_text') !!}">
        {!! Form::label('video_text', 'Video Metni', ['class' => 'bold']) !!}
        {!! Form::textarea('video_text', null, array('class' => 'form-control', 'id' => 'video_text', 'placeholder' => 'Video Metni', 'dir' => $direction)) !!}
        {!! APFrmErrHelp::showErrors($errors, 'video_text') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'video_link') !!}">
        {!! Form::label('video_link', 'Video Linki', ['class' => 'bold']) !!}
        {!! Form::text('video_link', null, array('class' => 'form-control', 'id' => 'video_link', 'placeholder' => 'Video Linki', 'dir' => $direction)) !!}
        {!! APFrmErrHelp::showErrors($errors, 'video_link') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_default') !!}">
        {!! Form::label('is_default', 'Varsayılan mı?', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
$is_default_1 = 'checked="checked"';
$is_default_2 = '';
if (old('is_default', ((isset($video)) ? $video->is_default : 1)) == 0) {
    $is_default_1 = '';
    $is_default_2 = 'checked="checked"';
}
            ?>
            <label class="radio-inline">
                <input id="default" name="is_default" type="radio" value="1" {{$is_default_1}}
                    onchange="showHideVideoId();">
                Evet </label>
            <label class="radio-inline">
                <input id="not_default" name="is_default" type="radio" value="0" {{$is_default_2}}
                    onchange="showHideVideoId();">
                Hayır </label>
        </div>
        {!! APFrmErrHelp::showErrors($errors, 'is_default') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'video_id') !!}" id="video_id_div">
        {!! Form::label('video_id', 'Varsayılan Video', ['class' => 'bold']) !!}
        {!! Form::select('video_id', ['' => 'Varsayılan Video Seçin'] + $videos, null, array('class' => 'form-control', 'id' => 'video_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'video_id') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_active') !!}">
        {!! Form::label('is_active', 'Aktif mi?', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
$is_active_1 = 'checked="checked"';
$is_active_2 = '';
if (old('is_active', ((isset($video)) ? $video->is_active : 1)) == 0) {
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
        function showHideVideoId() {
            $('#video_id_div').hide();
            var is_default = $("input[name='is_default']:checked").val();
            if (is_default == 0) {
                $('#video_id_div').show();
            }
        }
        showHideVideoId();
    </script>
@endpush