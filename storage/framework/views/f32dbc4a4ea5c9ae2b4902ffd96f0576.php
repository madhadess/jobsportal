<div class="header" id="siteheader">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-2 col-md-12 col-12"> <a href="<?php echo e(url('/')); ?>" class="logo"><img
            src="<?php echo e(asset('/')); ?>sitesetting_images/thumb/<?php echo e($siteSetting->site_logo); ?>"
            alt="<?php echo e($siteSetting->site_name); ?>" /></a>
        <div class="navbar-header navbar-light">
          <button class="navbar-toggler collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#nav-main"
            aria-controls="nav-main" aria-expanded="false" aria-label="Toggle navigation"> <i
              class="fas fa-bars"></i></button>
        </div>
        <div class="clearfix"></div>
      </div>
      <div class="col-lg-10 col-md-12 col-12">

        <!-- Nav start -->
        <nav class="navbar navbar-expand-lg navbar-light">

          <div class="navbar-collapse collapse" id="nav-main">
            <button class="close-toggler" type="button" data-toggle="offcanvas"> <span><i class="fas fa-times-circle"
                  aria-hidden="true"></i></span> </button>

            <ul class="navbar-nav">
              <li class="nav-item <?php echo e(Request::url() == route('index') ? 'active' : ''); ?>"><a href="<?php echo e(url('/')); ?>"
                  class="nav-link"><?php echo e(__('Home')); ?></a> </li>


              <?php if(Auth::guard('company')->check()): ?>
                <li class="nav-item <?php echo e(Request::url() == url('/job-seekers') ? 'active' : ''); ?>">
                  <a href="<?php echo e(url('/job-seekers')); ?>" class="nav-link">Yetenek Ara</a>
                </li>
              <?php else: ?>
                <li class="nav-item <?php echo e(Request::url() == route('job.list') ? 'active' : ''); ?>">
                  <a href="<?php echo e(route('job.list')); ?>" class="nav-link">İş İlanları</a>
                </li>
              <?php endif; ?>




              <li class="nav-item <?php echo e(Request::url() == route('company.listing') ? 'active' : ''); ?>">
                <a href="<?php echo e(route('company.listing')); ?>" class="nav-link">Şirketler</a>
              </li>

              <li class="nav-item nav-highlight <?php echo e(Request::url() == route('home-services.index') ? 'active' : ''); ?>">
                <a href="<?php echo e(route('home-services.index')); ?>" class="nav-link nav-link-highlight nav-link-hizmet">
                  <i class="fa fa-home"></i> Evine Hizmet Al
                </a>
              </li>

              <li class="nav-item nav-highlight <?php echo e(Request::url() == route('caregiver.index') ? 'active' : ''); ?>">
                <a href="<?php echo e(route('caregiver.index')); ?>" class="nav-link nav-link-highlight nav-link-bakici">
                  <i class="fa fa-heart"></i> Bakıcı Noktası
                </a>
              </li>



              <li class="nav-item <?php echo e(Request::url() == route('blogs') ? 'active' : ''); ?>"><a href="<?php echo e(route('blogs')); ?>"
                  class="nav-link"><?php echo e(__('Blog')); ?></a> </li>
              <li class="nav-item <?php echo e(Request::url() == route('contact.us') ? 'active' : ''); ?>"><a
                  href="<?php echo e(route('contact.us')); ?>" class="nav-link"><?php echo e(__('Contact Us')); ?></a> </li>
              <?php if(Auth::check() && !Auth::guard('company')->check()): ?>
                <li class="nav-item dropdown userbtn"><a href=""><?php echo e(Auth::user()->printUserImage()); ?></a>
                  <ul class="dropdown-menu">
                    <li class="nav-item"><a href="<?php echo e(route('home')); ?>" class="nav-link"><i class="fa fa-tachometer"
                          aria-hidden="true"></i> <?php echo e(__('Dashboard')); ?></a> </li>
                    <li class="nav-item"><a href="<?php echo e(route('my.profile')); ?>" class="nav-link"><i class="fa fa-user"
                          aria-hidden="true"></i> <?php echo e(__('My Profile')); ?></a> </li>
                    <?php if(Auth::user()->isMember()): ?>
                      <li class="nav-item"><a href="<?php echo e(route('home-services.my-requests')); ?>" class="nav-link"><i
                            class="fa fa-list" aria-hidden="true"></i> <?php echo e(__('My Requests')); ?></a> </li>
                    <?php endif; ?>
                    <li class="nav-item"><a href="<?php echo e(route('view.public.profile', Auth::user()->id)); ?>"
                        class="nav-link"><i class="fa fa-eye" aria-hidden="true"></i> <?php echo e(__('Public Profile')); ?></a> </li>
                    <li><a href="<?php echo e(route('my.job.applications')); ?>" class="nav-link"><i class="fa fa-desktop"
                          aria-hidden="true"></i> <?php echo e(__('My Job Applications')); ?></a> </li>
                    <li class="nav-item"><a href="<?php echo e(route('logout')); ?>"
                        onclick="event.preventDefault(); document.getElementById('logout-form-header').submit();"
                        class="nav-link"><i class="fa fa-sign-out" aria-hidden="true"></i> <?php echo e(__('Logout')); ?></a> </li>
                    <form id="logout-form-header" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                      <?php echo e(csrf_field()); ?>

                    </form>
                  </ul>
                </li>
              <?php elseif(Auth::guard('company')->check()): ?>
                <li class="nav-item register"><a href="<?php echo e(route('post.job')); ?>" class="nav-link register">İş İlanı Ver</a>
                </li>
                <li class="nav-item dropdown userbtn"><a
                    href=""><?php echo e(Auth::guard('company')->user()->printCompanyImage()); ?></a>
                  <ul class="dropdown-menu">
                    <li class="nav-item"><a href="<?php echo e(route('company.home')); ?>" class="nav-link"><i class="fa fa-tachometer"
                          aria-hidden="true"></i> <?php echo e(__('Dashboard')); ?></a> </li>
                    <li class="nav-item"><a href="<?php echo e(route('company.profile')); ?>" class="nav-link"><i class="fa fa-user"
                          aria-hidden="true"></i> <?php echo e(__('Company Profile')); ?></a></li>
                    <li class="nav-item"><a href="<?php echo e(route('post.job')); ?>" class="nav-link"><i class="fa fa-desktop"
                          aria-hidden="true"></i> <?php echo e(__('Post a Job')); ?></a></li>
                    <li class="nav-item"><a href="<?php echo e(route('company.messages')); ?>" class="nav-link"><i
                          class="fa fa-envelope" aria-hidden="true"></i> <?php echo e(__('Company Messages')); ?></a></li>
                    <li class="nav-item"><a href="<?php echo e(route('company.logout')); ?>"
                        onclick="event.preventDefault(); document.getElementById('logout-form-header1').submit();"
                        class="nav-link"><i class="fa fa-sign-out" aria-hidden="true"></i> <?php echo e(__('Logout')); ?></a> </li>
                    <form id="logout-form-header1" action="<?php echo e(route('company.logout')); ?>" method="POST"
                      style="display: none;">
                      <?php echo e(csrf_field()); ?>

                    </form>
                  </ul>
                </li>
              <?php endif; ?>

              <?php if(!Auth::user() && !Auth::guard('company')->user()): ?>
                <li class="nav-item dropdown auth-dropdown" id="authDropdown">
                  <a href="javascript:void(0);" class="nav-link dropdown-toggle auth-btn" data-bs-toggle="dropdown"
                    aria-expanded="false" onclick="toggleAuthDropdown(event)">
                    <span>Giriş Yap / Üye Ol</span>
                    <i class="fas fa-chevron-down ms-1"></i>
                  </a>
                  <div class="dropdown-menu dropdown-menu-end auth-menu">
                    <!-- Aday Bölümü -->
                    <div class="auth-section">
                      <h6 class="auth-section-title">Aday (İş mi Arıyorsun?)</h6>
                      <p class="auth-section-desc">Burada seni bekleyen binlerce ilan var!</p>
                      <div class="auth-buttons">
                        <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-primary btn-sm">Aday Girişi</a>
                        <a href="<?php echo e(route('register')); ?>" class="btn btn-primary btn-sm">Üye Ol</a>
                      </div>
                    </div>

                    <hr class="auth-divider">

                    <!-- İşveren Bölümü -->
                    <div class="auth-section">
                      <h6 class="auth-section-title">İşveren (İlan mı Vereceksiniz?)</h6>
                      <p class="auth-section-desc">Pozisyonunuza en uygun aday burada!</p>
                      <ul class="auth-links">
                        <li><a href="<?php echo e(url('company-login')); ?>"><i class="fas fa-sign-in-alt"></i> İşveren Girişi</a>
                        </li>
                        <li><a href="<?php echo e(url('company-register')); ?>"><i class="fas fa-user-plus"></i> Ücretsiz Üye Ol!</a>
                        </li>
                        <li><a href="<?php echo e(route('post.job')); ?>"><i class="fas fa-briefcase"></i> İşe Alım Çözümleri</a></li>
                        <li><a href="<?php echo e(route('contact.us')); ?>"><i class="fas fa-phone"></i> Sizi Arayalım</a></li>
                      </ul>
                    </div>
                  </div>
                </li>
              <?php endif; ?>
              <li class="nav-item dropdown lang-selector">
                <?php
                  $currentLang = app()->getLocale();
                  $countryMap = [
                    'tr' => 'tr',
                    'en' => 'gb',
                    'de' => 'de',
                    'fr' => 'fr',
                    'ar' => 'sa',
                    'es' => 'es',
                    'ru' => 'ru',
                    'zh' => 'cn',
                    'ja' => 'jp',
                    'ko' => 'kr',
                    'it' => 'it',
                    'pt' => 'pt',
                    'nl' => 'nl',
                    'pl' => 'pl',
                  ];
                ?>
                <a href="javascript:void(0);" class="nav-link dropdown-toggle lang-btn" data-bs-toggle="dropdown">
                  <img src="https://flagcdn.com/24x18/<?php echo e($countryMap[$currentLang] ?? 'tr'); ?>.png"
                    alt="<?php echo e($currentLang); ?>" class="flag-img">
                  <span class="lang-code"><?php echo e(strtoupper($currentLang)); ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <?php $__currentLoopData = $siteLanguages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $siteLang): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li>
                      <a href="javascript:;"
                        onclick="event.preventDefault(); document.getElementById('locale-form-<?php echo e($siteLang->iso_code); ?>').submit();"
                        class="dropdown-item <?php echo e($currentLang == $siteLang->iso_code ? 'active' : ''); ?>">
                        <img src="https://flagcdn.com/24x18/<?php echo e($countryMap[$siteLang->iso_code] ?? 'tr'); ?>.png"
                          alt="<?php echo e($siteLang->iso_code); ?>" class="flag-img">
                        <span><?php echo e($siteLang->native); ?></span>
                      </a>
                      <form id="locale-form-<?php echo e($siteLang->iso_code); ?>" action="<?php echo e(route('set.locale')); ?>" method="POST"
                        style="display: none;">
                        <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="locale" value="<?php echo e($siteLang->iso_code); ?>" />
                        <input type="hidden" name="return_url" value="<?php echo e(url()->full()); ?>" />
                        <input type="hidden" name="is_rtl" value="<?php echo e($siteLang->is_rtl); ?>" />
                      </form>
                    </li>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
              </li>
            </ul>

            <!-- Nav collapes end -->

          </div>
          <div class="clearfix"></div>
        </nav>

        <!-- Nav end -->

      </div>
    </div>

    <!-- row end -->

  </div>

  <!-- Header container end -->

</div>






<?php /*?>@if(!Auth::user() && !Auth::guard('company')->user())
<div class="">my dive 2</div>
@endif<?php */?>




<!-- Login -->
<div class="modal fade mypremodal" id="headlogin" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

      <div class="modal-body">
        <div class="preuserinfo">
          <h3>Giriş Yap</h3>
          <a href="<?php echo e(route('login')); ?>" class="btn btn-yellow mt-3">İş Arayan</a>
          <a href="<?php echo e(url('company-login')); ?>" class="btn btn-dark mt-3">Şirket</a>
        </div>
      </div>

    </div>
  </div>
</div>


<!-- Register -->
<div class="modal fade mypremodal" id="headregister" tabindex="-1" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

      <div class="modal-body">
        <div class="preuserinfo p-2 pb-4">
          <h3>Kayıt Ol</h3>
          <a href="<?php echo e(route('register')); ?>" class="btn btn-yellow mt-3">İş Arayan</a>
          <a href="<?php echo e(url('company-register')); ?>" class="btn btn-dark mt-3">Şirket</a>
        </div>
      </div>

    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade mypremodal" id="preresume" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

      <div class="modal-body">
        <div class="preuserinfo">
          <h3>Özgeçmişinizi Oluşturmak İçin Giriş Yapın veya Kayıt Olun</h3>
          <a href="<?php echo e(route('login')); ?>" class="btn btn-yellow mt-3">Giriş Yap</a>
          <a href="<?php echo e(route('register')); ?>" class="btn btn-dark mt-3">Kayıt Ol</a>
        </div>
      </div>

    </div>
  </div>
