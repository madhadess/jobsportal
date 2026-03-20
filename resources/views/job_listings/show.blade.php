@extends('layouts.app')

@section('content')
    @include('includes.header')
    @include('includes.inner_page_title', ['page_title' => 'İlan Detayı'])
    <div class="listpgWraper">
        <div class="container">
            <div class="post-detail-page">
                {{-- Header --}}
                <div class="post-detail-header">
                    <a href="{{ route('job-posts.index') }}" class="back-link"><i class="fa fa-arrow-left"></i>
                        İlanlarım</a>
                    <div class="post-title-row">
                        <div>
                            <h1>{{ $post->title }}</h1>
                            <div class="post-badges">
                                <span class="status-badge badge-{{ $post->status }}">{{ $post->getStatusLabel() }}</span>
                                <span
                                    class="type-badge">{{ $post->category_type === 'caregiver' ? '🧑‍⚕️ Bakıcı' : '🔧 Hizmet' }}</span>
                                @if($post->category)
                                    <span class="category-badge"><i class="fa fa-tag"></i>
                                        {{ $post->category->category_name }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="post-header-actions">
                            @if($post->status === 'draft')
                                <a href="{{ route('job-posts.edit', $post->id) }}" class="btn btn-warning btn-sm"><i
                                        class="fa fa-pencil"></i> Düzenle</a>
                                <form action="{{ route('job-posts.publish', $post->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf <button class="btn btn-success btn-sm"><i class="fa fa-globe"></i> Yayınla</button>
                                </form>
                            @elseif($post->status === 'published')
                                <a href="{{ route('job-posts.edit', $post->id) }}" class="btn btn-warning btn-sm"><i
                                        class="fa fa-pencil"></i> Düzenle</a>
                                <form action="{{ route('job-posts.close', $post->id) }}" method="POST" style="display:inline;"
                                    onsubmit="return confirm('İlan kapatılacak. Devam?')">
                                    @csrf <button class="btn btn-danger btn-sm"><i class="fa fa-times"></i> Kapat</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Tab Nav --}}
                <div class="detail-tabs">
                    <button class="tab-btn active" onclick="showTab('info')"><i class="fa fa-info-circle"></i> İlan
                        Detayı</button>
                    <button class="tab-btn" onclick="showTab('candidates')">
                        <i class="fa fa-users"></i> Adaylar
                        <span class="tab-count">{{ $post->applications_count }}</span>
                    </button>
                </div>

                {{-- TAB: İlan Detayı --}}
                <div id="tab-info" class="tab-content active">
                    <div class="info-grid">
                        <div class="info-card">
                            <h4><i class="fa fa-map-marker"></i> Lokasyon</h4>
                            <p>{{ $post->state->state ?? '—' }} {{ $post->city ? '/ ' . $post->city->city : '' }}</p>
                        </div>
                        <div class="info-card">
                            <h4><i class="fa fa-clock-o"></i> Çalışma Tipi</h4>
                            <p>{{ $post->getWorkTypeLabel() }}</p>
                            @if($post->work_hours_start && $post->work_hours_end)
                                <small>{{ $post->work_hours_start }} – {{ $post->work_hours_end }}</small>
                            @endif
                        </div>
                        <div class="info-card">
                            <h4><i class="fa fa-briefcase"></i> Deneyim</h4>
                            <p>Min. {{ $post->min_experience_years }} yıl</p>
                        </div>
                        <div class="info-card">
                            <h4><i class="fa fa-money"></i> Ücret Aralığı</h4>
                            <p>{{ $post->getSalaryRange() }}</p>
                        </div>
                        @if($post->requires_certificate)
                            <div class="info-card">
                                <h4><i class="fa fa-certificate"></i> Sertifika</h4>
                                <p>Gerekiyor</p>
                            </div>
                        @endif
                        @if($post->requires_reference)
                            <div class="info-card">
                                <h4><i class="fa fa-user-o"></i> Referans</h4>
                                <p>Zorunlu</p>
                            </div>
                        @endif
                    </div>

                    @if($post->requirements->isNotEmpty())
                        <div class="requirements-section">
                            <h4>Gereksinimler</h4>
                            <ul>
                                @foreach($post->requirements as $req)
                                    <li>
                                        <span class="req-type req-{{ $req->requirement_type }}">{{ $req->requirement_type }}</span>
                                        {{ $req->requirement_value }}
                                        @if($req->is_mandatory) <span class="req-mandatory">Zorunlu</span> @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if($post->description)
                        <div class="description-section">
                            <h4>Açıklama</h4>
                            <div class="desc-text">{{ $post->description }}</div>
                        </div>
                    @endif

                    @if($post->matched_user_id && $post->matchedUser)
                        <div class="matched-winner">
                            <i class="fa fa-handshake-o"></i>
                            <strong>Eşleşen Personel:</strong> {{ $post->matchedUser->getName() }}
                            @if($post->matched_at) — {{ $post->matched_at->format('d.m.Y') }} @endif
                        </div>
                    @endif
                </div>

                {{-- TAB: Adaylar --}}
                <div id="tab-candidates" class="tab-content" style="display:none;">
                    @if($post->applications->isEmpty())
                        <div class="empty-state">
                            <i class="fa fa-users fa-2x" style="color:#ccc;"></i>
                            <p style="color:#888; margin-top:10px;">Henüz başvuran yok.</p>
                            @if($post->status === 'draft')
                                <p><a href="{{ route('job-posts.publish', $post->id) }}"
                                        onclick="this.closest('form')?.submit(); return false;">İlanı yayınlayarak başvuru
                                        alabilirsiniz.</a></p>
                            @endif
                        </div>
                    @else
                        <div style="margin-bottom:12px; display:flex; justify-content:flex-end;">
                            <a href="{{ route('job-posts.candidates', $post->id) }}" class="btn btn-sm btn-primary">
                                <i class="fa fa-expand"></i> Tam Ekran Aday Yönetimi
                            </a>
                        </div>
                        <div class="mini-candidates-list">
                            @foreach($post->applications->take(5) as $app)
                                <div class="mini-cand-row">
                                    <img src="{{ $app->applicant->image ? asset('uploads/user_images/' . $app->applicant->image) : asset('admin_assets/no-image.png') }}"
                                        class="mini-avatar" alt="">
                                    <div class="mini-cand-info">
                                        <strong>{{ $app->applicant->getName() }}</strong>
                                        <small>{{ $app->applicant->email }}</small>
                                    </div>
                                    <div class="mini-score {{ $app->getMatchScoreBadgeColor() }}">
                                        %{{ number_format($app->match_score, 0) }}
                                    </div>
                                    <div class="mini-status badge-{{ $applicationLabels[$app->status] ?? '' }}">
                                        <span class="badge badge-{{ $app->getStatusColor() }}">{{ $app->getStatusLabel() }}</span>
                                    </div>
                                </div>
                            @endforeach
                            @if($post->applications->count() > 5)
                                <div style="text-align:center; margin-top:12px;">
                                    <a href="{{ route('job-posts.candidates', $post->id) }}" class="btn btn-sm btn-default">
                                        Tüm {{ $post->applications->count() }} adayı gör
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            <style>
                .post-detail-page {
                    max-width: 860px;
                    margin: 0 auto;
                    padding: 20px;
                }

                .back-link {
                    color: #667eea;
                    text-decoration: none;
                    font-size: 13px;
                }

                .post-detail-header {
                    margin-bottom: 20px;
                }

                .post-title-row {
                    display: flex;
                    justify-content: space-between;
                    align-items: flex-start;
                    flex-wrap: wrap;
                    gap: 15px;
                    margin-top: 8px;
                }

                .post-title-row h1 {
                    margin: 0 0 8px;
                    font-size: 22px;
                    font-weight: 700;
                }

                .post-badges {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 8px;
                    align-items: center;
                }

                .status-badge {
                    padding: 4px 12px;
                    border-radius: 12px;
                    font-size: 12px;
                    font-weight: 700;
                }

                .badge-draft {
                    background: #f3f4f6;
                    color: #374151;
                }

                .badge-published {
                    background: #d1fae5;
                    color: #065f46;
                }

                .badge-matched {
                    background: #dbeafe;
                    color: #1e40af;
                }

                .badge-closed,
                .badge-cancelled {
                    background: #fee2e2;
                    color: #991b1b;
                }

                .type-badge,
                .category-badge {
                    background: #f3f4f6;
                    padding: 4px 12px;
                    border-radius: 12px;
                    font-size: 12px;
                    color: #555;
                }

                .post-header-actions {
                    display: flex;
                    gap: 8px;
                    flex-wrap: wrap;
                }

                .detail-tabs {
                    display: flex;
                    gap: 0;
                    border-bottom: 2px solid #e5e7eb;
                    margin-bottom: 20px;
                }

                .tab-btn {
                    padding: 10px 20px;
                    border: none;
                    background: none;
                    cursor: pointer;
                    font-weight: 600;
                    font-size: 14px;
                    color: #888;
                    border-bottom: 3px solid transparent;
                    margin-bottom: -2px;
                    display: flex;
                    align-items: center;
                    gap: 6px;
                }

                .tab-btn.active {
                    color: #667eea;
                    border-bottom-color: #667eea;
                }

                .tab-count {
                    background: #667eea;
                    color: #fff;
                    border-radius: 10px;
                    padding: 2px 7px;
                    font-size: 11px;
                }

                .info-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));
                    gap: 12px;
                    margin-bottom: 20px;
                }

                .info-card {
                    background: #f8f9fa;
                    border-radius: 10px;
                    padding: 14px 16px;
                }

                .info-card h4 {
                    margin: 0 0 6px;
                    font-size: 12px;
                    color: #888;
                    font-weight: 600;
                }

                .info-card p {
                    margin: 0;
                    font-size: 15px;
                    font-weight: 700;
                    color: #111;
                }

                .info-card small {
                    color: #888;
                    font-size: 12px;
                }

                .requirements-section,
                .description-section {
                    background: #fff;
                    border-radius: 10px;
                    padding: 18px;
                    box-shadow: 0 1px 6px rgba(0, 0, 0, .06);
                    margin-bottom: 15px;
                }

                .requirements-section h4,
                .description-section h4 {
                    margin: 0 0 12px;
                    font-size: 15px;
                    font-weight: 700;
                }

                .requirements-section ul {
                    list-style: none;
                    padding: 0;
                    margin: 0;
                }

                .requirements-section li {
                    padding: 6px 0;
                    border-bottom: 1px solid #f0f0f0;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                }

                .req-type {
                    background: #e5e7eb;
                    padding: 2px 8px;
                    border-radius: 8px;
                    font-size: 11px;
                    font-weight: 600;
                    text-transform: capitalize;
                }

                .req-mandatory {
                    background: #fee2e2;
                    color: #991b1b;
                    padding: 2px 8px;
                    border-radius: 8px;
                    font-size: 10px;
                    font-weight: 700;
                    margin-left: auto;
                }

                .desc-text {
                    line-height: 1.7;
                    color: #374151;
                    white-space: pre-line;
                }

                .matched-winner {
                    background: #d1fae5;
                    border: 1px solid #a7f3d0;
                    border-radius: 10px;
                    padding: 14px 18px;
                    color: #065f46;
                    font-size: 14px;
                    display: flex;
                    align-items: center;
                    gap: 10px;
                }

                .mini-candidates-list {
                    display: flex;
                    flex-direction: column;
                    gap: 10px;
                }

                .mini-cand-row {
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    background: #f8f9fa;
                    border-radius: 10px;
                    padding: 12px 16px;
                }

                .mini-avatar {
                    width: 40px;
                    height: 40px;
                    border-radius: 50%;
                    object-fit: cover;
                }

                .mini-cand-info {
                    flex: 1;
                }

                .mini-cand-info strong {
                    display: block;
                    font-size: 14px;
                }

                .mini-cand-info small {
                    color: #888;
                    font-size: 12px;
                }

                .mini-score {
                    width: 46px;
                    height: 46px;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 13px;
                    font-weight: 800;
                    flex-shrink: 0;
                }

                .mini-score.success {
                    background: #d1fae5;
                    color: #065f46;
                }

                .mini-score.warning {
                    background: #fef3c7;
                    color: #92400e;
                }

                .mini-score.danger {
                    background: #fee2e2;
                    color: #991b1b;
                }

                .empty-state {
                    text-align: center;
                    padding: 40px;
                }
            </style>

            <script>
                function showTab(name) {
                    document.querySelectorAll('.tab-content').forEach(el => el.style.display = 'none');
                    document.querySelectorAll('.tab-btn').forEach(el => el.classList.remove('active'));
                    document.getElementById('tab-' + name).style.display = 'block';
                    event.target.closest('.tab-btn').classList.add('active');
                }
            </script>
        </div>
    </div>
    @include('includes.footer')
@endsection