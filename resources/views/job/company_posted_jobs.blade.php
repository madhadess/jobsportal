@extends('layouts.app')
@section('content')
<!-- Header start -->
@include('includes.header')
<!-- Header end --> 
<!-- Inner Page Title start -->
@include('includes.inner_page_title', ['page_title'=>__('Manage Jobs')])
<!-- Inner Page Title end -->
<div class="listpgWraper">
    <div class="container">
        <div class="row">
            @include('includes.company_dashboard_menu')

            <div class="col-lg-9"> 
                <div class="myads">

                    @include('flash::message') 

                    <h3>{{__('Manage Jobs')}}</h3>
                    
                    <!-- Tabs start -->
                    <ul class="nav nav-tabs mt-4" id="jobTabs">
                        <li class="nav-item">
                            <a class="nav-link active" id="active-tab" data-toggle="tab" href="#active-jobs">{{__('Active Jobs')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="expired-tab" data-toggle="tab" href="#expired-jobs">{{__('Expired Jobs')}}</a>
                        </li>
                    </ul>
                    <!-- Tabs end -->

                    <div class="tab-content">
                        <!-- active Jobs start -->
                        <div class="tab-pane fade show active" id="active-jobs">
                            <ul class="featuredlist row">
                                @if(isset($jobs) && count($jobs))
                                    @foreach($jobs as $job)
                                        @php 
                                            $company = $job->getCompany(); 
                                            $appliedUsersCount = $job->appliedUsers->count();
                                        @endphp
                                        @if(null !== $company && $job->expiry_date >= now())

                                        <li class="col-lg-6 col-md-6" id="job_li_{{$job->id}}">
                                            <div class="jobint">

                                                <div class="d-flex">
                                                    <div class="fticon"><i class="fas fa-briefcase"></i> {{$job->getJobType('job_type')}}</div>                        
                                                </div>
                                                <h4><a href="{{route('job.detail', [$job->slug])}}" title="{{$job->title}}">{!! \Illuminate\Support\Str::limit($job->title, $limit = 20, $end = '...') !!}</a>
                                                </h4>
                                                @if(!(bool)$job->hide_salary)                    
                                                <div class="salary mb-2">{{__('Salary')}}: <strong>{{ $job->getSalaryRange() }}/{{$job->getSalaryPeriod('salary_period')}}</strong></div>
                                                @endif 
                                                <strong><i class="fas fa-map-marker-alt"></i> {{$job->getCity('city')}}</strong>    
                                                <span>{{$job->created_at->translatedFormat('d F Y')}}</span>
                                                <div class="d-flex mt-3 compjobslinks">
                                                    <a class="btn btn-primary me-2" href="{{route('list.applied.users', [$job->id])}}">{{__('Candidates')}}
                                                        @if($appliedUsersCount > 0)
                                                            <span class="badge bg-white text-dark">{{$appliedUsersCount}}</span>
                                                        @else
                                                            <span class="badge bg-white text-dark">0</span>
                                                        @endif
                                                    </a>
                                                    <a class="btn btn-warning me-2" href="{{route('edit.front.job', [$job->id])}}"><i class="fas fa-edit"></i></a>
                                                    @if($job->is_featured == 1)
                                                        <button class="btn btn-success me-2" disabled><i class="fas fa-check-circle"></i> {{__('Öne Çıkarıldı')}}</button>
                                                    @else
                                                        <a class="btn btn-info me-2" href="javascript:;" onclick="makeFeatured({{$job->id}});" id="featured_btn_{{$job->id}}"><i class="fas fa-arrow-up"></i> {{__('Öne Çıkar')}}</a>
                                                    @endif
                                                    <a class="btn btn-danger me-2" href="javascript:;" onclick="deleteJob({{$job->id}});"><i class="fas fa-trash"></i></a>                                    
                                                </div>
                                            </div>
                                        </li>

                                        @endif
                                    @endforeach
                                @else
                                    <p>{{__('No active Jobs')}}</p>
                                @endif
                            </ul>
                        </div>
                        <!-- active Jobs end -->

                        <!-- Expired Jobs start -->
                        <div class="tab-pane fade" id="expired-jobs">
                            <ul class="featuredlist row">
                                @if(isset($jobs) && count($jobs))
                                    @foreach($jobs as $job)
                                        @php 
                                            $company = $job->getCompany(); 
                                            $appliedUsersCount = $job->appliedUsers->count();
                                        @endphp
                                        @if(null !== $company && $job->expiry_date < now())
                                           
                                            <li class="col-lg-6 col-md-6" id="job_li_{{$job->id}}">
                                            <div class="jobint">

                                                <div class="d-flex">
                                                    <div class="fticon"><i class="fas fa-briefcase"></i> {{$job->getJobType('job_type')}}</div>                        
                                                </div>
                                                <h4><a href="{{route('job.detail', [$job->slug])}}" title="{{$job->title}}">{!! \Illuminate\Support\Str::limit($job->title, $limit = 20, $end = '...') !!}</a>
                                                </h4>
                                                @if(!(bool)$job->hide_salary)                    
                                                <div class="salary mb-2">{{__('Salary')}}: <strong>{{ $job->getSalaryRange() }}/{{$job->getSalaryPeriod('salary_period')}}</strong></div>
                                                @endif 
                                                <strong><i class="fas fa-map-marker-alt"></i> {{$job->getCity('city')}}</strong>    
                                                <span>{{$job->created_at->translatedFormat('d F Y')}}</span>
                                                <div class="d-flex mt-3 compjobslinks">
                                                <a class="btn btn-primary me-2" href="{{route('list.applied.users', [$job->id])}}">{{__('Candidates')}}
                                                                @if($appliedUsersCount > 0)
                                                                    <span class="badge bg-white text-dark">{{$appliedUsersCount}}</span>
                                                                @else
                                                                    <span class="badge bg-white text-dark">0</span>
                                                                @endif
                                                            </a>
                                                            <a class="btn btn-warning me-2" href="{{route('edit.front.job', [$job->id])}}">{{__('Repost')}}</a>
                                                            <a class="btn btn-danger me-2" href="javascript:;" onclick="deleteJob({{$job->id}});"><i class="fas fa-trash"></i></a>                                       
                                                </div>
                                            </div>
                                        </li>







                                        @endif
                                    @endforeach
                                @else
                                    <p>{{__('No Expired Jobs')}}</p>
                                @endif
                            </ul>
                        </div>
                        <!-- Expired Jobs end -->
                    </div>

                    <!-- Pagination Start -->
                    <div class="pagiWrap mt-4">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="showreslt">
                                    {{__('Showing Jobs')}} : {{ $jobs->firstItem() }} - {{ $jobs->lastItem() }} {{__('Total')}} {{ $jobs->total() }}
                                </div>
                            </div>
                            <div class="col-md-7 text-right">
                                @if(isset($jobs) && count($jobs))
                                    {{ $jobs->appends(request()->query())->links() }}
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- Pagination end -->

                </div>
            </div>
        </div>
    </div>
</div>
@include('includes.footer')
@endsection

@push('scripts')
<script type="text/javascript">
    function deleteJob(id) {
        var msg = "{{__('Are you sure?')}}";
        if (confirm(msg)) {
            $.post("{{ route('delete.front.job') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})
                .done(function (response) {
                    if (response == 'ok') {
                        $('#job_li_' + id).remove();
                    } else {
                        alert("{{__('Request Failed!')}}");
                    }
                });
        }
    }

    function makeFeatured(id) {
        var msg = "{{__('Bu ilanı öne çıkarmak istediğinize emin misiniz? Bu işlem 1 öne çıkarma kredinizi kullanacaktır.')}}";
        if (confirm(msg)) {
            $.post("{{ route('make.job.featured') }}", {job_id: id, _token: '{{ csrf_token() }}'})
                .done(function (response) {
                    if (response.status == 'success') {
                        $('#featured_btn_' + id).removeClass('btn-info').addClass('btn-success').attr('disabled', true).html('<i class="fas fa-check-circle"></i> {{__("Öne Çıkarıldı")}}').removeAttr('onclick');
                        alert(response.message);
                    } else {
                        alert(response.message);
                    }
                });
        }
    }

    $(document).ready(function() {
        // Initialize the tab functionality
        $('#jobTabs a').on('click', function (e) {
            e.preventDefault();
            $(this).tab('show');
        });
    });
</script>
@endpush


