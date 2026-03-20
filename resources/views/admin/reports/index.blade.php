@extends('admin.layouts.admin_layout')
@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li><a href="{{ route('admin.home') }}">Ana Sayfa</a><i class="fa fa-circle"></i></li>
                    <li><span>Raporlar</span></li>
                </ul>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <h1 class="page-title">Raporlama Merkezi</h1>
                </div>
                <div class="col-md-6 text-right" style="margin-top: 25px;">
                    <a href="{{ route('admin.reports.test_mail') }}" class="btn btn-warning">
                        <i class="fa fa-envelope"></i> Sistem Mail Testi Yap
                    </a>
                </div>
            </div>

            @if(session('success_message'))
                <div class="alert alert-success">
                    {{ session('success_message') }}
                </div>
            @endif

            @if(session('error_message'))
                <div class="alert alert-danger">
                    {{ session('error_message') }}
                </div>
            @endif

            <!-- İstatistik Kartları -->
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="dashboard-stat2">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-blue-sharp">{{ number_format($stats['total_jobs']) }}</h3>
                                <small>TOPLAM İLAN</small>
                            </div>
                            <div class="icon"><i class="icon-briefcase"></i></div>
                        </div>
                        <div class="progress-info">
                            <div class="status">
                                <span class="font-green-jungle">{{ number_format($stats['active_jobs']) }} Aktif</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="dashboard-stat2">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-purple-soft">{{ number_format($stats['total_companies']) }}</h3>
                                <small>TOPLAM ŞİRKET</small>
                            </div>
                            <div class="icon"><i class="icon-building"></i></div>
                        </div>
                        <div class="progress-info">
                            <div class="status">
                                <span class="font-green-jungle">{{ number_format($stats['active_companies']) }} Aktif</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="dashboard-stat2">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-green-jungle">{{ number_format($stats['total_users']) }}</h3>
                                <small>TOPLAM KULLANICI</small>
                            </div>
                            <div class="icon"><i class="icon-users"></i></div>
                        </div>
                        <div class="progress-info">
                            <div class="status">
                                <span class="font-green-jungle">{{ number_format($stats['verified_users']) }}
                                    Doğrulanmış</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6">
                    <div class="dashboard-stat2">
                        <div class="display">
                            <div class="number">
                                <h3 class="font-red-thunderbird">{{ number_format($stats['total_applications']) }}</h3>
                                <small>TOPLAM BAŞVURU</small>
                            </div>
                            <div class="icon"><i class="icon-envelope"></i></div>
                        </div>
                        <div class="progress-info">
                            <div class="status">
                                <span class="font-yellow-casablanca">{{ number_format($stats['pending_applications']) }}
                                    Beklemede</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rapor Menüleri -->
            <div class="row" style="margin-top: 30px;">
                <div class="col-md-4">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-briefcase font-blue"></i>
                                <span class="caption-subject font-blue bold uppercase">İş İlanları Raporu</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <p>Tüm iş ilanlarını tarih, şehir, iş alanı ve duruma göre filtreleyin. Excel ve PDF formatında
                                çıktı alın.</p>
                            <ul>
                                <li>Tarih aralığına göre filtreleme</li>
                                <li>Şehir ve iş alanına göre filtreleme</li>
                                <li>Aktif/Pasif durum filtresi</li>
                                <li>Excel ve PDF export</li>
                            </ul>
                            <a href="{{ route('admin.reports.jobs') }}" class="btn btn-primary btn-block"
                                style="margin-top: 15px;">
                                <i class="fa fa-file-text"></i> İş İlanları Raporuna Git
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-building font-purple"></i>
                                <span class="caption-subject font-purple bold uppercase">Şirketler Raporu</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <p>Kayıtlı şirketleri analiz edin. İlan sayıları, doğrulama durumları ve sektör bilgilerini
                                görüntüleyin.</p>
                            <ul>
                                <li>Şirket detaylı listesi</li>
                                <li>İlan sayısına göre sıralama</li>
                                <li>Sektör ve şehir filtresi</li>
                                <li>Excel ve PDF export</li>
                            </ul>
                            <a href="{{ route('admin.reports.companies') }}" class="btn btn-success btn-block"
                                style="margin-top: 15px;">
                                <i class="fa fa-building"></i> Şirketler Raporuna Git
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-envelope font-red"></i>
                                <span class="caption-subject font-red bold uppercase">Başvurular Raporu</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <p>İş başvurularını takip edin. Durum, tarih ve şirkete göre filtreleme yapın.</p>
                            <ul>
                                <li>Başvuru durumu takibi</li>
                                <li>Şirkete göre filtreleme</li>
                                <li>Tarih aralığı filtresi</li>
                                <li>Excel ve PDF export</li>
                            </ul>
                            <a href="{{ route('admin.reports.applications') }}" class="btn btn-danger btn-block"
                                style="margin-top: 15px;">
                                <i class="fa fa-envelope"></i> Başvurular Raporuna Git
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hizmetler Rapor Menüleri -->
            <div class="row" style="margin-top: 20px;">
                <div class="col-md-6">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-wrench font-green"></i>
                                <span class="caption-subject font-green bold uppercase">Hizmetler Raporu</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <p>Tüm hizmetleri analiz edin. Kategori, fiyat, talep sayısı ve görüntülenme bilgilerini
                                görüntüleyin.</p>
                            <ul>
                                <li>Hizmet detaylı listesi</li>
                                <li>Kategoriye göre filtreleme</li>
                                <li>Talep ve görüntülenme istatistikleri</li>
                                <li>Excel ve PDF export</li>
                            </ul>
                            <a href="{{ route('admin.reports.services') }}" class="btn btn-info btn-block"
                                style="margin-top: 15px;">
                                <i class="fa fa-wrench"></i> Hizmetler Raporuna Git
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-call-in font-purple"></i>
                                <span class="caption-subject font-purple bold uppercase">Hizmet Talepleri Raporu</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <p>Hizmet taleplerini takip edin. Durum, tarih ve hizmete göre filtreleme yapın.</p>
                            <ul>
                                <li>Talep durumu takibi (Beklemede, Onaylandı, Tamamlandı)</li>
                                <li>Hizmete göre filtreleme</li>
                                <li>Tarih aralığı filtresi</li>
                                <li>Excel ve PDF export</li>
                            </ul>
                            <a href="{{ route('admin.reports.service_requests') }}" class="btn btn-warning btn-block"
                                style="margin-top: 15px;">
                                <i class="fa fa-phone"></i> Hizmet Talepleri Raporuna Git
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grafikler -->
            <div class="row" style="margin-top: 30px;">
                <div class="col-md-6">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-bar-chart font-blue"></i>
                                <span class="caption-subject font-blue bold uppercase">Son 30 Gün - İş İlanları</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <canvas id="jobsChart" height="250"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-bar-chart font-green"></i>
                                <span class="caption-subject font-green bold uppercase">Son 30 Gün - Başvurular</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <canvas id="applicationsChart" height="250"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Şehirlere ve İş Alanlarına Göre -->
            <div class="row" style="margin-top: 30px;">
                <div class="col-md-6">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-map font-purple"></i>
                                <span class="caption-subject font-purple bold uppercase">Şehirlere Göre İlanlar (Top
                                    10)</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Şehir</th>
                                        <th class="text-right">İlan Sayısı</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jobsByCity as $item)
                                        <tr>
                                            <td>{{ $item->city_name ?? 'Belirtilmemiş' }}</td>
                                            <td class="text-right"><span class="badge badge-primary">{{ $item->count }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-layers font-green"></i>
                                <span class="caption-subject font-green bold uppercase">İş Alanlarına Göre İlanlar (Top
                                    10)</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>İş Alanı</th>
                                        <th class="text-right">İlan Sayısı</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($jobsByArea as $item)
                                        <tr>
                                            <td>{{ $item->area_name ?? 'Belirtilmemiş' }}</td>
                                            <td class="text-right"><span class="badge badge-success">{{ $item->count }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // İş İlanları Grafiği
            var jobsCtx = document.getElementById('jobsChart').getContext('2d');
            var jobsChart = new Chart(jobsCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($jobTrend->pluck('date')->map(function ($d) {
        return \Carbon\Carbon::parse($d)->format('d.m'); })) !!},
                    datasets: [{
                        label: 'İş İlanları',
                        data: {!! json_encode($jobTrend->pluck('count')) !!},
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });

            // Başvurular Grafiği
            var appsCtx = document.getElementById('applicationsChart').getContext('2d');
            var appsChart = new Chart(appsCtx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($applicationTrend->pluck('date')->map(function ($d) {
        return \Carbon\Carbon::parse($d)->format('d.m'); })) !!},
                    datasets: [{
                        label: 'Başvurular',
                        data: {!! json_encode($applicationTrend->pluck('count')) !!},
                        borderColor: 'rgb(34, 197, 94)',
                        backgroundColor: 'rgba(34, 197, 94, 0.1)',
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        });
    </script>

    <style>
        .dashboard-stat2 {
            background: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

        .dashboard-stat2 .display {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .dashboard-stat2 .number h3 {
            font-size: 32px;
            font-weight: 700;
            margin: 0;
        }

        .dashboard-stat2 .number small {
            font-size: 12px;
            color: #888;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .dashboard-stat2 .icon i {
            font-size: 48px;
            opacity: 0.2;
        }

        .dashboard-stat2 .progress-info {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }

        .font-blue-sharp {
            color: #3b82f6;
        }

        .font-purple-soft {
            color: #8b5cf6;
        }

        .font-green-jungle {
            color: #22c55e;
        }

        .font-red-thunderbird {
            color: #ef4444;
        }

        .font-yellow-casablanca {
            color: #f59e0b;
        }

        .badge-primary {
            background: #3b82f6;
            color: #fff;
            padding: 5px 10px;
            border-radius: 4px;
        }

        .badge-success {
            background: #22c55e;
            color: #fff;
            padding: 5px 10px;
            border-radius: 4px;
        }
    </style>
@endsection