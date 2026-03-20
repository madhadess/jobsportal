@extends('layouts.app')

@section('content')
    @include('includes.header')
    @include('includes.inner_page_title', ['page_title' => 'İlanlarım'])
    <div class="listpgWraper">
        <div class="container">
            <div class="jobpost-page">
                <div class="page-header-bar">
                    <div class="page-header-left">
                        <h1><i class="fa fa-list-alt"></i> İlanlarım</h1>
                        <p class="subtitle">Hizmet ilanlarınızı oluşturun ve yönetin</p>
                    </div>
                    <a href="{{ route('job-posts.create') }}" class="btn-new-post">
                        <i class="fa fa-plus"></i> Yeni İlan Oluştur
                    </a>
                </div>

                {{-- Stats --}}
                <div class="post-stats-row">
                    <div class="stat-pill blue">
                        <i class="fa fa-globe"></i>
                        <span>{{ $jobPosts->where('status', 'published')->count() }}</span> Yayında
                    </div>
                    <div class="stat-pill green">
                        <i class="fa fa-handshake-o"></i>
                        <span>{{ $jobPosts->where('status', 'matched')->count() }}</span> Eşleşti
                    </div>
                    <div class="stat-pill gray">
                        <i class="fa fa-pencil"></i>
                        <span>{{ $jobPosts->where('status', 'draft')->count() }}</span> Taslak
                    </div>
                </div>

                {{-- Filter Bar --}}
                <form method="GET" class="filter-bar"
                    style="margin-bottom: 20px; display:flex; gap:10px; flex-wrap:wrap; align-items:center;">
                    <select name="status" class="form-control" style="max-width:180px;" onchange="this.form.submit()">
                        <option value="">Tüm Durumlar</option>
                        @foreach($statusLabels as $key => $label)
                            <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    <a href="{{ route('job-posts.index') }}" class="btn btn-sm btn-default">Temizle</a>
                </form>

                @if($jobPosts->isEmpty())
                    <div class="empty-state">
                        <i class="fa fa-inbox fa-3x" style="color:#ccc;"></i>
                        <p style="margin-top:15px; color:#888;">Henüz bir ilanınız yok.</p>
                        <a href="{{ route('job-posts.create') }}" class="btn btn-primary">İlk İlanı Oluştur</a>
                    </div>
                @else
                    <div class="posts-grid">
                        @foreach($jobPosts as $post)
                            <div class="post-card status-{{ $post->status }}">
                                <div class="post-card-header">
                                    <span class="status-badge badge-{{ $post->status }}">{{ $post->getStatusLabel() }}</span>
                                    <span
                                        class="post-type-badge">{{ $post->category_type === 'caregiver' ? '🧑‍⚕️ Bakıcı' : '🔧 Hizmet' }}</span>
                                </div>
                                <div class="post-card-body">
                                    <h3 class="post-title">
                                        <a href="{{ route('job-posts.show', $post->id) }}">{{ $post->title }}</a>
                                    </h3>
                                    <div class="post-meta">
                                        @if($post->category)
                                            <span><i class="fa fa-tag"></i> {{ $post->category->category_name }}</span>
                                        @endif
                                        @if($post->state)
                                            <span><i class="fa fa-map-marker"></i> {{ $post->state->state }}</span>
                                        @endif
                                        <span><i class="fa fa-clock-o"></i> {{ $post->getWorkTypeLabel() }}</span>
                                        <span><i class="fa fa-money"></i> {{ $post->getSalaryRange() }}</span>
                                    </div>
                                </div>
                                <div class="post-card-footer">
                                    <div class="applicant-count">
                                        <i class="fa fa-users"></i>
                                        <strong>{{ $post->applications_count }}</strong> başvuru
                                    </div>
                                    <div class="post-actions">
                                        <a href="{{ route('job-posts.candidates', $post->id) }}" class="btn btn-xs btn-info">
                                            <i class="fa fa-users"></i> Adaylar
                                        </a>
                                        @if($post->status === 'draft')
                                            <form action="{{ route('job-posts.publish', $post->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-xs btn-success">
                                                    <i class="fa fa-globe"></i> Yayınla
                                                </button>
                                            </form>
                                        @endif
                                        @if($post->status === 'published')
                                            <a href="{{ route('job-posts.edit', $post->id) }}" class="btn btn-xs btn-warning">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <form action="{{ route('job-posts.close', $post->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-xs btn-danger">
                                                    <i class="fa fa-times"></i> Kapat
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                                @if($post->published_at)
                                    <div class="post-date">
                                        <small><i class="fa fa-calendar"></i> {{ $post->published_at->format('d.m.Y') }}</small>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                    <div class="pagination-wrapper">{{ $jobPosts->links() }}</div>
                @endif
            </div>

            <style>
                .jobpost-page {
                    padding: 20px;
                }

                .page-header-bar {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 25px;
                    flex-wrap: wrap;
                    gap: 15px;
                }

                .page-header-bar h1 {
                    margin: 0;
                    font-size: 22px;
                    font-weight: 700;
                }

                .subtitle {
                    margin: 5px 0 0;
                    color: #888;
                    font-size: 14px;
                }

                .btn-new-post {
                    background: linear-gradient(135deg, #667eea, #764ba2);
                    color: white;
                    padding: 12px 22px;
                    border-radius: 10px;
                    text-decoration: none;
                    font-weight: 600;
                }

                .btn-new-post:hover {
                    opacity: .9;
                    color: white;
                    text-decoration: none;
                }

                .post-stats-row {
                    display: flex;
                    gap: 10px;
                    margin-bottom: 20px;
                    flex-wrap: wrap;
                }

                .stat-pill {
                    display: inline-flex;
                    align-items: center;
                    gap: 6px;
                    padding: 8px 16px;
                    border-radius: 20px;
                    font-weight: 600;
                    font-size: 13px;
                }

                .stat-pill.blue {
                    background: #e8f0fe;
                    color: #1a56db;
                }

                .stat-pill.green {
                    background: #d1fae5;
                    color: #065f46;
                }

                .stat-pill.gray {
                    background: #f3f4f6;
                    color: #374151;
                }

                .posts-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
                    gap: 20px;
                }

                .post-card {
                    background: #fff;
                    border-radius: 12px;
                    box-shadow: 0 2px 12px rgba(0, 0, 0, .08);
                    overflow: hidden;
                    display: flex;
                    flex-direction: column;
                }

                .post-card-header {
                    display: flex;
                    justify-content: space-between;
                    padding: 12px 15px;
                    background: #f8f9fa;
                }

                .status-badge {
                    padding: 4px 12px;
                    border-radius: 12px;
                    font-size: 11px;
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

                .badge-closed {
                    background: #fee2e2;
                    color: #991b1b;
                }

                .badge-cancelled {
                    background: #fef3c7;
                    color: #92400e;
                }

                .post-type-badge {
                    font-size: 12px;
                    color: #666;
                }

                .post-card-body {
                    padding: 15px;
                    flex: 1;
                }

                .post-title {
                    margin: 0 0 10px;
                    font-size: 16px;
                }

                .post-title a {
                    color: #333;
                    text-decoration: none;
                    font-weight: 600;
                }

                .post-title a:hover {
                    color: #667eea;
                }

                .post-meta {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 8px;
                    font-size: 12px;
                    color: #666;
                }

                .post-meta span {
                    display: flex;
                    align-items: center;
                    gap: 4px;
                }

                .post-card-footer {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 12px 15px;
                    border-top: 1px solid #f0f0f0;
                }

                .applicant-count {
                    font-size: 13px;
                    color: #555;
                }

                .post-actions {
                    display: flex;
                    gap: 5px;
                }

                .post-date {
                    text-align: right;
                    padding: 6px 15px 10px;
                    font-size: 11px;
                    color: #aaa;
                }

                .empty-state {
                    text-align: center;
                    padding: 60px 20px;
                }

                .pagination-wrapper {
                    margin-top: 25px;
                    text-align: center;
                }
            </style>
        </div>
    </div>
    @include('includes.footer')
@endsection