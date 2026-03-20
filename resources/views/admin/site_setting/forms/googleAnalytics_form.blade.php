{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <fieldset>
        <legend>Analytics Kodu Girin:</legend>
        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'ganalytics') !!}">

            {!! Form::textarea('ganalytics', null, array('class' => 'form-control', 'contenteditable' => 'true', 'id' => 'ganalytics', 'placeholder' => 'Analytics Kodunu Buraya Ekleyin')) !!}


            {!! APFrmErrHelp::showErrors($errors, 'ganalytics') !!}
        </div>
    </fieldset>


    <fieldset>
        <legend>Head İçin Google Tag Manager:</legend>
        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'google_tag_manager_for_head') !!}">

            {!! Form::textarea('google_tag_manager_for_head', null, array('class' => 'form-control', 'contenteditable' => 'true', 'id' => 'google_tag_manager_for_head', 'placeholder' => 'Head için Google Tag Manager Kodunu Buraya Ekleyin')) !!}


            {!! APFrmErrHelp::showErrors($errors, 'google_tag_manager_for_head') !!}
        </div>
    </fieldset>

    <fieldset>
        <legend>Body İçin Google Tag Manager:</legend>
        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'google_tag_manager_for_body') !!}">

            {!! Form::textarea('google_tag_manager_for_body', null, array('class' => 'form-control', 'contenteditable' => 'true', 'id' => 'google_tag_manager_for_body', 'placeholder' => 'Body için Google Tag Manager Kodunu Buraya Ekleyin')) !!}


            {!! APFrmErrHelp::showErrors($errors, 'google_tag_manager_for_body') !!}
        </div>
    </fieldset>

</div>