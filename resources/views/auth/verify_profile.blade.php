@extends('layouts.app')

@section('content')
    @include('includes.header')
    @include('includes.inner_page_title', ['page_title' => __('Profilinizi Doğrulayın')])

    <div class="listpgWraper">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2 mx-auto">
                    <div class="userccount">
                        <div class="formpanel">
                            <h5>{{__('Neredeyse Hazırsınız!')}}</h5>
                            <p>
                                @if(Auth::user()->isPersonnel() || Auth::user()->isCaregiver())
                                    {{__('Hizmet vermeye başlamak için CV ve Tanıtım Videonuzu yüklemeniz gerekmektedir.')}}
                                @else
                                    {{__('İş başvurusu yapabilmek için CV yüklemeniz gerekmektedir.')}}
                                @endif
                            </p>
                            <hr>

                            <form action="{{ route('verify.profile.submit') }}" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}

                                <div class="formrow {{ $errors->has('cv_file') ? 'has-error' : '' }}">
                                    <label class="bold">{{__('Özgeçmiş (CV)')}} <span class="text-danger">*</span></label>
                                    <input type="file" name="cv_file" class="form-control" accept=".pdf,.doc,.docx"
                                        required>
                                    <small class="text-muted">PDF, DOC, DOCX (Max: 5MB)</small>
                                    @if ($errors->has('cv_file'))
                                        <span class="help-block"><strong>{{ $errors->first('cv_file') }}</strong></span>
                                    @endif
                                </div>

                                <div class="formrow {{ $errors->has('video_file') ? 'has-error' : '' }}">
                                    <label class="bold">
                                        {{__('Tanıtım Videosu')}}
                                        @if(Auth::user()->isPersonnel() || Auth::user()->isCaregiver())
                                            <span class="text-danger">* {{__('(Zorunlu)')}}</span>
                                        @else
                                            <span class="text-muted">({{__('Opsiyonel')}})</span>
                                        @endif
                                    </label>
                                    <input type="file" name="video_file" class="form-control" accept="video/*" {{ (Auth::user()->isPersonnel() || Auth::user()->isCaregiver()) ? 'required' : '' }}>
                                    <small class="text-muted">MP4, MOV (Max: 20MB). Kendinizi tanıtan kısa bir video
                                        güvenilirliğinizi artırır.</small>
                                    @if ($errors->has('video_file'))
                                        <span class="help-block"><strong>{{ $errors->first('video_file') }}</strong></span>
                                    @endif
                                </div>

                                <div class="formrow mt-4">
                                    <button type="submit"
                                        class="btn btn-primary btn-block">{{__('Profilimi Tamamla ve Devam Et')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('includes.footer')
@endsection