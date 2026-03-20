@extends('admin.layouts.admin_layout')

@section('content')
    <style>
        .addon-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px 0;
            color: white;
            margin-bottom: 30px;
        }

        .addon-header h1 {
            font-size: 28px;
            font-weight: 700;
            margin: 0;
        }

        .addon-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }

        .addon-card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 20px;
            font-weight: 600;
        }

        .addon-card-body {
            padding: 20px;
        }

        .addon-table {
            margin: 0;
        }

        .addon-table thead {
            background: #f9f9f9;
        }

        .addon-table th {
            padding: 12px 15px;
            font-weight: 600;
            color: #1a1a1a;
        }

        .addon-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #f0f0f0;
        }

        .addon-image {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 4px;
        }

        .btn-Action {
            padding: 6px 12px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s;
        }

        .btn-edit {
            background: #e8f0fe;
            color: #667eea;
        }

        .btn-edit:hover {
            background: #667eea;
            color: white;
        }

        .btn-delete {
            background: #f8d7da;
            color: #842029;
        }

        .btn-delete:hover {
            background: #842029;
            color: white;
        }

        .btn-add-new {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
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
                <div class="addon-header">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-9">
                                <h1><i class="fa fa-plus-circle"></i> Ek Hizmetler Yönetimi</h1>
                                <p style="margin: 5px 0 0 0; opacity: 0.9;">{{ $service->service_name }} için ek hizmetleri
                                    yönetin</p>
                            </div>
                            <div class="col-md-3 text-right">
                                <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-light"
                                    style="color: #667eea;">
                                    <i class="fa fa-arrow-left"></i> Geri Dön
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid">
                    <!-- Add New Addon -->
                    <div class="addon-card">
                        <div class="addon-card-header">
                            <i class="fa fa-plus"></i> Yeni Ek Hizmet Ekle
                        </div>
                        <div class="addon-card-body">
                            <form Action="{{ route('admin.service-add-ons.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="service_id" value="{{ $service->id }}">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="addon_name">Ek Hizmet Adı *</label>
                                            <input type="text" class="form-control" id="addon_name" name="addon_name"
                                                placeholder="Örn: Ütü, Avize Temizliği" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="addon_price">Fiyat (TL) *</label>
                                            <input type="number" class="form-control" id="addon_price" name="addon_price"
                                                placeholder="250" step="0.01" min="0" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="addon_description">Açıklama</label>
                                    <textarea class="form-control" id="addon_description" name="addon_description" rows="3"
                                        placeholder="Ek hizmetin açıklaması"></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="addon_image">Görsel</label>
                                    <input type="file" class="form-control" id="addon_image" name="addon_image"
                                        accept="image/*">
                                    <small class="text-muted">Önerilen boyut: 200x120px</small>
                                </div>

                                <button type="submit" class="btn-add-new">
                                    <i class="fa fa-save"></i> Ekle
                                </button>
                            </form>
                        </div>
                    </div>

                    <!-- Addons List -->
                    <div class="addon-card">
                        <div class="addon-card-header">
                            <i class="fa fa-list"></i> Mevcut Ek Hizmetler
                        </div>
                        <div class="addon-card-body">
                            <table class="table addon-table">
                                <thead>
                                    <tr>
                                        <th width="10%">Görsel</th>
                                        <th width="25%">Adı</th>
                                        <th width="35%">Açıklama</th>
                                        <th width="15%">Fiyat</th>
                                        <th width="15%">İşlemler</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($addons as $addon)
                                        <tr>
                                            <td>
                                                @if($addon->addon_image)
                                                    <img src="{{ asset('uploads/addons/' . $addon->addon_image) }}"
                                                        alt="{{ $addon->addon_name }}" class="addon-image">
                                                @else
                                                    <div
                                                        style="width: 50px; height: 50px; background: #f0f0f0; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: #999;">
                                                        <i class="fa fa-image"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td><strong>{{ $addon->addon_name }}</strong></td>
                                            <td><small>{{ \Illuminate\Support\Str::limit($addon->addon_description, 50) }}</small>
                                            </td>
                                            <td><strong
                                                    style="color: #667eea;">₺{{ number_format($addon->addon_price, 2) }}</strong>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.service-add-ons.edit', $addon->id) }}"
                                                    class="btn-Action btn-edit">
                                                    <i class="fa fa-edit"></i> Düzenle
                                                </a>
                                                <button class="btn-Action btn-delete" onclick="deleteAddon({{ $addon->id }})">
                                                    <i class="fa fa-trash"></i> Sil
                                                </button>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" style="text-align: center; padding: 40px; color: #999;">
                                                <i class="fa fa-inbox"
                                                    style="font-size: 48px; margin-bottom: 10px; display: block;"></i>
                                                <strong>Henüz ek hizmet eklenmemiştir</strong>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function deleteAddon(id) {
            if (confirm('Bu ek hizmeti silmek istediğinizden emin misiniz?')) {
                $.ajax({
                    url: '{{ url("admin/service-add-ons") }}/' + id,
                    type: 'DELETE',
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