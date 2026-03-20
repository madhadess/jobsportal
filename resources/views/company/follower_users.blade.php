@extends('layouts.app')
@section('content') 
<!-- Header start --> 
@include('includes.header') 
<!-- Header end --> 
<!-- Inner Page Title start --> 
@include('includes.inner_page_title', ['page_title'=>__('Şirket Takipçileri')]) 
<!-- Inner Page Title end -->
<div class="listpgWraper">
    <div class="container">
        <div class="row">
            @include('includes.company_dashboard_menu')

            <div class="col-md-9 col-sm-8"> 
                <div class="myads">
                    <h3>{{__('Şirket Takipçileri')}}</h3>
                    <ul class="searchList">
                        <!-- job start --> 
                        @if(isset($users) && count($users))
                        @foreach($users as $user)
                        <li>
                            <div class="row">
                                <div class="col-md-9 col-sm-9">
                                    <div class="jobimg">{{$user->printUserImage(100, 100)}}</div>
                                    <div class="jobinfo">
                                        <h3><a href="{{route('user.profile', $user->id)}}">{{$user->getName()}}</a></h3>
                                        <div class="location"> {{$user->getLocation()}}</div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="col-md-3 col-sm-3">
                                    <div class="listbtn"><a href="{{route('user.profile', $user->id)}}">{{__('Profili Görüntüle')}}</a></div>
                                </div>
                            </div>
                            <p>{{\Illuminate\Support\Str::limit($user->getProfileSummary('summary'),150,'...')}}</p>
                        </li>
                        <!-- job end --> 
                        @endforeach
                        @else
                            
                            <div class="nodatabox">
                                <h4>{{__('Takipçi Bulunamadı. Lütfen aday seçin.')}}</h4>
                                <div class="viewallbtn mt-2"><a href="{{url('/job-seekers')}}">{{__('İş Ara')}}</a></div>
                            </div>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@include('includes.footer')
@endsection


