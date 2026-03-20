@extends(auth()->user()->getDashboardLayout() ?? 'layouts.user')

@section('content')
    <div class="app-detail-page">
        <a href="{{ route('my-applications.index') }}" class="back-link"><i class="fa fa-arrow-left"></i> Başvurularım</a>

        <div class="app-detail-header">
            <div>
                <h1>{{ $application->jobPost->title }}</h1>
                <div style="display:flex; gap:8px; flex-wrap:wrap; margin-top:8px;">
                    <span
                        class="badge badge-{{ $application->getStatusColor() }}">{{ $application->getStatusLabel() }}</span>
                    <span style="color:#888; font-size:13px;"><i class="fa fa-calendar"></i>
                        {{ $application->created_at->format('d.m.Y H:i') }}</span>
                </div>
            </div>
            <div class="score-pill score-{{ $application->getMatchScoreBadgeColor() }}">
                <span class="score-num">%{{ number_format($application->match_score, 0) }}</span>
                <span class="score-label">Uygunluk</span>
            </div>
        </div>

        {{-- Explanation --}}
        @if($application->match_explanation)
            <div class="explanation-box">
                <i class="fa fa-lightbulb-o"></i> {{ $application->match_explanation }}
            </div>
        @endif

        {{-- Score Breakdown --}}
        @if(!empty($application->match_breakdown))
            <div class="breakdown-card">
                <h4><i class="fa fa-bar-chart"></i> Eşleşme Kriterleriniz</h4>
                <div class="breakdown-grid">
                    @foreach($application->match_breakdown as $key => $crit)
                        @php $raw = $crit['raw'] ?? 0;
                        $c = $raw >= 70 ? '#10b981' : ($raw >= 40 ? '#f59e0b' : '#ef4444'); @endphp
                        <div>
                            <div style="display:flex; justify-content:space-between; font-size:12px; margin-bottom:3px;">
                                <span style="color:#555;">{{ $crit['label'] ?? $key }}</span>
                                <strong style="color:{{ $c }};">%{{ $raw }}</strong>
                            </div>
                            <div style="background:#f3f4f6; border-radius:6px; height:7px; overflow:hidden;">
                                <div style="width:{{ $raw }}%; height:100%; background:{{ $c }}; border-radius:6px;"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Cover Note --}}
        @if($application->cover_note)
            <div class="cover-note-card">
                <h4><i class="fa fa-comment-o"></i> Başvuru Notunuz</h4>
                <p>{{ $application->cover_note }}</p>
            </div>
        @endif

        {{-- Audit Timeline --}}
        <div class="timeline-card">
            <h4><i class="fa fa-history"></i> Başvuru Geçmişi</h4>
            <div class="timeline">
                @foreach($application->statusHistory as $log)
                    <div class="timeline-item">
                        <div class="timeline-dot {{ $log->new_status }}"></div>
                        <div class="timeline-content">
                            <div class="timeline-status">
                                <span
                                    class="badge badge-{{ \App\ListingApplication::getStatusColors()[$log->new_status] ?? 'default' }}">
                                    {{ \App\ListingApplication::getStatusLabels()[$log->new_status] ?? $log->new_status }}
                                </span>
                                @if($log->old_status)
                                    <small style="color:#aaa;">
                                        ← {{ \App\ListingApplication::getStatusLabels()[$log->old_status] ?? $log->old_status }}
                                    </small>
                                @endif
                            </div>
                            <div class="timeline-meta">
                                <small>{{ $log->changed_by_role === 'system' ? 'Sistem' : ($log->changedByUser?->getName() ?? 'Kullanıcı') }}</small>
                                &bull;
                                <small>{{ \Carbon\Carbon::parse($log->created_at)->format('d.m.Y H:i') }}</small>
                            </div>
                            @if($log->notes)
                                <p class="timeline-notes">{{ $log->notes }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Withdraw (if applicable) --}}
        @if(in_array($application->status, ['pending', 'shortlisted']))
            <div style="margin-top:15px; text-align:right;">
                <form action="{{ route('listings.withdraw', $application->job_post_id) }}" method="POST"
                    onsubmit="return confirm('Başvurunuzu geri çekmek istediğinize emin misiniz?')">
                    @csrf
                    <button class="btn btn-danger btn-sm">
                        <i class="fa fa-times"></i> Başvuruyu Geri Çek
                    </button>
                </form>
            </div>
        @endif
    </div>

    <style>
        .app-detail-page {
            max-width: 720px;
            margin: 0 auto;
            padding: 20px;
        }

        .back-link {
            color: #667eea;
            text-decoration: none;
            font-size: 13px;
        }

        .app-detail-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            background: #fff;
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .07);
            margin: 12px 0 16px;
            flex-wrap: wrap;
        }

        .app-detail-header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
        }

        .score-pill {
            text-align: center;
            padding: 10px 18px;
            border-radius: 12px;
            min-width: 80px;
        }

        .score-pill.success {
            background: #d1fae5;
            color: #065f46;
        }

        .score-pill.warning {
            background: #fef3c7;
            color: #92400e;
        }

        .score-pill.danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .score-num {
            display: block;
            font-size: 22px;
            font-weight: 900;
            line-height: 1;
        }

        .score-label {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .explanation-box {
            background: #f0f4ff;
            border-left: 4px solid #667eea;
            padding: 12px 16px;
            border-radius: 0 8px 8px 0;
            color: #374151;
            font-size: 13px;
            margin-bottom: 15px;
        }

        .breakdown-card,
        .cover-note-card,
        .timeline-card {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .06);
            margin-bottom: 15px;
        }

        .breakdown-card h4,
        .cover-note-card h4,
        .timeline-card h4 {
            margin: 0 0 14px;
            font-size: 15px;
            font-weight: 700;
        }

        .breakdown-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        @media(max-width:560px) {
            .breakdown-grid {
                grid-template-columns: 1fr;
            }
        }

        .cover-note-card p {
            color: #374151;
            line-height: 1.7;
            margin: 0;
            white-space: pre-line;
        }

        .timeline {
            position: relative;
            padding-left: 22px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 6px;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e5e7eb;
        }

        .timeline-item {
            position: relative;
            padding: 0 0 18px 16px;
        }

        .timeline-dot {
            position: absolute;
            left: -16px;
            top: 4px;
            width: 12px;
            height: 12px;
            border-radius: 50%;
            border: 2px solid #fff;
            box-shadow: 0 0 0 2px #e5e7eb;
            background: #6b7280;
        }

        .timeline-dot.accepted {
            background: #10b981;
        }

        .timeline-dot.rejected {
            background: #ef4444;
        }

        .timeline-dot.shortlisted {
            background: #3b82f6;
        }

        .timeline-dot.invited {
            background: #8b5cf6;
        }

        .timeline-dot.pending {
            background: #f59e0b;
        }

        .timeline-dot.withdrawn {
            background: #9ca3af;
        }

        .timeline-status {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 4px;
        }

        .timeline-meta {
            font-size: 11px;
            color: #aaa;
            margin-bottom: 4px;
        }

        .timeline-notes {
            font-size: 12px;
            color: #555;
            margin: 4px 0 0;
        }

        .badge {
            padding: 3px 10px;
            border-radius: 10px;
            font-size: 12px;
            font-weight: 700;
        }

        .badge-success {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-info {
            background: #dbeafe;
            color: #1e40af;
        }

        .badge-primary {
            background: #ede9fe;
            color: #5b21b6;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-secondary {
            background: #f3f4f6;
            color: #374151;
        }
    </style>
@endsection