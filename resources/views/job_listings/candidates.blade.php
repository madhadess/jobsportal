@extends('layouts.app')

@section('content')
    @include('includes.header')
    @include('includes.inner_page_title', ['page_title' => __('Başvuran Adaylar')])
    <div class="listpgWraper">
        <div class="container">
            <div class="candidates-page">
                <div class="page-header-bar">
                    <div>
                        <a href="{{ route('job-posts.show', $post->id) }}" class="back-link"><i
                                class="fa fa-arrow-left"></i>
                            {{ $post->title }}</a>
                        <h1>Başvuran Adaylar</h1>
                    </div>
                    <div class="header-stats">
                        <span class="stat-chip">{{ $candidates->total() }} başvuru</span>
                    </div>
                </div>

                {{-- Filter --}}
                <form method="GET" class="filter-bar" style="margin-bottom:20px; display:flex; gap:10px; flex-wrap:wrap;">
                    <select name="status" class="form-control" style="max-width:180px;" onchange="this.form.submit()">
                        <option value="">Tüm Durumlar</option>
                        @foreach($statusLabels as $key => $label)
                            <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <a href="{{ route('job-posts.candidates', $post->id) }}" class="btn btn-sm btn-default">Temizle</a>
                </form>

                @if($candidates->isEmpty())
                    <div class="empty-state">
                        <i class="fa fa-users fa-3x" style="color:#ccc;"></i>
                        <p style="margin-top:15px; color:#888;">Henüz başvuran yok.</p>
                    </div>
                @else
                    <div class="candidates-grid">
                        @foreach($candidates as $app)
                            @php
                                $applicant = $app->applicant;
                                $scoreColor = $app->getMatchScoreBadgeColor();
                                $breakdown = is_array($app->match_breakdown) ? $app->match_breakdown : [];
                            @endphp
                            <div class="candidate-card status-{{ $app->status }}">
                                <div class="candidate-header">
                                    <img src="{{ $applicant->image ? asset('uploads/user_images/' . $applicant->image) : asset('admin_assets/no-image.png') }}"
                                        alt="{{ $applicant->getName() }}" class="cand-avatar">
                                    <div class="cand-header-info">
                                        <h3>{{ $applicant->getName() }}</h3>
                                        <small>{{ $applicant->email }}</small>
                                        <div class="cand-location">
                                            <i class="fa fa-map-marker"></i>
                                            {{ $applicant->state_id ?? '—' }}
                                        </div>
                                    </div>
                                    <div class="score-badge badge-{{ $scoreColor }}">
                                        <span class="score-pct">%{{ number_format($app->match_score, 0) }}</span>
                                        <span class="score-label">Uygunluk</span>
                                    </div>
                                </div>

                                {{-- Score Breakdown --}}
                                @if(!empty($app->match_explanation))
                                    <div class="score-explanation">
                                        <i class="fa fa-info-circle"></i> {{ $app->match_explanation }}
                                    </div>
                                @endif

                                {{-- Criteria Bars --}}
                                @if(!empty($breakdown))
                                    <div class="criteria-bars">
                                        @foreach($breakdown as $key => $crit)
                                            <div class="crit-row">
                                                <span class="crit-label">{{ $crit['label'] ?? $key }}</span>
                                                <div class="crit-bar-wrap">
                                                    <div class="crit-bar"
                                                        style="width:{{ $crit['raw'] ?? 0 }}%; background:{{ ($crit['raw'] ?? 0) >= 70 ? '#10b981' : (($crit['raw'] ?? 0) >= 40 ? '#f59e0b' : '#ef4444') }};">
                                                    </div>
                                                </div>
                                                <span class="crit-val">{{ $crit['raw'] ?? 0 }}%</span>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                {{-- Meta --}}
                                <div class="cand-meta">
                                    <span><i class="fa fa-briefcase"></i>
                                        {{ $applicant->job_experience_id ? 'Deneyimli' : 'Deneyim belirtilmemiş' }}</span>
                                    <span class="status-badge-sm badge-{{ $app->status }}">{{ $app->getStatusLabel() }}</span>
                                    <span><i class="fa fa-calendar"></i> {{ $app->created_at->format('d.m.Y') }}</span>
                                </div>

                                @if($app->cover_note)
                                    <div class="cover-note">
                                        <i class="fa fa-quote-left"></i> {{ Str::limit($app->cover_note, 120) }}
                                    </div>
                                @endif

                                {{-- Actions --}}
                                <div class="cand-actions">
                                    <a href="{{ route('view.public.profile', $applicant->id) }}" target="_blank"
                                        class="btn-action btn-view">
                                        <i class="fa fa-user"></i> Profil
                                    </a>

                                    @if($app->status === 'pending')
                                        <form action="{{ route('job-posts.candidates.shortlist', [$post->id, $app->id]) }}"
                                            method="POST" style="display:inline;">
                                            @csrf
                                            <button class="btn-action btn-shortlist"><i class="fa fa-star"></i> Kısa Liste</button>
                                        </form>
                                    @endif

                                    @if(in_array($app->status, ['pending', 'shortlisted']))
                                        <form action="{{ route('job-posts.candidates.invite', [$post->id, $app->id]) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            <button class="btn-action btn-invite"><i class="fa fa-envelope"></i> Davet</button>
                                        </form>
                                        <form action="{{ route('job-posts.candidates.accept', [$post->id, $app->id]) }}" method="POST"
                                            style="display:inline;"
                                            onsubmit="return confirm('Bu adayı kabul etmek istiyor musunuz? Diğer başvurular otomatik reddedilecek.')">
                                            @csrf
                                            <button class="btn-action btn-accept"><i class="fa fa-check"></i> Kabul Et</button>
                                        </form>
                                        <form action="{{ route('job-posts.candidates.reject', [$post->id, $app->id]) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            <button class="btn-action btn-reject"><i class="fa fa-times"></i> Reddet</button>
                                        </form>
                                    @endif

                                    @if($app->status === 'invited')
                                        <form action="{{ route('job-posts.candidates.accept', [$post->id, $app->id]) }}" method="POST"
                                            style="display:inline;" onsubmit="return confirm('Bu adayı kabul ediyorsunuz. Devam?')">
                                            @csrf
                                            <button class="btn-action btn-accept"><i class="fa fa-check"></i> Kabul Et</button>
                                        </form>
                                        <form action="{{ route('job-posts.candidates.reject', [$post->id, $app->id]) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            <button class="btn-action btn-reject"><i class="fa fa-times"></i> Reddet</button>
                                        </form>
                                    @endif

                                    @if($app->status === 'accepted')
                                        <span class="accepted-badge"><i class="fa fa-check-circle"></i> Kabul Edildi</span>
                                    @endif
                                    @if($app->status === 'rejected')
                                        <span class="rejected-badge"><i class="fa fa-times-circle"></i> Reddedildi</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="pagination-wrapper">{{ $candidates->appends(request()->query())->links() }}</div>
                @endif
            </div>

            <style>
                .candidates-page {
                    padding: 20px;
                }

                .page-header-bar {
                    display: flex;
                    justify-content: space-between;
                    align-items: flex-start;
                    margin-bottom: 25px;
                    flex-wrap: wrap;
                    gap: 15px;
                }

                .back-link {
                    color: #667eea;
                    text-decoration: none;
                    font-size: 13px;
                }

                .page-header-bar h1 {
                    margin: 5px 0 0;
                    font-size: 20px;
                    font-weight: 700;
                }

                .stat-chip {
                    background: #f3f4f6;
                    padding: 6px 14px;
                    border-radius: 20px;
                    font-size: 13px;
                    font-weight: 600;
                    color: #374151;
                }

                .candidates-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
                    gap: 20px;
                }

                .candidate-card {
                    background: #fff;
                    border-radius: 14px;
                    box-shadow: 0 2px 14px rgba(0, 0, 0, .08);
                    padding: 20px;
                    display: flex;
                    flex-direction: column;
                    gap: 12px;
                }

                .candidate-header {
                    display: flex;
                    align-items: flex-start;
                    gap: 14px;
                }

                .cand-avatar {
                    width: 60px;
                    height: 60px;
                    border-radius: 50%;
                    object-fit: cover;
                    flex-shrink: 0;
                }

                .cand-header-info {
                    flex: 1;
                }

                .cand-header-info h3 {
                    margin: 0 0 3px;
                    font-size: 16px;
                    font-weight: 700;
                }

                .cand-header-info small {
                    color: #888;
                    font-size: 12px;
                }

                .cand-location {
                    font-size: 12px;
                    color: #666;
                    margin-top: 4px;
                }

                .score-badge {
                    text-align: center;
                    padding: 8px 14px;
                    border-radius: 12px;
                    flex-shrink: 0;
                }

                .badge-success {
                    background: #d1fae5;
                    color: #065f46;
                }

                .badge-warning {
                    background: #fef3c7;
                    color: #92400e;
                }

                .badge-danger {
                    background: #fee2e2;
                    color: #991b1b;
                }

                .score-pct {
                    display: block;
                    font-size: 22px;
                    font-weight: 800;
                    line-height: 1;
                }

                .score-label {
                    font-size: 10px;
                    font-weight: 600;
                    text-transform: uppercase;
                }

                .score-explanation {
                    background: #f0f4ff;
                    border-left: 3px solid #667eea;
                    padding: 10px 14px;
                    border-radius: 6px;
                    font-size: 12px;
                    color: #374151;
                }

                .criteria-bars {
                    display: flex;
                    flex-direction: column;
                    gap: 5px;
                }

                .crit-row {
                    display: flex;
                    align-items: center;
                    gap: 8px;
                    font-size: 11px;
                }

                .crit-label {
                    width: 120px;
                    color: #555;
                    flex-shrink: 0;
                }

                .crit-bar-wrap {
                    flex: 1;
                    background: #f3f4f6;
                    border-radius: 4px;
                    height: 6px;
                    overflow: hidden;
                }

                .crit-bar {
                    height: 100%;
                    border-radius: 4px;
                    transition: width .3s;
                }

                .crit-val {
                    width: 30px;
                    text-align: right;
                    font-weight: 600;
                    color: #374151;
                }

                .cand-meta {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    font-size: 12px;
                    color: #666;
                    flex-wrap: wrap;
                    gap: 6px;
                }

                .status-badge-sm {
                    padding: 3px 10px;
                    border-radius: 10px;
                    font-size: 11px;
                    font-weight: 700;
                }

                .cover-note {
                    background: #fafafa;
                    border-radius: 8px;
                    padding: 10px;
                    font-size: 13px;
                    color: #555;
                    font-style: italic;
                }

                .cand-actions {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 6px;
                }

                .btn-action {
                    padding: 7px 14px;
                    border-radius: 8px;
                    border: none;
                    cursor: pointer;
                    font-size: 12px;
                    font-weight: 600;
                    text-decoration: none;
                    display: inline-flex;
                    align-items: center;
                    gap: 5px;
                }

                .btn-view {
                    background: #f3f4f6;
                    color: #374151;
                }

                .btn-shortlist {
                    background: #fef3c7;
                    color: #92400e;
                }

                .btn-invite {
                    background: #dbeafe;
                    color: #1e40af;
                }

                .btn-accept {
                    background: #d1fae5;
                    color: #065f46;
                }

                .btn-reject {
                    background: #fee2e2;
                    color: #991b1b;
                }

                .accepted-badge {
                    color: #065f46;
                    font-weight: 700;
                    font-size: 13px;
                    display: flex;
                    align-items: center;
                    gap: 5px;
                }

                .rejected-badge {
                    color: #991b1b;
                    font-weight: 700;
                    font-size: 13px;
                    display: flex;
                    align-items: center;
                    gap: 5px;
                }

                .pagination-wrapper {
                    margin-top: 25px;
                    text-align: center;
                }

                .empty-state {
                    text-align: center;
                    padding: 60px 20px;
                }
            </style>
        </div>
    </div>
    </div>
    @include('includes.footer')
@endsection