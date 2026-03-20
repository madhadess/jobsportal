@extends('admin.layouts.admin_layout')

@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li><a href="{{ route('admin.home') }}">Ana Sayfa</a><i class="fa fa-circle"></i></li>
                    <li><a href="{{ route('admin.job-posts.index') }}">İlanlar</a><i class="fa fa-circle"></i></li>
                    <li><span>İstatistikler</span></li>
                </ul>
            </div>

            {{-- Summary Stats --}}
            <div class="row" style="margin-bottom:25px;">
                <div class="col-lg-2 col-sm-4 col-xs-6">
                    <div class="stat-widget" style="background:linear-gradient(135deg,#667eea,#764ba2);">
                        <div class="sw-icon"><i class="fa fa-list-alt"></i></div>
                        <div class="sw-num">{{ $stats['total_posts'] }}</div>
                        <div class="sw-label">Toplam İlan</div>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-4 col-xs-6">
                    <div class="stat-widget" style="background:linear-gradient(135deg,#10b981,#059669);">
                        <div class="sw-icon"><i class="fa fa-globe"></i></div>
                        <div class="sw-num">{{ $stats['open'] }}</div>
                        <div class="sw-label">Yayında</div>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-4 col-xs-6">
                    <div class="stat-widget" style="background:linear-gradient(135deg,#3b82f6,#1d4ed8);">
                        <div class="sw-icon"><i class="fa fa-handshake-o"></i></div>
                        <div class="sw-num">{{ $stats['matched'] }}</div>
                        <div class="sw-label">Eşleşti</div>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-4 col-xs-6">
                    <div class="stat-widget" style="background:linear-gradient(135deg,#f59e0b,#d97706);">
                        <div class="sw-icon"><i class="fa fa-paper-plane"></i></div>
                        <div class="sw-num">{{ $stats['total_apps'] }}</div>
                        <div class="sw-label">Toplam Başvuru</div>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-4 col-xs-6">
                    <div class="stat-widget" style="background:linear-gradient(135deg,#8b5cf6,#7c3aed);">
                        <div class="sw-icon"><i class="fa fa-star"></i></div>
                        <div class="sw-num">%{{ $stats['avg_score'] }}</div>
                        <div class="sw-label">Ort. Skor</div>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-4 col-xs-6">
                    <div class="stat-widget" style="background:linear-gradient(135deg,#ef4444,#dc2626);">
                        <div class="sw-icon"><i class="fa fa-check-circle"></i></div>
                        <div class="sw-num">%{{ $stats['accept_rate'] }}</div>
                        <div class="sw-label">Kabul Oranı</div>
                    </div>
                </div>
            </div>

            {{-- Score Distribution --}}
            <div class="row" style="margin-bottom:20px;">
                <div class="col-md-8">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-dark">
                                <i class="icon-bar-chart font-dark"></i>
                                <span class="caption-subject bold uppercase">Son Hesaplanan Uygunluk Skorları</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            @if($recentScores->isEmpty())
                                <p class="text-muted text-center" style="padding:20px;">Henüz skor hesaplanmamış.</p>
                            @else
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Aday</th>
                                            <th>İlan</th>
                                            <th>Skor</th>
                                            <th>Motor</th>
                                            <th>Tarih</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentScores as $log)
                                            <tr>
                                                <td>
                                                    <strong>{{ $log->user?->getName() }}</strong><br>
                                                    <small class="text-muted">{{ $log->user?->email }}</small>
                                                </td>
                                                <td>{{ Str::limit($log->jobPost?->title, 30) }}</td>
                                                <td>
                                                    @php $s = (float) $log->total_score; @endphp
                                                    <div style="display:flex; align-items:center; gap:8px;">
                                                        <div
                                                            style="background:#f3f4f6; border-radius:4px; height:8px; width:80px; overflow:hidden;">
                                                            <div
                                                                style="width:{{ min($s, 100) }}%; height:100%; background:{{ $s >= 70 ? '#10b981' : ($s >= 40 ? '#f59e0b' : '#ef4444') }};">
                                                            </div>
                                                        </div>
                                                        <span
                                                            style="font-weight:700; color:{{ $s >= 70 ? '#065f46' : ($s >= 40 ? '#92400e' : '#991b1b') }};">
                                                            %{{ number_format($s, 0) }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td><code>{{ $log->engine_version }}</code></td>
                                                <td>{{ $log->computed_at ? \Carbon\Carbon::parse($log->computed_at)->format('d.m.Y H:i') : '—' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Score Buckets --}}
                <div class="col-md-4">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-dark">
                                <i class="icon-pie-chart font-dark"></i>
                                <span class="caption-subject bold uppercase">Skor Dağılımı</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            @php
                                use App\ListingApplication;
                                $buckets = [
                                    ['label' => '80-100% (Yüksek)', 'min' => 80, 'max' => 100, 'color' => '#10b981'],
                                    ['label' => '60-79% (İyi)', 'min' => 60, 'max' => 79, 'color' => '#3b82f6'],
                                    ['label' => '40-59% (Orta)', 'min' => 40, 'max' => 59, 'color' => '#f59e0b'],
                                    ['label' => '20-39% (Düşük)', 'min' => 20, 'max' => 39, 'color' => '#ef4444'],
                                    ['label' => '0-19% (Çok Düşük)', 'min' => 0, 'max' => 19, 'color' => '#9ca3af'],
                                ];
                                $total = ListingApplication::whereNotNull('match_score')->count();
                            @endphp
                            @foreach($buckets as $bucket)
                                @php
                                    $count = ListingApplication::whereNotNull('match_score')
                                        ->where('match_score', '>=', $bucket['min'])
                                        ->where('match_score', '<=', $bucket['max'])
                                        ->count();
                                    $pct = $total > 0 ? round(($count / $total) * 100) : 0;
                                @endphp
                                <div style="margin-bottom:12px;">
                                    <div
                                        style="display:flex; justify-content:space-between; font-size:12px; margin-bottom:4px;">
                                        <span style="color:#555;">{{ $bucket['label'] }}</span>
                                        <span style="font-weight:700;">{{ $count }} <small
                                                class="text-muted">({{ $pct }}%)</small></span>
                                    </div>
                                    <div style="background:#f3f4f6; border-radius:6px; height:10px; overflow:hidden;">
                                        <div
                                            style="width:{{ $pct }}%; height:100%; background:{{ $bucket['color'] }}; border-radius:6px;">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="text-muted text-center" style="margin-top:10px; font-size:12px;">
                                Toplam: {{ $total }} başvuru
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Navigation --}}
            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('admin.job-posts.index') }}" class="btn btn-default">
                        <i class="fa fa-arrow-left"></i> İlanlara Dön
                    </a>
                    <a href="{{ route('admin.match-rules.index') }}" class="btn btn-primary" style="margin-left:8px;">
                        <i class="fa fa-sliders"></i> Kural Ağırlıklarını Yönet
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        .stat-widget {
            border-radius: 12px;
            padding: 18px;
            color: #fff;
            text-align: center;
            margin-bottom: 15px;
        }

        .sw-icon i {
            font-size: 28px;
            opacity: .8;
            margin-bottom: 8px;
            display: block;
        }

        .sw-num {
            font-size: 28px;
            font-weight: 900;
            line-height: 1;
        }

        .sw-label {
            font-size: 11px;
            margin-top: 4px;
            opacity: .9;
            font-weight: 600;
            text-transform: uppercase;
        }
    </style>
@endsection