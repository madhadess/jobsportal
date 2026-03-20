@extends('layouts.app')

@section('content')
    {{-- Header --}}
    @include('includes.header')

    @php
        // ====== ACCESS / UNLOCK LOGIC (SENİN KODUN) ======
        $true = false;

        if (Auth::guard('company')->user()) {
            $package = Auth::guard('company')->user();
            if (null !== ($package)) {
                $array_ids = explode(',', $package->availed_cvs_ids);
                if (in_array($user->id, $array_ids)) {
                    $true = true;
                }
            }
        } elseif (auth()->check() && auth()->user()->id == $user->id) {
            $true = true;
        }

        // ====== Service History ======
        $serviceHistory = \App\ServiceBooking::where('user_id', $user->id)
            ->with('service', 'category')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get();

        // ====== User's Job Listings ======
        $userJobPosts = \App\JobPost::where('user_id', $user->id)
            ->with('category', 'state')
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // ====== User's Service Applications (from wizards) ======
        $userApplications = \App\ListingApplication::where('user_id', $user->id)
            ->with([
                'jobPost' => function ($q) {
                    $q->with('category', 'state');
                }
            ])
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // Profile complete check
        $companyUser = Auth::guard('company')->user();
        $isProfileComplete = !empty($user->cv_file) && !empty($user->email) && !empty($user->phone);
    @endphp

    <div class="listpgWraper profile-v2">
        <div class="container">
            @include('flash::message')

            <div class="row g-3">
                {{-- LEFT --}}
                <div class="col-lg-8">

                    {{-- HERO --}}
                    <div class="p-hero">
                        <div class="p-cover">
                            {!! $user->printUserCoverImage() !!}
                            <div class="p-cover-overlay"></div>
                        </div>

                        <div class="p-header">
                            <div class="p-avatar">
                                {!! $user->printUserImage() !!}
                            </div>

                            <div class="p-title">
                                <h1 class="p-name">
                                    {{$user->getName()}}
                                    <span class="p-badge">({{$user->getFunctionalArea('functional_area')}})</span>
                                </h1>

                                <div class="p-meta">
                                    <span><i class="fa fa-map-marker"></i> {{$user->getLocation()}}</span>
                                    <span><i class="fa fa-history"></i> {{__('Member Since')}},
                                        {{$user->created_at->translatedFormat('d F Y')}}</span>

                                    @if((bool) $user->is_immediate_available)
                                        <span class="p-ready"><i class="fas fa-laptop"></i> {{__('Ready for Hire')}}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- ACTIONS --}}
                        <div class="p-actions">
                            <div class="userlinkstp p-actions-inner">

                                @if($true === true)
                                    {{-- Job actions --}}
                                    @if(isset($job) && isset($company))
                                        @if(Auth::guard('company')->check() && Auth::guard('company')->user()->isHiredApplicant($user->id, $job->id, $company->id))
                                            <a href="{{route('remove.hire.from.favourite.applicant', [$job_application->id, $user->id, $job->id, $company->id])}}"
                                                class="btn p-btn">
                                                <i class="fa fa-floppy-o" aria-hidden="true"></i> {{__('Remove From Hired List')}}
                                            </a>
                                        @else
                                            @if(Auth::guard('company')->check() && Auth::guard('company')->user()->isFavouriteApplicant($user->id, $job->id, $company->id))
                                                <a href="{{route('remove.from.favourite.applicant', [$job_application->id, $user->id, $job->id, $company->id])}}"
                                                    class="btn p-btn">
                                                    <i class="fa fa-floppy-o" aria-hidden="true"></i> {{__('Shortlisted')}}
                                                </a>

                                                @if(isset($is_applicant))
                                                    <a style="color:#fff" href="{{route('reject.applicant.profile', [$job_application->id])}}"
                                                        class="btn btn-warning p-btn">
                                                        <i class="fa fa-floppy-o" aria-hidden="true"></i> {{__('Reject')}}
                                                    </a>
                                                @endif
                                            @else
                                                <a href="{{route('add.to.favourite.applicant', [$job_application->id, $user->id, $job->id, $company->id])}}"
                                                    class="btn p-btn">
                                                    <i class="fa fa-floppy-o" aria-hidden="true"></i> {{__('Shortlist')}}
                                                </a>
                                            @endif

                                            <a href="{{route('hire.from.favourite.applicant', [$job_application->id, $user->id, $job->id, $company->id])}}"
                                                class="btn p-btn p-btn-primary">
                                                <i class="fa fa-floppy-o" aria-hidden="true"></i> {{__('Hire This Candidate')}}
                                            </a>
                                        @endif
                                    @endif

                                    {{-- CV download --}}
                                    @if(null !== $profileCv)
                                        <a href="{{ asset('cvs/' . $profileCv->cv_file) }}" class="btn p-btn">
                                            <i class="fa fa-download" aria-hidden="true"></i> {{__('Download CV')}}
                                        </a>
                                    @endif

                                    {{-- Send message --}}
                                    @if(auth()->check() && auth()->user()->id != $user->id)
                                        <a href="javascript:;" onclick="send_message()" class="btn p-btn">
                                            <i class="fa fa-envelope" aria-hidden="true"></i> {{__('Send Message')}}
                                        </a>
                                    @endif
                                @endif

                                {{-- Company lock --}}
                                @if(Auth::guard('company')->user())
                                    @if($true === false)
                                        @if(!$isProfileComplete)
                                            <div class="p-alert p-alert-danger">
                                                {{ __("Candidate profile is not completed, so you can't unlock it.") }}
                                            </div>
                                        @else
                                            <a href="{{ route('company.unlock', $user->id) }}" class="btn btn-default p-btn p-btn-lock">
                                                <i class="fa fa-lock" aria-hidden="true"></i> {{__('Profile Locked')}}
                                            </a>
                                            <span
                                                class="p-hint">{{ __('Unlock profile to view candidate CV and contact details') }}</span>
                                        @endif
                                    @endif
                                @endif

                            </div>
                        </div>
                    </div>

                    {{-- SERVICE HISTORY --}}
                    @if(($user->isCaregiver() || $user->isPersonnel()) && $serviceHistory->count() > 0)
                        <div class="p-card mt-3">
                            <div class="p-card-head">
                                <h3 class="p-card-title"><i class="fas fa-tools"></i> {{__('Hizmet Geçmişi')}}</h3>
                            </div>
                            <div class="p-card-body">
                                <div class="row g-3">
                                    @foreach($serviceHistory as $request)
                                        <div class="col-md-4">
                                            <div class="p-mini-card">
                                                <div class="p-mini-title">{{ $request->service->service_name ?? 'N/A' }}</div>

                                                <div class="p-mini-row">
                                                    <i class="fas fa-tag"></i>
                                                    <span><b>{{__('Kategori')}}:</b>
                                                        {{ $request->category->category_name ?? 'N/A' }}</span>
                                                </div>
                                                <div class="p-mini-row">
                                                    <i class="fas fa-calendar"></i>
                                                    <span><b>{{__('Tarih')}}:</b>
                                                        {{ \Carbon\Carbon::parse($request->booking_date)->translatedFormat('d F Y') }}</span>
                                                </div>
                                                <div class="p-mini-row">
                                                    <i class="fas fa-clock"></i>
                                                    <span><b>{{__('Saat')}}:</b>
                                                        {{ \Carbon\Carbon::parse($request->booking_time)->format('H:i') }}</span>
                                                </div>
                                                <div class="p-mini-row">
                                                    <i class="fas fa-money-bill"></i>
                                                    <span><b>{{__('Fiyat')}}:</b>
                                                        {{ number_format($request->total_price, 2, ',', '.') }} ₺</span>
                                                </div>

                                                <div class="p-mini-status">
                                                    @if($request->status == 'pending')
                                                        <span class="badge bg-warning text-dark">{{__('Beklemede')}}</span>
                                                    @elseif($request->status == 'confirmed')
                                                        <span class="badge bg-info text-dark">{{__('Onaylandı')}}</span>
                                                    @elseif($request->status == 'completed')
                                                        <span class="badge bg-success">{{__('Tamamlandı')}}</span>
                                                    @else
                                                        <span class="badge bg-danger">{{__('İptal Edildi')}}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- ABOUT --}}
                    <div class="p-card mt-3">
                        <div class="p-card-head">
                            <h3 class="p-card-title">{{__('About me')}}</h3>
                        </div>
                        <div class="p-card-body">
                            <p class="p-text">{{$user->getProfileSummary('summary')}}</p>
                        </div>
                    </div>

                    {{-- SKILLS --}}
                    <div class="p-card mt-3">
                        <div class="p-card-head">
                            <h3 class="p-card-title">{{__('Skills')}}</h3>
                        </div>
                        <div class="p-card-body">
                            <div id="skill_div"></div>
                        </div>
                    </div>

                    {{-- LANGUAGES --}}
                    <div class="p-card mt-3">
                        <div class="p-card-head">
                            <h3 class="p-card-title">{{__('Languages')}}</h3>
                        </div>
                        <div class="p-card-body">
                            <div id="language_div"></div>
                        </div>
                    </div>

                    {{-- EXPERIENCE --}}
                    <div class="p-card mt-3">
                        <div class="p-card-head">
                            <h3 class="p-card-title">{{__('Experience')}}</h3>
                        </div>
                        <div class="p-card-body">
                            <div id="experience_div"></div>
                        </div>
                    </div>

                    {{-- EDUCATION --}}
                    <div class="p-card mt-3">
                        <div class="p-card-head">
                            <h3 class="p-card-title">{{__('Education')}}</h3>
                        </div>
                        <div class="p-card-body">
                            <div id="education_div"></div>
                        </div>
                    </div>

                    {{-- PORTFOLIO --}}
                    <div class="p-card mt-3">
                        <div class="p-card-head">
                            <h3 class="p-card-title">{{__('Portfolio')}}</h3>
                        </div>
                        <div class="p-card-body">
                            <div id="projects_div"></div>
                        </div>
                    </div>

                    {{-- USER'S JOB LISTINGS --}}
                    @if($userJobPosts->count() > 0)
                        <div class="p-card mt-3">
                            <div class="p-card-head">
                                <h3 class="p-card-title"><i class="fas fa-list-alt"></i> {{__('Oluşturduğu İlanlar')}}</h3>
                            </div>
                            <div class="p-card-body">
                                <div class="row g-3">
                                    @foreach($userJobPosts as $post)
                                        <div class="col-md-6">
                                            <div class="p-mini-card">
                                                <div class="p-mini-title">{{ $post->title }}</div>
                                                @if($post->category)
                                                    <div class="p-mini-row">
                                                        <i class="fas fa-tag"></i>
                                                        <span>{{ $post->category->category_name }}</span>
                                                    </div>
                                                @endif
                                                @if($post->state)
                                                    <div class="p-mini-row">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                        <span>{{ $post->state->state }}</span>
                                                    </div>
                                                @endif
                                                <div class="p-mini-row">
                                                    <i class="fas fa-clock"></i>
                                                    <span>{{ $post->getWorkTypeLabel() }}</span>
                                                </div>
                                                <div class="p-mini-row">
                                                    <i class="fas fa-money-bill"></i>
                                                    <span>{{ $post->getSalaryRange() }}</span>
                                                </div>
                                                <div class="p-mini-status">
                                                    <span
                                                        class="badge bg-{{ $post->status === 'published' ? 'success' : ($post->status === 'draft' ? 'secondary' : 'danger') }}">
                                                        {{ $post->getStatusLabel() }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- USER'S SERVICE APPLICATIONS --}}
                    @if($userApplications->count() > 0)
                        <div class="p-card mt-3">
                            <div class="p-card-head">
                                <h3 class="p-card-title"><i class="fas fa-paper-plane"></i> {{__('Başvurduğu Hizmetler')}}</h3>
                            </div>
                            <div class="p-card-body">
                                <div class="row g-3">
                                    @foreach($userApplications as $app)
                                        @if($app->jobPost)
                                            <div class="col-md-6">
                                                <div class="p-mini-card">
                                                    <div class="p-mini-title">{{ $app->jobPost->title }}</div>
                                                    @if($app->jobPost->category)
                                                        <div class="p-mini-row">
                                                            <i class="fas fa-tag"></i>
                                                            <span>{{ $app->jobPost->category->category_name }}</span>
                                                        </div>
                                                    @endif
                                                    @if($app->jobPost->state)
                                                        <div class="p-mini-row">
                                                            <i class="fas fa-map-marker-alt"></i>
                                                            <span>{{ $app->jobPost->state->state }}</span>
                                                        </div>
                                                    @endif
                                                    <div class="p-mini-row">
                                                        <i class="fas fa-calendar"></i>
                                                        <span>{{ $app->created_at->format('d.m.Y') }}</span>
                                                    </div>
                                                    <div class="p-mini-status">
                                                        <span
                                                            class="badge bg-{{ $app->status === 'accepted' ? 'success' : ($app->status === 'pending' ? 'warning' : ($app->status === 'shortlisted' ? 'info' : 'secondary')) }}">
                                                            {{ $app->getStatusLabel() }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                </div>

                {{-- RIGHT --}}
                <div class="col-lg-4">
                    <div class="p-sticky">

                        {{-- Contact (Unlocked) --}}
                        <?php if ($true == true) { ?>
                        <div class="p-card">
                            <div class="p-card-head">
                                <h3 class="p-card-title">{{__('Contact Information')}}</h3>
                            </div>
                            <div class="p-card-body">
                                <div class="p-contact">
                                    @if(!empty($user->phone))
                                        <a class="p-contact-item" href="tel:{{$user->phone}}">
                                            <i class="fa fa-phone" aria-hidden="true"></i> {{$user->phone}}
                                        </a>
                                    @endif
                                    @if(!empty($user->mobile_num))
                                        <a class="p-contact-item" href="tel:{{$user->mobile_num}}">
                                            <i class="fa fa-mobile" aria-hidden="true"></i> {{$user->mobile_num}}
                                        </a>
                                    @endif
                                    @if(!empty($user->email))
                                        <a class="p-contact-item" href="mailto:{{$user->email}}">
                                            <i class="fa fa-envelope" aria-hidden="true"></i> {{$user->email}}
                                        </a>
                                    @endif
                                    <div class="p-contact-item">
                                        <i class="fa fa-map-marker" aria-hidden="true"></i> {{$user->street_address}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>

                        {{-- Candidate Details (SENİN Lİ’LERİN AYNISI) --}}
                        <div class="p-card mt-3">
                            <div class="p-card-head">
                                <h3 class="p-card-title">{{__('Candidate Details')}}</h3>
                            </div>
                            <div class="p-card-body">
                                <ul class="jbdetail row p-detail-grid">
                                    <li class="col-lg-6 col-md-6 col-6">
                                        <div class="jbitlist">
                                            <span class="material-symbols-outlined">verified</span>
                                            <div class="jbitdata">
                                                <strong>{{__('Verified')}}</strong>
                                                <span>{{((bool) $user->verified) ? __('Yes') : __('No')}}</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="col-lg-6 col-md-6 col-6">
                                        <div class="jbitlist">
                                            <span class="material-symbols-outlined">handshake</span>
                                            <div class="jbitdata">
                                                <strong>{{__('Ready for Hire')}}</strong>
                                                <span>{{((bool) $user->is_immediate_available) ? __('Yes') : __('No')}}</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="col-lg-6 col-md-6 col-6">
                                        <div class="jbitlist">
                                            <span class="material-symbols-outlined">cake</span>
                                            <div class="jbitdata">
                                                <strong>{{__('Age')}}</strong>
                                                <span>{{$user->getAge()}} {{__('Years')}}</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="col-lg-6 col-md-6 col-6">
                                        <div class="jbitlist">
                                            <span class="material-symbols-outlined">account_circle</span>
                                            <div class="jbitdata">
                                                <strong>{{__('Gender')}}</strong>
                                                <span>{{$user->getGender('gender')}}</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="col-lg-6 col-md-6 col-6">
                                        <div class="jbitlist">
                                            <span class="material-symbols-outlined">content_paste</span>
                                            <div class="jbitdata">
                                                <strong>{{__('Marital Status')}}</strong>
                                                <span>{{$user->getMaritalStatus('marital_status')}}</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="col-lg-6 col-md-6 col-6">
                                        <div class="jbitlist">
                                            <span class="material-symbols-outlined">business_center</span>
                                            <div class="jbitdata">
                                                <strong>{{__('Experience')}}</strong>
                                                <span>{{$user->getJobExperience('job_experience')}}</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="col-lg-6 col-md-6 col-6">
                                        <div class="jbitlist">
                                            <span class="material-symbols-outlined">schema</span>
                                            <div class="jbitdata">
                                                <strong>{{__('Career Level')}}</strong>
                                                <span>{{$user->getCareerLevel('career_level')}}</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="col-lg-6 col-md-6 col-6">
                                        <div class="jbitlist">
                                            <span class="material-symbols-outlined">location_on</span>
                                            <div class="jbitdata">
                                                <strong>{{__('Location')}}</strong>
                                                <span>{{$user->getLocation()}}</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="col-lg-6 col-md-6 col-6">
                                        <div class="jbitlist">
                                            <span class="material-symbols-outlined">currency_lira</span>
                                            <div class="jbitdata">
                                                <strong>{{__('Current Salary')}}</strong>
                                                <span>{{$user->formatSalary($user->current_salary)}}</span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="col-lg-6 col-md-6 col-6">
                                        <div class="jbitlist">
                                            <span class="material-symbols-outlined">currency_lira</span>
                                            <div class="jbitdata">
                                                <strong>{{__('Expected Salary')}}</strong>
                                                <span>{{$user->formatSalary($user->expected_salary)}}</span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        {{-- Video (sadece personel/bakıcı/iş arayan) --}}
                        @if(!$user->isMember() && $user->video_link !== '' && null !== ($user->video_link))
                            <div class="p-card mt-3">
                                <div class="p-card-head">
                                    <h3 class="p-card-title">{{__('Video Profile')}}</h3>
                                </div>
                                <div class="p-card-body">
                                    <div class="p-video">
                                        @if(preg_match('/(youtube\.com|youtu\.be|vimeo\.com)/i', $user->video_link))
                                            <iframe src="{{$user->video_link}}" frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                allowfullscreen></iframe>
                                        @else
                                            <video width="100%" height="auto" controls>
                                                <source src="{{ asset('uploads/videos/' . $user->video_link) }}" type="video/mp4">
                                                {{__('Tarayıcınız video etiketini desteklemiyor.')}}
                                            </video>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- SEND MESSAGE MODAL (SENİN KODUN) --}}
    <div class="modal fade" id="sendmessage" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="" id="send-form">
                    @csrf
                    <input type="hidden" name="seeker_id" id="seeker_id" value="{{$user->id}}">
                    <div class="modal-header">
                        <h4 class="modal-title">{{__('Mesaj Gönder')}}</h4>
                        <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <textarea class="form-control" name="message" id="message" cols="10" rows="7"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">{{__('Close')}}</button>
                        <button type="submit" class="btn btn-primary">{{__('Submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    @include('includes.footer')
@endsection


@push('styles')
    <style>
        /* ========= PROFILE V2 (TEK CSS) ========= */
        .profile-v2 {
            --p-bg: #f6f8fb;
            --p-card: #fff;
            --p-text: #111827;
            --p-muted: #6b7280;
            --p-line: #e5e7eb;
            --p-primary: #0357e9;
            --p-radius: 16px;
            background: var(--p-bg);
        }

        .profile-v2 .container {
            padding-top: 18px;
            padding-bottom: 30px;
        }

        /* HERO */
        .profile-v2 .p-hero {
            background: var(--p-card);
            border: 1px solid var(--p-line);
            border-radius: var(--p-radius);
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .04);
        }

        .profile-v2 .p-cover {
            position: relative;
            height: 220px;
            background: #0b1220;
        }

        .profile-v2 .p-cover img {
            width: 100%;
            height: 220px;
            object-fit: cover;
            display: block;
        }

        .profile-v2 .p-cover-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(0, 0, 0, .10), rgba(0, 0, 0, .60));
        }

        .profile-v2 .p-header {
            display: flex;
            gap: 16px;
            align-items: flex-end;
            padding: 0 18px 16px 18px;
            margin-top: -28px;
        }

        .profile-v2 .p-avatar {
            width: 108px;
            height: 108px;
            border-radius: 18px;
            overflow: hidden;
            border: 4px solid #fff;
            box-shadow: 0 18px 35px rgba(0, 0, 0, .12);
            background: #fff;
            flex: 0 0 auto;
        }

        .profile-v2 .p-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .profile-v2 .p-title {
            min-width: 0;
            padding-bottom: 6px;
        }

        .profile-v2 .p-name {
            margin: 0;
            font-size: 22px;
            font-weight: 900;
            color: #0b1220;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: baseline;
        }

        .profile-v2 .p-badge {
            font-size: 13px;
            font-weight: 800;
            color: #fff;
            background: rgba(3, 87, 233, .92);
            padding: 6px 10px;
            border-radius: 999px;
        }

        .profile-v2 .p-meta {
            margin-top: 10px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            color: #e5e7eb;
        }

        .profile-v2 .p-meta span {
            display: inline-flex;
            gap: 8px;
            align-items: center;
            font-weight: 700;
            font-size: 13px;
        }

        .profile-v2 .p-ready {
            background: #17d27c;
            color: #d1fae5;
            padding: 6px 10px;
            border-radius: 999px;
            border: 1px solid rgba(34, 197, 94, .25);
        }

        /* ACTIONS */
        .profile-v2 .p-actions {
            padding: 12px 18px 18px 18px;
            border-top: 1px solid var(--p-line);
            background: #fff;
        }

        .profile-v2 .p-actions-inner {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }

        .profile-v2 .p-btn {
            border-radius: 12px !important;
            padding: 10px 14px !important;
            font-weight: 800 !important;
            letter-spacing: .2px;
        }

        .profile-v2 .p-btn-primary {
            background: var(--p-primary) !important;
            border-color: var(--p-primary) !important;
            color: #fff !important;
        }

        .profile-v2 .p-btn-lock {
            border: 1px dashed rgba(3, 87, 233, .45) !important;
        }

        .profile-v2 .p-hint {
            color: var(--p-muted);
            font-weight: 700;
            font-size: 12px;
        }

        /* ALERT */
        .profile-v2 .p-alert {
            padding: 10px 12px;
            border-radius: 12px;
            font-weight: 800;
            font-size: 13px;
            border: 1px solid;
        }

        .profile-v2 .p-alert-danger {
            background: #fff1f2;
            color: #9f1239;
            border-color: #fecdd3;
        }

        /* CARDS */
        .profile-v2 .p-card {
            background: var(--p-card);
            border: 1px solid var(--p-line);
            border-radius: var(--p-radius);
            box-shadow: 0 10px 25px rgba(0, 0, 0, .04);
            overflow: hidden;
        }

        .profile-v2 .p-card-head {
            padding: 16px 18px;
            border-bottom: 1px solid var(--p-line);
            background: linear-gradient(180deg, rgba(3, 87, 233, .06), rgba(3, 87, 233, 0));
        }

        .profile-v2 .p-card-title {
            margin: 0;
            font-size: 16px;
            font-weight: 900;
            color: #1f2937;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .profile-v2 .p-card-body {
            padding: 16px 18px;
        }

        .profile-v2 .p-text {
            margin: 0;
            color: #374151;
            line-height: 1.7;
        }

        /* SERVICE MINI */
        .profile-v2 .p-mini-card {
            border: 1px solid var(--p-line);
            border-radius: 14px;
            padding: 14px;
            height: 100%;
            background: #fff;
            transition: transform .15s ease, box-shadow .15s ease, border-color .15s ease;
        }

        .profile-v2 .p-mini-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 18px 35px rgba(0, 0, 0, .06);
            border-color: rgba(3, 87, 233, .25);
        }

        .profile-v2 .p-mini-title {
            font-weight: 900;
            color: #0b1220;
            margin-bottom: 10px;
        }

        .profile-v2 .p-mini-row {
            display: flex;
            gap: 8px;
            align-items: flex-start;
            color: #4b5563;
            font-size: 13px;
            margin-bottom: 6px;
        }

        .profile-v2 .p-mini-row i {
            color: var(--p-primary);
            margin-top: 3px;
            width: 16px;
            text-align: center;
        }

        .profile-v2 .p-mini-status {
            margin-top: 10px;
        }

        /* SIDEBAR sticky */
        .profile-v2 .p-sticky {
            position: sticky;
            top: 18px;
        }

        /* CONTACT */
        .profile-v2 .p-contact {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .profile-v2 .p-contact-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border: 1px solid var(--p-line);
            border-radius: 12px;
            color: #111827;
            text-decoration: none;
            background: #fff;
        }

        .profile-v2 .p-contact-item i {
            color: var(--p-primary);
            width: 16px;
            text-align: center;
        }

        .profile-v2 .p-contact-item:hover {
            border-color: rgba(3, 87, 233, .30);
            box-shadow: 0 12px 25px rgba(0, 0, 0, .05);
        }

        /* DETAILS */
        .profile-v2 .p-detail-grid>li {
            margin-bottom: 14px;
        }

        .profile-v2 .jbitlist {
            border: 1px solid var(--p-line);
            border-radius: 14px;
            padding: 12px;
            background: #fff;
        }

        .profile-v2 .jbitlist .material-symbols-outlined {
            color: var(--p-primary);
            background: rgba(3, 87, 233, .10);
            border-radius: 999px;
            padding: 8px;
            margin-right: 10px;
            vertical-align: middle;
        }

        /* VIDEO */
        .profile-v2 .p-video {
            border-radius: 14px;
            overflow: hidden;
            border: 1px solid var(--p-line);
        }

        .profile-v2 .p-video iframe {
            width: 100%;
            height: 220px;
            display: block;
        }

        /* Mobile */
        @media (max-width: 991px) {
            .profile-v2 .p-sticky {
                position: static;
            }
        }

        @media (max-width: 767px) {
            .profile-v2 .p-cover {
                height: 160px;
            }

            .profile-v2 .p-cover img {
                height: 160px;
            }

            .profile-v2 .p-header {
                margin-top: 20px;
                padding: 0 12px 12px 12px;
            }

            .profile-v2 .p-avatar {
                width: 92px;
                height: 92px;
                border-radius: 16px;
            }

            .profile-v2 .p-name {
                font-size: 18px;
            }

            .profile-v2 .p-badge {
                font-size: 12px;
            }

            .profile-v2 .p-actions {
                padding: 12px;
            }

            .profile-v2 .p-card-body {
                padding: 14px;
            }

            .profile-v2 .p-card-head {
                padding: 14px;
            }
        }

        /* ====== COVER SİĞDIRMA PATCH ====== */
        .profile-v2 .p-cover {
            position: relative;
            height: 220px;
            /* istersen 180 yap */
            overflow: hidden;
        }

        /* printUserCoverImage() ne döndürürse döndürsün,
                       cover içine %100 sığdır */
        .profile-v2 .p-cover>* {
            position: absolute !important;
            inset: 0 !important;
            width: 100% !important;
            height: 100% !important;
            max-width: 100% !important;
            max-height: 100% !important;
        }

        /* İçeride img varsa */
        .profile-v2 .p-cover img {
            width: 100% !important;
            height: 100% !important;
            object-fit: cover !important;
            display: block !important;
        }

        /* Cover içinde "Kapak fotoğrafı ekleyiniz" gibi bir placeholder varsa */
        .profile-v2 .p-cover,
        .profile-v2 .p-cover * {
            box-sizing: border-box;
        }

        .profile-v2 .p-cover {
            display: block;
        }

        /* Overlay üste gelsin */
        .profile-v2 .p-cover-overlay {
            position: absolute;
            inset: 0;
            z-index: 2;
        }

        /* Cover içeriği overlay'in altında kalsın */
        .profile-v2 .p-cover>* {
            z-index: 1;
        }

        /* Header (avatar + isim) overlay üstünde kalsın */
        .profile-v2 .p-header {
            position: relative;
            z-index: 3;
        }
    </style>
@endpush


@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).on('click', '#send_applicant_message', function () {
                var postData = $('#send-applicant-message-form').serialize();
                $.ajax({
                    type: 'POST',
                    url: "{{ route('contact.applicant.message.send') }}",
                    data: postData,
                    success: function (data) {
                        response = JSON.parse(data);
                        var res = response.success;
                        if (res == 'success') {
                            var errorString = '<div role="alert" class="alert alert-success">' + response.message + '</div>';
                            $('#alert_messages').html(errorString);
                            $('#send-applicant-message-form').hide('slow');
                            $(document).scrollTo('.alert', 2000);
                        } else {
                            var errorString = '<div class="alert alert-danger" role="alert"><ul>';
                            response = JSON.parse(data);
                            $.each(response, function (index, value) {
                                errorString += '<li>' + value + '</li>';
                            });
                            errorString += '</ul></div>';
                            $('#alert_messages').html(errorString);
                            $(document).scrollTo('.alert', 2000);
                        }
                    },
                });
            });

            showEducation();
            showProjects();
            showExperience();
            showSkills();
            showLanguages();
        });

        function showProjects() {
            $.post("{{ route('show.applicant.profile.projects', $user->id) }}",
                { user_id: {{$user->id}}, _method: 'POST', _token: '{{ csrf_token() }}' }
            ).done(function (response) {
                $('#projects_div').html(response);
            });
        }

        function showExperience() {
            $.post("{{ route('show.applicant.profile.experience', $user->id) }}",
                { user_id: {{$user->id}}, _method: 'POST', _token: '{{ csrf_token() }}' }
            ).done(function (response) {
                $('#experience_div').html(response);
            });
        }

        function showEducation() {
            $.post("{{ route('show.applicant.profile.education', $user->id) }}",
                { user_id: {{$user->id}}, _method: 'POST', _token: '{{ csrf_token() }}' }
            ).done(function (response) {
                $('#education_div').html(response);
            });
        }

        function showLanguages() {
            $.post("{{ route('show.applicant.profile.languages', $user->id) }}",
                { user_id: {{$user->id}}, _method: 'POST', _token: '{{ csrf_token() }}' }
            ).done(function (response) {
                $('#language_div').html(response);
            });
        }

        function showSkills() {
            $.post("{{ route('show.applicant.profile.skills', $user->id) }}",
                { user_id: {{$user->id}}, _method: 'POST', _token: '{{ csrf_token() }}' }
            ).done(function (response) {
                $('#skill_div').html(response);
            });
        }

        function send_message() {
            const el = document.createElement('div')
            el.innerHTML = "Lütfen <a class='btn' href='{{route('login')}}' onclick='set_session()'>giriş yapın</a> bir İşveren olarak ve tekrar deneyin."
            @if(null !== (Auth::guard('company')->user()))
                $('#sendmessage').modal('show');
            @else
                swal({
                    title: "Giriş yapmadınız",
                    content: el,
                    icon: "error",
                    button: "TAMAM",
                });
            @endif
                        }

        if ($("#send-form").length > 0) {
            $("#send-form").validate({
                validateHiddenInputs: true,
                ignore: "",
                rules: {
                    message: {
                        required: true,
                        maxlength: 5000
                    },
                },
                messages: {
                    message: { required: "{{__('Message is required')}}" }
                },
                submitHandler: function (form) {
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    @if(null !== (Auth::guard('company')->user()))
                        $.ajax({
                            url: "{{route('submit-message-seeker')}}",
                            type: "POST",
                            data: $('#send-form').serialize(),
                            success: function (response) {
                                $("#send-form").trigger("reset");
                                $('#sendmessage').modal('hide');
                                swal({
                                    title: "{{__('Success')}}",
                                    text: response["msg"],
                                    icon: "success",
                                    button: "{{__('OK')}}",
                                });
                            }
                        });
                    @endif
                                }
            })
        }
    </script>
@endpush