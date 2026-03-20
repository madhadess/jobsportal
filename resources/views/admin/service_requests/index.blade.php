@extends('admin.layouts.admin_layout')

@section('content')
    <style>
        .admin-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px 0;
            color: white;
            margin-bottom: 30px;
        }

        .admin-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0;
        }

        .admin-filters {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        .admin-filters select {
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            padding: 10px 12px;
            margin-right: 10px;
        }

        .admin-table-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .admin-table {
            margin: 0;
        }

        .admin-table thead {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .admin-table thead th {
            border: none;
            padding: 15px;
            font-weight: 600;
        }

        .admin-table tbody tr {
            border-bottom: 1px solid #f0f0f0;
        }

        .admin-table tbody tr:hover {
            background: #f9f9f9;
        }

        .admin-table tbody td {
            padding: 15px;
            vertical-align: middle;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-approved {
            background: #d1ecf1;
            color: #0c5460;
        }

        .status-in_progress {
            background: #cfe2ff;
            color: #084298;
        }

        .status-completed {
            background: #d1e7dd;
            color: #0f5132;
        }

        .status-cancelled {
            background: #f8d7da;
            color: #842029;
        }

        .btn-Action {
            padding: 6px 12px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s;
        }

        .btn-view {
            background: #e8f0fe;
            color: #667eea;
        }

        .btn-view:hover {
            background: #667eea;
            color: white;
        }

        .btn-approve {
            background: #d1e7dd;
            color: #0f5132;
        }

        .btn-approve:hover {
            background: #0f5132;
            color: white;
        }

        .pagination {
            margin-top: 20px;
        }
    </style>

    <div class="content-wrapper">
        <div class="page-content-wrapper">
            <div class="page-content">
                @if(session()->has('message.updated'))
                    <div class="alert alert-success fade in"
                        style="background: #d1e7dd; color: #0f5132; border: 1px solid #0f5132;">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        {!! session('message.content') !!}
                    </div>
                @endif

                <!-- Header -->
                <div class="admin-header">
                    <div class="container-fluid">
                        <h1><i class="fa fa-list-alt"></i>
                            {{ $type == 'caregiver' ? 'Bakıcı Talepleri Yönetimi' : 'Hizmet Talepleri Yönetimi' }}</h1>
                        <p style="margin: 5px 0 0 0; opacity: 0.9;">Müşteri {{ $type == 'caregiver' ? 'bakıcı' : 'hizmet' }}
                            taleplerini yönetin ve durumlarını güncelleyin</p>
                    </div>
                </div>

                <div class="container-fluid">
                    <!-- Filters -->
                    <div class="admin-filters">
                        <form method="GET" Action="{{ route('admin.service-requests.index') }}" class="form-inline">
                            <input type="hidden" name="type" value="{{ $type }}">
                            <select name="status" class="form-control" onchange="this.form.submit()">
                                <option value="">📊 Tüm Durumlar</option>
                                @foreach($statusLabels as $key => $label)
                                    <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>{{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            <select name="service_id" class="form-control" onchange="this.form.submit()">
                                <option value="">🔧 Tüm Hizmetler</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" {{ request('service_id') == $service->id ? 'selected' : '' }}>{{ $service->service_name }}</option>
                                @endforeach
                            </select>
                        </form>
                    </div>

                    <!-- Table -->
                    <div class="admin-table-card">
                        <table class="table admin-table" id="requestsTable">
                            <thead>
                                <tr>
                                    <th width="10%"><i class="fa fa-hashtag"></i> Talep No</th>
                                    <th width="15%"><i class="fa fa-user"></i> Müşteri</th>
                                    <th width="15%"><i class="fa fa-wrench"></i> Hizmet</th>
                                    <th width="12%"><i class="fa fa-phone"></i> Telefon</th>
                                    <th width="15%"><i class="fa fa-map-marker"></i> Adres</th>
                                    <th width="10%"><i class="fa fa-calendar"></i> Tercih Tarihi</th>
                                    <th width="10%"><i class="fa fa-info-circle"></i> Durum</th>
                                    <th width="8%"><i class="fa fa-clock"></i> Tarih</th>
                                    <th width="8%"><i class="fa fa-cog"></i> İşlemler</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($requests as $request)
                                    <tr id="row-{{ $request->id }}">
                                        <td><strong style="color: #667eea;">{{ $request->request_number }}</strong></td>
                                        <td>
                                            @if($request->user)
                                                <strong>{{ $request->user->getName() ?: $request->user->email }}</strong>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($request->service)
                                                {{ $request->service->service_name }}
                                            @elseif($request->category)
                                                <span class="badge badge-info">{{ $request->category->category_name }}</span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td><strong>{{ $request->customer_phone }}</strong></td>
                                        <td>
                                            <small>{{ \Illuminate\Support\Str::limit($request->customer_address, 30) }}</small>
                                            <br><small
                                                class="text-muted">{{ $request->customer_district }}/{{ $request->customer_city }}</small>
                                        </td>
                                        <td>
                                            <strong>{{ $request->getFormattedDate() }}</strong>
                                            <br><small class="text-muted">{{ $request->getFormattedTime() }}</small>
                                        </td>
                                        <td>
                                            <span class="status-badge status-{{ $request->status }}">
                                                {{ $request->getStatusLabel() }}
                                            </span>
                                        </td>
                                        <td>
                                            <small>{{ $request->created_at->format('d.m.Y') }}</small>
                                            <br><small class="text-muted">{{ $request->created_at->format('H:i') }}</small>
                                        </td>
                                        <td>
                                            <a href="{{ route('admin.service-requests.show', $request->id) }}"
                                                class="btn btn-Action btn-view" title="Detayları Görüntüle">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            @if($request->status == 'pending')
                                                @php
                                                    $isCaregiver = $request->category && $request->category->type == 'caregiver';
                                                    $canApprove = $isCaregiver
                                                        ? (APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('approve_caregiver_requests'))
                                                        : (APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('approve_service_requests'));
                                                @endphp
                                                @if($canApprove)
                                                    <button class="btn btn-Action btn-approve"
                                                        onclick="approveRequest({{ $request->id }})" title="Onayla">
                                                        <i class="fa fa-check"></i>
                                                    </button>
                                                @endif
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center" style="padding: 40px;">
                                            <i class="fa fa-inbox"
                                                style="font-size: 48px; color: #ddd; margin-bottom: 10px; display: block;"></i>
                                            <strong
                                                style="color: #999;">{{ $type == 'caregiver' ? 'Bakıcı talebi' : 'Hizmet talebi' }}
                                                bulunamadı</strong>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="text-center" style="padding: 20px;">
                            {{ $requests->appends(request()->query())->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function approveRequest(id) {
            if (confirm('Bu talebi onaylamak istediğinizden emin misiniz?')) {
                $.ajax({
                    url: '{{ url("admin/service-requests") }}/' + id + '/approve',
                    type: 'POST',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function (response) {
                        if (response.success) {
                            location.reload();
                        }
                    },
                    error: function () {
                        alert('Bir hata oluştu!');
                    }
                });
            }
        }
    </script>
@endpush