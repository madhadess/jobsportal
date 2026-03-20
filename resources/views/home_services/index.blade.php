@extends('layouts.app')

@push('styles')
    <link
        href="https://fonts.googleapis.com/css2?family=Unbounded:wght@400;700&family=Public+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        :root {
            /* Dynamic Colors based on Type */
            --primary-color:
                @if($type == 'caregiver')
                #ff4d91 @else #0d6efd @endif;
            --secondary-color:
                @if($type == 'caregiver')
                #7000ff @else #2a5298 @endif;
            --bg-light:
                @if($type == 'caregiver')
                #fff5fa @else #f8faff @endif;
            --dark-color: #1a2b48;
            --step-bg: #f8faff;
        }

        body {
            font-family: 'Public Sans', sans-serif;
            overflow-x: hidden;
            background: #fff;
        }

        .unbounded {
            font-family: 'Unbounded', sans-serif;
        }

        .transition-03 {
            transition: all 0.3s ease;
        }

        /* Unified Premium Hero */
        .premium-hero {
            background: radial-gradient(at 0% 0%, rgba(@if($type == 'caregiver') 255, 77, 145 @else 13, 110, 253 @endif, 0.12) 0%, transparent 50%),
                radial-gradient(at 100% 100%, rgba(@if($type == 'caregiver') 112, 0, 255 @else 42, 82, 152 @endif, 0.12) 0%, transparent 50%),
                #fff;
            padding: 100px 0;
            position: relative;
            overflow: hidden;
        }

        .mesh-blob {
            position: absolute;
            width: 600px;
            height: 600px;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            filter: blur(100px);
            opacity: 0.08;
            border-radius: 50%;
            z-index: 0;
        }

        .mesh-blob-1 {
            top: -200px;
            right: -100px;
            animation: rotateBlob 20s infinite linear;
        }

        .mesh-blob-2 {
            bottom: -200px;
            left: -100px;
            animation: floatBlob 15s infinite alternate;
        }

        @keyframes rotateBlob {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        @keyframes floatBlob {
            0% {
                transform: translate(0, 0);
            }

            100% {
                transform: translate(100px, 50px);
            }
        }

        .gradient-text {
            background: linear-gradient(to right, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 800;
        }

        .premium-btn {
            background: #fff;
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            padding: 15px 40px;
            border-radius: 50px;
            font-weight: 700;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
        }

        .premium-btn:hover {
            background: var(--primary-color);
            color: #fff;
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .premium-btn-primary {
            background: var(--primary-color);
            border-color: var(--primary-color);
            color: #fff;
        }

        .premium-btn-primary:hover {
            background: var(--dark-color);
            border-color: var(--dark-color);
        }

        /* Glassmorphism Cards */
        .glass-card-premium {
            background: #fff;
            border-radius: 35px;
            padding: 40px;
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            height: 100%;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.03);
            border: 1px solid #f1f1f1;
            position: relative;
            z-index: 1;
        }

        .glass-card-premium:hover {
            transform: translateY(-12px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.08);
            border-color: var(--primary-color);
        }

        .icon-box-premium {
            width: 85px;
            height: 85px;
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.4rem;
            margin-bottom: 30px;
            color: #fff;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
        }

        .badge-premium {
            background: rgba(var(--primary-rgb), 0.1);
            color: var(--primary-color);
            font-weight: 700;
            padding: 6px 15px;
            border-radius: 50px;
            font-size: 0.8rem;
        }

        /* Process Steps */
        .step-section {
            background: var(--step-bg);
            padding: 100px 0;
            border-radius: 80px;
            margin: 60px 0;
        }

        .step-card {
            text-align: center;
            position: relative;
            padding: 0 20px;
        }

        .step-icon {
            width: 110px;
            height: 110px;
            background: #fff;
            border-radius: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            font-size: 2.5rem;
            color: var(--primary-color);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.05);
            position: relative;
        }

        .step-nr {
            position: absolute;
            top: -12px;
            right: -12px;
            width: 40px;
            height: 40px;
            background: var(--dark-color);
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1rem;
            border: 4px solid #fff;
        }

        /* Video/CTA Banner */
        .cta-neon-unified {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            border-radius: 50px;
            padding: 80px 40px;
            color: #fff;
            text-align: center;
            position: relative;
            overflow: hidden;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .cta-neon-unified::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3z' fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
            pointer-events: none;
            /* Fix: Allow clicks to pass through overlay */
            z-index: 0;
        }

        @media (max-width: 768px) {
            .premium-hero {
                padding: 80px 0;
            }

            .glass-card-premium {
                padding: 30px 20px;
                border-radius: 25px;
            }

            .step-section {
                border-radius: 40px;
                padding: 60px 0;
            }
        }
    </style>
@endpush

@section('content')
    @include('includes.header')

    <!-- Unified Hero Section -->
    <section class="premium-hero">
        <div class="mesh-blob mesh-blob-1"></div>
        <div class="mesh-blob mesh-blob-2"></div>

        <div class="container text-center position-relative" style="z-index: 1;">
            <div class="mb-4">
                <span class="badge rounded-pill px-4 py-2"
                    style="background: rgba(@if($type == 'caregiver') 255, 77, 145 @else 13, 110, 253 @endif, 0.1); color: var(--primary-color); font-weight: 700;">
                    <i class="fas @if($type == 'caregiver') fa-heart @else fa-check-circle @endif me-2"></i>
                    {{ $type == 'caregiver' ? __('Güvenilir Bakım Hizmetleri') : __('Profesyonel Ev Hizmetleri') }}
                </span>
            </div>

            <h1 class="unbounded display-3 gradient-text mb-4">
                {{ $type == 'caregiver' ? 'Bakıcı Noktası' : 'Eviniz İçin Her Şey' }}
            </h1>

            <p class="lead text-muted mx-auto mb-5" style="max-width: 800px;">
                @if($type == 'caregiver')
                    {{ __('Aileniz ve sevdikleriniz için güvenilir, deneyimli ve sertifikalı bakıcılar. Bebek, çocuk, yaşlı ve hasta bakımında profesyonel destek.') }}
                @else
                    {{ __('Evinizdeki her türlü tamirat, temizlik, bakım ve teknik ihtiyaçlarınız için uzman profesyonellerle anında iletişime geçin.') }}
                @endif
            </p>

            <div class="d-flex justify-content-center gap-3 flex-wrap">
                @php
                    $canRequest = true;
                    if (Auth::check()) {
                        $user = Auth::user();
                        if ($user->isJobSeeker() || $user->isPersonnel() || $user->isCaregiver()) {
                            $canRequest = false;
                        }
                    }
                @endphp

                @if($canRequest)
                    <a href="{{ $type == 'caregiver' ? route('caregiver.all') : route('home-services.all') }}"
                        class="premium-btn premium-btn-primary shadow-lg">
                        <i class="fas fa-search me-2"></i>
                        {{ $type == 'caregiver' ? __('Bakıcı Ara') : __('Hizmetleri Keşfet') }}
                    </a>
                    <a href="{{ route('services.wizard', $type) }}" class="premium-btn">
                        <i class="fas fa-magic me-2"></i> {{ __('Hizmet Sihirbazı') }}
                    </a>
                @else
                    <div class="alert alert-warning d-inline-block px-4 py-3 rounded-pill mb-0 shadow-sm border-0"
                        style="background: rgba(255, 193, 7, 0.15); color: #856404; font-weight: 600;">
                        <i class="fas fa-info-circle me-2"></i>
                        {{ __('Hizmet veya bakıcı talebi oluşturmak için lütfen "Hizmet Alan" hesabınızla giriş yapın.') }}
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Services Grid -->
    <section class="py-5">
        <div class="container py-4">
            <div class="text-center mb-5">
                <h2 class="unbounded h1 fw-bold mb-2">Hizmet Alanlarımız</h2>
                <p class="text-muted">İhtiyacınıza en uygun kategoriyi seçerek hemen başlayın</p>
            </div>

            <div class="row g-4">
                @php
                    $colors = ['#ff4d91', '#7000ff', '#00d2ff', '#3fb991', '#ff9f43', '#ee5253'];
                    $icons = $type == 'caregiver'
                        ? ['baby', 'child', 'user-nurse', 'heartbeat', 'hand-holding-heart', 'home']
                        : ['broom', 'cat', 'bolt', 'wrench', 'water', 'paint-roller', 'couch', 'camera', 'tools'];
                @endphp
                @foreach($categories as $index => $category)
                    <div class="col-lg-6">
                        <div class="glass-card-premium d-flex flex-column flex-md-row gap-4 align-items-center">
                            <div class="icon-box-premium shrink-0" style="background: {{ $colors[$index % 6] }};">
                                <i class="fas fa-{{ $icons[$index % count($icons)] }}"></i>
                            </div>
                            <div class="flex-grow-1 text-center text-md-start">
                                <h4 class="unbounded fs-5 mb-2">{{ $category->category_name }}</h4>
                                <div class="d-flex flex-wrap justify-content-center justify-content-md-start gap-2 mb-3">
                                    <span class="badge-premium"
                                        style="background: rgba(var(--primary-rgb), 0.05);">{{ __('Doğrulanmış Uzmanlar') }}</span>
                                    <span class="badge-premium"
                                        style="background: rgba(var(--primary-rgb), 0.05);">{{ __('Hızlı Çözüm') }}</span>
                                </div>
                                <p class="small text-muted mb-0">Profesyonel kalitede {{ strtolower($category->category_name) }}
                                    desteği ile hayatınızı kolaylaştırın.</p>

                                @if($canRequest)
                                    <a href="{{ route('services.wizard', ['type' => $type, 'category_id' => $category->id]) }}"
                                        class="btn btn-link text-primary fw-bold p-0 text-decoration-none mt-3">
                                        {{ __('Hemen Başla') }} <i class="fas fa-arrow-right ms-2 transition-03"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- How It Works (Unified) -->
    <section class="container my-5">
        <div class="step-section">
            <div class="text-center mb-5">
                <h2 class="unbounded h1 fw-bold">{{ __('Nasıl Çalışır?') }}</h2>
                <p class="text-muted">3 basit adımla hayalinizdeki hizmete kavuşun</p>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-icon">
                            <i class="fas fa-filter"></i>
                            <div class="step-nr">1</div>
                        </div>
                        <h4 class="unbounded fs-5 mb-3">{{ __('İhtiyacı Belirle') }}</h4>
                        <p class="text-muted small">Sihirbazımızı kullanarak kriterlerinizi ve bütçenizi kolayca
                            filtreleyin.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-icon">
                            <i class="fas fa-hand-holding-heart"></i>
                            <div class="step-nr">2</div>
                        </div>
                        <h4 class="unbounded fs-5 mb-3">{{ __('En İyilerle Eşleş') }}</h4>
                        <p class="text-muted small">Kriterlerinize en uygun doğrulanmış profesyonellerle anında listelenin.
                        </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-card">
                        <div class="step-icon">
                            <i class="fas fa-shield-alt"></i>
                            <div class="step-nr">3</div>
                        </div>
                        <h4 class="unbounded fs-5 mb-3">{{ __('Güvenle Başlat') }}</h4>
                        <p class="text-muted small">Randevunuzu onaylayın ve garantili profesyonel hizmetin keyfini çıkarın.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Unified CTA -->
    <section class="container pb-5">
        <div class="cta-neon-unified">
            <div style="position: relative; z-index: 2;">
                <h2 class="unbounded h1 fw-bold mb-3">
                    {{ $type == 'caregiver' ? __('Doğru Bakıcıyı Bugün Bulun') : __('Evinizi Emin Ellere Teslim Edin') }}
                </h2>
                <p class="mb-5 opacity-90 mx-auto" style="max-width: 700px;">
                    {{ __('Binlerce mutlu müşterimiz arasına katılın. Uzmanlarımızı titizlikle seçiyor ve en iyi deneyimi yaşamanız için çalışıyoruz.') }}
                </p>
                <div class="d-flex flex-wrap justify-content-center gap-3">
                    @if($canRequest)
                        <a href="{{ route('member.register') }}"
                            class="btn btn-light btn-lg rounded-pill px-5 fw-bold text-primary shadow-lg">{{ __('Hemen Ücretsiz Kayıt Ol') }}</a>
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#moreInfoModal"
                            class="btn btn-outline-light btn-lg rounded-pill px-5">{{ __('Daha Fazla Bilgi') }}</a>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- More Info Modal -->
    <div class="modal fade" id="moreInfoModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 25px; overflow: hidden;">
                <div class="modal-header border-0 text-white"
                    style="background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));">
                    <h5 class="modal-title unbounded fw-bold">
                        <i class="fas fa-info-circle me-2"></i>
                        {{ $type == 'caregiver' ? __('Sevdikleriniz İçin En İyi Bakım') : __('Personel Noktası ile Eviniz Güvende') }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body p-5">
                    <!-- Why Us Section -->
                    <h6 class="text-uppercase text-muted fw-bold mb-4 ls-1 border-bottom pb-2">{{ __('Neden Biz?') }}</h6>
                    <div class="row g-4 mb-5">
                        <div class="col-md-6">
                            <div class="d-flex align-items-start mb-3">
                                <div class="icon-box-premium shrink-0 me-3"
                                    style="width: 50px; height: 50px; font-size: 1.2rem; margin-bottom: 0;">
                                    <i class="fas fa-user-shield"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1">
                                        {{ $type == 'caregiver' ? __('Doğrulanmış Bakıcılar') : __('Doğrulanmış Uzmanlar') }}
                                    </h5>
                                    <p class="text-muted small mb-0">
                                        {{ __('Tüm adaylarımızın kimlik, adli sicil ve referans kontrolleri titizlikle yapılır. Evinizi güvenle emanet edebilirsiniz.') }}
                                    </p>
                                </div>
                            </div>
                            <div class="d-flex align-items-start mb-3">
                                <div class="icon-box-premium shrink-0 me-3"
                                    style="width: 50px; height: 50px; font-size: 1.2rem; margin-bottom: 0; background: linear-gradient(135deg, #00d2ff, #3a7bd5);">
                                    <i class="fas fa-cogs"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1">
                                        {{ __('Akıllı Eşleşme') }}
                                    </h5>
                                    <p class="text-muted small mb-0">
                                        {{ __('Vakit kaybetmeyin! Sistemimiz, kriterlerinize (konum, saat, tecrübe) en uygun personeli saniyeler içinde otomatik olarak bulur.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex align-items-start mb-3">
                                <div class="icon-box-premium shrink-0 me-3"
                                    style="width: 50px; height: 50px; font-size: 1.2rem; margin-bottom: 0; background: linear-gradient(135deg, #f12711, #f5af19);">
                                    <i class="fas fa-star"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1">
                                        {{ __('Yüksek Memnuniyet') }}
                                    </h5>
                                    <p class="text-muted small mb-0">
                                        {{ __('Hizmet verenlerimiz, önceki işlerde aldıkları puan ve yorumlara göre önceliklendirilir. Kaliteden ödün vermezsiniz.') }}
                                    </p>
                                </div>
                            </div>
                            <div class="d-flex align-items-start mb-3">
                                <div class="icon-box-premium shrink-0 me-3"
                                    style="width: 50px; height: 50px; font-size: 1.2rem; margin-bottom: 0; background: linear-gradient(135deg, #11998e, #38ef7d);">
                                    <i class="fas fa-headset"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold mb-1">
                                        {{ __('7/24 Kesintisiz Destek') }}
                                    </h5>
                                    <p class="text-muted small mb-0">
                                        {{ __('Süreç öncesinde ve sonrasında aklınıza takılan her türlü soru için uzman ekibimiz yanınızda.') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- How it Works Section -->
                    <h6 class="text-uppercase text-muted fw-bold mb-4 ls-1 border-bottom pb-2">
                        {{ __('Sistem Nasıl Çalışır?') }}</h6>
                    <div class="row g-3 text-center">
                        <div class="col-md-3 col-6">
                            <div class="p-3 rounded-4 bg-light h-100 border border-1">
                                <div class="fs-2 text-primary mb-3">1</div>
                                <h6 class="fw-bold">{{ __('Talep Oluştur') }}</h6>
                                <p class="text-muted xsmall mb-0">
                                    {{ __('Hizmet türünü, tarihini ve özel isteklerinizi birkaç adımda girin.') }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="p-3 rounded-4 bg-light h-100 border border-1">
                                <div class="fs-2 text-primary mb-3">2</div>
                                <h6 class="fw-bold">{{ __('Sistem Eşleştirir') }}</h6>
                                <p class="text-muted xsmall mb-0">
                                    {{ __('Algoritmamız, size en yakın ve en uygun puanlı uzmanı anında bulur.') }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="p-3 rounded-4 bg-light h-100 border border-1">
                                <div class="fs-2 text-primary mb-3">3</div>
                                <h6 class="fw-bold">{{ __('Onay & Bilgi') }}</h6>
                                <p class="text-muted xsmall mb-0">
                                    {{ __('Uzman görevi kabul eder, bilgileri size SMS/Email ile iletilir.') }}
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="p-3 rounded-4 bg-light h-100 border border-1">
                                <div class="fs-2 text-primary mb-3">4</div>
                                <h6 class="fw-bold">{{ __('Hizmet Al') }}</h6>
                                <p class="text-muted xsmall mb-0">
                                    {{ __('Uzmanımız belirtilen saatte gelir, hizmeti güvenle alırsınız.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 justify-content-center pb-4">
                    <a href="{{ route('member.register') }}" class="premium-btn premium-btn-primary px-5">
                        {{ __('Hemen Başla') }} <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    @include('includes.footer')
@endsection