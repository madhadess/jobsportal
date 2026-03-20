@extends('admin.layouts.admin_layout')

@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li><a href="{{ route('admin.home') }}">Ana Sayfa</a><i class="fa fa-circle"></i></li>
                    <li><a href="{{ route('admin.applications.index') }}">Başvurular</a><i class="fa fa-circle"></i></li>
                    <li><span>Başvuru #{{ $application->id }}</span></li>
                </ul>
            </div>

            <div class="row">
                {{-- Left: Application Detail --}}
                <div class="col-md-8">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-dark">
                                <i class="fa fa-paper-plane font-dark"></i>
                                <span class="caption-subject bold uppercase">Başvuru Detayı</span>
                            </div>
                            <div class="actions">
                                <span
                                    class="label label-{{ \App\ListingApplication::getStatusColors()[$application->status] ?? 'default' }} label-lg">
                                    {{ $statusLabels[$application->status] ?? $application->status }}
                                </span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width:160px;">İlan</th>
                                    <td>
                                        <a href="{{ route('admin.job-posts.show', $application->job_post_id) }}">
                                            <strong>{{ $application->jobPost?->title }}</strong>
                                        </a><br>
                                        <small class="text-muted">İlan Sahibi:
                                            {{ $application->jobPost?->owner?->getName() }}</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Başvuran</th>
                                    <td>
                                        <strong>{{ $application->applicant?->getName() }}</strong><br>
                                        <small class="text-muted">{{ $application->applicant?->email }}</small>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Uygunluk Skoru</th>
                                    <td>
                                        @php $score = (float) $application->match_score; @endphp
                                        <div style="display:flex; align-items:center; gap:12px;">
                                            <div
                                                style="background:#f3f4f6; border-radius:6px; height:12px; width:140px; overflow:hidden;">
                                                <div
                                                    style="width:{{ min($score, 100) }}%;height:100%;background:{{ $score >= 70 ? '#10b981' : ($score >= 40 ? '#f59e0b' : '#ef4444') }};">
                                                </div>
                                            </div>
                                            <strong
                                                style="color:{{ $score >= 70 ? '#065f46' : ($score >= 40 ? '#92400e' : '#991b1b') }}; font-size:18px;">
                                                %{{ number_format($score, 1) }}
                                            </strong>
                                        </div>
                                        @if($application->match_explanation)
                                            <p style="margin:10px 0 0; font-size:13px; color:#555;">
                                                <i class="fa fa-info-circle"></i> {{ $application->match_explanation }}
                                            </p>
                                        @endif
                                    </td>
                                </tr>
                                @if(!empty($application->match_breakdown))
                                    <tr>
                                        <th>Kriter Puanları</th>
                                        <td>
                                            <div style="display:grid; grid-template-columns:1fr 1fr; gap:8px;">
                                                @foreach($application->match_breakdown as $key => $crit)
                                                    @php $r = $crit['raw'] ?? 0; @endphp
                                                    <div>
                                                        <div
                                                            style="display:flex;justify-content:space-between;font-size:12px;margin-bottom:3px;">
                                                            <span>{{ $crit['label'] ?? $key }}</span>
                                                            <strong>%{{ $r }}</strong>
                                                        </div>
                                                        <div
                                                            style="background:#f3f4f6;border-radius:4px;height:6px;overflow:hidden;">
                                                            <div
                                                                style="width:{{ $r }}%;height:100%;background:{{ $r >= 70 ? '#10b981' : ($r >= 40 ? '#f59e0b' : '#ef4444') }};">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                                @if($application->cover_note)
                                    <tr>
                                        <th>Başvuru Notu</th>
                                        <td style="font-style:italic; color:#555;">{{ $application->cover_note }}</td>
                                    </tr>
                                @endif
                                <tr>
                                    <th>Başvuru Tarihi</th>
                                    <td>{{ $application->created_at->format('d.m.Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    {{-- Audit Timeline --}}
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-dark">
                                <i class="fa fa-history font-dark"></i>
                                <span class="caption-subject bold uppercase">Durum Geçmişi</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="mt-timeline">
                                @forelse($application->statusHistory as $log)
                                    <div class="mt-timeline-entry clearfix">
                                        <div class="mt-timeline-time">
                                            <span class="mt-timeline-icon bg-green-jungle">
                                                <i class="fa fa-circle"></i>
                                            </span>
                                        </div>
                                        <div class="mt-timeline-body">
                                            <div class="mt-timeline-body-head">
                                                <span
                                                    class="label label-{{ \App\ListingApplication::getStatusColors()[$log->new_status] ?? 'default' }}">
                                                    {{ \App\ListingApplication::getStatusLabels()[$log->new_status] ?? $log->new_status }}
                                                </span>
                                                @if($log->old_status)
                                                    ← <small
                                                        class="text-muted">{{ \App\ListingApplication::getStatusLabels()[$log->old_status] ?? $log->old_status }}</small>
                                                @endif
                                            </div>
                                            <div class="mt-timeline-body-head-desc">
                                                <small>{{ $log->changedByUser?->getName() ?? ucfirst($log->changed_by_role) }}</small>
                                                &bull;
                                                <small>{{ $log->created_at->format('d.m.Y H:i') }}</small>
                                            </div>
                                            @if($log->notes)
                                                <div class="mt-timeline-body-content">
                                                    <p>{{ $log->notes }}</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-muted">Durum geçmişi bulunamadı.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right: Applicant Info --}}
                <div class="col-md-4">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-dark">
                                <i class="fa fa-user font-dark"></i>
                                <span class="caption-subject bold uppercase">Aday Profili</span>
                            </div>
                        </div>
                        <div class="portlet-body" style="text-align:center;">
                            @php $ap = $application->applicant; @endphp
                            <img src="{{ $ap?->image ? asset('uploads/user_images/' . $ap->image) : asset('admin_assets/no-image.png') }}"
                                style="width:80px; height:80px; border-radius:50%; object-fit:cover; margin-bottom:12px;">
                            <h4 style="margin:0 0 4px;">{{ $ap?->getName() }}</h4>
                            <p style="color:#888; font-size:13px;">{{ $ap?->email }}</p>
                            @if($ap?->phone)
                                <p style="color:#888; font-size:13px;"><i class="fa fa-phone"></i> {{ $ap->phone }}</p>
                            @endif
                        </div>
                        <div class="portlet-body" style="border-top:1px solid #f0f0f0; padding-top:12px;">
                            <table class="table table-condensed">
                                <tr>
                                    <th>İl</th>
                                    <td>{{ $ap?->state?->state ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <th>Deneyim</th>
                                    <td>{{ $ap?->job_experience_id ? 'Var' : 'Belirtilmemiş' }}</td>
                                </tr>
                                <tr>
                                    <th>Aday Türü</th>
                                    <td>
                                        {{ $ap?->isPersonnel() ? '🔧 Personel' : ($ap?->isCaregiver() ? '🧑‍⚕️ Bakıcı' : '—') }}
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div style="display:flex; gap:8px; justify-content:center; margin-top:10px;">
                        <a href="{{ route('admin.applications.index') }}" class="btn btn-default btn-sm">
                            <i class="fa fa-arrow-left"></i> Geri
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection