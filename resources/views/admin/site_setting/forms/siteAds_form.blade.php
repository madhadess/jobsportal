{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'index_page_below_top_employes_ad') !!}">
        {!! Form::label('index_page_below_top_employes_ad', 'Ana Sayfa En İyi İşverenler Altı', ['class' => 'bold']) !!}
        {!! Form::textarea('index_page_below_top_employes_ad', null, array('class' => 'form-control', 'id' => 'index_page_below_top_employes_ad', 'placeholder' => 'Ana Sayfa En İyi İşverenler Altı')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'index_page_below_top_employes_ad') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'above_footer_ad') !!}">
        {!! Form::label('above_footer_ad', 'Ana Sayfa Şehirler Altı', ['class' => 'bold']) !!}
        {!! Form::textarea('above_footer_ad', null, array('class' => 'form-control', 'id' => 'above_footer_ad', 'placeholder' => 'Ana Sayfa Şehirler Altı')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'above_footer_ad') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'dashboard_page_ad') !!}">
        {!! Form::label('dashboard_page_ad', 'Panel Menü Altı Dikey Reklam', ['class' => 'bold']) !!}
        {!! Form::textarea('dashboard_page_ad', null, array('class' => 'form-control', 'id' => 'dashboard_page_ad', 'placeholder' => 'Panel Menü Altı Dikey Reklam')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'dashboard_page_ad') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'cms_page_ad') !!}">
        {!! Form::label('cms_page_ad', 'CMS Sayfa İçerik Altı Reklam', ['class' => 'bold']) !!}
        {!! Form::textarea('cms_page_ad', null, array('class' => 'form-control', 'id' => 'cms_page_ad', 'placeholder' => 'CMS Sayfa İçerik Altı Reklam')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'cms_page_ad') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'listing_page_vertical_ad') !!}">
        {!! Form::label('listing_page_vertical_ad', 'Listeleme Sayfası Yan Panel Dikey Reklam', ['class' => 'bold']) !!}
        {!! Form::textarea('listing_page_vertical_ad', null, array('class' => 'form-control', 'id' => 'listing_page_vertical_ad', 'placeholder' => 'Listeleme Sayfası Yan Panel Dikey Reklam')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'listing_page_vertical_ad') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'listing_page_horizontal_ad') !!}">
        {!! Form::label('listing_page_horizontal_ad', 'Listeleme Sayfası İlanların Altı Yatay Reklam', ['class' => 'bold']) !!}
        {!! Form::textarea('listing_page_horizontal_ad', null, array('class' => 'form-control', 'id' => 'listing_page_horizontal_ad', 'placeholder' => 'Listeleme Sayfası İlanların Altı Yatay Reklam')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'listing_page_horizontal_ad') !!}
    </div>
</div>