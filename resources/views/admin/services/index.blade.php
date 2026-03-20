@extends('admin.layouts.admin_layout')

@section('content')
    <div class="content-wrapper">
        <div class="page-content-wrapper">
            <div class="page-content">
                @if(session()->has('message.added'))
                    <div class="alert alert-success fade in">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        {!! session('message.content') !!}
                    </div>
                @endif
                @if(session()->has('message.updated'))
                    <div class="alert alert-success fade in">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        {!! session('message.content') !!}
                    </div>
                @endif

                <div class="row">
                    <div class="col-lg-12">
                        <section class="content-header">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-9">
                                        <h1><i class="fa fa-cogs"></i>
                                            {{ $type == 'caregiver' ? 'Bakıcı Türleri' : 'Hizmetler' }}</h1>
                                    </div>
                                    <div class="col-md-3 text-right">
                                        <a href="{{ route('admin.services.create', ['type' => $type]) }}"
                                            class="btn btn-primary">
                                            <i class="fa fa-plus"></i>
                                            {{ $type == 'caregiver' ? 'Yeni Bakıcı Türü Ekle' : 'Yeni Hizmet Ekle' }}
                                        </a>
                                    </div>
                                </div>
                                <ul class="breadcrumb">
                                    <li><a href="{{ route('admin.home') }}"><i class="fa fa-dashboard"></i> Kontrol
                                            Paneli</a></li>
                                    <li class="Aktif"><i class="fa fa-cogs"></i>
                                        {{ $type == 'caregiver' ? 'Bakıcı Türleri' : 'Hizmetler' }}</li>
                                </ul>
                            </div>
                        </section>

                        <section class="content">
                            <div class="panel-body">
                                <table class="table table-striped table-bordered" id="servicesTable">
                                    <thead>
                                        <tr>
                                            <th width="5%">ID</th>
                                            <th width="10%">Görsel</th>
                                            <th width="20%">Hizmet Adı</th>
                                            <th width="15%">Kategori</th>
                                            <th width="10%">Fiyat</th>
                                            <th width="8%">Süre</th>
                                            <th width="7%">Öne Çıkan</th>
                                            <th width="7%">Durum</th>
                                            <th width="8%">Talepler</th>
                                            <th width="10%">İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($services as $service)
                                            <tr id="row-{{ $service->id }}">
                                                <td>{{ $service->id }}</td>
                                                <td>
                                                    @if($service->service_image)
                                                        <img src="{{ asset('uploads/services/' . $service->service_image) }}"
                                                            alt="{{ $service->service_name }}"
                                                            style="max-width: 60px; max-height: 45px;">
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <strong>{{ $service->service_name }}</strong>
                                                    <br><small
                                                        class="text-muted">{{ \Illuminate\Support\Str::limit($service->service_desc, 50) }}</small>
                                                </td>
                                                <td>
                                                    @if($service->category)
                                                        <span
                                                            class="label label-info">{{ $service->category->category_name }}</span>
                                                    @else
                                                        <span class="text-muted">-</span>
                                                    @endif
                                                </td>
                                                <td>{{ $service->getFormattedPrice() }}</td>
                                                <td>{{ $service->getFormattedDuration() }}</td>
                                                <td>
                                                    <button
                                                        class="btn btn-xs {{ $service->is_featured ? 'btn-warning' : 'btn-default' }}"
                                                        onclick="toggleFeatured({{ $service->id }})" title="Öne Çıkan">
                                                        <i class="fa fa-star"></i>
                                                    </button>
                                                </td>
                                                <td>
                                                    <button
                                                        class="btn btn-xs {{ $service->is_active ? 'btn-success' : 'btn-danger' }}"
                                                        onclick="toggleStatus({{ $service->id }})">
                                                        {{ $service->is_active ? 'Aktif' : 'Pasif' }}
                                                    </button>
                                                </td>
                                                <td>
                                                    <span class="badge badge-primary">{{ $service->requests_count }}</span>
                                                </td>
                                                <td>
                                                    <a href="{{ route('admin.services.edit', $service->id) }}"
                                                        class="btn btn-xs btn-primary" title="Düzenle">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                    <button class="btn btn-xs btn-danger"
                                                        onclick="deleteService({{ $service->id }})" title="Sil">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#servicesTable').DataTable({
                "Language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Turkish.json"
                },
                "order": [[0, "desc"]]
            });
        });

        function toggleStatus(id) {
            $.ajax({
                url: '{{ url("admin/services") }}/' + id + '/toggle-status',
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

        function toggleFeatured(id) {
            $.ajax({
                url: '{{ url("admin/services") }}/' + id + '/toggle-featured',
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

        function deleteService(id) {
            if (confirm('Bu hizmeti silmek istediğinizden emin misiniz?')) {
                $.ajax({
                    url: '{{ url("admin/services") }}/' + id,
                    type: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function (response) {
                        if (response.success) {
                            $('#row-' + id).fadeOut(function () {
                                $(this).remove();
                            });
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