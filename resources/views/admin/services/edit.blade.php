@extends('admin.layouts.admin_layout')

@section('content')
    <div class="content-wrapper">
        <div class="page-content-wrapper">
            <div class="page-content">
                <div class="row">
                    <div class="col-lg-12">
                        <section class="content-header">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-9">
                                        <h1><i class="fa fa-pencil"></i>
                                            {{ $type == 'caregiver' ? 'Bakıcı Türü Düzenle' : 'Hizmet Düzenle' }}</h1>
                                    </div>
                                    <div class="col-md-3 text-right">
                                        <a href="{{ route('admin.services.index', ['type' => $type]) }}"
                                            class="btn btn-default">
                                            <i class="fa fa-arrow-left"></i> Geri Dön
                                        </a>
                                    </div>
                                </div>
                                <ul class="breadcrumb">
                                    <li><a href="{{ route('admin.home') }}"><i class="fa fa-dashboard"></i> Kontrol
                                            Paneli</a></li>
                                    <li><a href="{{ route('admin.services.index', ['type' => $type]) }}"><i
                                                class="fa fa-cogs"></i>
                                            {{ $type == 'caregiver' ? 'Bakıcı Türleri' : 'Hizmetler' }}</a></li>
                                    <li class="Aktif">Düzenle</li>
                                </ul>
                            </div>
                        </section>

                        <section class="content">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <form Action="{{ route('admin.services.update', $service->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')

                                        <div class="row">
                                            <div class="col-md-8">
                                                <div
                                                    class="form-group {{ $errors->has('service_name') ? 'has-error' : '' }}">
                                                    <label for="service_name">Hizmet Adı <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="service_name"
                                                        name="service_name"
                                                        value="{{ old('service_name', $service->service_name) }}" required>
                                                    @if($errors->has('service_name'))
                                                        <span class="text-danger">{{ $errors->first('service_name') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div
                                                    class="form-group {{ $errors->has('category_id') ? 'has-error' : '' }}">
                                                    <label for="category_id">Kategori <span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-control" id="category_id" name="category_id"
                                                        required>
                                                        <option value="">Kategori Seçin</option>
                                                        @foreach($categories as $category)
                                                            <option value="{{ $category->id }}" {{ old('category_id', $service->category_id) == $category->id ? 'selected' : '' }}>
                                                                {{ $category->category_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @if($errors->has('category_id'))
                                                        <span class="text-danger">{{ $errors->first('category_id') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group {{ $errors->has('service_desc') ? 'has-error' : '' }}">
                                            <label for="service_desc">Hizmet Açıklaması <span
                                                    class="text-danger">*</span></label>
                                            <textarea class="form-control" id="service_desc" name="service_desc" rows="5"
                                                required>{{ old('service_desc', $service->service_desc) }}</textarea>
                                            @if($errors->has('service_desc'))
                                                <span class="text-danger">{{ $errors->first('service_desc') }}</span>
                                            @endif
                                        </div>

                                        <div class="form-group {{ $errors->has('service_image') ? 'has-error' : '' }}">
                                            <label for="service_image">Hizmet Görseli</label>
                                            @if($service->service_image)
                                                <div class="mb-2">
                                                    <img src="{{ asset('uploads/services/' . $service->service_image) }}"
                                                        alt="{{ $service->service_name }}"
                                                        style="max-width: 200px; max-height: 150px;">
                                                    <br><small class="text-muted">Mevcut görsel</small>
                                                </div>
                                            @endif
                                            <input type="file" class="form-control" id="service_image" name="service_image"
                                                accept="image/*">
                                            <small class="text-muted">Yeni görsel yüklerseniz mevcut görsel
                                                değiştirilir.</small>
                                            @if($errors->has('service_image'))
                                                <span class="text-danger">{{ $errors->first('service_image') }}</span>
                                            @endif
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group {{ $errors->has('price') ? 'has-error' : '' }}">
                                                    <label for="price">Fiyat (TL)</label>
                                                    <input type="number" class="form-control" id="price" name="price"
                                                        value="{{ old('price', $service->price) }}" step="0.01" min="0">
                                                    @if($errors->has('price'))
                                                        <span class="text-danger">{{ $errors->first('price') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div
                                                    class="form-group {{ $errors->has('price_model') ? 'has-error' : '' }}">
                                                    <label for="price_model">Fiyatlandırma Modeli <span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-control" id="price_model" name="price_model"
                                                        required>
                                                        <option value="fixed" {{ old('price_model', $service->price_model) == 'fixed' ? 'selected' : '' }}>Sabit Fiyat
                                                        </option>
                                                        <option value="hourly" {{ old('price_model', $service->price_model) == 'hourly' ? 'selected' : '' }}>Saatlik
                                                            Ücret</option>
                                                        <option value="package" {{ old('price_model', $service->price_model) == 'package' ? 'selected' : '' }}>Paket
                                                            Fiyatı</option>
                                                    </select>
                                                    @if($errors->has('price_model'))
                                                        <span class="text-danger">{{ $errors->first('price_model') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div
                                                    class="form-group {{ $errors->has('duration_minutes') ? 'has-error' : '' }}">
                                                    <label for="duration_minutes">Tahmini Süre (Dakika)</label>
                                                    <input type="number" class="form-control" id="duration_minutes"
                                                        name="duration_minutes"
                                                        value="{{ old('duration_minutes', $service->duration_minutes) }}"
                                                        min="0">
                                                    @if($errors->has('duration_minutes'))
                                                        <span
                                                            class="text-danger">{{ $errors->first('duration_minutes') }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="sort_order">Sıralama</label>
                                                    <input type="number" class="form-control" id="sort_order"
                                                        name="sort_order"
                                                        value="{{ old('sort_order', $service->sort_order) }}" min="0">
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="is_active">Durum <span class="text-danger">*</span></label>
                                                    <select class="form-control" id="is_active" name="is_active" required>
                                                        <option value="1" {{ old('is_active', $service->is_active) == 1 ? 'selected' : '' }}>Aktif</option>
                                                        <option value="0" {{ old('is_active', $service->is_active) == 0 ? 'selected' : '' }}>Pasif</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="is_featured">Öne Çıkan</label>
                                                    <select class="form-control" id="is_featured" name="is_featured">
                                                        <option value="0" {{ old('is_featured', $service->is_featured) == 0 ? 'selected' : '' }}>Hayır</option>
                                                        <option value="1" {{ old('is_featured', $service->is_featured) == 1 ? 'selected' : '' }}>Evet</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-save"></i> Güncelle
                                            </button>
                                            <a href="{{ route('admin.services.index', ['type' => $type]) }}"
                                                class="btn btn-default">
                                                <i class="fa fa-times"></i> İptal
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection