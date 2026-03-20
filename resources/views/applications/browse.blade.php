@extends('layouts.app')

@section('content')
    @include('includes.header')
    @include('includes.inner_page_title', ['page_title' => 'İlanları Keşfet'])
    <div class="listpgWraper">
        <div class="container">
            <div class="browse-page">
                <div class="browse-header">
                    <h1><i class="fa fa-search"></i> İlanlar</h1>
                    <p>Size uygun hizmet ilanlarını keşfedin</p>
                </div>

                {{-- Filter Panel --}}
                <form method="GET" class="filter-panel">
                    <div class="filter-grid">
                        <div class="filter-item">
                            <label>İl</label>
                            <select name="state_id" class="filter-ctrl">
                                <option value="">Tüm İller</option>
                                @foreach($states as $s)
                                    <option value="{{ $s->state_id }}" {{ request('state_id') == $s->state_id ? 'selected' : '' }}>
                                        {{ $s->state }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="filter-item">
                            <label>Kategori</label>
                            <select name="category_id" class="filter-ctrl">
                                <option value="">Tüm Kategoriler</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="filter-item">
                            <label>Tür</label>
                            <select name="category_type" class="filter-ctrl">
                                <option value="">Tümü</option>
                                <option value="service" {{ request('category_type') == 'service' ? 'selected' : '' }}>Hizmet
                                    Personeli
                                </option>
                                <option value="caregiver" {{ request('category_type') == 'caregiver' ? 'selected' : '' }}>
                                    Bakıcı
                                </option>
                            </select>
                        </div>
                        <div class="filter-item">
                            <label>Çalışma Tipi</label>
                            <select name="work_type" class="filter-ctrl">
                                <option value="">Tümü</option>
                                @foreach($workTypes as $key => $label)
                                    <option value="{{ $key }}" {{ request('work_type') == $key ? 'selected' : '' }}>{{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="filter-item">
                            <label>Min. Uygunluk (%)</label>
                            <input type="number" name="min_score" class="filter-ctrl" min="0" max="100"
                                value="{{ request('min_score') }}" placeholder="0">
                        </div>
                        <div class="filter-item filter-actions">
                            <button type="submit" class="btn-filter">
                                <i class="fa fa-search"></i> Filtrele
                            </button>
                            <a href="{{ route('listings.browse') }}" class="btn-clear">Temizle</a>
                        </div>
                    </div>
                </form>

                @if($jobPosts->isEmpty())
                    <div class="no-results">
                        <i class="fa fa-search fa-3x" style="color:#ccc;"></i>
                        <p>Filtrelerinize uygun ilan bulunamadı.</p>
                    </div>
                @else
                    <div class="listings-grid">
                        @foreach($jobPosts as $post)
                            @php
                                $scoreData = $scores[$post->id] ?? ['total_score' => 0, 'explanation' => ''];
                                $score = (float) $scoreData['total_score'];
                                $alreadyApplied = isset($userApplications[$post->id]);
                                $scoreColor = $score >= 70 ? '#10b981' : ($score >= 40 ? '#f59e0b' : '#ef4444');
                            @endphp
                            <div class="listing-card">
                                <div class="listing-card-top">
                                    <div class="listing-type-badge {{ $post->category_type }}">
                                        {{ $post->category_type === 'caregiver' ? '🧑‍⚕️ Bakıcı' : '🔧 Hizmet' }}
                                    </div>
                                    <div class="score-ring" style="--score-color: {{ $scoreColor }};">
                                        <div class="score-ring-inner">
                                            <span class="score-num">%{{ round($score) }}</span>
                                            <span class="score-tag">Uygun</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="listing-card-body">
                                    <h3>
                                        <a href="{{ route('listings.show', $post->id) }}">{{ $post->title }}</a>
                                    </h3>
                                    <div class="listing-meta">
                                        @if($post->category)
                                            <span class="meta-chip"><i class="fa fa-tag"></i>
                                                {{ $post->category->category_name }}</span>
                                        @endif
                                        @if($post->state)
                                            <span class="meta-chip"><i class="fa fa-map-marker"></i> {{ $post->state->state }}</span>
                                        @endif
                                        <span class="meta-chip"><i class="fa fa-clock-o"></i> {{ $post->getWorkTypeLabel() }}</span>
                                        <span class="meta-chip"><i class="fa fa-money"></i> {{ $post->getSalaryRange() }}</span>
                                        @if($post->min_experience_years > 0)
                                            <span class="meta-chip"><i class="fa fa-briefcase"></i> Min.
                                                {{ $post->min_experience_years }}
                                                yıl</span>
                                        @endif
                                    </div>

                                    @if(!empty($scoreData['explanation']))
                                        <div class="score-tip">
                                            <i class="fa fa-lightbulb-o"></i>
                                            {{ \Illuminate\Support\Str::limit($scoreData['explanation'], 100) }}
                                        </div>
                                    @endif
                                </div>

                                <div class="listing-card-footer">
                                    <span class="app-count">
                                        <i class="fa fa-users"></i> {{ $post->applications_count }} başvuru
                                    </span>
                                    <div class="listing-actions">
                                        <a href="{{ route('listings.show', $post->id) }}" class="btn-detail">
                                            <i class="fa fa-eye"></i> İncele
                                        </a>
                                        @if($alreadyApplied)
                                            <span class="applied-badge">
                                                <i class="fa fa-check-circle"></i>
                                                {{ \App\ListingApplication::getStatusLabels()[$userApplications[$post->id]] ?? 'Başvuruldu' }}
                                            </span>
                                        @else
                                            <a href="{{ route('listings.show', $post->id) }}" class="btn-apply-now">
                                                <i class="fa fa-paper-plane"></i> Başvur
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="pagination-wrapper">{{ $jobPosts->appends(request()->query())->links() }}</div>
                @endif
            </div>

            <style>
                .browse-page {
                    padding: 20px;
                }

                .browse-header {
                    margin-bottom: 25px;
                }

                .browse-header h1 {
                    font-size: 22px;
                    font-weight: 700;
                    margin: 0 0 5px;
                }

                .browse-header p {
                    color: #888;
                    margin: 0;
                    font-size: 14px;
                }

                .filter-panel {
                    background: #fff;
                    border-radius: 12px;
                    padding: 20px;
                    box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
                    margin-bottom: 25px;
                }

                .filter-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
                    gap: 12px;
                    align-items: end;
                }

                .filter-item label {
                    display: block;
                    font-size: 12px;
                    font-weight: 600;
                    color: #374151;
                    margin-bottom: 5px;
                }

                .filter-ctrl {
                    width: 100%;
                    padding: 9px 12px;
                    border: 1px solid #e5e7eb;
                    border-radius: 8px;
                    font-size: 13px;
                }

                .filter-actions {
                    display: flex;
                    gap: 8px;
                    align-items: center;
                }

                .btn-filter {
                    background: linear-gradient(135deg, #667eea, #764ba2);
                    color: #fff;
                    border: none;
                    padding: 10px 20px;
                    border-radius: 8px;
                    font-weight: 600;
                    cursor: pointer;
                }

                .btn-clear {
                    color: #6b7280;
                    text-decoration: none;
                    font-size: 13px;
                    font-weight: 500;
                }

                .listings-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
                    gap: 20px;
                }

                .listing-card {
                    background: #fff;
                    border-radius: 14px;
                    box-shadow: 0 2px 14px rgba(0, 0, 0, .07);
                    overflow: hidden;
                    display: flex;
                    flex-direction: column;
                }

                .listing-card-top {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 12px 16px;
                    background: linear-gradient(135deg, #f8f9fa, #fff);
                    border-bottom: 1px solid #f0f0f0;
                }

                .listing-type-badge {
                    font-size: 12px;
                    font-weight: 600;
                }

                .score-ring {
                    width: 60px;
                    height: 60px;
                    border-radius: 50%;
                    background: conic-gradient(var(--score-color) 0%, #e5e7eb 0%);
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }

                .score-ring-inner {
                    width: 48px;
                    height: 48px;
                    border-radius: 50%;
                    background: #fff;
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    justify-content: center;
                }

                .score-num {
                    font-size: 14px;
                    font-weight: 800;
                    color: #111;
                    line-height: 1;
                }

                .score-tag {
                    font-size: 8px;
                    color: #888;
                    font-weight: 600;
                }

                .listing-card-body {
                    padding: 15px 16px;
                    flex: 1;
                }

                .listing-card-body h3 {
                    margin: 0 0 10px;
                    font-size: 15px;
                }

                .listing-card-body h3 a {
                    color: #111;
                    text-decoration: none;
                    font-weight: 700;
                }

                .listing-card-body h3 a:hover {
                    color: #667eea;
                }

                .listing-meta {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 6px;
                    margin-bottom: 10px;
                }

                .meta-chip {
                    background: #f3f4f6;
                    padding: 4px 10px;
                    border-radius: 12px;
                    font-size: 11px;
                    color: #555;
                    display: flex;
                    align-items: center;
                    gap: 4px;
                }

                .score-tip {
                    background: #f0f4ff;
                    border-left: 3px solid #667eea;
                    padding: 8px 12px;
                    border-radius: 6px;
                    font-size: 12px;
                    color: #374151;
                }

                .listing-card-footer {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 12px 16px;
                    border-top: 1px solid #f0f0f0;
                }

                .app-count {
                    font-size: 12px;
                    color: #888;
                }

                .listing-actions {
                    display: flex;
                    gap: 8px;
                    align-items: center;
                }

                .btn-detail {
                    background: #f3f4f6;
                    color: #374151;
                    padding: 7px 14px;
                    border-radius: 8px;
                    text-decoration: none;
                    font-size: 12px;
                    font-weight: 600;
                }

                .btn-apply-now {
                    background: linear-gradient(135deg, #667eea, #764ba2);
                    color: #fff;
                    padding: 7px 14px;
                    border-radius: 8px;
                    text-decoration: none;
                    font-size: 12px;
                    font-weight: 700;
                }

                .applied-badge {
                    background: #d1fae5;
                    color: #065f46;
                    padding: 5px 12px;
                    border-radius: 12px;
                    font-size: 11px;
                    font-weight: 700;
                    display: flex;
                    align-items: center;
                    gap: 5px;
                }

                .no-results {
                    text-align: center;
                    padding: 60px;
                    color: #aaa;
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