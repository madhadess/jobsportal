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
                            <span class="current">Hizmetler Raporu</span>
                        </nav>
                        <h1 class="page-title-modern">
                            <i class="fa fa-cogs"></i> Hizmetler Raporu
                        </h1>
                        <p class="page-subtitle">Tüm hizmetlerin detaylı analizi, kategori bazlı filtreleme ve performans
                            metrikleri</p>
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
                        <div class="stat-label">Toplam Hizmet</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card stat-green">
                        <div class="stat-number">{{ number_format($totalStats['active']) }}</div>
                        <div class="stat-label">Aktif Hizmet</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card stat-purple">
                        <div class="stat-number">{{ number_format($totalStats['featured']) }}</div>
                        <div class="stat-label">Öne Çıkan</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="stat-card stat-orange">
                        <div class="stat-number">{{ number_format($totalStats['total_requests']) }}</div>
                        <div class="stat-label">Toplam Talep</div>
                    </div>
                </div>
            </div>

            <!-- Filtreler -->
            <div class="portlet light bordered" style="margin-top: 20px;">
                <div class="portlet-title">
                    <div class="caption">
                        <i class="icon-filter font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Filtreler</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <form method="GET" action="{{ route('admin.reports.services') }}">
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
                                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Pasif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Kategori</label>
                                    <select name="category_id" class="form-control">
                                        <option value="">Tümü</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->category_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group" style="margin-top: 25px;">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>
                                        Filtrele</button>
                                    <a href="{{ route('admin.reports.services') }}" class="btn btn-default"><i
                                            class="fa fa-refresh"></i> Sıfırla</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="btn-group">
                                    <a href="{{ route('admin.reports.services.export', array_merge(request()->all(), ['format' => 'excel'])) }}"
                                        class="btn btn-success">
                                        <i class="fa fa-file-excel-o"></i> Excel İndir
                                    </a>
                                    <a href="{{ route('admin.reports.services.export', array_merge(request()->all(), ['format' => 'pdf'])) }}"
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
                        <i class="icon-list font-green"></i>
                        <span class="caption-subject font-green bold uppercase">Hizmetler Listesi</span>
                        <span class="caption-helper">({{ $services->total() }} kayıt)</span>
                    </div>
                </div>
                <div class="portlet-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered" id="servicesTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Hizmet Adı</th>
                                    <th>Kategori</th>
                                    <th>Fiyat</th>
                                    <th>Süre</th>
                                    <th>Talep Sayısı</th>
                                    <th>Görüntülenme</th>
                                    <th>Durum</th>
                                    <th>Öne Çıkan</th>
                                    <th>Oluşturulma</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($services as $service)
                                    <tr>
                                        <td>{{ $service->id }}</td>
                                        <td>{{ Str::limit($service->service_name, 30) }}</td>
                                        <td>{{ $service->category->category_name ?? '-' }}</td>
                                        <td>{{ $service->getFormattedPrice() }}</td>
                                        <td>{{ $service->getFormattedDuration() }}</td>
                                        <td><span class="badge badge-info">{{ $service->requests_count ?? 0 }}</span></td>
                                        <td>{{ number_format($service->views_count ?? 0) }}</td>
                                        <td>
                                            @if($service->is_active)
                                                <span class="label label-success">Aktif</span>
                                            @else
                                                <span class="label label-danger">Pasif</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($service->is_featured)
                                                <span class="label label-warning">Evet</span>
                                            @else
                                                <span class="label label-default">Hayır</span>
                                            @endif
                                        </td>
                                        <td>{{ $service->created_at ? $service->created_at->format('d.m.Y H:i') : '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">Kayıt bulunamadı.</td>
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
                initModernDataTable('#servicesTable', {
                    order: [[0, 'desc']],
                    pageLength: 25
                });
            });
        </script>
    @endpush

@endsection