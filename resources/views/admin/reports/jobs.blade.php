@extends('admin.layouts.admin_layout')
@php use Illuminate\Support\Str; @endphp
@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">

            <!-- Modern Header -->
            <div class="report-page-header jobs">
                <div class="header-content">
                    <div class="header-left">
                        <nav class="breadcrumb-modern">
                            <a href="{{ route('admin.home') }}"><i class="fa fa-home"></i></a>
                            <span class="separator"><i class="fa fa-angle-right"></i></span>
                            <a href="{{ route('admin.reports.index') }}">Raporlar</a>
                            <span class="separator"><i class="fa fa-angle-right"></i></span>
                            <span class="current">İş İlanları Raporu</span>
                        </nav>
                        <h1 class="page-title-modern">
                            <i class="fa fa-briefcase"></i> İş İlanları Raporu
                        </h1>
                        <p class="page-subtitle">Tüm iş ilanlarının detaylı analizi, şehir bazlı filtreleme ve performans metrikleri</p>
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
                        <div class="stat-label">Toplam İlan</div>
                        <div class="stat-subtext">Seçilen Filtrelere Göre</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card stat-green">
                        <div class="stat-number">{{ number_format($totalStats['active']) }}</div>
                        <div class="stat-label">Aktif İlan</div>
                        <div class="stat-subtext">Yayında Olanlar</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card stat-red">
                        <div class="stat-number">{{ number_format($totalStats['inactive']) }}</div>
                        <div class="stat-label">Pasif İlan</div>
                        <div class="stat-subtext">Kapatılmış/Taslak</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card stat-purple">
                        <div class="stat-number">{{ number_format($totalStats['featured']) }}</div>
                        <div class="stat-label">Öne Çıkan</div>
                        <div class="stat-subtext">Premium İlanlar</div>
                    </div>
                </div>
            </div>

            <!-- Gelişmiş Filtreler -->
            <div class="portlet light bordered modern-filter-portlet" style="margin-top: 20px;">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-magnifier font-blue"></i>
                        <span class="caption-subject font-blue bold uppercase">Gelişmiş Arama & Filtreleme</span>
                    </div>
                    <div class="actions">
                        <div class="btn-group">
                            <a href="{{ route('admin.reports.jobs.export', array_merge(request()->all(), ['format' => 'excel'])) }}" class="btn btn-sm btn-success">
                                <i class="fa fa-file-excel-o"></i> Excel Çıktısı
                            </a>
                            <a href="{{ route('admin.reports.jobs.export', array_merge(request()->all(), ['format' => 'pdf'])) }}" class="btn btn-sm btn-danger" target="_blank">
                                <i class="fa fa-file-pdf-o"></i> PDF İndir
                            </a>
                        </div>
                    </div>
                </div>
                <div class="portlet-body">
                    <form method="GET" action="{{ route('admin.reports.jobs') }}" id="filterForm">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group select2-modern">
                                    <label class="control-label">Şirket Seçin</label>
                                    <select name="company_id" class="form-control select2">
                                        <option value="">Tüm Şirketler</option>
                                        @foreach($companies as $company)
                                            <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
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
                                <div class="form-group select2-modern">
                                    <label class="control-label">İş Alanı</label>
                                    <select name="functional_area_id" class="form-control select2">
                                        <option value="">Tüm Alanlar</option>
                                        @foreach($functionalAreas as $area)
                                            <option value="{{ $area->functional_area_id }}" {{ request('functional_area_id') == $area->functional_area_id ? 'selected' : '' }}>{{ $area->functional_area }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group select2-modern">
                                    <label class="control-label">İlan Durumu</label>
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label">Öne Çıkan</label>
                                    <select name="is_featured" class="form-control">
                                        <option value="">Tümü</option>
                                        <option value="1" {{ request('is_featured') == '1' ? 'selected' : '' }}>Evet</option>
                                        <option value="0" {{ request('is_featured') == '0' ? 'selected' : '' }}>Hayır</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group" style="padding-top: 25px;">
                                    <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-filter"></i> Sorgula</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <a href="{{ route('admin.reports.jobs') }}" class="text-muted"><i class="fa fa-undo"></i> Filtreleri Temizle</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Veri Tablosu -->
            <div class="portlet light bordered report-table-portlet">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-grid font-blue"></i>
                        <span class="caption-subject font-blue bold uppercase">İş İlanları Listesi</span>
                        <span class="caption-helper">({{ $jobs->total() }} İlan Listeleniyor)</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover modern-table" id="jobsTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>İlan Bilgisi</th>
                                    <th>Şirket</th>
                                    <th>Konum</th>
                                    <th>İş Meta</th>
                                    <th>Durum</th>
                                    <th>Tarih</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($jobs as $job)
                                    <tr>
                                        <td><span class="badge badge-light">#{{ $job->id }}</span></td>
                                        <td>
                                            <div class="job-title-cell">
                                                <a href="{{ route('job.detail', $job->slug) }}" target="_blank" class="job-name">{{ Str::limit($job->title, 50) }}</a>
                                                <div class="job-subtext">{{ $job->functionalArea->functional_area ?? '-' }}</div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="company-cell">
                                                <span class="company-name">{{ $job->company->name ?? '-' }}</span>
                                            </div>
                                        </td>
                                        <td><i class="fa fa-map-marker text-muted"></i> {{ $job->city->city ?? '-' }}</td>
                                        <td>
                                            <div class="meta-item">
                                                <span class="label label-sm label-info">{{ $job->jobType->job_type ?? '-' }}</span>
                                            </div>
                                            <div class="meta-item mt-1">
                                                @if($job->is_featured)<span class="label label-sm label-warning">Öne Çıkan</span>@endif
                                            </div>
                                        </td>
                                        <td>
                                            @if($job->is_active)
                                                <span class="status-indicator status-active">Aktif</span>
                                            @else
                                                <span class="status-indicator status-inactive">Pasif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="date-cell">
                                                <div class="date-main">{{ $job->created_at->format('d.m.Y') }}</div>
                                                <div class="date-sub">{{ $job->created_at->format('H:i') }}</div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <i class="fa fa-search-minus fa-3x text-muted mb-3"></i>
                                            <p>Arama kriterlerinize uygun ilan bulunamadı.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="pagination-wrapper mt-4">
                        {!! $jobs->links() !!}
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
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
        .stat-red { border-left-color: #ef4444; } .stat-red .stat-number { color: #ef4444; }
        .stat-purple { border-left-color: #8b5cf6; } .stat-purple .stat-number { color: #8b5cf6; }

        .modern-filter-portlet { border-radius: 12px !important; border: none !important; box-shadow: 0 4px 15px rgba(0,0,0,0.04) !important; }
        .modern-filter-portlet .portlet-title { padding: 15px 20px !important; min-height: auto !important; }
        .control-label { font-weight: 600; color: #475569; font-size: 12px; margin-bottom: 8px; }
        
        .modern-table thead th { background: #f8fafc; color: #475569; font-weight: 700; text-transform: uppercase; font-size: 11px; padding: 15px !important; }
        .modern-table tbody td { vertical-align: middle !important; padding: 15px !important; color: #1e293b; }
        
        .job-name { font-weight: 700; color: #3b82f6; text-decoration: none; font-size: 14px; }
        .job-subtext { font-size: 12px; color: #64748b; margin-top: 2px; }
        .company-name { font-weight: 600; font-size: 13px; }
        
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
