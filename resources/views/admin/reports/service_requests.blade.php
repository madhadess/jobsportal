@extends('admin.layouts.admin_layout')
@php use Illuminate\Support\Str; @endphp
@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">

            <!-- Modern Header -->
            <div class="report-page-header">
                <div class="header-content">
                    <div class="header-left">
                        <nav class="breadcrumb-modern">
                            <a href="{{ route('admin.home') }}"><i class="fa fa-home"></i></a>
                            <span class="separator"><i class="fa fa-angle-right"></i></span>
                            <a href="{{ route('admin.reports.index') }}">Raporlar</a>
                            <span class="separator"><i class="fa fa-angle-right"></i></span>
                            <span class="current">Hizmet Talepleri Raporu</span>
                        </nav>
                        <h1 class="page-title-modern">
                            <i class="fa fa-phone"></i> Hizmet Talepleri Raporu
                        </h1>
                        <p class="page-subtitle">Tüm hizmet taleplerinin detaylı takibi ve analizi</p>
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
                    <div class="stat-card stat-info">
                        <div class="stat-number">{{ number_format($totalStats['approved']) }}</div>
                        <div class="stat-label">Onaylandı</div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="stat-card stat-purple">
                        <div class="stat-number">{{ number_format($totalStats['in_progress']) }}</div>
                        <div class="stat-label">Devam Ediyor</div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="stat-card stat-green">
                        <div class="stat-number">{{ number_format($totalStats['completed']) }}</div>
                        <div class="stat-label">Tamamlandı</div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="stat-card stat-red">
                        <div class="stat-number">{{ number_format($totalStats['cancelled']) }}</div>
                        <div class="stat-label">İptal</div>
                    </div>
                </div>
            </div>

            <!-- Filtreler -->
            <div class="portlet light bordered" style="margin-top: 20px;">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-filter font-purple"></i>
                        <span class="caption-subject font-purple bold uppercase">Filtreler</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <form method="GET" action="{{ route('admin.reports.service_requests') }}">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label>Başlangıç Tarihi</label>
                                    <input type="date" name="date_from" class="form-control"
                                        value="{{ request('date_from') }}">
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
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                            Beklemede</option>
                                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                                            Onaylandı</option>
                                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>Devam Ediyor</option>
                                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                                            Tamamlandı</option>
                                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>
                                            İptal Edildi</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Hizmet</label>
                                    <select name="service_id" class="form-control">
                                        <option value="">Tümü</option>
                                        @foreach($servicesList as $service)
                                            <option value="{{ $service->id }}" {{ request('service_id') == $service->id ? 'selected' : '' }}>{{ $service->service_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group" style="margin-top: 25px;">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>
                                        Filtrele</button>
                                    <a href="{{ route('admin.reports.service_requests') }}" class="btn btn-default"><i
                                            class="fa fa-refresh"></i> Sıfırla</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="btn-group">
                                    <a href="{{ route('admin.reports.service_requests.export', array_merge(request()->all(), ['format' => 'excel'])) }}"
                                        class="btn btn-success">
                                        <i class="fa fa-file-excel-o"></i> Excel İndir
                                    </a>
                                    <a href="{{ route('admin.reports.service_requests.export', array_merge(request()->all(), ['format' => 'pdf'])) }}"
                                        class="btn btn-danger" target="_blank">
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
                        <i class="icon-list font-purple"></i>
                        <span class="caption-subject font-purple bold uppercase">Hizmet Talepleri Listesi</span>
                        <span class="caption-helper">({{ $requests->total() }} kayıt)</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered" id="serviceRequestsTable">
                            <thead>
                                <tr>
                                    <th>Talep No</th>
                                    <th>Müşteri</th>
                                    <th>Telefon</th>
                                    <th>Hizmet</th>
                                    <th>Adres</th>
                                    <th>Tercih Edilen Tarih</th>
                                    <th>Durum</th>
                                    <th>Fiyat</th>
                                    <th>Talep Tarihi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($requests as $req)
                                    <tr>
                                        <td><strong>{{ $req->request_number }}</strong></td>
                                        <td>{{ $req->user->name ?? '-' }}</td>
                                        <td>{{ $req->customer_phone ?? '-' }}</td>
                                        <td>{{ Str::limit($req->service->service_name ?? '-', 25) }}</td>
                                        <td>{{ Str::limit($req->customer_address ?? '-', 30) }}</td>
                                        <td>
                                            {{ $req->getFormattedDate() }}<br>
                                            <small class="text-muted">{{ $req->preferred_time ?? '' }}</small>
                                        </td>
                                        <td>
                                            <span
                                                class="label label-{{ $req->getStatusColor() }}">{{ $req->getStatusLabel() }}</span>
                                        </td>
                                        <td>
                                            @if($req->final_price)
                                                {{ number_format($req->final_price, 2, ',', '.') }} TL
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>{{ $req->created_at ? $req->created_at->format('d.m.Y H:i') : '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center">Kayıt bulunamadı.</td>
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
            $(document).ready(function () {
                initModernDataTable('#serviceRequestsTable', {
                    order: [[0, 'desc']],
                    pageLength: 25
                });
            });
        </script>
    @endpush

    <style>
        /* Modern Header Styles */
        .report-page-header {
            background: linear-gradient(135deg, #7c3aed 0%, #8b5cf6 100%);
            border-radius: 12px;
            padding: 25px 30px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(124, 58, 237, 0.3);
        }

        .report-page-header .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .report-page-header .header-left {
            flex: 1;
        }

        .breadcrumb-modern {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
        }

        .breadcrumb-modern a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 13px;
            transition: color 0.2s;
        }

        .breadcrumb-modern a:hover {
            color: #fff;
        }

        .breadcrumb-modern .separator {
            color: rgba(255, 255, 255, 0.5);
            font-size: 12px;
        }

        .breadcrumb-modern .current {
            color: #fff;
            font-weight: 600;
            font-size: 13px;
        }

        .page-title-modern {
            color: #fff;
            font-size: 28px;
            font-weight: 700;
            margin: 0 0 5px 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .page-title-modern i {
            opacity: 0.9;
        }

        .page-subtitle {
            color: rgba(255, 255, 255, 0.85);
            font-size: 14px;
            margin: 0;
        }

        .btn-outline-back {
            background: rgba(255, 255, 255, 0.15);
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: #fff;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .btn-outline-back:hover {
            background: rgba(255, 255, 255, 0.25);
            border-color: rgba(255, 255, 255, 0.5);
            color: #fff;
        }

        /* Stat Cards */
        .stat-card {
            background: #fff;
            border-radius: 12px;
            padding: 18px;
            text-align: center;
            box-shadow: 0 3px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
            border-left: 5px solid;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
        }

        .stat-card .stat-number {
            font-size: 30px;
            font-weight: 700;
        }

        .stat-card .stat-label {
            font-size: 11px;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 5px;
        }

        .stat-blue {
            border-left-color: #3b82f6;
        }

        .stat-blue .stat-number {
            color: #3b82f6;
        }

        .stat-green {
            border-left-color: #22c55e;
        }

        .stat-green .stat-number {
            color: #22c55e;
        }

        .stat-red {
            border-left-color: #ef4444;
        }

        .stat-red .stat-number {
            color: #ef4444;
        }

        .stat-purple {
            border-left-color: #8b5cf6;
        }

        .stat-purple .stat-number {
            color: #8b5cf6;
        }

        .stat-orange {
            border-left-color: #f59e0b;
        }

        .stat-orange .stat-number {
            color: #f59e0b;
        }

        .stat-info {
            border-left-color: #06b6d4;
        }

        .stat-info .stat-number {
            color: #06b6d4;
        }

        /* Portlet Improvements */
        .portlet.light.bordered {
            border-radius: 10px;
            overflow: hidden;
        }

        .portlet-title {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }
    </style>
@endsection