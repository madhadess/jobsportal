@extends('admin.layouts.admin_layout')
@php use Illuminate\Support\Str; @endphp
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
        
        <!-- Modern Header -->
        <div class="report-page-header applications">
            <div class="header-content">
                <div class="header-left">
                    <nav class="breadcrumb-modern">
                        <a href="{{ route('admin.home') }}"><i class="fa fa-home"></i></a>
                        <span class="separator"><i class="fa fa-angle-right"></i></span>
                        <a href="{{ route('admin.reports.index') }}">Raporlar</a>
                        <span class="separator"><i class="fa fa-angle-right"></i></span>
                        <span class="current">Başvurular Raporu</span>
                    </nav>
                    <h1 class="page-title-modern">
                        <i class="fa fa-envelope"></i> Başvurular Raporu
                    </h1>
                    <p class="page-subtitle">Tüm iş başvurularının detaylı takibi, durum bazlı filtreleme ve aday performans metrikleri</p>
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
            <div class="col-md-2">
                <div class="stat-card stat-blue">
                    <div class="stat-number">{{ number_format($totalStats['total']) }}</div>
                    <div class="stat-label">Toplam</div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stat-card stat-orange">
                    <div class="stat-number">{{ number_format($totalStats['pending']) }}</div>
                    <div class="stat-label">Beklemede</div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stat-card stat-purple">
                    <div class="stat-number">{{ number_format($totalStats['shortlisted']) }}</div>
                    <div class="stat-label">Ön Eleme</div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stat-card stat-red">
                    <div class="stat-number">{{ number_format($totalStats['rejected']) }}</div>
                    <div class="stat-label">Reddedildi</div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="stat-card stat-green">
                    <div class="stat-number">{{ number_format($totalStats['hired']) }}</div>
                    <div class="stat-label">İşe Alındı</div>
                </div>
            </div>
        </div>

        <!-- Filtreler -->
        <div class="portlet light bordered" style="margin-top: 20px;">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-filter font-red"></i>
                    <span class="caption-subject font-red bold uppercase">Filtreler</span>
                </div>
            </div>
            <div class="portlet-body">
                <form method="GET" action="{{ route('admin.reports.applications') }}">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Başlangıç Tarihi</label>
                                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Bitiş Tarihi</label>
                                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Durum</label>
                                <select name="status" class="form-control">
                                    <option value="">Tümü</option>
                                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Beklemede</option>
                                    <option value="shortlisted" {{ request('status') == 'shortlisted' ? 'selected' : '' }}>Ön Eleme Geçti</option>
                                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Reddedildi</option>
                                    <option value="hired" {{ request('status') == 'hired' ? 'selected' : '' }}>İşe Alındı</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Şirket</label>
                                <select name="company_id" class="form-control">
                                    <option value="">Tümü</option>
                                    @foreach($companies as $company)
                                    <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>{{ $company->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group" style="margin-top: 25px;">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Filtrele</button>
                                <a href="{{ route('admin.reports.applications') }}" class="btn btn-default"><i class="fa fa-refresh"></i> Sıfırla</a>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="btn-group">
                                <a href="{{ route('admin.reports.applications.export', array_merge(request()->all(), ['format' => 'excel'])) }}" class="btn btn-success">
                                    <i class="fa fa-file-excel-o"></i> Excel İndir
                                </a>
                                <a href="{{ route('admin.reports.applications.export', array_merge(request()->all(), ['format' => 'pdf'])) }}" class="btn btn-danger" target="_blank">
                                    <i class="fa fa-file-pdf-o"></i> PDF Görüntüle
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tablo -->
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-list font-red"></i>
                    <span class="caption-subject font-red bold uppercase">Başvurular Listesi</span>
                    <span class="caption-helper">({{ $applications->total() }} kayıt)</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" id="applicationsTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Aday Adı</th>
                                <th>E-posta</th>
                                <th>İlan Başlığı</th>
                                <th>Şirket</th>
                                <th>Durum</th>
                                <th>Başvuru Tarihi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($applications as $app)
                            <tr>
                                <td>{{ $app->id }}</td>
                                <td>{{ $app->user->name ?? '-' }}</td>
                                <td>{{ $app->user->email ?? '-' }}</td>
                                <td>
                                    @if($app->job)
                                    <a href="{{ route('job.detail', $app->job->slug) }}" target="_blank">{{ Str::limit($app->job->title, 30) }}</a>
                                    @else
                                    -
                                    @endif
                                </td>
                                <td>{{ $app->job->company->name ?? '-' }}</td>
                                <td>
                                    @switch($app->status)
                                        @case('pending')
                                            <span class="label label-warning">Beklemede</span>
                                            @break
                                        @case('shortlisted')
                                            <span class="label label-info">Ön Eleme Geçti</span>
                                            @break
                                        @case('rejected')
                                            <span class="label label-danger">Reddedildi</span>
                                            @break
                                        @case('hired')
                                            <span class="label label-success">İşe Alındı</span>
                                            @break
                                        @default
                                            <span class="label label-default">{{ $app->status }}</span>
                                    @endswitch
                                </td>
                                <td>{{ $app->created_at->format('d.m.Y H:i') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Kayıt bulunamadı.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        initModernDataTable('#applicationsTable', {
            order: [[0, 'desc']],
            pageLength: 25
        });
    });
</script>
@endpush

<style>
.stat-card {
    background: #fff;
    border-radius: 8px;
    padding: 20px;
    text-align: center;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    margin-bottom: 20px;
    border-left: 4px solid;
}
.stat-card .stat-number {
    font-size: 28px;
    font-weight: 700;
}
.stat-card .stat-label {
    font-size: 11px;
    color: #888;
    text-transform: uppercase;
    letter-spacing: 1px;
}
.stat-blue { border-left-color: #3b82f6; }
.stat-blue .stat-number { color: #3b82f6; }
.stat-green { border-left-color: #22c55e; }
.stat-green .stat-number { color: #22c55e; }
.stat-red { border-left-color: #ef4444; }
.stat-red .stat-number { color: #ef4444; }
.stat-purple { border-left-color: #8b5cf6; }
.stat-purple .stat-number { color: #8b5cf6; }
.stat-orange { border-left-color: #f59e0b; }
.stat-orange .stat-number { color: #f59e0b; }
</style>
@endsection
