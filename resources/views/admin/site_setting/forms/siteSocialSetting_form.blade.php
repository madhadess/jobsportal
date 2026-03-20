{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">        
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'facebook_address') !!}">
        {!! Form::label('facebook_address', 'Facebook Adresi', ['class' => 'bold']) !!}                    
        {!! Form::text('facebook_address', null, array('class'=>'form-control', 'id'=>'facebook_address', 'placeholder'=>'Facebook Adresi')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'facebook_address') !!}                                       
    </div>    
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'google_plus_address') !!}">
        {!! Form::label('google_plus_address', 'Google+ Adresi', ['class' => 'bold']) !!}                    
        {!! Form::text('google_plus_address', null, array('class'=>'form-control', 'id'=>'google_plus_address', 'placeholder'=>'Google+ Adresi')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'google_plus_address') !!}                                       
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'pinterest_address') !!}">
        {!! Form::label('pinterest_address', 'Pinterest Adresi', ['class' => 'bold']) !!}                    
        {!! Form::text('pinterest_address', null, array('class'=>'form-control', 'id'=>'pinterest_address', 'placeholder'=>'Pinterest Adresi')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'pinterest_address') !!}                                       
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'twitter_address') !!}">
        {!! Form::label('twitter_address', 'Twitter Adresi', ['class' => 'bold']) !!}                    
        {!! Form::text('twitter_address', null, array('class'=>'form-control', 'id'=>'twitter_address', 'placeholder'=>'Twitter Adresi')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'twitter_address') !!}                                       
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'instagram_address') !!}">
        {!! Form::label('instagram_address', 'Instagram Adresi', ['class' => 'bold']) !!}                    
        {!! Form::text('instagram_address', null, array('class'=>'form-control', 'id'=>'instagram_address', 'placeholder'=>'Instagram Adresi')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'instagram_address') !!}                                       
    </div>    
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'linkedin_address') !!}">
        {!! Form::label('linkedin_address', 'Linkedin Adresi', ['class' => 'bold']) !!}                    
        {!! Form::text('linkedin_address', null, array('class'=>'form-control', 'id'=>'linkedin_address', 'placeholder'=>'Linkedin Adresi')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'linkedin_address') !!}                                       
    </div>    
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'youtube_address') !!}">
        {!! Form::label('youtube_address', 'Youtube Adresi', ['class' => 'bold']) !!}                    
        {!! Form::text('youtube_address', null, array('class'=>'form-control', 'id'=>'youtube_address', 'placeholder'=>'Youtube Adresi')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'youtube_address') !!}                                       
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'tumblr_address') !!}">
        {!! Form::label('tumblr_address', 'Tumblr Adresi', ['class' => 'bold']) !!}                    
        {!! Form::text('tumblr_address', null, array('class'=>'form-control', 'id'=>'tumblr_address', 'placeholder'=>'Tumblr Adresi')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'tumblr_address') !!}                                       
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'flickr_address') !!}">
        {!! Form::label('flickr_address', 'Flickr Adresi', ['class' => 'bold']) !!}                    
        {!! Form::text('flickr_address', null, array('class'=>'form-control', 'id'=>'flickr_address', 'placeholder'=>'Flickr Adresi')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'flickr_address') !!}                                       
    </div>
</div>







