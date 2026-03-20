@extends('admin.layouts.admin_layout')
@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li> <a href="{{ route('admin.home') }}">Ana Sayfa</a> <i class="fa fa-circle"></i> </li>
                    <li> <a href="{{ route('admin.automation.index') }}">Otomatik Eşleştirme</a> <i
                            class="fa fa-circle"></i> </li>
                    <li> <span>Personel Performans Analizi</span> </li>
                </ul>
            </div>
            <h3 class="page-title"> Personel Performansı <small>Otomatik Atama Uygunluğu ve Verimlilik</small> </h3>

            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-dark">
                                <i class="fa fa-users font-dark"></i>
                                <span class="caption-subject bold uppercase"> Aktif Atama Havuzundaki Personeller</span>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Ad Soyad</th>
                                        <th>Ort. Puan</th>
                                        <th>Şehir</th>
                                        <th>Hizmetler</th>
                                        <th>Aktif Görev</th>
                                        <th>Günlük Limit</th>
                                        <th>Tamamlanan</th>
                                        <th>Son Görev</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($personnel as $user)
                                        <tr>
                                            <td>{{ $user->id }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>
                                                <div class="label label-info">{{ number_format($user->average_rating, 1) }} /
                                                    5.0</div>
                                            </td>
                                            <td>
                                                @if(!empty($user->work_locations))
                                                    <small>{{ count($user->work_locations) }} Bölge Tanımlı</small>
                                                @else
                                                    <span class="text-danger">Tüm Bölgeler</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if(!empty($user->service_types))
                                                    <small>{{ count($user->service_types) }} Hizmet Tanımlı</small>
                                                @else
                                                    <span class="text-danger">Tüm Hizmetler</span>
                                                @endif
                                            </td>
                                            <td>{{ $user->current_active_tasks }}</td>
                                            <td>{{ $user->max_daily_tasks }}</td>
                                            <td>{{ $user->matched_requests_count }}</td>
                                            <td>{{ $user->last_task_date ? $user->last_task_date->format('d.m.Y') : '-' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-7 col-sm-7 text-right">
                                    {{ $personnel->appends(request()->query())->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection