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

        .btn-save {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
        }

        .img-preview {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
            margin-top: 10px;
            border: 1px solid #ddd;
        }
    </style>

    <div class="content-wrapper">
        <div class="page-content-wrapper">
            <div class="page-content">
                @if(session()->has('message.updated'))
                    <div class="alert alert-success fade in">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        {!! session('message.content') !!}
                    </div>
                @endif

                <!-- Header -->
                <div class="addon-header">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-9">
                                <h1><i class="fa fa-edit"></i> Ek Hizmet Düzenle</h1>
                                <p style="margin: 5px 0 0 0; opacity: 0.9;">{{ $service->service_name }} hizmeti için ek
                                    hizmeti düzenliyorsunuz</p>
                            </div>
                            <div class="col-md-3 text-right">
                                <a href="{{ route('admin.service-add-ons.index', $service->id) }}" class="btn btn-light"
                                    style="color: #667eea;">
                                    <i class="fa fa-arrow-left"></i> Geri Dön
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid">
                    <div class="addon-card">
                        <div class="addon-card-header">
                            <i class="fa fa-pencil"></i> Ek Hizmet Bilgileri
                        </div>
                        <div class="addon-card-body">
                            <form action="{{ route('admin.service-add-ons.update', $addon->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="addon_name">Ek Hizmet Adı *</label>
                                            <input type="text" class="form-control" id="addon_name" name="addon_name"
                                                value="{{ $addon->addon_name }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="addon_price">Fiyat (TL) *</label>
                                            <input type="number" class="form-control" id="addon_price" name="addon_price"
                                                value="{{ $addon->addon_price }}" step="0.01" min="0" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="addon_description">Açıklama</label>
                                    <textarea class="form-control" id="addon_description" name="addon_description"
                                        rows="3">{{ $addon->addon_description }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="addon_image">Görsel</label>
                                    <input type="file" class="form-control" id="addon_image" name="addon_image"
                                        accept="image/*">
                                    <small class="text-muted">Değiştirmek istemiyorsanız boş bırakın. Önerilen boyut:
                                        200x120px</small>
                                    @if($addon->addon_image)
                                        <div>
                                            <img src="{{ asset('uploads/addons/' . $addon->addon_image) }}" alt="Current Image"
                                                class="img-preview">
                                        </div>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label>Durum</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_active" id="active" value="1"
                                            {{ $addon->is_active ? 'checked' : '' }}>
                                        <label class="form-check-label" for="active">Aktif</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="is_active" id="passive" value="0"
                                            {{ !$addon->is_active ? 'checked' : '' }}>
                                        <label class="form-check-label" for="passive">Pasif</label>
                                    </div>
                                </div>

                                <button type="submit" class="btn-save">
                                    <i class="fa fa-save"></i> Değişiklikleri Kaydet
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection