@extends('layouts.app')
@section('content')
    <!-- Header start -->
    @include('includes.header')
    <!-- Header end -->
    <!-- Inner Page Title start -->
    @include('includes.inner_page_title', ['page_title' => __('Atanan Görevlerim')])
    <!-- Inner Page Title end -->
    <div class="listpgWraper">
        <div class="container">
            <div class="row">
                @include('includes.user_dashboard_menu')
                <div class="col-lg-9">
                    <div class="userccount">
                        <div class="formpanel mt-0">
                            <h3>{{__('Size Atanan Hizmet Görevleri')}}</h3>
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>{{__('Talep No')}}</th>
                                            <th>{{__('Hizmet')}}</th>
                                            <th>{{__('Müşteri')}}</th>
                                            <th>{{__('Tarih/Saat')}}</th>
                                            <th>{{__('Durum')}}</th>
                                            <th>{{__('İşlem')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($assignments as $assignment)
                                            <tr>
                                                <td>#{{ $assignment->request_number }}</td>
                                                <td>{{ $assignment->service->service_name ?? 'Belirtilmemiş' }}</td>
                                                <td>{{ $assignment->user->name ?? 'Belirtilmemiş' }}</td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($assignment->preferred_date)->format('d.m.Y') }}
                                                    {{ $assignment->preferred_time }}
                                                </td>
                                                <td>
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
                                                </td>
                                                <td>
                                                    <a href="{{ route('personnel.assignment_details', $assignment->id) }}"
                                                        class="btn btn-xs btn-info"><i class="fas fa-eye"></i>
                                                        {{__('Detay')}}</a>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center">
                                                    {{__('Henüz size atanan bir görev bulunmamaktadır.')}}
                                                </td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-3">
                                {{ $assignments->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('includes.footer')
@endsection