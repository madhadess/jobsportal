@extends('admin.layouts.admin_layout')
@php use Illuminate\Support\Str; @endphp
@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">

            <!-- Modern Header -->
            <div class="report-page-header companies">
                <div class="header-content">
                    <div class="header-left">
                        <nav class="breadcrumb-modern">
                            <a href="{{ route('admin.home') }}"><i class="fa fa-home"></i></a>
                            <span class="separator"><i class="fa fa-angle-right"></i></span>
                            <a href="{{ route('admin.reports.index') }}">Raporlar</a>
                            <span class="separator"><i class="fa fa-angle-right"></i></span>
                            <span class="current">Şirketler Raporu</span>
                        </nav>
                        <h1 class="page-title-modern">
                            <i class="fa fa-building"></i> Şirketler Raporu
                        </h1>
                        <p class="page-subtitle">Tüm şirketlerin detaylı analizi, sektör bazlı filtreleme ve ilan performans metrikleri</p>
                    </div>
                    <div class="header-right">
                        <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-back">
                            <i class="fa fa-arrow-left"></i> Raporlara Dön
                        </a>
                    </div>
                </div>
            </div>

            <!-- İstatistik Kartları -->
            <div class="row" style="margin-top: 25px;">
                <div class="col-md-3">
                    <div class="stat-card stat-blue">
                        <div class="stat-number">{{ number_format($totalStats['total']) }}</div>
                        <div class="stat-label">Toplam Şirket</div>
                        <div class="stat-subtext">Sistemdeki Tüm Kayıtlar</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card stat-green">
                        <div class="stat-number">{{ number_format($totalStats['active']) }}</div>
                        <div class="stat-label">Aktif Şirket</div>
                        <div class="stat-subtext">Hizmet Verenler</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card stat-purple">
                        <div class="stat-number">{{ number_format($totalStats['verified']) }}</div>
                        <div class="stat-label">Doğrulanmış</div>
                        <div class="stat-subtext">Onaylı Hesaplar</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card stat-orange">
                        <div class="stat-number">{{ number_format($totalStats['with_jobs']) }}</div>
                        <div class="stat-label">İlan Veren</div>
                        <div class="stat-subtext">En Az 1 İlanı Olan</div>
                    </div>
                </div>
            </div>

            <!-- Gelişmiş Filtreler -->
            <div class="portlet light bordered modern-filter-portlet" style="margin-top: 20px;">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-magnifier font-purple"></i>
                        <span class="caption-subject font-purple bold uppercase">Gelişmiş Filtreleme</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group">
                            <a href="{{ route('admin.reports.companies.export', array_merge(request()->all(), ['format' => 'excel'])) }}" class="btn btn-sm btn-success">
                                <i class="fa fa-file-excel-o"></i> Excel
                            </a>
                            <a href="{{ route('admin.reports.companies.export', array_merge(request()->all(), ['format' => 'pdf'])) }}" class="btn btn-sm btn-danger" target="_blank">
                                <i class="fa fa-file-pdf-o"></i> PDF
                            </a>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <form method="GET" action="{{ route('admin.reports.companies') }}" id="filterForm">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group select2-modern">
                                    <label class="control-label">Sektör</label>
                                    <select name="industry_id" class="form-control select2">
                                        <option value="">Tüm Sektörler</option>
                                        @foreach($industries as $industry)
                                            <option value="{{ $industry->industry_id }}" {{ request('industry_id') == $industry->industry_id ? 'selected' : '' }}>
                                                {{ $industry->industry }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group select2-modern">
                                    <label class="control-label">Şehir</label>
                                    <select name="state_id" class="form-control select2">
                                        <option value="">Tüm Şehirler</option>
                                        @foreach($states as $state)
                                            <option value="{{ $state->state_id }}" {{ request('state_id') == $state->state_id ? 'selected' : '' }}>{{ $state->state }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Doğrulama Durumu</label>
                                    <select name="verified" class="form-control">
                                        <option value="">Tümü</option>
                                        <option value="1" {{ request('verified') == '1' ? 'selected' : '' }}>Doğrulanmış</option>
                                        <option value="0" {{ request('verified') == '0' ? 'selected' : '' }}>Doğrulanmamış</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Hesap Durumu</label>
                                    <select name="status" class="form-control">
                                        <option value="">Tümü</option>
                                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Pasif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Başlangıç Tarihi</label>
                                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Bitiş Tarihi</label>
                                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group" style="padding-top: 25px;">
                                    <button type="submit" class="btn btn-primary px-5"><i class="fa fa-filter"></i> Filtrele</button>
                                    <a href="{{ route('admin.reports.companies') }}" class="btn btn-link text-muted"><i class="fa fa-undo"></i> Temizle</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Veri Tablosu -->
            <div class="portlet light bordered report-table-portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-grid font-purple"></i>
                        <span class="caption-subject font-purple bold uppercase">Şirket Listesi</span>
                        <span class="caption-helper">({{ $companies->total() }} Şirket)</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover modern-table" id="companiesTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Şirket Bilgisi</th>
                                    <th>İletişim</th>
                                    <th>Sektör & Konum</th>
                                    <th>İstatistik</th>
                                    <th>Durum</th>
                                    <th>Kayıt</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($companies as $company)
                                    <tr>
                                        <td><span class="badge badge-light">#{{ $company->id }}</span></td>
                                        <td>
                                            <div class="company-name-cell">
                                                <a href="{{ route('company.detail', $company->slug) }}" target="_blank" class="company-name-link">{{ Str::limit($company->name, 40) }}</a>
                                                <div class="company-sub">
                                                    @if($company->verified)
                                                        <span class="text-primary"><i class="fa fa-check-circle"></i> Onaylı</span>
                                                    @else
                                                        <span class="text-muted">Onay Bekliyor</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="contact-info">
                                                <div class="contact-item"><i class="fa fa-envelope-o"></i> {{ $company->email }}</div>
                                                <div class="contact-item mt-1"><i class="fa fa-phone"></i> {{ $company->phone ?? '-' }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="tag-cell">
                                                <span class="label label-sm label-info">{{ $company->industry->industry ?? '-' }}</span>
                                                <div class="mt-1"><i class="fa fa-map-marker text-muted"></i> {{ $company->city->city ?? '-' }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="stats-grouped">
                                                <div class="stat-item">
                                                    <span class="stat-val">{{ $company->jobs_count ?? 0 }}</span>
                                                    <span class="stat-lbl">Toplam İlan</span>
                                                </div>
                                                <div class="stat-item text-success">
                                                    <span class="stat-val">{{ $company->active_jobs_count ?? 0 }}</span>
                                                    <span class="stat-lbl">Aktif İlan</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            @if($company->is_active)
                                                <span class="status-indicator status-active">Aktif</span>
                                            @else
                                                <span class="status-indicator status-inactive">Pasif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="date-cell">
                                                <div class="date-main">{{ $company->created_at->format('d.m.Y') }}</div>
                                                <div class="date-sub">{{ $company->created_at->format('H:i') }}</div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <i class="fa fa-building-o fa-3x text-muted mb-3"></i>
                                            <p>Arama kriterlerinize uygun şirket bulunamadı.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="pagination-wrapper mt-4 text-center">
                        {!! $companies->links() !!}
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        /* Shared Report Styles (same as Jobs for consistency) */
        .report-page-header { background: #fff; padding: 25px; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.05); }
        .page-title-modern { font-size: 24px; font-weight: 700; color: #1e293b; margin: 10px 0 5px; }
        .page-subtitle { color: #64748b; font-size: 14px; margin: 0; }
        
        .stat-card { background: #fff; border-radius: 12px; padding: 22px; text-align: center; box-shadow: 0 4px 15px rgba(0,0,0,0.04); border-left: 5px solid; transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-3px); }
        .stat-number { font-size: 30px; font-weight: 800; line-height: 1; margin-bottom: 8px; }
        .stat-label { font-size: 13px; font-weight: 600; color: #475569; text-transform: uppercase; }
        .stat-subtext { font-size: 11px; color: #94a3b8; margin-top: 4px; }
        
        .stat-blue { border-left-color: #3b82f6; } .stat-blue .stat-number { color: #3b82f6; }
        .stat-green { border-left-color: #10b981; } .stat-green .stat-number { color: #10b981; }
        .stat-purple { border-left-color: #8b5cf6; } .stat-purple .stat-number { color: #8b5cf6; }
        .stat-orange { border-left-color: #f59e0b; } .stat-orange .stat-number { color: #f59e0b; }

        .modern-filter-portlet { border-radius: 12px !important; border: none !important; box-shadow: 0 4px 15px rgba(0,0,0,0.04) !important; }
        .modern-filter-portlet .portlet-title { padding: 15px 20px !important; min-height: auto !important; }
        .control-label { font-weight: 600; color: #475569; font-size: 12px; margin-bottom: 8px; }
        
        .modern-table thead th { background: #f8fafc; color: #475569; font-weight: 700; text-transform: uppercase; font-size: 11px; padding: 15px !important; }
        .modern-table tbody td { vertical-align: middle !important; padding: 15px !important; color: #1e293b; }
        
        .company-name-link { font-weight: 700; color: #8b5cf6; text-decoration: none; font-size: 14px; }
        .company-sub { font-size: 11px; margin-top: 2px; font-weight: 600; }
        
        .contact-info { font-size: 12px; color: #475569; }
        .contact-item i { width: 15px; color: #94a3b8; }
        
        .stats-grouped { display: flex; gap: 15px; }
        .stat-item { display: flex; flex-direction: column; }
        .stat-val { font-weight: 700; font-size: 15px; }
        .stat-lbl { font-size: 10px; text-transform: uppercase; color: #94a3b8; }
        
        .status-indicator { padding: 4px 12px; border-radius: 20px; font-size: 11px; font-weight: 700; display: inline-block; }
        .status-active { background: #dcfce7; color: #166534; }
        .status-inactive { background: #fee2e2; color: #991b1b; }
        
        .date-main { font-weight: 600; font-size: 13px; }
        .date-sub { font-size: 11px; color: #94a3b8; }
        
        .select2-modern .select2-container--bootstrap .select2-selection { border-radius: 8px; min-height: 38px; border-color: #e2e8f0; }
        .mt-3 { margin-top: 1rem; }
    </style>

    @push('scripts')
        <script>
            $(document).ready(function () {
                $('.select2').select2({
                    theme: 'bootstrap',
                    width: '100%'
                });
            });
        </script>
    @endpush
@endsection