</div>

<div class="modal fade mypremodal" id="prejobpost" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

      <div class="modal-body">
        <div class="preuserinfo ps-0 pe-0">
          <h3>İşveren Portalına Hoş Geldiniz</h3>
          <p>Kullanıcılarımızın güvenini kazanın. İlan yayınlamaya başlamak için hesabınızı onaylandırın</p>

          <?php if(!Auth::user() && !Auth::guard('company')->user()): ?>
            <a href="<?php echo e(url('company-login')); ?>" class="btn btn-yellow mt-3">Giriş Yap</a>
            <a href="<?php echo e(url('company-register')); ?>" class="btn btn-dark mt-3">Kayıt Ol</a>


          <?php endif; ?>




        </div>
      </div>

    </div>
  </div>
</div>


<div class="mobilenav">
  <ul>
    <li><a href="<?php echo e(url('/')); ?>">
        <svg xmlns="http://www.w3.org/2000/svg" height="36px" viewBox="0 -960 960 960" width="36px" fill="#5f6368">
          <path
            d="M240-200h120v-240h240v240h120v-360L480-740 240-560v360Zm-80 80v-480l320-240 320 240v480H520v-240h-80v240H160Zm320-350Z" />
        </svg>
        <span>Anasayfa</span>
      </a></li>


    <?php if(Auth::guard('company')->check()): ?>
      <li>
        <a href="<?php echo e(url('/job-seekers')); ?>">
          <svg xmlns="http://www.w3.org/2000/svg" height="36px" viewBox="0 -960 960 960" width="36px" fill="#5f6368">
            <path
              d="M160-120q-33 0-56.5-23.5T80-200v-440q0-33 23.5-56.5T160-720h160v-80q0-33 23.5-56.5T400-880h160q33 0 56.5 23.5T640-800v80h160q33 0 56.5 23.5T880-640v440q0 33-23.5 56.5T800-120H160Zm0-80h640v-440H160v440Zm240-520h160v-80H400v80ZM160-200v-440 440Z" />
          </svg>
          <span>Talent</span>
        </a>
      </li>
    <?php else: ?>
      <li>
        <a href="<?php echo e(route('job.list')); ?>">
          <svg xmlns="http://www.w3.org/2000/svg" height="36px" viewBox="0 -960 960 960" width="36px" fill="#5f6368">
            <path
              d="M160-120q-33 0-56.5-23.5T80-200v-440q0-33 23.5-56.5T160-720h160v-80q0-33 23.5-56.5T400-880h160q33 0 56.5 23.5T640-800v80h160q33 0 56.5 23.5T880-640v440q0 33-23.5 56.5T800-120H160Zm0-80h640v-440H160v440Zm240-520h160v-80H400v80ZM160-200v-440 440Z" />
          </svg>
          <span>İlanlar</span>
        </a>
      </li>
    <?php endif; ?>




    <?php if(!Auth::user() && !Auth::guard('company')->user()): ?>
      <li>
        <a href="<?php echo e(route('company.listing')); ?>">
          <svg xmlns="http://www.w3.org/2000/svg" height="36px" viewBox="0 -960 960 960" width="36px" fill="#5f6368">
            <path
              d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Zm80-80h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z" />
          </svg>
          <span>Şirketler</span>
        </a>
      </li>


      <li>
        <a href="javascript:void();" data-bs-toggle="modal" data-bs-target="#headlogin">
          <svg xmlns="http://www.w3.org/2000/svg" height="36px" viewBox="0 -960 960 960" width="36px" fill="#5f6368">
            <path
              d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Zm80-80h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z" />
          </svg>
          <span>Giriş Yap</span>
        </a>
      </li>
    <?php endif; ?>



    <?php if(Auth::check() && !Auth::guard('company')->check()): ?>
      <li>
        <a href="<?php echo e(route('my.messages')); ?>">
          <svg xmlns="http://www.w3.org/2000/svg" height="36px" viewBox="0 -960 960 960" width="36px" fill="#5f6368">
            <path
              d="M880-80 720-240H320q-33 0-56.5-23.5T240-320v-40h440q33 0 56.5-23.5T760-440v-280h40q33 0 56.5 23.5T880-640v560ZM160-473l47-47h393v-280H160v327ZM80-280v-520q0-33 23.5-56.5T160-880h440q33 0 56.5 23.5T680-800v280q0 33-23.5 56.5T600-440H240L80-280Zm80-240v-280 280Z" />
          </svg>
          <span>Mesajlar</span>
        </a>
      </li>
      <li>
        <a href="javascript:void();" class="openmbnav">
          <svg xmlns="http://www.w3.org/2000/svg" height="36px" viewBox="0 -960 960 960" width="36px" fill="#5f6368">
            <path
              d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Zm80-80h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z" />
          </svg>
          <span>Profil</span>
        </a>
      </li>


    <?php elseif(Auth::guard('company')->check()): ?>
      <li>
        <a href="<?php echo e(route('company.messages')); ?>">
          <svg xmlns="http://www.w3.org/2000/svg" height="36px" viewBox="0 -960 960 960" width="36px" fill="#5f6368">
            <path
              d="M880-80 720-240H320q-33 0-56.5-23.5T240-320v-40h440q33 0 56.5-23.5T760-440v-280h40q33 0 56.5 23.5T880-640v560ZM160-473l47-47h393v-280H160v327ZM80-280v-520q0-33 23.5-56.5T160-880h440q33 0 56.5 23.5T680-800v280q0 33-23.5 56.5T600-440H240L80-280Zm80-240v-280 280Z" />
          </svg>
          <span>Mesajlar</span>
        </a>
      </li>
      <li>
        <a href="javascript:void();" class="openmbnav">
          <svg xmlns="http://www.w3.org/2000/svg" height="36px" viewBox="0 -960 960 960" width="36px" fill="#5f6368">
            <path
              d="M480-480q-66 0-113-47t-47-113q0-66 47-113t113-47q66 0 113 47t47 113q0 66-47 113t-113 47ZM160-160v-112q0-34 17.5-62.5T224-378q62-31 126-46.5T480-440q66 0 130 15.5T736-378q29 15 46.5 43.5T800-272v112H160Zm80-80h480v-32q0-11-5.5-20T700-306q-54-27-109-40.5T480-360q-56 0-111 13.5T260-306q-9 5-14.5 14t-5.5 20v32Zm240-320q33 0 56.5-23.5T560-640q0-33-23.5-56.5T480-720q-33 0-56.5 23.5T400-640q0 33 23.5 56.5T480-560Zm0-80Zm0 400Z" />
          </svg>
          <span>Kontrol Paneli</span>
        </a>
      </li>

    <?php endif; ?>




  </ul>
