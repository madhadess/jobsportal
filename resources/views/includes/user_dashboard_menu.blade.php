<div class="col-lg-3">

    <!-- Featured Profile Package -->
    <?php 
    $featured_package = App\Package::where('package_for', 'make_featured')->first();
$packageEndDate = auth()->user()->featured_package_end_at ?? auth()->user()->package_end_date;
$isExpired = $packageEndDate ? \Carbon\Carbon::parse($packageEndDate)->isPast() : true;
?>

    @if((bool) config('jobseeker.is_jobseeker_package_active'))
    @if(auth()->user()->isCandidate())
        @if(!auth()->user()->is_featured || $isExpired)
            <div class="featuredprofile">
                <div class="packginfor">
                    <h5><i class="fas fa-bolt"></i> {{__($featured_package->package_title)}}</h5>
                    <div class="featprice">
                        {{$featured_package->package_price}} {{ $siteSetting->default_currency_code ?? '' }}
                        <span>{{$featured_package->package_num_days}} {{__('Gün İçin')}}</span>
                    </div>
                    <p>{{__('İש piyasasında rakiplerinizin önüne geçin ve ayrıcalıklı özelliklerden yararlanın.')}}</p>
                    <ul class="pckfeatlist">
                        <li><i class="fas fa-crown"></i> {{__('Premium Rozet')}}</li>
                        <li><i class="fas fa-chart-line"></i> {{__('Sıra Yükseltici')}}</li>
                        <li><i class="fas fa-ribbon"></i> {{__('CV’niz diğerlerinin üzerinde görüntülenir')}}</li>
                        <li><i class="fas fa-briefcase"></i> {{__('Daha Fazla İş Fırsatı')}}</li>
                        <li><i class="fas fa-eye"></i> {{__('Daha Fazla Profil Görüntülenmesi')}}</li>
                        <li><i class="fas fa-bell"></i> {{__('Özel Bildirimler')}}</li>
                    </ul>
                </div>
                <div class="order">
                    @if(count(auth()->user()->getProfileProjectsArray()) == 0 || count(auth()->user()->getProfileCvsArray()) == 0 || count(auth()->user()->profileExperience()->get()) == 0 || count(auth()->user()->profileEducation()->get()) == 0 || count(auth()->user()->profileSkills()->get()) == 0)
                        <a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#buyfeatured">{{__('Satın Al')}}</a>
                    @else
                        <a href="{{ route('order.package', $featured_package->id) }}" class="btn btn-primary d-block">
                            <i class="fas fa-shopping-cart" aria-hidden="true"></i> {{__('Satın Al')}}
                        </a>
                    @endif
                </div>
            </div>
        @else
            <div class="featuredprofile purchased">
                <div class="packginfor">
                    <h5>{{__('Öne Çıkan Profil')}}</h5>
                    <p>{{__('Tebrikler! Profiliniz artık daha görünür ve işverenlerin dikkatini daha fazla çekecek şekilde öne çıkarıldı.')}}
                    </p>
                </div>
                <ul class="pckfeatlist">
                    <li><i class="fas fa-crown"></i> {{__('Premium Rozet')}}</li>
                    <li><i class="fas fa-chart-line"></i> {{__('Sıra Yükseltici')}}</li>
                    <li><i class="fas fa-ribbon"></i> {{__('CV’niz diğerlerinin üzerinde görüntülenir')}}</li>
                    <li><i class="fas fa-briefcase"></i> {{__('Daha Fazla İş Fırsatı')}}</li>
                    <li><i class="fas fa-eye"></i> {{__('Daha Fazla Profil Görüntülenmesi')}}</li>
                    <li><i class="fas fa-bell"></i> {{__('Özel Bildirimler')}}</li>
                </ul>
                <div class="">
                    <div class="order">
                        <span>{{__('Paket Başlangıç Tarihi')}}</span>
                        <strong>{{ \Carbon\Carbon::parse(auth()->user()->package_start_date)->translatedFormat('d F Y') }}</strong>
                    </div>
                    <div class="order">
                        <span>{{__('Paket Bitiş Tarihi')}}</span>
                        <strong>{{ \Carbon\Carbon::parse($packageEndDate)->translatedFormat('d F Y') }}</strong>
                    </div>
                </div>
            </div>
        @endif
    @endif

    <!-- Modal -->
    <div class="modal fade mypremodal" id="buyfeatured" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <div class="preuserinfo">
                        <h3>{{__('Öne çıkan paket satın almak için önce profilinizi tamamlamanız gerekmektedir.')}}</h3>
                        <a href="{{ route('my.profile') }}" class="btn btn-yellow mt-3">{{__('Profili Düzenle')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <div class="usernavwrap">
        @if(auth()->user()->isCandidate())
            <div class="switchbox">
                <div class="txtlbl">{{__('İşe Açık')}} <i class="fas fa-question-circle"
                        title="{{__('Hemen çalışmaya müsait misiniz?')}}"></i>
                </div>
                <div class="">
                    <label class="switch switch-green"> @php
                        $checked = ((bool) Auth::user()->is_immediate_available) ? 'checked="checked"' : '';
                    @endphp
                        <input type="checkbox" name="is_immediate_available" id="is_immediate_available"
                            class="switch-input" {{$checked}}
                            onchange="changeImmediateAvailableStatus({{Auth::user()->id}}, {{Auth::user()->is_immediate_available}});">
                        <span class="switch-label" data-on="{{__('Evet')}}" data-off="{{__('Hayır')}}"></span> <span
                            class="switch-handle"></span> </label>
                </div>
                <div class="clearfix"></div>
            </div>
        @endif

        <ul class="usernavdash">
            <li class="{{ Request::url() == route('home') ? 'active' : '' }}"><a href="{{route('home')}}"><i
                        class="fas fa-tachometer" aria-hidden="true"></i> {{__('Panel')}}</a></li>
            <li class="{{ Request::url() == route('my.profile') ? 'active' : '' }}"><a
                    href="{{ route('my.profile') }}"><i class="fas fa-pencil" aria-hidden="true"></i>
                    {{__('Profil Düzenle')}}</a>
            </li>
            @if(auth()->user()->isJobSeeker())
                <li class="{{ Request::url() == route('build.resume') ? 'active' : '' }}"><a
                        href="{{ route('build.resume') }}"><i class="fas fa-file" aria-hidden="true"></i>
                        {{__('Özgeçmiş Oluştur')}}</a></li>
                <li><a href="{{ route('resume', Auth::user()->id) }}"><i class="fa fa-print" aria-hidden="true"></i>
                        {{__('CV İndir')}}</a></li>
                <li><a href="{{ route('view.public.profile', Auth::user()->id) }}"><i class="fas fa-eye"
                            aria-hidden="true"></i>
                        {{__('Genel Profil')}}</a></li>
                <li class="{{ Request::url() == route('my.job.applications') ? 'active' : '' }}"><a
                        href="{{ route('my.job.applications') }}"><i class="fas fa-desktop" aria-hidden="true"></i>
                        {{__('İş Başvurularım')}}</a></li>
                <li class="{{ Request::url() == route('my.favourite.jobs') ? 'active' : '' }}"><a
                        href="{{ route('my.favourite.jobs') }}"><i class="fas fa-heart" aria-hidden="true"></i>
                        {{__('Favori İşlerim')}}</a></li>
                <li class="{{ Request::url() == route('my-alerts') ? 'active' : '' }}"><a href="{{ route('my-alerts') }}"><i
                            class="fas fa-bullhorn" aria-hidden="true"></i> {{__('İş Uyarılarım')}}</a></li>
                <li class="{{ Request::url() == route('my.followings') ? 'active' : '' }}"><a
                        href="{{route('my.followings')}}"><i class="fas fa-user" aria-hidden="true"></i>
                        {{__('Takip Ettiklerim')}}</a></li>

            @endif

            @if(auth()->user()->isPersonnel() || auth()->user()->isCaregiver())
                <li class="{{ Request::url() == route('build.resume') ? 'active' : '' }}"><a
                        href="{{ route('build.resume') }}"><i class="fas fa-file" aria-hidden="true"></i>
                        {{__('Özgeçmiş Oluştur')}}</a></li>
                <li><a href="{{ route('resume', Auth::user()->id) }}"><i class="fa fa-print" aria-hidden="true"></i>
                        {{__('CV İndir')}}</a></li>
                <li><a href="{{ route('view.public.profile', Auth::user()->id) }}"><i class="fas fa-eye"
                            aria-hidden="true"></i>
                        {{__('Genel Profil')}}</a></li>

                <li class="{{ Request::url() == route('personnel.assignments') ? 'active' : '' }}">
                    <a href="{{ route('personnel.assignments') }}"><i class="fas fa-tasks"></i>
                        {{__('Atanan Görevlerim')}}</a>
                </li>

                <li class="{{ Request::url() == route('personnel.preferences') ? 'active' : '' }}">
                    <a href="{{ route('personnel.preferences') }}"><i class="fas fa-cog"></i>
                        {{__('Çalışma Tercihlerim')}}</a>
                </li>

                {{-- İlanlar Modülü --}}
                <li class="{{ Request::routeIs('listings.*') ? 'active' : '' }}">
                    <a href="{{ route('listings.browse') }}"><i class="fas fa-list-alt"></i>
                        {{__('Hizmet İlanları')}}</a>
                </li>
                <li class="{{ Request::routeIs('my-applications.*') ? 'active' : '' }}">
                    <a href="{{ route('my-applications.index') }}"><i class="fas fa-paper-plane"></i>
                        {{__('Başvurularım')}}</a>
                </li>
            @endif

            @if(auth()->user()->isJobSeeker() || auth()->user()->isPersonnel() || auth()->user()->isCaregiver())
                <li class="{{ Request::url() == route('candidate.list-payment-history') ? 'active' : '' }}">
                    <a href="{{ route('candidate.list-payment-history') }}"><i class="fas fa-file-invoice-dollar"></i>
                        {{__('Ödeme Geçmişi')}}</a>
                </li>
            @endif

            @if(auth()->user()->isMember())
                <li class="{{ Request::url() == route('home-services.my-requests') ? 'active' : '' }}">
                    <a href="{{ route('home-services.my-requests') }}"><i class="fas fa-concierge-bell"></i>
                        {{__('Hizmet Taleplerim')}}</a>
                </li>

                {{-- İlanlar Modülü --}}
                <li class="{{ Request::routeIs('job-posts.*') ? 'active' : '' }}">
                    <a href="{{ route('job-posts.index') }}"><i class="fas fa-list-alt"></i>
                        {{__('İlanlarım')}}</a>
                </li>
            @endif

            <li class="{{ Request::url() == route('my.messages') ? 'active' : '' }}"><a
                    href="{{route('my.messages')}}"><i class="fas fa-envelope" aria-hidden="true"></i>
                    {{__('Mesajlarım')}}</a>
            </li>
            <li>
                <a href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out" aria-hidden="true"></i> {{__('Çıkış')}}
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </li>
        </ul>
    </div>
</div>