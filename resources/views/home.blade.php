@extends('layouts.app')
@section('content') 
<!-- Header start --> 
@include('includes.header') 
<!-- Header end --> 
<!-- Inner Page Title start --> 
@if(auth()->user()->isJobSeeker())
<div class="pageSearch pt-md-5 pb-md-5">
<form action="{{route('job.list')}}" method="get">
	<!-- Page Title start -->
	<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-7">
					<h3 class="mt-0 text-center">{{__('Aday Kontrol Panelinize Hoş Geldiniz')}}</h3>
						<div class="searchform">
						<div class="input-group">
							<input type="text"  name="search" id="jbsearch" value="{{Request::get('search', '')}}" class="form-control" placeholder="{{__('Yetenek veya iş unvanı girin')}}" autocomplete="off" />
							<button type="submit" class="btn"><i class="fas fa-search"></i></button>
						</div>
						</div>
					</div>
				</div>
	</div>
	<!-- Page Title end -->
</form>
</div>
@else
<div class="pageSearch pt-md-5 pb-md-5">
	<div class="container">
				<div class="row justify-content-center">
					<div class="col-lg-7">
					<h3 class="mt-0 text-center">{{__('Hesabınıza Hoş Geldiniz')}}</h3>
					<p class="text-center">{{__('Hizmetlerinizi ve taleplerinizi buradan yönetebilirsiniz.')}}</p>
					</div>
				</div>
	</div>