</div>








<?php if(Auth::check() && !Auth::guard('company')->check()): ?>
  <ul class="usernavdash" id="usermbnav">
    <li class="nav-item"><a href="<?php echo e(route('home')); ?>" class="nav-link"><i class="fa fa-tachometer" aria-hidden="true"></i>
        Panel</a> </li>
    <li class="nav-item"><a href="<?php echo e(route('my.profile')); ?>" class="nav-link"><i class="fa fa-user"
          aria-hidden="true"></i> Profilim</a> </li>
    <?php if(Auth::user()->isMember()): ?>
      <li class="nav-item"><a href="<?php echo e(route('home-services.my-requests')); ?>" class="nav-link"><i class="fa fa-list"
            aria-hidden="true"></i> Taleplerim</a> </li>
    <?php endif; ?>
    <li class="nav-item"><a href="<?php echo e(route('view.public.profile', Auth::user()->id)); ?>" class="nav-link"><i
          class="fa fa-eye" aria-hidden="true"></i> Genel Profil</a> </li>
    <li><a href="<?php echo e(route('my.job.applications')); ?>" class="nav-link"><i class="fa fa-desktop" aria-hidden="true"></i> İş
        Başvurularım</a> </li>
    <li class="nav-item"><a href="<?php echo e(route('logout')); ?>"
        onclick="event.preventDefault(); document.getElementById('logout-form-header').submit();" class="nav-link"><i
          class="fa fa-sign-out" aria-hidden="true"></i> Çıkış</a> </li>
    <form id="logout-form-header" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
      <?php echo e(csrf_field()); ?>

    </form>
  </ul>
<?php elseif(Auth::guard('company')->check()): ?>
  <ul class="usernavdash" id="usermbnav">
    <li class="nav-item"><a href="<?php echo e(route('company.home')); ?>" class="nav-link"><i class="fa fa-tachometer"
          aria-hidden="true"></i> Panel</a> </li>
    <li class="nav-item"><a href="<?php echo e(route('company.profile')); ?>" class="nav-link"><i class="fa fa-user"
          aria-hidden="true"></i> Şirket Profili</a></li>
    <li class="nav-item"><a href="<?php echo e(route('post.job')); ?>" class="nav-link"><i class="fa fa-desktop"
          aria-hidden="true"></i> İş İlanı Yayınla</a></li>

    <li class="nav-item"><a href="<?php echo e(route('posted.jobs')); ?>" class="nav-link"><i class="fab fa-black-tie"></i> İlanları
        Yönet</a></li>

    <li class="nav-item"><a href="<?php echo e(route('company.packages')); ?>" class="nav-link"><i class="fas fa-search"
          aria-hidden="true"></i> CV Arama Paketleri</a></li>

    <li class="nav-item"><a href="<?php echo e(url('/list-payment-history')); ?>" class="nav-link"><i class="fas fa-file-invoice"></i>
        Ödeme Geçmişi</a></li>

    <li class="nav-item"><a href="<?php echo e(route('company.unloced-users')); ?>" class="nav-link"><i class="fas fa-user"
          aria-hidden="true"></i> Kilit Açık Kullanıcılar</a></li>
    <li class="nav-item"><a href="<?php echo e(route('company.followers')); ?>" class="nav-link"><i class="fas fa-users"
          aria-hidden="true"></i> Şirket Takipçileri</a></li>


    <li class="nav-item"><a href="<?php echo e(route('company.logout')); ?>"
        onclick="event.preventDefault(); document.getElementById('logout-form-header1').submit();" class="nav-link"><i
          class="fa fa-sign-out" aria-hidden="true"></i> Çıkış</a> </li>
    <form id="logout-form-header1" action="<?php echo e(route('company.logout')); ?>" method="POST" style="display: none;">
      <?php echo e(csrf_field()); ?>

    </form>
  </ul>
<?php endif; ?>

<script>
  function toggleAuthDropdown(event) {
    event.preventDefault();
    event.stopPropagation();
    var dropdown = document.getElementById('authDropdown');
    dropdown.classList.toggle('show');
    var menu = dropdown.querySelector('.dropdown-menu');
    menu.classList.toggle('show');
  }

  // Close dropdown when clicking outside
  document.addEventListener('click', function (event) {
    var dropdown = document.getElementById('authDropdown');
    if (dropdown && !dropdown.contains(event.target)) {
      dropdown.classList.remove('show');
      var menu = dropdown.querySelector('.dropdown-menu');
      if (menu) menu.classList.remove('show');
    }
  });
</script><?php /**PATH /home/personelnoktasit/public_html/resources/views/includes/header.blade.php ENDPATH**/ ?>