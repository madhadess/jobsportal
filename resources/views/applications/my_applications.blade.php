@extends('layouts.app')

@section('content')
    @include('includes.header')
    @include('includes.inner_page_title', ['page_title' => 'Başvurularım'])
    <div class="listpgWraper">
        <div class="container">
            <div class="my-apps-page">
                <div class="page-header-bar">
                    <h1><i class="fa fa-paper-plane"></i> Başvurularım</h1>
                    <a href="{{ route('listings.browse') }}" class="btn-browse">
                        <i class="fa fa-search"></i> İlanları Keşfet
                    </a>
                </div>

                @if($applications->isEmpty())
                    <div class="empty-state">
                        <i class="fa fa-paper-plane fa-3x" style="color:#ccc;"></i>
                        <p style="margin-top:15px; color:#888;">Henüz herhangi bir ilana başvurmadınız.</p>
                        <a href="{{ route('listings.browse') }}" class="btn btn-primary">İlanları Keşfet</a>
                    </div>
                @else
                    <div class="apps-list">
                        @foreach($applications as $app)
                            <div class="app-row status-{{ $app->status }}">
                                <div class="app-score-col">
                                    <div class="score-circle {{ $app->getMatchScoreBadgeColor() }}">
                                        %{{ number_format($app->match_score, 0) }}
                                    </div>
                                </div>
                                <div class="app-info-col">
                                    <h3>
                                        <a href="{{ route('listings.show', $app->job_post_id) }}">{{ $app->jobPost->title }}</a>
                                    </h3>
                                    <div class="app-meta">
                                        @if($app->jobPost->category)
                                            <span><i class="fa fa-tag"></i> {{ $app->jobPost->category->category_name }}</span>
                                        @endif
                                        @if($app->jobPost->state)
                                            <span><i class="fa fa-map-marker"></i> {{ $app->jobPost->state->state }}</span>
                                        @endif
                                        <span><i class="fa fa-calendar"></i> {{ $app->created_at->format('d.m.Y') }}</span>
                                    </div>
                                </div>
                                <div class="app-status-col">
                                    <span class="status-badge badge-{{ $statusColors[$app->status] ?? 'default' }}">
                                        {{ $statusLabels[$app->status] ?? $app->status }}
                                    </span>
                                </div>
                                <div class="app-actions-col">
                                    <a href="{{ route('my-applications.show', $app->id) }}" class="btn btn-xs btn-info">
                                        <i class="fa fa-eye"></i> Detay
                                    </a>
                                    @if(in_array($app->status, ['pending', 'shortlisted']))
                                        <form action="{{ route('listings.withdraw', $app->job_post_id) }}" method="POST"
                                            style="display:inline;"
                                            onsubmit="return confirm('Başvuruyu geri çekmek istediğinize emin misiniz?')">
                                            @csrf
                                            <button class="btn btn-xs btn-danger">
                                                <i class="fa fa-times"></i> Geri Çek
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="pagination-wrapper">{{ $applications->links() }}</div>
                @endif
            </div>

            <style>
                .my-apps-page {
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

                .btn-browse {
                    background: linear-gradient(135deg, #667eea, #764ba2);
                    color: #fff;
                    padding: 11px 20px;
                    border-radius: 10px;
                    text-decoration: none;
                    font-weight: 600;
                    font-size: 13px;
                }

                .btn-browse:hover {
                    opacity: .9;
                    color: #fff;
                    text-decoration: none;
                }

                .apps-list {
                    display: flex;
                    flex-direction: column;
                    gap: 12px;
                }

                .app-row {
                    display: flex;
                    align-items: center;
                    gap: 16px;
                    background: #fff;
                    border-radius: 12px;
                    padding: 16px 20px;
                    box-shadow: 0 2px 10px rgba(0, 0, 0, .06);
                    flex-wrap: wrap;
                }

                .app-score-col {
                    flex-shrink: 0;
                }

                .score-circle {
                    width: 55px;
                    height: 55px;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 14px;
                    font-weight: 800;
                }

                .score-circle.success {
                    background: #d1fae5;
                    color: #065f46;
                }

                .score-circle.warning {
                    background: #fef3c7;
                    color: #92400e;
                }

                .score-circle.danger {
                    background: #fee2e2;
                    color: #991b1b;
                }

                .app-info-col {
                    flex: 1;
                    min-width: 200px;
                }

                .app-info-col h3 {
                    margin: 0 0 6px;
                    font-size: 15px;
                    font-weight: 700;
                }

                .app-info-col h3 a {
                    color: #111;
                    text-decoration: none;
                }

                .app-info-col h3 a:hover {
                    color: #667eea;
                }

                .app-meta {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 10px;
                    font-size: 12px;
                    color: #888;
                }

                .app-status-col {
                    flex-shrink: 0;
                }

                .status-badge {
                    padding: 5px 14px;
                    border-radius: 12px;
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

                .badge-default {
                    background: #f3f4f6;
                    color: #374151;
                }

                .app-actions-col {
                    display: flex;
                    gap: 6px;
                    flex-shrink: 0;
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
    @include('includes.footer')
@endsection