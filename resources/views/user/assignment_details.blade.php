@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title' => __('Hizmet Görevi Detayı')])
    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <div class="container">
            <div class="row">
                @include('includes.user_dashboard_menu')
                <div class="col-lg-9">
                    <div class="userccount">
                        <div class="formpanel mt-0">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3>{{__('Görev Bilgileri')}}</h3>
                                </div>
                                <div class="col-md-6 text-end">
                                    <a href="{{ route('personnel.assignments') }}" class="btn btn-secondary btn-sm">
                                        <i class="fas fa-arrow-left"></i> {{__('Geri Dön')}}
                                    </a>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><strong>{{__('Talep No')}}:</strong>
                                            #{{ $assignment->request_number }}</li>
                                        <li class="list-group-item"><strong>{{__('Hizmet')}}:</strong>
                                            {{ $assignment->service->service_name ?? 'Belirtilmemiş' }}</li>
                                        <li class="list-group-item"><strong>{{__('Tarih')}}:</strong>
                                            {{ \Carbon\Carbon::parse($assignment->preferred_date)->translatedFormat('d F Y') }}
                                        </li>
                                        <li class="list-group-item"><strong>{{__('Saat')}}:</strong>
                                            {{ $assignment->preferred_time }}</li>
                                        <li class="list-group-item"><strong>{{__('Durum')}}:</strong>
                                            @php
                                                $statusTranslations = [
                                                    'pending_matching' => 'Eşleştirme Bekliyor',
                                                    'matched' => 'Atandı / Kabul Bekliyor',
                                                    'accepted' => 'Kabul Edildi',
                                                    'failed' => 'Başarısız',
                                                    'admin_review' => 'İncelemede'
                                                ];
                                                $autoStatus = $assignment->automation_status;
                                                $translatedStatus = $statusTranslations[$autoStatus] ?? $autoStatus;
                                                $badgeClass = $autoStatus == 'accepted' ? 'bg-success' : (($autoStatus == 'matched') ? 'bg-info' : 'bg-secondary');
                                            @endphp
                                            <span class="badge {{ $badgeClass }}">{{ __($translatedStatus) }}</span>
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-6">
                                    <ul class="list-group list-group-flush">
                                        <li class="list-group-item"><strong>{{__('Müşteri')}}:</strong>
                                            {{ $assignment->user->name ?? 'Belirtilmemiş' }}</li>
                                        <li class="list-group-item"><strong>{{__('Telefon')}}:</strong>
                                            {{ $assignment->user->phone ?? 'Belirtilmemiş' }}</li>
                                        <li class="list-group-item"><strong>{{__('Adres')}}:</strong>
                                            {{ $assignment->customer_address }}</li>
                                        <li class="list-group-item"><strong>{{__('Şehir/İlçe')}}:</strong>
                                            {{ $assignment->city->city ?? 'Belirtilmemiş' }} /
                                            {{ $assignment->state->state ?? 'Belirtilmemiş' }}
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            @if($assignment->automation_status == 'matched')
                                <div class="row mt-4">
                                    <div class="col-md-12 text-center d-flex justify-content-center gap-3">
                                        <form action="{{ route('personnel.reject_assignment', $assignment->id) }}" method="POST"
                                            onsubmit="return confirm('Bu işi reddetmek istediğinize emin misiniz? Reddedilen işler sicilinize işlenebilir.');">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-lg px-5">
                                                <i class="fas fa-times-circle"></i> {{__('Reddet')}}
                                            </button>
                                        </form>

                                        <form action="{{ route('personnel.accept_assignment', $assignment->id) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-lg px-5">
                                                <i class="fas fa-check-circle"></i> {{__('İşi Kabul Et')}}
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endif

                            @if($assignment->home_size || $assignment->service_duration)
                                <hr>
                                <h3>{{__('Ek Detaylar')}}</h3>
                                <div class="row">
                                    @if($assignment->home_size)
                                        <div class="col-md-6">
                                            <p><strong>{{__('Ev Büyüklüğü')}}:</strong> {{ $assignment->home_size }}</p>
                                        </div>
                                    @endif
                                    @if($assignment->service_duration)
                                        <div class="col-md-6">
                                            <p><strong>{{__('Tahmini Süre')}}:</strong> {{ $assignment->service_duration }}
                                                {{__('Saat')}}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('includes.footer')
@endsection