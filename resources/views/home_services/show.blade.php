@extends('layouts.app')

@section('content')
    @include('includes.header')

    <style>
        .service-header {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            padding: 60px 0;
            color: white;
        }

        .service-header h1 {
            font-size: 38px;
            font-weight: 700;
            margin-bottom: 15px;
        }

        .service-header .breadcrumb {
            opacity: 0.9;
            font-size: 14px;
        }

        .service-content {
            padding: 60px 0;
            background: #f5f7fa;
        }

        .service-card {
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .service-image {
            width: 100%;
            height: 350px;
            object-fit: cover;
        }

        .service-details {
            padding: 45px;
        }

        .service-details h2 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 25px;
            color: #1a1a1a;
        }

        .service-details p {
            color: #555;
            line-height: 1.8;
            font-size: 15px;
            margin-bottom: 0;
        }

        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-top: 35px;
            padding-top: 35px;
            border-top: 2px solid #e5e5e5;
        }

        .info-item label {
            color: #999;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: block;
            margin-bottom: 8px;
        }

        .info-item value {
            font-size: 18px;
            font-weight: 700;
            color: #1e3c72;
            display: block;
        }

        .sidebar {
            position: sticky;
            top: 20px;
        }

        .sidebar-card {
            background: white;
            border-radius: 12px;
            padding: 35px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        }

        .price-display {
            font-size: 36px;
            font-weight: 700;
            color: #1e3c72;
            text-align: center;
            margin-bottom: 30px;
        }

        .cta-button {
            display: block;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: white;
            padding: 16px 24px;
            border-radius: 8px;
            text-align: center;
            text-decoration: none;
            font-weight: 600;
            font-size: 15px;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 25px;
        }

        .cta-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .feature-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .feature-list li {
            padding: 10px 0;
            color: #555;
            font-size: 14px;
            border-bottom: 1px solid #f0f0f0;
        }

        .feature-list li:last-child {
            border-bottom: none;
        }

        .feature-list i {
            color: #1e3c72;
            margin-right: 10px;
            width: 16px;
        }
    </style>

    <!-- Service Detail Header -->
    <section class="service-header">
        <div class="container">
            <div class="breadcrumb" style="margin-bottom: 20px;">
                <a href="{{ route('index') }}" style="color: rgba(255,255,255,0.8);">Ana Sayfa</a> /
                <a href="{{ $type == 'caregiver' ? route('caregiver.index') : route('home-services.index') }}"
                    style="color: rgba(255,255,255,0.8);">{{ $type == 'caregiver' ? 'Bakıcı Noktası' : 'Evine Hizmet Al' }}</a>
                @if($service->category)
                    / <a href="{{ $type == 'caregiver' ? route('caregiver.category', $service->category->category_slug) : route('home-services.category', $service->category->category_slug) }}"
                        style="color: rgba(255,255,255,0.8);">{{ $service->category->category_name }}</a>
                @endif
            </div>
            <h1>{{ $service->service_name }}</h1>
            <div style="display: flex; gap: 30px; font-size: 15px; opacity: 0.95;">
                <span><i class="fa fa-eye"></i> {{ $service->views_count }} görüntülenme</span>
                <span><i class="fa fa-users"></i> {{ $service->requests_count }} talep</span>
            </div>
        </div>
    </section>

    <!-- Service Detail -->
    <section class="service-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="service-card">
                        @if($service->service_image)
                            <img src="{{ asset('uploads/services/' . $service->service_image) }}"
                                alt="{{ $service->service_name }}" class="service-image">
                        @else
                            <div
                                style="width: 100%; height: 350px; background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); display: flex; align-items: center; justify-content: center;">
                                <i class="fa fa-cog" style="font-size: 80px; color: white; opacity: 0.8;"></i>
                            </div>
                        @endif

                        <div class="service-details">
                            <h2>{{ $type == 'caregiver' ? 'Bakıcı Detayları' : 'Hizmet Detayları' }}</h2>
                            <p>{{ $service->service_desc }}</p>

                            <div class="info-grid">
                                <div class="info-item">
                                    <label>Fiyat</label>
                                    <value>₺{{ number_format($service->price, 2) }}</value>
                                </div>
                                <div class="info-item">
                                    <label>Durum</label>
                                    <value style="color: #28a745;">
                                        @if($service->is_active)
                                            <i class="fa fa-check-circle"></i> active
                                        @else
                                            <i class="fa fa-times-circle"></i> Pasif
                                        @endif
                                    </value>
                                </div>
                                <div class="info-item">
                                    <label>Tahmini Süre</label>
                                    <value>{{ $service->getFormattedDuration() }}</value>
                                </div>
                                <div class="info-item">
                                    <label>Fiyatlandırma Modeli</label>
                                    <value>
                                        @if($service->price_model == 'fixed') Sabit Fiyat
                                        @elseif($service->price_model == 'hourly') Saatlik
                                        @else Paket @endif
                                    </value>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Related Services -->
                    @if($relatedServices->count() > 0)
                        <div style="margin-top: 50px;">
                            <h3 style="font-weight: 600; margin-bottom: 25px; font-size: 20px; color: #1a1a1a;">
                                {{ $type == 'caregiver' ? 'Benzer Bakıcı Türleri' : 'Benzer Hizmetler' }}</h3>
                            <div class="row">
                                @foreach($relatedServices as $related)
                                    <div class="col-md-6" style="margin-bottom: 20px;">
                                        <div class="service-card" style="margin-bottom: 0;">
                                            <div style="display: flex; height: 120px;">
                                                @if($related->service_image)
                                                    <img src="{{ asset('uploads/services/' . $related->service_image) }}"
                                                        alt="{{ $related->service_name }}"
                                                        style="width: 120px; height: 120px; object-fit: cover;">
                                                @else
                                                    <div
                                                        style="width: 120px; height: 120px; background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); display: flex; align-items: center; justify-content: center;">
                                                        <i class="fa fa-cog" style="font-size: 40px; color: white; opacity: 0.7;"></i>
                                                    </div>
                                                @endif
                                                <div
                                                    style="padding: 20px; flex: 1; display: flex; flex-direction: column; justify-content: space-between;">
                                                    <div>
                                                        <h5
                                                            style="font-weight: 600; margin: 0 0 8px 0; font-size: 15px; color: #1a1a1a;">
                                                            {{ $related->service_name }}</h5>
                                                        <span
                                                            style="color: #1e3c72; font-weight: 700; font-size: 14px;">₺{{ number_format($related->price, 2) }}</span>
                                                    </div>
                                                    <a href="{{ $type == 'caregiver' ? route('caregiver.show', $related->service_slug) : route('home-services.show', $related->service_slug) }}"
                                                        style="color: #1e3c72; font-size: 13px; font-weight: 600; text-decoration: none;">Detaylar
                                                        →</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="col-md-4">
                    <div class="sidebar-card">
                        <div class="price-display">₺{{ number_format($service->price, 2) }}</div>

                        @php
                            $canRequest = true;
                            if(Auth::check()) {
                                $user = Auth::user();
                                if($user->isJobSeeker() || $user->isPersonnel() || $user->isCaregiver()) {
                                    $canRequest = false;
                                }
                            }
                        @endphp

                        @if($canRequest)
                            <a href="{{ $type == 'caregiver' ? route('caregiver.request-form', $service->service_slug) : route('home-services.request-form', $service->service_slug) }}"
                                class="cta-button">
                                <i class="fa fa-paper-plane"></i>
                                {{ $type == 'caregiver' ? 'Bakıcı Talep Et' : 'Hizmet Talep Et' }}
                            </a>
                        @else
                            <div class="alert alert-warning mt-4" style="font-size: 14px;">
                                <i class="fa fa-info-circle"></i>
                                {{ __('Hizmet veya bakıcı talebinde bulunabilmek için "Hizmet Alan" hesabınızla giriş yapmalısınız.') }}
                            </div>
                        @endif

                        <div style="margin-top: 30px; padding-top: 25px; border-top: 2px solid #e5e5e5;">
                            <h5 style="font-weight: 600; margin-bottom: 20px; font-size: 15px; color: #1a1a1a;">
                                {{ $type == 'caregiver' ? 'Bakıcı Özellikleri' : 'Hizmet Özellikleri' }}</h5>
                            <ul class="feature-list">
                                <li style="margin-bottom: 10px;"><i class="fa fa-check"
                                        style="color: #28a745; margin-right: 10px;"></i> Profesyonel Ekip</li>
                                <li style="margin-bottom: 10px;"><i class="fa fa-check"
                                        style="color: #28a745; margin-right: 10px;"></i> Garantili Hizmet</li>
                                <li style="margin-bottom: 10px;"><i class="fa fa-check"
                                        style="color: #28a745; margin-right: 10px;"></i> Uygun Fiyat</li>
                                <li style="margin-bottom: 10px;"><i class="fa fa-check"
                                        style="color: #28a745; margin-right: 10px;"></i> 7/24 Destek</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('includes.footer')
@endsection