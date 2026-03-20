{!! APFrmErrHelp::showErrorsNotice($errors) !!}
<div class="form-body">
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'page_title') !!}">
        {!! Form::label('page_title', 'Sayfa Adı (Sistem Kodu)', ['class' => 'bold']) !!}
        @if(isset($seo->is_static) && $seo->is_static == 1)
            {!! Form::text('page_title', null, array('class'=>'form-control', 'id'=>'page_title', 'readonly'=>'readonly')) !!}
            <span class="help-block"> Bu bir sistem sayfasıdır, başlık değiştirilemez. </span>
        @else
            @if(isset($systemPages) && count($systemPages) > 0)
                {!! Form::select('page_title', ['' => 'Bir Sayfa Seçin'] + $systemPages, null, array('class'=>'form-control', 'id'=>'page_title')) !!}
            @else
                 {!! Form::text('page_title', null, array('class'=>'form-control', 'id'=>'page_title', 'placeholder'=>'Sayfa Adı')) !!}
            @endif
        @endif
        {!! APFrmErrHelp::showErrors($errors, 'page_title') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'slug') !!}">
        {!! Form::label('slug', 'Slug (URL Adresi)', ['class' => 'bold']) !!}
        {!! Form::text('slug', null, array('class' => 'form-control', 'id' => 'slug', 'placeholder' => 'Slug (Örn: iletisim-sayfasi)')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'slug') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'seo_title') !!}">
        {!! Form::label('seo_title', 'SEO Başlığı', ['class' => 'bold']) !!}
        {!! Form::text('seo_title', null, array('class' => 'form-control', 'id' => 'seo_title', 'placeholder' => 'SEO Başlığı')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'seo_title') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'seo_description') !!}">
        {!! Form::label('seo_description', 'SEO Açıklaması', ['class' => 'bold']) !!}
        {!! Form::textarea('seo_description', null, array('class' => 'form-control', 'id' => 'seo_description', 'placeholder' => 'SEO Açıklaması')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'seo_description') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'seo_keywords') !!}">
        {!! Form::label('seo_keywords', 'SEO Anahtar Kelimeler', ['class' => 'bold']) !!}
        {!! Form::textarea('seo_keywords', null, array('class' => 'form-control', 'id' => 'seo_keywords', 'placeholder' => 'SEO Anahtar Kelimeler')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'seo_keywords') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'seo_other') !!}">
        {!! Form::label('seo_other', 'Diğer SEO Etiketleri', ['class' => 'bold']) !!}
        {!! Form::textarea('seo_other', null, array('class' => 'form-control', 'id' => 'seo_other', 'placeholder' => 'Diğer SEO Etiketleri')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'seo_other') !!}
    </div>
</div>