</div>
@endif
<!-- Inner Page Title end -->
<div class="listpgWraper">
    <div class="container">@include('flash::message')
        <div class="row"> @include('includes.user_dashboard_menu')
            <div class="col-lg-9">
            @if(auth()->user()->isJobSeeker())
            @if(count(auth()->user()->getProfileProjectsArray())==0 || count(auth()->user()->getProfileCvsArray())==0 || count(auth()->user()->profileExperience()->get()) == 0 || count(auth()->user()->profileEducation()->get()) == 0 || count(auth()->user()->profileSkills()->get()) == 0)
				<div class="userprofilealert"><h5><i class="fas fa-exclamation-triangle"></i> Özgeçmişiniz eksik, lütfen güncelleyin.</h5>
				<div class="editbtbn"><a href="{{ route('build.resume') }}"><i class="fas fa-user-edit"></i> Özgeçmişi Tamamla </a></div>	</div>
				@endif
            @include('includes.user_dashboard_stats')
            @endif
            <div class="usercoverphoto">{{auth()->user()->printUserCoverImage()}}                    
                <a href="{{ route('my.profile') }}"><i class="fas fa-edit"></i></a>
            </div>
             <!-- Profile Information -->
			<div class="profileban">
				<div class="abtuser">
					<div class="row">
						<div class="col-lg-2 col-md-3">
							<div class="uavatar">{{auth()->user()->printUserImage()}}</div>						
						</div>
						<div class="col-lg-10 col-md-9">
							<h4>{{auth()->user()->name}}</h4>
							<ul class="userdata">
								<li><i class="fas fa-map-marker-alt" aria-hidden="true"></i> {{Auth::user()->getLocation()}}</li>
								<li><i class="fas fa-phone" aria-hidden="true"></i> {{auth()->user()->phone}}</li>
								<li><i class="fas fa-envelope" aria-hidden="true"></i> {{auth()->user()->email}}</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
            @if(auth()->user()->isMember())
            <div class="appliedjobswrap">
                <h3><i class="fas fa-concierge-bell"></i> {{__('Hizmet Taleplerim')}}</h3>
                @php
                    $serviceRequests = \App\ServiceRequest::where('user_id', auth()->id())->with('service')->orderBy('created_at', 'desc')->limit(5)->get();
                @endphp
                @if($serviceRequests->count() > 0)
                    <table class="table table-striped">
                    <thead class="table-dark">
                            <tr>
                            <th>{{ __('Hizmet') }}</th>
                            <th>{{ __('Talep No') }}</th>
                            <th>{{ __('Tarih') }}</th>
                            <th>{{ __('Durum') }}</th>
                            <th>{{ __('İşlem') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($serviceRequests as $sReq)
                                <tr>
                                    <td><strong>{{ $sReq->service->service_name ?? 'N/A' }}</strong></td>
                                    <td>{{ $sReq->request_number }}</td>
                                    <td>{{ $sReq->getFormattedDate() }}</td>
                                    <td>
                                        <span class="badge bg-{{ $sReq->getStatusColor() }}">{{ $sReq->getStatusLabel() }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('home-services.request-detail', $sReq->request_number) }}" class="btn btn-sm btn-info">
                                            <i class="fa fa-eye"></i> {{__('Detay')}}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted">{{__('Henüz bir hizmet talebiniz bulunmuyor.')}}</p>
                @endif
            </div>
            @endif

            @if(auth()->user()->isJobSeeker())
            <!-- Applied jobs -->
			<div class="appliedjobswrap">
                <h3>{{__('Başvurduğum İşler')}}</h3>	   	
                @if(isset($appliedJobs) && count($appliedJobs))
                    <table class="table table-striped">
                    <thead class="table-dark">
                            <tr>
                            <th>{{ __('İş Unvanı') }}</th>
                            <th>{{ __('Şirket') }}</th>
                            <th>{{ __('Konum') }}</th>
                            <th>{{ __('Başvuru Tarihi') }}</th>
                            <th>{{ __('Durum') }}</th>
                            <th>{{ __('İşlem') }}</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($appliedJobs as $appliedjob)
                                @php
                                    $job = App\Job::where('id', $appliedjob->job_id)->first();
                                    $company = $job->getCompany();
                                    // Assuming you are using the JobApplication model to store applied jobs
                                    $appliedDate = $appliedjob->created_at->format('Y-m-d'); 
                                @endphp
                                @if(null !== $company)
                                    <tr>
                                        <td>
                                            <h5><a href="{{ route('job.detail', [$job->slug]) }}" title="{{ $job->title }}">{{ $job->title }}</a></h5>
                                        </td>
                                        <td>
                                            <a href="{{ route('company.detail', $company->slug) }}" title="{{ $company->name }}">{{ $company->name }}</a>
                                        </td>
                                        <td>{{ $job->getCity('city') }}</td>
                                        <td>{{ $appliedDate }}</td> 
                                        @php
                                            $statusMap = [
                                                'applied' => 'Başvuruldu',
                                                'shortlist' => 'Kısa Liste',
                                                'hired' => 'İşe Alındı',
                                                'rejected' => 'Reddedildi',
                                                'pending' => 'Beklemede',
                                            ];
                                            $statusText = $statusMap[$appliedjob->status] ?? $appliedjob->status;
                                        @endphp
                                        <td>{{ $statusText }}</td>
                                        <td>
                                            <a href="{{ route('job.detail', [$job->slug]) }}" class="btn btn-primary">{{ __('Detayları Gör') }}</a>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Başvurulan iş ilanı bulunamadı.</p>
                @endif
			</div>
            @endif

            @if(auth()->user()->isPersonnel() || auth()->user()->isCaregiver())
            <div class="appliedjobswrap">
                <h3><i class="fas fa-tasks"></i> {{__('Atanan Görevlerim')}}</h3>
                @php
                    $assignments = \App\ServiceRequest::where('matched_personnel_id', auth()->id())->orderBy('created_at', 'desc')->limit(5)->get();
                @endphp
                @if($assignments->count() > 0)
                    <table class="table table-striped">
                    <thead class="table-dark">
                            <tr>
                            <th>{{ __('Hizmet') }}</th>
                            <th>{{ __('Tarih') }}</th>
                            <th>{{ __('Durum') }}</th>
                            <th>{{ __('İşlem') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($assignments as $assign)
                                <tr>
                                    <td><strong>{{ $assign->service->service_name ?? 'N/A' }}</strong></td>
                                    <td>{{ \Carbon\Carbon::parse($assign->preferred_date)->format('d.m.Y') }}</td>
                                    <td>
                                        @php
                                            $statusTranslations = [
                                                'matched' => 'Personel Atandı',
                                                'accepted' => 'Kabul Edildi',
                                                'completed' => 'Tamamlandı'
                                            ];
                                            $label = $statusTranslations[$assign->automation_status] ?? $assign->automation_status;
                                        @endphp
                                        <span class="badge bg-{{ $assign->automation_status == 'accepted' ? 'success' : 'info' }}">{{ $label }}</span>
                                    </td>
                                    <td>
                                        <a href="{{ route('personnel.assignment_details', $assign->id) }}" class="btn btn-sm btn-info">
                                            <i class="fa fa-eye"></i> {{__('Detay')}}
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted">{{__('Henüz atanmış bir göreviniz bulunmuyor.')}}</p>
                @endif
            </div>
            @endif

          


            @if(auth()->user()->isCandidate())
                @if((bool)config('jobseeker.is_jobseeker_package_active'))
                @php
                $packages = App\Package::where('package_for', 'like', 'job_seeker')->get();
                $package = Auth::user()->getPackage();
                if(null !== $package){
                $packages = App\Package::where('package_for', 'like', 'job_seeker')->where('id', '<>', $package->id)->where('package_price', '>=', $package->package_price)->get();
                }
                @endphp
                @if(null !== $package)
                @include('includes.user_package_msg')
                @include('includes.user_packages_upgrade')
                @else
                @if(null !== $packages)
                @include('includes.user_packages_new')
                @endif
                @endif
                @endif 
            @endif 



            @if(auth()->user()->isJobSeeker())
                @if(!empty($matchingJobs) && count($matchingJobs) > 0)
                            <div class="profbox">
                                <h3>{{__('Önerilen İşler')}}</h3>
                                <ul class="featuredlist">
    @foreach($matchingJobs as $match)
        <li class="col-lg-4 col-md-6 @if($match->is_featured == 1) featured @endif">
            <div class="jobint">
                @if($match->is_featured == 1) 
                    <span class="promotepof-badge"><i class="fa fa-bolt" title="{{__('Bu Eşleşme Öne Çıkan')}}"></i></span> 
                @endif
                <div class="d-flex">
                    <div class="fticon"><i class="fas fa-briefcase"></i> {{$match->getJobType('job_type')}}</div>                        
                </div>
                <h4>
                    <a href="{{route('job.detail', [$match->slug])}}" title="{{$match->title}}">
                        {!! \Illuminate\Support\Str::limit($match->title, 20, '...') !!}
                    </a>
                </h4>                                        
                @if(!(bool)$match->hide_salary)                    
                    <div class="salary mb-2">Maaş: 
                        <strong>{{$match->salary_currency.''.$match->salary_from}} - {{$match->salary_currency.''.$match->salary_to}}/{{$match->getSalaryPeriod('salary_period')}}</strong>
                    </div>
                @endif 
                <strong><i class="fas fa-map-marker-alt"></i> {{$match->getCity('city')}}</strong>                                         
                <div class="jobcompany">
                    <div class="ftjobcomp">
                        <span>{{$match->created_at->translatedFormat('d F Y')}}</span>
                        @if(isset($match->company))
                            <a href="{{route('company.detail', $match->company->slug)}}" title="{{$match->company->name}}">{{$match->company->name}}</a>
                        @endif
                    </div>
                    @if(isset($match->company))
                        <a href="{{route('company.detail', $match->company->slug)}}" class="company-logo" title="{{$match->company->name}}">{{$match->company->printCompanyImage()}}</a>
                    @endif
                </div>
            </div>
        </li>
    @endforeach 
                                </ul>
                            </div>
@endif

 <!-- My Followings -->

                            <div class="profbox followbox">
								<h3>{{__('Takip Ettiklerim')}} <a href="{{route('my.followings')}}">{{__('Tümünü Gör')}} <i class="fas fa-arrow-right"></i></a></h3>
								<ul class="row compnaieslist">
								@if(isset($followers) && $followers->isNotEmpty())
                                @foreach($followers as $follow)
                                @php
                                    $company = \App\Company::where('slug', $follow->company_slug)
                                        ->where('is_active', 1)
                                        ->first();
                                @endphp
                                @if(isset($company))
                                    <li class="col-lg-4 col-md-6">
                                        <div class="empint">
                                            <a href="{{route('company.detail', $company->slug)}}" title="{{$company->name}}">
                                                <div class="emptbox">
                                                    <div class="comimg">{{$company->printCompanyImage()}}</div>
                                                    <div class="text-info-right">
                                                        <h4>{{$company->name}}</h4>    
                                                        @if($company->getIndustry('industry'))
                                                            <div class="indst">                            
                                                                {{ $company->getIndustry('industry') }}                          
                                                            </div>
                                                        @endif
                                                        <div class="emloc"><i class="fas fa-map-marker-alt"></i> {{$company->location}}</div>
                                                    </div>                                         
                                                    <div class="cm-info-bottom">
                                                        <span><i class="fas fa-briefcase"></i> {{$company->countNumJobs('company_id',$company->id)}} {{__('Açık İşler')}}</span>
                                                    </div>    
                                                </div>
                                            </a>                    
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                                @else
                                <li class="col-lg-12">{{ __('Takip Edilen Bulunamadı') }}</li>
                                @endif
								</ul>
								
							</div>
            @endif


			</div>
        </div>
    </div>
</div>
@include('includes.footer')
@endsection
@push('scripts')
@include('includes.immediate_available_btn')
<script>
$(document).ready(function() {
    function fadeTextEffect(texts) {
        var index = 0;
        function fadeText() {
            $(texts[index])
                .fadeIn(500) // Fade in over 1 second
                .delay(8000) // Display for 8 seconds
                .fadeOut(500, function() { // Fade out over 1 second
                    index = (index + 1) % texts.length; // Move to the next text
                    fadeText(); // Recursively call to continue the loop
                });
        }
        fadeText(); // Start the animation loop
    }
    // Apply the fade effect to both fade-text and fadetext2
    fadeTextEffect($('.fade-text'));
    fadeTextEffect($('.fadetext2'));
});
</script>
@endpush

