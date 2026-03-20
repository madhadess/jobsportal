@extends('admin.layouts.admin_layout')
@section('content')
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <!-- BEGIN PAGE BAR -->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li> <a href="{{ route('admin.home') }}">Ana Sayfa</a> <i class="fa fa-circle"></i> </li>
                    <li> <span>Otomatik Eşleştirme İzleme</span> </li>
                </ul>
            </div>
            <!-- END PAGE BAR -->
            <!-- BEGIN PAGE TITLE-->
            <h3 class="page-title"> Otomatik Eşleştirme İzleme <small>Talep ve Atama Durumları</small> </h3>
            <!-- END PAGE TITLE-->
            <!-- END PAGE HEADER-->
            <div class="row">
                <div class="col-md-12">
                    <!-- BEGIN DASHBOARD STATS 1-->
                    <div class="row">
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                                <div class="visual">
                                    <i class="fa fa-clock-o"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup"
                                            data-value="{{ $stats['total_pending'] }}">{{ $stats['total_pending'] }}</span>
                                    </div>
                                    <div class="desc"> Bekleyen Eşleştirmeler </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                                <div class="visual">
                                    <i class="fa fa-check-circle"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup"
                                            data-value="{{ $stats['total_matched'] }}">{{ $stats['total_matched'] }}</span>
                                    </div>
                                    <div class="desc"> Eşleşti (Kabul Bekliyor) </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a class="dashboard-stat dashboard-stat-v2 purple" href="#">
                                <div class="visual">
                                    <i class="fa fa-thumbs-up"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup"
                                            data-value="{{ $stats['total_accepted'] }}">{{ $stats['total_accepted'] }}</span>
                                    </div>
                                    <div class="desc"> Kabul Edildi </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                            <a class="dashboard-stat dashboard-stat-v2 red" href="#">
                                <div class="visual">
                                    <i class="fa fa-warning"></i>
                                </div>
                                <div class="details">
                                    <div class="number">
                                        <span data-counter="counterup"
                                            data-value="{{ $stats['total_failed'] }}">{{ $stats['total_failed'] }}</span>
                                    </div>
                                    <div class="desc"> Başarısız / Manuel İnceleme </div>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <!-- END DASHBOARD STATS 1-->

                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-dark">
                                <i class="icon-settings font-dark"></i>
                                <span class="caption-subject bold uppercase">Son Eşleştirme İşlemleri</span>
                            </div>
                            <div class="actions">
                                <form action="{{ route('admin.automation.run-all-pending') }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success"
                                        onclick="return confirm('Tüm bekleyen talepler için eşleştirme çalıştırılacak. Devam?')">
                                        <i class="fa fa-magic"></i> Tüm Bekleyenleri Eşleştir
                                    </button>
                                </form>
                                &nbsp;
                                <a href="{{ route('admin.automation.personnel') }}" class="btn btn-xs blue">Personel
                                    Verimlilik Analizi</a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            {{-- Filter Form --}}
                            <form method="GET" action="" class="form-inline" style="margin-bottom:15px;">
                                <select name="automation_status" class="form-control input-sm" style="margin-right:8px;">
                                    <option value="">Tüm Durumlar</option>
                                    <option value="pending_matching" {{ request('automation_status') == 'pending_matching' ? 'selected' : '' }}>Kuyrukta</option>
                                    <option value="matched" {{ request('automation_status') == 'matched' ? 'selected' : '' }}>
                                        Eşleşti</option>
                                    <option value="accepted" {{ request('automation_status') == 'accepted' ? 'selected' : '' }}>Kabul Edildi</option>
                                    <option value="failed" {{ request('automation_status') == 'failed' ? 'selected' : '' }}>
                                        Başarısız</option>
                                </select>
                                <input type="date" name="date_from" class="form-control input-sm"
                                    value="{{ request('date_from') }}" style="margin-right:5px;">
                                <input type="date" name="date_to" class="form-control input-sm"
                                    value="{{ request('date_to') }}" style="margin-right:8px;">
                                <button type="submit" class="btn btn-sm btn-default"><i class="fa fa-filter"></i>
                                    Filtrele</button>
                                <a href="{{ route('admin.automation.index') }}" class="btn btn-sm btn-default"
                                    style="margin-left:5px;">Temizle</a>
                            </form>
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Talep No</th>
                                        <th>Müşteri</th>
                                        <th>Hizmet</th>
                                        <th>Durum</th>
                                        <th>Atanan Personel</th>
                                        <th>Deneme</th>
                                        <th>Tarih</th>
                                        <th>Aksiyon</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentMatchings as $request)
                                        <tr>
                                            <td>{{ $request->request_number }}</td>
                                            <td>{{ $request->user->name ?? 'N/A' }}</td>
                                            <td>{{ $request->service->service_name ?? 'N/A' }}</td>
                                            <td>
                                                @if($request->automation_status == 'matched')
                                                    <span class="label label-success">Eşleşti</span>
                                                @elseif($request->automation_status == 'pending_matching')
                                                    <span class="label label-warning">Bekliyor</span>
                                                @elseif($request->automation_status == 'failed')
                                                    <span class="label label-danger">Başarısız</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($request->matchedPersonnel)
                                                    {{ $request->matchedPersonnel->name }} (ID:
                                                    {{ $request->matchedPersonnel->id }})
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $request->matching_attempts }} / 5</td>
                                            <td>{{ $request->updated_at->format('d.m.Y H:i') }}</td>
                                            <td>
                                                @if($request->automation_status == 'failed' || $request->automation_status == 'pending_matching')
                                                    <form action="{{ route('admin.automation.retry', $request->id) }}" method="POST"
                                                        style="display:inline;">
                                                        @csrf
                                                        <button type="submit" class="btn btn-xs yellow">Yeniden Dene</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-5 col-sm-5">
                                    <div class="dataTables_info">Toplam {{ $recentMatchings->total() }} kayıt gösteriliyor.
                                    </div>
                                </div>
                                <div class="col-md-7 col-sm-7 text-right">
                                    {{ $recentMatchings->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END CONTENT BODY -->
    </div>
@endsection