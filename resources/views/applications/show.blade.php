@extends('layouts.app')

@section('content')
@include('includes.header')
@include('includes.inner_page_title', ['page_title' => 'İlan Detayı'])
<div class="listpgWraper">
    <div class="container">
    <div class="listing-detail-page">
        <a href="{{ route('listings.browse') }}" class="back-link"><i class="fa fa-arrow-left"></i> İlanlara Dön</a>

        <div class="listing-hero">
            <div class="listing-hero-left">
                <div class="listing-type-icon">{{ $post->category_type === 'caregiver' ? '🧑‍⚕️' : '🔧' }}</div>
                <div class="listing-hero-info">
                    <h1>{{ $post->title }}</h1>
                    <div class="listing-meta-chips">
                        @if($post->category)
                            <span class="chip chip-blue"><i class="fa fa-tag"></i> {{ $post->category->category_name }}</span>
                        @endif
                        @if($post->state)
                            <span class="chip"><i class="fa fa-map-marker"></i> {{ $post->state->state }}</span>
                        @endif
                        <span class="chip"><i class="fa fa-clock-o"></i> {{ $post->getWorkTypeLabel() }}</span>
                        <span class="chip"><i class="fa fa-money"></i> {{ $post->getSalaryRange() }}</span>
                        @if($post->min_experience_years > 0)
                            <span class="chip"><i class="fa fa-briefcase"></i> Min. {{ $post->min_experience_years }} yıl</span>
                        @endif
                        @if($post->requires_certificate)
                            <span class="chip chip-amber"><i class="fa fa-certificate"></i> Sertifika gerekli</span>
                        @endif
                        @if($post->requires_reference)
                            <span class="chip chip-amber"><i class="fa fa-user-o"></i> Referans zorunlu</span>
                        @endif
                    </div>
                    <div class="posted-by">
                        <i class="fa fa-calendar"></i>
                        Yayın tarihi: {{ $post->published_at ? $post->published_at->format('d.m.Y') : '—' }}
                        &nbsp;&bull;&nbsp;
                        <i class="fa fa-users"></i> {{ $post->applications_count }} başvuru
                    </div>
                </div>
            </div>

            {{-- Uygunluk Skoru Kartı --}}
            <div class="score-hero-card">
                <div
                    class="score-hero-circle score-{{ $scoreData['total_score'] >= 70 ? 'high' : ($scoreData['total_score'] >= 40 ? 'mid' : 'low') }}">
                    <span class="score-hero-num">%{{ round($scoreData['total_score']) }}</span>
                    <span class="score-hero-label">Uygunluk</span>
                </div>
                @if(!empty($scoreData['explanation']))
                    <p class="score-hero-exp">{{ $scoreData['explanation'] }}</p>
                @endif
            </div>
        </div>

        {{-- Score Criteria --}}
        @if(!empty($scoreData['breakdown']))
            <div class="criteria-panel">
                <h4><i class="fa fa-bar-chart"></i> Uygunluk Kriterleri</h4>
                <div class="criteria-grid">
                    @foreach($scoreData['breakdown'] as $key => $crit)
                        @php $raw = $crit['raw'] ?? 0;
                        $color = $raw >= 70 ? '#10b981' : ($raw >= 40 ? '#f59e0b' : '#ef4444'); @endphp
                        <div class="crit-item">
                            <div class="crit-header">
                                <span class="crit-name">{{ $crit['label'] ?? $key }}</span>
                                <span class="crit-pct" style="color:{{ $color }};">%{{ $raw }}</span>
                            </div>
                            <div class="crit-track">
                                <div class="crit-fill" style="width:{{ $raw }}%; background:{{ $color }};"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Requirements --}}
        @if($post->requirements->isNotEmpty())
            <div class="req-panel">
                <h4><i class="fa fa-list-ul"></i> Gereksinimler</h4>
                <div class="req-tags">
                    @foreach($post->requirements as $req)
                        <span class="req-tag {{ $req->is_mandatory ? 'req-mandatory' : 'req-optional' }}">
                            {{ $req->requirement_value }}
                            @if($req->is_mandatory) <small>*</small> @endif
                        </span>
                    @endforeach
                </div>
                <small class="req-note">* Zorunlu gereksinim</small>
            </div>
        @endif

        {{-- Description --}}
        @if($post->description)
            <div class="desc-panel">
                <h4><i class="fa fa-file-text-o"></i> İlan Açıklaması</h4>
                <div class="desc-text">{{ $post->description }}</div>
            </div>
        @endif

        {{-- Apply / Already Applied / Cannot Apply --}}
        <div class="apply-section">
            @if($hasApplied)
                <div class="applied-notice">
                    <i class="fa fa-check-circle"></i>
                    Bu ilana zaten başvurdunuz. <a href="{{ route('my-applications.index') }}">Başvurularımı Gör</a>
                </div>
            @elseif(!$post->isOpen())
                <div class="closed-notice">
                    <i class="fa fa-lock"></i> Bu ilan artık başvuruya kapalıdır.
                </div>
            @elseif(!$canApply)
                <div class="ineligible-notice">
                    <i class="fa fa-exclamation-triangle"></i>
                    Uygunluk skorunuz bu ilan için çok düşük (%{{ round($scoreData['total_score']) }}). Profilinizi
                    güncelleyerek skoru artırabilirsiniz.
                    <br><a href="{{ route('personnel.preferences') }}">Profilimi Güncelle</a>
                </div>
            @else
                <div class="apply-card">
                    <h3>Bu İlana Başvur</h3>
                    <p>Uygunluk skorunuz: <strong style="color:#667eea;">%{{ round($scoreData['total_score']) }}</strong></p>
                    <form action="{{ route('listings.apply', $post->id) }}" method="POST" id="applyForm">
                        @csrf
                        <div class="form-group">
                            <label>Kısa Not (opsiyonel)</label>
                            <textarea name="cover_note" rows="4" maxlength="1000"
                                placeholder="Kendinizi kısaca tanıtın, neden bu pozisyon için uygun olduğunuzu belirtin..."
                                class="apply-textarea"></textarea>
                            <small class="char-count">0 / 1000</small>
                        </div>
                        <button type="submit" class="btn-apply-submit"
                            onclick="return confirm('Bu ilana başvurmak istiyor musunuz?')">
                            <i class="fa fa-paper-plane"></i> Başvuruyu Gönder
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>

    <style>
        .listing-detail-page {
            max-width: 860px;
            margin: 0 auto;
            padding: 20px;
        }

        .back-link {
            color: #667eea;
            text-decoration: none;
            font-size: 13px;
        }

        .listing-hero {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 20px;
            background: #fff;
            border-radius: 14px;
            padding: 22px;
            box-shadow: 0 2px 14px rgba(0, 0, 0, .07);
            margin: 15px 0 20px;
            flex-wrap: wrap;
        }

        .listing-hero-left {
            display: flex;
            gap: 16px;
            flex: 1;
        }

        .listing-type-icon {
            font-size: 36px;
            line-height: 1;
        }

        .listing-hero-info h1 {
            margin: 0 0 10px;
            font-size: 22px;
            font-weight: 700;
        }

        .listing-meta-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 7px;
            margin-bottom: 10px;
        }

        .chip {
            background: #f3f4f6;
            padding: 5px 12px;
            border-radius: 14px;
            font-size: 12px;
            color: #555;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .chip-blue {
            background: #dbeafe;
            color: #1e40af;
        }

        .chip-amber {
            background: #fef3c7;
            color: #92400e;
        }

        .posted-by {
            font-size: 12px;
            color: #aaa;
        }

        .score-hero-card {
            text-align: center;
            min-width: 140px;
        }

        .score-hero-circle {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin: 0 auto 10px;
            border: 4px solid;
        }

        .score-high {
            border-color: #10b981;
            background: #d1fae5;
            color: #065f46;
        }

        .score-mid {
            border-color: #f59e0b;
            background: #fef3c7;
            color: #92400e;
        }

        .score-low {
            border-color: #ef4444;
            background: #fee2e2;
            color: #991b1b;
        }

        .score-hero-num {
            font-size: 24px;
            font-weight: 900;
            line-height: 1;
        }

        .score-hero-label {
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .score-hero-exp {
            font-size: 12px;
            color: #555;
            max-width: 180px;
            text-align: center;
        }

        .criteria-panel,
        .req-panel,
        .desc-panel,
        .apply-section {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .06);
            margin-bottom: 15px;
        }

        .criteria-panel h4,
        .req-panel h4,
        .desc-panel h4 {
            margin: 0 0 14px;
            font-size: 15px;
            font-weight: 700;
        }

        .criteria-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        @media(max-width:600px) {
            .criteria-grid {
                grid-template-columns: 1fr;
            }
        }

        .crit-item {
            padding: 6px 0;
        }

        .crit-header {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            margin-bottom: 4px;
        }

        .crit-name {
            color: #555;
            font-weight: 500;
        }

        .crit-pct {
            font-weight: 800;
        }

        .crit-track {
            background: #f3f4f6;
            border-radius: 6px;
            height: 7px;
            overflow: hidden;
        }

        .crit-fill {
            height: 100%;
            border-radius: 6px;
        }

        .req-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 6px;
        }

        .req-tag {
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .req-mandatory {
            background: #fee2e2;
            color: #991b1b;
        }

        .req-optional {
            background: #f3f4f6;
            color: #374151;
        }

        .req-note {
            color: #aaa;
            font-size: 11px;
        }

        .desc-text {
            line-height: 1.8;
            color: #374151;
            white-space: pre-line;
        }

        .apply-card h3 {
            margin: 0 0 6px;
            font-size: 17px;
            font-weight: 700;
        }

        .apply-card p {
            color: #555;
            font-size: 14px;
            margin: 0 0 16px;
        }

        .apply-textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            resize: vertical;
        }

        .apply-textarea:focus {
            border-color: #667eea;
            outline: none;
        }

        .char-count {
            color: #aaa;
            font-size: 11px;
            display: block;
            text-align: right;
        }

        .btn-apply-submit {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: #fff;
            border: none;
            padding: 13px 30px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
        }

        .btn-apply-submit:hover {
            opacity: .9;
        }

        .applied-notice {
            background: #d1fae5;
            color: #065f46;
            padding: 16px 20px;
            border-radius: 10px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .closed-notice {
            background: #f3f4f6;
            color: #374151;
            padding: 16px 20px;
            border-radius: 10px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .ineligible-notice {
            background: #fef3c7;
            color: #92400e;
            padding: 16px 20px;
            border-radius: 10px;
            font-size: 14px;
        }

        .ineligible-notice a {
            color: #92400e;
            font-weight: 700;
        }
    </style>

    <script>
        document.querySelector('[name="cover_note"]').addEventListener('input', function () {
            document.querySelector('.char-count').textContent = this.value.length + ' / 1000';
        });
    </script>
    </div>
</div>
@include('includes.footer')
@endsection