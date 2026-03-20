<?php
$lang = config('default_lang');
if (isset($faq))
    $lang = $faq->lang;
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
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'faq_question') !!}">
        {!! Form::label('faq_question', 'Soru', ['class' => 'bold']) !!}
        {!! Form::textarea('faq_question', null, array('class' => 'form-control', 'id' => 'faq_question', 'placeholder' => 'Soru')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'faq_question') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'faq_answer') !!}">
        {!! Form::label('faq_answer', 'Cevap', ['class' => 'bold']) !!}
        {!! Form::textarea('faq_answer', null, array('class' => 'form-control', 'id' => 'faq_answer', 'placeholder' => 'Cevap')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'faq_answer') !!}
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
    </script>
    @include('admin.shared.tinyMCE')
@endpush