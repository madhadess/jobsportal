
<?php $__env->startSection('content'); ?>
    <!-- Header start -->
    <?php echo $__env->make('includes.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Header end -->

    <!-- Hero Section - Corporate Style with Slider -->
    <section class="corporate-hero">
        <div class="hero-bg-pattern"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h2 class="hero-title"><?php echo e(__('Kariyer Fırsatlarını Keşfet')); ?></h2>
                    <p class="hero-subtitle">
                        <span id="typewriter" class="typewriter-text"></span>
                        <span class="typewriter-cursor">|</span>
                    </p>

                    <!-- Search Form -->
                    <form action="<?php echo e(route('job.list')); ?>" method="get" class="hero-search-form">
                        <div class="search-box">
                            <div class="search-field">
                                <label><?php echo e(__('Pozisyon')); ?></label>
                                <input type="text" name="search" placeholder="<?php echo e(__('Ör: Bebek Bakıcısı')); ?>"
                                    class="form-control" />
                            </div>
                            <div class="search-field location-field">
                                <label><?php echo e(__('Şehir veya Firma adı')); ?></label>
                                <input type="text" name="location" placeholder="<?php echo e(__('Tüm Türkiye')); ?>"
                                    class="form-control" />
                            </div>
                            <button type="submit" class="btn btn-search">
                                <i class="fas fa-search"></i> <?php echo e(__('İş Ara')); ?>

                            </button>
                        </div>
                    </form>

                    <!-- Popular Searches Tags -->
                    <div class="popular-tags mt-4">
                        <span class="tag-label"><?php echo e(__('POPÜLER ARAMALAR')); ?></span>
                        <a href="<?php echo e(route('job.list', ['search' => 'Bakıcı'])); ?>" class="tag-item"><?php echo e(__('Bakıcı')); ?></a>
                        <a href="<?php echo e(route('job.list', ['search' => 'Elektirik Ustası'])); ?>"
                            class="tag-item"><?php echo e(__('Elektrik Ustası ')); ?></a>
                        <a href="<?php echo e(route('job.list', ['search' => 'Komi'])); ?>" class="tag-item"><?php echo e(__('Komi')); ?></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <?php if((bool) $siteSetting->is_slider_active): ?>
                        <!-- SEO Optimized Slider -->
                        <article class="slider-container" itemscope itemtype="https://schema.org/ImageGallery">
                            <div class="modern-slider" id="mainSlider" role="region"
                                aria-label="<?php echo e(__('Öne Çıkan İçerikler')); ?>">
                                <?php if(isset($sliders) && count($sliders)): ?>
                                    <?php $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <figure class="slide-item <?php echo e($index === 0 ? 'active' : ''); ?>" itemprop="image" itemscope
                                            itemtype="https://schema.org/ImageObject" data-slide="<?php echo e($index); ?>">
                                            <picture>
                                                <source media="(max-width: 768px)"
                                                    data-srcset="<?php echo e(ImgUploader::print_image_src('/slider_images/mobile_' . $slide->slider_image)); ?>">
                                                <img alt="<?php echo e($slide->slider_heading); ?>" title="<?php echo e($slide->slider_heading); ?>"
                                                    src="<?php echo e(ImgUploader::print_image_src('/slider_images/' . $slide->slider_image)); ?>"
                                                    class="slide-image" itemprop="contentUrl" width="600" height="400"
                                                    onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\" http://www.w3.org/2000/svg\"
                                                    viewBox=\"0 0 600 400\"%3E%3Crect fill=\"%23f0f0f0\" width=\"600\"
                                                    height=\"400\"/%3E%3Ctext fill=\"%23999\" x=\"50%\" y=\"50%\" text-anchor=\"middle\"
                                                    dy=\".3em\" font-size=\"20\"%3EResim Yüklenemedi%3C/text%3E%3C/svg%3E'">
                                            </picture>
                                            <figcaption class="slide-content">
                                                <h3 class="slide-heading" itemprop="name"><?php echo e($slide->slider_heading); ?></h3>
                                                <p class="slide-description" itemprop="description">
                                                    <?php echo strip_tags($slide->slider_description); ?></p>
                                                <?php if($slide->slider_link): ?>
                                                    <a href="<?php echo e($slide->slider_link); ?>" class="slide-cta" itemprop="url"
                                                        rel="noopener"><?php echo e($slide->slider_link_text); ?></a>
                                                <?php endif; ?>
                                            </figcaption>
                                            <meta itemprop="width" content="600">
                                            <meta itemprop="height" content="400">
                                        </figure>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                                <nav class="slider-nav" aria-label="<?php echo e(__('Slider Navigasyonu')); ?>">
                                    <button class="slider-prev" aria-label="<?php echo e(__('Önceki')); ?>" type="button"><i
                                            class="fas fa-chevron-left"></i></button>
                                    <button class="slider-next" aria-label="<?php echo e(__('Sonraki')); ?>" type="button"><i
                                            class="fas fa-chevron-right"></i></button>
                                </nav>
                                <div class="slider-dots" role="tablist">
                                    <?php if(isset($sliders) && count($sliders)): ?>
                                        <?php $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <button class="dot <?php echo e($index === 0 ? 'active' : ''); ?>" data-slide="<?php echo e($index); ?>" role="tab"
                                                aria-selected="<?php echo e($index === 0 ? 'true' : 'false'); ?>"
                                                aria-label="<?php echo e(__('Slayt')); ?> <?php echo e($index + 1); ?>"></button>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </article>
                    <?php else: ?>
                        <div class="hero-visual">
                            <div class="hero-letter">K</div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Modern Split Hero Section -->
    <section class="split-hero-section py-4">
        <div class="container">
            <div class="row gy-4">
                <!-- Caregiver Card (Indigo/Corporate) -->
                <div class="col-lg-6">
                    <div class="modern-hero-card card-bakici transition-all shadow-lg rounded-4 overflow-hidden position-relative">
                        <div class="card-body p-4 p-md-5 text-white">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box-modern me-3 bg-white-transparent rounded-3 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-heart"></i>
                                </div>
                                <div>
                                    <h3 class="h4 fw-bold mb-0">Bakıcı Noktası</h3>
                                    <p class="small opacity-75 mb-0">Güvenilir bakım hizmetleri</p>
                                </div>
                            </div>
                            <p class="mb-4 description-modern">Bebek, yaşlı, hasta bakıcısı. Doğrulanmış ve güvenilir bakıcılarla tanışın.</p>
                            
                            <div class="d-flex flex-wrap gap-2 mb-4">
                                <span class="badge-modern">Bebek Bakıcısı</span>
                                <span class="badge-modern">Yaşlı Bakıcısı</span>
                                <span class="badge-modern">Hasta Bakıcısı</span>
                            </div>

                            <a href="<?php echo e(route('services.wizard', ['type' => 'caregiver'])); ?>" class="wizard-btn-modern">
                                <?php echo e(__('Sihirbazı Başlat')); ?> <i class="fas fa-magic ms-2"></i>
                            </a>
                        </div>
                        <div class="card-geometric-pattern"></div>
                    </div>
                </div>

                <!-- House Services Card (Blue/Corporate) -->
                <div class="col-lg-6">
                    <div class="modern-hero-card card-bakim transition-all shadow-lg rounded-4 overflow-hidden position-relative">
                        <div class="card-body p-4 p-md-5 text-white">
                            <div class="d-flex align-items-center mb-3">
                                <div class="icon-box-modern me-3 bg-white-transparent rounded-3 d-flex align-items-center justify-content-center">
                                    <i class="fas fa-wrench"></i>
                                </div>
                                <div>
                                    <h3 class="h4 fw-bold mb-0">Hizmet Al</h3>
                                    <p class="small opacity-75 mb-0">Ev ve ofis bakım hizmetleri</p>
                                </div>
                            </div>
                            <p class="mb-4 description-modern">Temizlik, tamir, tadilat. Eviniz için profesyonel bakım hizmetleri.</p>
                            
                            <div class="d-flex flex-wrap gap-2 mb-4">
                                <span class="badge-modern">Temizlik</span>
                                <span class="badge-modern">Tadilat</span>
                                <span class="badge-modern">Elektrik</span>
                                <span class="badge-modern">Tesisat</span>
                            </div>

                            <a href="<?php echo e(route('services.wizard', ['type' => 'service'])); ?>" class="wizard-btn-modern">
                                <?php echo e(__('Sihirbazı Başlat')); ?> <i class="fas fa-magic ms-2"></i>
                            </a>
                        </div>
                        <div class="card-geometric-pattern"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .hover-scale { transition: transform 0.3s ease; }
        .hover-scale:hover { transform: translateY(-3px); }
        .transition-all { transition: all 0.3s ease; }
        
        /* Modern Hero Cards */
        .modern-hero-card {
            border: none;
            min-height: 280px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            z-index: 1;
        }

        .card-bakici {
            background: linear-gradient(135deg, #2b32b2 0%, #1488cc 100%);
        }

        .card-bakim {
            background: linear-gradient(135deg, #0d6efd 0%, #003d99 100%);
        }

        .icon-box-modern {
            width: 50px;
            height: 50px;
            font-size: 1.5rem;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .bg-white-transparent {
            background: rgba(255, 255, 255, 0.15);
        }

        .badge-modern {
            background: rgba(255, 255, 255, 0.1);
            padding: 6px 15px;
            border-radius: 50px;
            font-size: 0.85rem;
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .description-modern {
            font-size: 1rem;
            line-height: 1.5;
            opacity: 0.85;
        }

        .wizard-btn-modern {
            display: inline-flex;
            align-items: center;
            background: white;
            color: #0d6efd;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .wizard-btn-modern:hover {
            background: #f8f9fa;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            color: #003d99;
        }

        /* Geometric Pattern Wrapper */
        .card-geometric-pattern {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            overflow: hidden;
            pointer-events: none;
            z-index: -1;
            opacity: 0.4;
        }

        /* Unique Geometric Elements */
        .card-geometric-pattern::after {
            content: '';
            position: absolute;
            width: 300px;
            height: 300px;
            background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, transparent 70%);
            top: -150px;
            right: -100px;
            transform: rotate(45deg);
        }

        .card-geometric-pattern::before {
            content: '';
            position: absolute;
            width: 200px;
            height: 2px;
            background: rgba(255,255,255,0.2);
            bottom: 40px;
            left: -50px;
            transform: rotate(-30deg);
            box-shadow: 0 0 20px rgba(255,255,255,0.1);
        }

        @media (max-width: 767px) {
            .modern-hero-card {
                min-height: 240px;
                border-radius: 20px !important;
            }
            .description-modern {
                font-size: 0.9rem;
                margin-bottom: 1rem !important;
            }
            .badge-modern {
                font-size: 0.75rem;
                padding: 4px 12px;
            }
            .h4 {
                font-size: 1.2rem !important;
            }
            .wizard-btn-modern {
                padding: 8px 20px;
                font-size: 0.9rem;
            }
        }
        /* Premium How It Works (4-Step) Styles */
        .how-it-works-premium {
            background-color: #ffffff;
            font-family: 'Inter', sans-serif;
        }

        .section-title-premium {
            font-size: 2.5rem;
            color: #111827;
        }

        .section-subtitle-premium {
            font-size: 1.1rem;
            opacity: 0.8;
        }

        .bg-purple { background-color: #a855f7; }
        .bg-orange { background-color: #f97316; }

        .icon-wrap-premium {
            width: 70px;
            height: 70px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
        }

        .step-counter-black {
            position: absolute;
            top: -5px;
            right: -5px;
            width: 24px;
            height: 24px;
            background: #111827;
            color: white;
            border-radius: 50%;
            font-size: 0.8rem;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid white;
        }

        .step-card-premium {
            transition: all 0.3s ease;
            position: relative;
            z-index: 2;
        }

        .step-card-premium:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05) !important;
            border-color: #e5e7eb !important;
        }

        .connector-line-premium {
            position: absolute;
            top: 75px;
            left: 10%;
            right: 10%;
            height: 1px;
            background: #e5e7eb;
            z-index: 1;
        }

        .bg-light-blue {
            background-color: #eff6ff;
        }

        .feature-icon-sm {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
        }

        @media (max-width: 991px) {
            .section-title-premium {
                font-size: 2rem;
            }
        }
    </style>

    <!-- Featured Jobs Section -->
    <section class="featured-jobs-section py-5">
        <div class="container">
            <div class="section-header d-flex justify-content-between align-items-center mb-4">
                <h3 class="section-title"><i class="fas fa-star text-warning"></i> <?php echo e(__('ÖNE ÇIKAN İLANLAR')); ?></h3>
                <a href="<?php echo e(route('job.list')); ?>" class="btn btn-outline-primary btn-sm"><?php echo e(__('Tümünü Gör')); ?></a>
            </div>

            <!-- Filter Tabs -->
            <div class="filter-tabs mb-4">
                <span class="filter-label"><?php echo e(__('Kariyer seviyenize göre ilanları filtreleyin:')); ?></span>
                <div class="filter-buttons">
                    <a href="<?php echo e(route('job.list')); ?>?career_level_id[]=5"
                        class="filter-btn active"><?php echo e(__('Stajyer / Öğrenci')); ?></a>
                    <a href="<?php echo e(route('job.list')); ?>?career_level_id[]=2" class="filter-btn"><?php echo e(__('Giriş Seviyesi')); ?></a>
                    <a href="<?php echo e(route('job.list')); ?>?career_level_id[]=3" class="filter-btn"><?php echo e(__('Deneyimli')); ?></a>
                    <a href="<?php echo e(route('job.list')); ?>?is_freelance[]=1" class="filter-btn"><?php echo e(__('Freelance')); ?></a>
                </div>
            </div>

            <div class="row">
                <!-- Left Column - Employer Highlights -->
                <div class="col-lg-3">
                    <div class="employer-highlights">
                        <h5><?php echo e(__('İşveren Tercihleriniz')); ?></h5>
                        <ul class="employer-list">
                            <li><a href="<?php echo e(route('company.listing')); ?>"><?php echo e(__('Yeni Üye Şirketler')); ?></a></li>
                            <li><a href="<?php echo e(route('login')); ?>"><?php echo e(__('Hızlı Başvuru')); ?></a></li>
                            <li><a href="<?php echo e(route('login')); ?>"><?php echo e(__('Mülakat Randevusu')); ?></a></li>
                        </ul>
                    </div>
                </div>

                <!-- Right Column - Job Listings -->
                <div class="col-lg-9">
                    <div class="jobs-grid">
                        <?php
                            $featuredJobs = \App\Job::active()->featured()->orderBy('created_at', 'desc')->limit(6)->get();
                        ?>
                        <?php $__empty_1 = true; $__currentLoopData = $featuredJobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="job-card">
                                <div class="job-card-header">
                                    <div class="company-logo">
                                        <?php if($job->company): ?>
                                            <?php echo e($job->company->printCompanyImage()); ?>

                                        <?php else: ?>
                                            <i class="fas fa-building"></i>
                                        <?php endif; ?>
                                    </div>
                                    <div class="job-info">
                                        <h5><a href="<?php echo e(route('job.detail', $job->slug)); ?>"><?php echo e($job->title); ?></a></h5>
                                        <p class="company-name">
                                            <?php if($job->company): ?>
                                                <a
                                                    href="<?php echo e(route('company.detail', $job->company->slug)); ?>"><?php echo e($job->company->name); ?></a>
                                            <?php endif; ?>
                                        </p>
                                    </div>
                                    <button class="btn-save"><i class="far fa-heart"></i></button>
                                </div>
                                <div class="job-card-footer">
                                    <span class="job-location"><i class="fas fa-map-marker-alt"></i>
                                        <?php echo e($job->getCity('city')); ?></span>
                                    <span class="job-date"><?php echo e($job->created_at->diffForHumans()); ?></span>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="alert alert-info"><?php echo e(__('Öne çıkan ilan bulunamadı')); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Job Categories Section -->
    <section class="job-categories-section py-5 bg-light">
        <div class="container">
            <?php
                // Veritabanından aktif iş ilanlarının başlıklarını çek (benzersiz)
                $jobTitles = \App\Job::where('is_active', 1)
                    ->select('title')
                    ->distinct()
                    ->orderBy('title')
                    ->limit(15)
                    ->pluck('title');

                // Veritabanından aktif iş ilanı olan fonksiyonel alanları çek
                $activeAreaIds = \App\Job::where('is_active', 1)->distinct()->pluck('functional_area_id')->toArray();
                $functionalAreas = \App\FunctionalArea::whereIn('functional_area_id', $activeAreaIds)->where('lang', 'tr')->get();

                // Veritabanından aktif iş ilanı olan şehirleri çek
                $cityIdsWithJobs = \App\Job::active()->distinct()->pluck('city_id')->toArray();
                $citiesWithJobs = \App\City::whereIn('city_id', $cityIdsWithJobs)->where('lang', 'tr')->get();

                // Veritabanından iş türlerini çek (Tam Zamanlı, Yarı Zamanlı, Staj vb.)
                $jobTypeIdsWithJobs = \App\Job::active()->distinct()->pluck('job_type_id')->toArray();
                $jobTypesWithJobs = \App\JobType::whereIn('job_type_id', $jobTypeIdsWithJobs)->where('lang', 'tr')->where('job_type', '!=', '')->get();
            ?>

            <!-- İş İlanı İsimleri -->
            <div class="section-header d-flex justify-content-between align-items-center mb-4">
                <h3 class="section-title"><?php echo e(__('Popüler İş İlanları')); ?></h3>
                <div class="dropdown">
                    <a href="<?php echo e(route('job.list')); ?>" class="btn btn-outline-secondary btn-sm">
                        <?php echo e(__('Tümünü Gör')); ?>

                    </a>
                </div>
            </div>

            <div class="categories-grid">
                <?php $__currentLoopData = $jobTitles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('job.list', ['search' => $title])); ?>" class="category-item">
                        <span class="category-name"><?php echo e($title); ?></span>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- More Category Sections -->
            <div class="category-accordions mt-4">

                <!-- İş Alanlarına Göre -->
                <div class="accordion-item">
                    <button class="accordion-btn" data-toggle="collapse" data-target="#areasAccordion">
                        <span><?php echo e(__('İş Alanlarına Göre İlanlar')); ?></span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="accordion-content" id="areasAccordion" style="display: none;">
                        <div class="categories-grid py-3">
                            <?php $__currentLoopData = $functionalAreas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $area): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('job.list', ['functional_area_id' => [$area->functional_area_id]])); ?>"
                                    class="category-item"><?php echo e($area->functional_area); ?></a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>

                <!-- İş Türüne Göre -->
                <div class="accordion-item">
                    <button class="accordion-btn" data-toggle="collapse" data-target="#jobTypesAccordion">
                        <span><?php echo e(__('İş Türüne Göre İlanlar')); ?></span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="accordion-content" id="jobTypesAccordion" style="display: none;">
                        <div class="categories-grid py-3">
                            <?php $__currentLoopData = $jobTypesWithJobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $jobType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('job.list', ['job_type_id' => [$jobType->job_type_id]])); ?>"
                                    class="category-item"><?php echo e($jobType->job_type); ?></a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>

                <!-- Şehre Göre -->
                <div class="accordion-item">
                    <button class="accordion-btn" data-toggle="collapse" data-target="#citiesAccordion">
                        <span><?php echo e(__('Şehre Göre İş İlanları')); ?></span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="accordion-content" id="citiesAccordion" style="display: none;">
                        <div class="categories-grid py-3">
                            <?php $__currentLoopData = $citiesWithJobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="<?php echo e(route('job.list', ['city_id' => [$city->city_id]])); ?>"
                                    class="category-item"><?php echo e($city->city); ?></a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Top Employers Section - Clean Modern Style -->
    <section class="top-employers-section">
        <div class="container">
            <!-- Section Header -->
            <div class="section-header-row">
                <div class="section-title-wrap">
                    <i class="fas fa-star text-warning"></i>
                    <h3><?php echo e(__('ÖNE ÇIKAN ŞİRKETLER')); ?></h3>
                </div>
                <a href="<?php echo e(route('company.listing')); ?>" class="btn-view-all"><?php echo e(__('Tümünü Gör')); ?></a>
            </div>

            <!-- Filter Tabs -->
            <div class="filter-tabs-wrap">
                <span class="filter-label"><?php echo e(__('Sektöre göre filtreleyin')); ?></span>
                <div class="filter-tabs" id="companyFilterTabs">
                    <button class="filter-tab active" data-filter="all"><?php echo e(__('Tümü')); ?></button>
                    <?php
                        $industries = \App\Industry::whereHas('companies', function ($q) {
                            $q->where('is_active', 1);
                        })->limit(4)->get();
                    ?>
                    <?php $__currentLoopData = $industries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $industry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button class="filter-tab" data-filter="<?php echo e($industry->id); ?>"><?php echo e($industry->industry); ?></button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>

            <div class="row">
                <!-- Sidebar -->
                <div class="col-lg-3 col-md-4">
                    <div class="employers-sidebar">
                        <h6><?php echo e(__('İşveren Tercihleri')); ?></h6>
                        <ul class="sidebar-links">
                            <li><a href="<?php echo e(route('company.listing')); ?>"><?php echo e(__('Yeni Üye Şirketler')); ?></a></li>
                            <li><a href="<?php echo e(route('job.list')); ?>"><?php echo e(__('Hızlı Başvuru')); ?></a></li>
                            <li><a href="<?php echo e(route('job.list')); ?>"><?php echo e(__('Mülakat Randevusu')); ?></a></li>
                        </ul>
                    </div>
                </div>

                <!-- Companies Grid -->
                <div class="col-lg-9 col-md-8">
                    <div class="row g-3" id="companiesGrid">
                        <?php
                            $topCompanies = \App\Company::active()->limit(6)->get();
                        ?>
                        <?php $__empty_1 = true; $__currentLoopData = $topCompanies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="col-lg-6 company-item" data-industry="<?php echo e($company->industry_id); ?>">
                                <div class="employer-list-card">
                                    <div class="employer-logo-sm">
                                        <?php echo e($company->printCompanyImage()); ?>

                                    </div>
                                    <div class="employer-info">
                                        <h5><a href="<?php echo e(route('company.detail', $company->slug)); ?>"><?php echo e($company->name); ?></a>
                                        </h5>
                                        <p class="employer-location"><i class="fas fa-map-marker-alt"></i>
                                            <?php echo e($company->getCity('city') ?? 'Türkiye'); ?></p>
                                    </div>
                                    <div class="employer-meta">
                                        <span class="job-time"><?php echo e($company->countNumJobs('company_id', $company->id)); ?>

                                            <?php echo e(__('Açık İş')); ?></span>
                                        <button class="btn-favorite" onclick="toggleFavorite(this)"><i
                                                class="far fa-heart"></i></button>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="col-12 text-center">
                                <p class="text-muted"><?php echo e(__('Henüz şirket bulunamadı.')); ?></p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Filter tabs functionality
            const filterTabs = document.querySelectorAll('#companyFilterTabs .filter-tab');
            const companyItems = document.querySelectorAll('.company-item');

            filterTabs.forEach(tab => {
                tab.addEventListener('click', function () {
                    // Remove active class from all tabs
                    filterTabs.forEach(t => t.classList.remove('active'));
                    // Add active class to clicked tab
                    this.classList.add('active');

                    const filter = this.getAttribute('data-filter');

                    companyItems.forEach(item => {
                        if (filter === 'all') {
                            item.style.display = 'block';
                        } else {
                            if (item.getAttribute('data-industry') === filter) {
                                item.style.display = 'block';
                            } else {
                                item.style.display = 'none';
                            }
                        }
                    });
                });
            });
        });

        // Favorite button toggle
        function toggleFavorite(btn) {
            const icon = btn.querySelector('i');
            if (icon.classList.contains('far')) {
                icon.classList.remove('far');
                icon.classList.add('fas');
                icon.style.color = '#ef4444';
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
                icon.style.color = '';
            }
        }
    </script>

    <!-- How it Works Section - Premium 4-Step Style -->
    <section class="how-it-works-premium py-5">
        <div class="container text-center">
            <div class="mb-4">
                <span class="badge bg-light text-primary px-3 py-2 rounded-pill fw-bold border"><?php echo e(__('Basit & Güvenli')); ?></span>
            </div>
            <h2 class="section-title-premium fw-bold mb-3"><?php echo e(__('Nasıl Çalışır?')); ?></h2>
            <p class="section-subtitle-premium text-muted mb-5 mx-auto" style="max-width: 600px;">
                <?php echo e(__('Hizmet almak veya vermek hiç bu kadar kolay olmamıştı. 4 basit adımda başlayın.')); ?>

            </p>

            <div class="row gy-5 how-it-row-premium position-relative mb-5">
                <!-- Connector Line -->
                <div class="connector-line-premium d-none d-lg-block"></div>

                <!-- Step 1 -->
                <div class="col-lg-3 col-md-6">
                    <div class="step-card-premium transition-all p-4 rounded-4 h-100 bg-white border">
                        <div class="icon-wrap-premium bg-primary text-white mb-4 mx-auto position-relative">
                            <i class="fas fa-file-invoice"></i>
                            <div class="step-counter-black">1</div>
                        </div>
                        <h5 class="fw-bold mb-2"><?php echo e(__('Kayıt Olun')); ?></h5>
                        <p class="small text-muted mb-0"><?php echo e(__('Ücretsiz hesap oluşturun. 2 dakikada tamamlayın.')); ?></p>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="col-lg-3 col-md-6">
                    <div class="step-card-premium transition-all p-4 rounded-4 h-100 bg-white border">
                        <div class="icon-wrap-premium bg-purple text-white mb-4 mx-auto position-relative">
                            <i class="fas fa-search"></i>
                            <div class="step-counter-black">2</div>
                        </div>
                        <h5 class="fw-bold mb-2"><?php echo e(__('İlan Verin veya Keşfedin')); ?></h5>
                        <p class="small text-muted mb-0"><?php echo e(__('İhtiyacınızı ilan edin veya profesyonelleri bulun.')); ?></p>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="col-lg-3 col-md-6">
                    <div class="step-card-premium transition-all p-4 rounded-4 h-100 bg-white border">
                        <div class="icon-wrap-premium bg-orange text-white mb-4 mx-auto position-relative">
                            <i class="fas fa-credit-card"></i>
                            <div class="step-counter-black">3</div>
                        </div>
                        <h5 class="fw-bold mb-2"><?php echo e(__('Anlaşın & Güvenli Ödeyin')); ?></h5>
                        <p class="small text-muted mb-0"><?php echo e(__('Teklifleri karşılaştırın, güvenli altyapı ile ödeyin.')); ?></p>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="col-lg-3 col-md-6">
                    <div class="step-card-premium transition-all p-4 rounded-4 h-100 bg-white border">
                        <div class="icon-wrap-premium bg-success text-white mb-4 mx-auto position-relative">
                            <i class="fas fa-thumbs-up"></i>
                            <div class="step-counter-black">4</div>
                        </div>
                        <h5 class="fw-bold mb-2"><?php echo e(__('İşi Tamamlayın & Değerlendirin')); ?></h5>
                        <p class="small text-muted mb-0"><?php echo e(__('Hizmet tamamlansın, ödeme serbest kalsın.')); ?></p>
                    </div>
                </div>
            </div>

            <!-- Bottom Features -->
            <div class="row g-4 mt-4 justify-content-center">
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                        <div class="feature-icon-sm bg-light-blue text-primary me-3">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <div class="text-start">
                            <h6 class="fw-bold mb-0"><?php echo e(__('Güvenli Ödeme')); ?></h6>
                            <p class="small text-muted mb-0"><?php echo e(__('Güvenli Ödeme Sistemi')); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                        <div class="feature-icon-sm bg-light-blue text-primary me-3">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <div class="text-start">
                            <h6 class="fw-bold mb-0"><?php echo e(__('Doğrulanmış Profiller')); ?></h6>
                            <p class="small text-muted mb-0"><?php echo e(__('Kimlik Kontrolü')); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                        <div class="feature-icon-sm bg-light-blue text-primary me-3">
                            <i class="fas fa-comment-dots"></i>
                        </div>
                        <div class="text-start">
                            <h6 class="fw-bold mb-0"><?php echo e(__('7/24 Destek')); ?></h6>
                            <p class="small text-muted mb-0"><?php echo e(__('Her Zaman Yanınızda')); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                        <div class="feature-icon-sm bg-light-blue text-primary me-3">
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="text-start">
                            <h6 class="fw-bold mb-0"><?php echo e(__('Memnuniyet Garantisi')); ?></h6>
                            <p class="small text-muted mb-0"><?php echo e(__('İade Politikası')); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section - Corporate Style -->
    <section class="testimonials-section py-5">
        <div class="container">
            <div class="section-header text-center mb-5">
                <span class="section-subtitle text-white-50"><?php echo e(__('KULLANICI DENEYİMLERİ')); ?></span>
                <h3 class="section-title text-white"><?php echo e(__('Başarı Hikayeleri')); ?></h3>
            </div>

            <div class="row gy-4">
                <?php
                    $testimonials = \App\Testimonial::where('is_active', 1)->where('lang', 'tr')->orderBy('sort_order')->limit(3)->get();
                ?>
                <?php $__empty_1 = true; $__currentLoopData = $testimonials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testimonial): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="col-md-4">
                        <div class="testimonial-card">
                            <div class="testimonial-rating mb-3">
                                <?php for($i = 0; $i < 5; $i++): ?>
                                    <i class="fas fa-star text-warning"></i>
                                <?php endfor; ?>
                            </div>
                            <p class="testimonial-text">"<?php echo e($testimonial->testimonial); ?>"</p>
                            <div class="testimonial-author mt-4">
                                <div class="author-avatar">
                                    <i class="fas fa-user-circle fa-2x"></i>
                                </div>
                                <div class="author-info">
                                    <h6 class="mb-0"><?php echo e($testimonial->testimonial_by); ?></h6>
                                    <span class="text-muted"><?php echo e($testimonial->company ?? ''); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-12 text-center">
                        <p class="text-white-50"><?php echo e(__('Henüz kullanıcı yorumu bulunmuyor.')); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Career Guide Section -->
    <section class="career-guide-section py-5 bg-light">
        <div class="container">
            <div class="section-header d-flex justify-content-between align-items-center mb-4">
                <h3 class="section-title"><?php echo e(__('KARİYER REHBERİ')); ?></h3>
                <a href="<?php echo e(route('blogs')); ?>" class="link-more"><?php echo e(__('Tümünü Gör')); ?> <i
                        class="fas fa-arrow-right"></i></a>
            </div>

            <div class="row gy-4">
                <?php
                    $blogs = \App\Blog::orderBy('created_at', 'desc')->limit(3)->get();
                ?>
                <?php $__empty_1 = true; $__currentLoopData = $blogs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="col-md-4">
                        <div class="guide-card">
                            <div class="guide-image">
                                <?php echo e($blog->printBlogImage()); ?>

                            </div>
                            <div class="guide-content">
                                <h5><a
                                        href="<?php echo e(route('blog-detail', $blog->slug)); ?>"><?php echo e(\Illuminate\Support\Str::limit($blog->heading, 60)); ?></a>
                                </h5>
                                <p><?php echo e(\Illuminate\Support\Str::limit(strip_tags($blog->content), 100)); ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-12">
                        <p class="text-muted"><?php echo e(__('Henüz blog yazısı bulunmuyor.')); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php echo $__env->make('includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).ready(function ($) {
            $("form").submit(function () {
                $(this).find(":input").filter(function () {
                    return !this.value;
                }).attr("disabled", "disabled");
                return true;
            });
            $("form").find(":input").prop("disabled", false);

            // Typewriter Effect
            var phrases = [
                "Hayalindeki işi bul",
                "Binlerce iş ilanı seni bekliyor",
                "Kariyerinde yeni bir sayfa aç",
                "En iyi şirketlerden teklifler al",
                "Yeteneklerini keşfet",
                "Profesyonel ağını genişlet",
                "Uzaktan çalışma fırsatları",
                "Stajyer pozisyonları",
                "Yönetici kariyer fırsatları",
                "Freelance projeler bul"
            ];
            var currentPhrase = 0;
            var currentChar = 0;
            var isDeleting = false;
            var typewriterElement = document.getElementById('typewriter');

            function typeWriter() {
                if (!typewriterElement) return;

                var phrase = phrases[currentPhrase];

                if (isDeleting) {
                    typewriterElement.textContent = phrase.substring(0, currentChar - 1);
                    currentChar--;
                } else {
                    typewriterElement.textContent = phrase.substring(0, currentChar + 1);
                    currentChar++;
                }

                var typeSpeed = isDeleting ? 30 : 80;

                if (!isDeleting && currentChar === phrase.length) {
                    typeSpeed = 2000;
                    isDeleting = true;
                } else if (isDeleting && currentChar === 0) {
                    isDeleting = false;
                    currentPhrase = (currentPhrase + 1) % phrases.length;
                    typeSpeed = 500;
                }

                setTimeout(typeWriter, typeSpeed);
            }

            typeWriter();

            // Filter Tabs Functionality
            $('.filter-btn').on('click', function () {
                $('.filter-btn').removeClass('active');
                $(this).addClass('active');
                var filterType = $(this).text().trim();
                // Redirect to job list with filter
                window.location.href = "<?php echo e(route('job.list')); ?>?search=" + encodeURIComponent(filterType);
            });

            // Accordion Functionality
            $('.accordion-btn').on('click', function () {
                $(this).toggleClass('active');
                $(this).find('i').toggleClass('fa-chevron-down fa-chevron-up');
                var content = $(this).next('.accordion-content');
                if (content.length) {
                    content.slideToggle();
                }
            });

            // Modern Slider - Mobile Touch Support & Lazy Loading
            (function () {
                var slider = document.getElementById('mainSlider');
                if (!slider) return;

                var slides = slider.querySelectorAll('.slide-item');
                var dots = slider.querySelectorAll('.dot');
                var prevBtn = slider.querySelector('.slider-prev');
                var nextBtn = slider.querySelector('.slider-next');
                var currentSlide = 0;
                var slideCount = slides.length;
                var autoPlayInterval;
                var touchStartX = 0;
                var touchEndX = 0;


                // Show Slide
                function showSlide(index) {
                    if (index >= slideCount) index = 0;
                    if (index < 0) index = slideCount - 1;

                    slides.forEach(function (slide, i) {
                        slide.classList.remove('active');
                        if (dots[i]) {
                            dots[i].classList.remove('active');
                            dots[i].setAttribute('aria-selected', 'false');
                        }
                    });

                    slides[index].classList.add('active');
                    if (dots[index]) {
                        dots[index].classList.add('active');
                        dots[index].setAttribute('aria-selected', 'true');
                    }

                    currentSlide = index;
                }

                // Next/Prev
                function nextSlide() { showSlide(currentSlide + 1); }
                function prevSlide() { showSlide(currentSlide - 1); }

                // Event Listeners
                if (prevBtn) prevBtn.addEventListener('click', function () { prevSlide(); resetAutoPlay(); });
                if (nextBtn) nextBtn.addEventListener('click', function () { nextSlide(); resetAutoPlay(); });

                dots.forEach(function (dot, i) {
                    dot.addEventListener('click', function () { showSlide(i); resetAutoPlay(); });
                });

                // Touch/Swipe Support
                slider.addEventListener('touchstart', function (e) {
                    touchStartX = e.changedTouches[0].screenX;
                }, { passive: true });

                slider.addEventListener('touchend', function (e) {
                    touchEndX = e.changedTouches[0].screenX;
                    handleSwipe();
                }, { passive: true });

                function handleSwipe() {
                    var diff = touchStartX - touchEndX;
                    if (Math.abs(diff) > 50) {
                        if (diff > 0) nextSlide();
                        else prevSlide();
                        resetAutoPlay();
                    }
                }

                // Keyboard Navigation
                slider.setAttribute('tabindex', '0');
                slider.addEventListener('keydown', function (e) {
                    if (e.key === 'ArrowLeft') { prevSlide(); resetAutoPlay(); }
                    if (e.key === 'ArrowRight') { nextSlide(); resetAutoPlay(); }
                });

                // Auto Play
                function startAutoPlay() {
                    autoPlayInterval = setInterval(nextSlide, 5000);
                }

                function resetAutoPlay() {
                    clearInterval(autoPlayInterval);
                    startAutoPlay();
                }

                // Initialize
                startAutoPlay();

                // Pause on hover
                slider.addEventListener('mouseenter', function () { clearInterval(autoPlayInterval); });
                slider.addEventListener('mouseleave', startAutoPlay);
            })();
        });
    </script>
    <?php echo $__env->make('includes.country_state_city_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/personelnoktasit/public_html/resources/views/welcome.blade.php ENDPATH**/ ?>