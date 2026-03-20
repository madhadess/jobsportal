@extends('layouts.app')

@section('content')
@include('includes.header')
@include('includes.inner_page_title', ['page_title' => 'İlan Düzenle'])
<div class="listpgWraper">
    <div class="container">
<div class="create-post-page">
    <div class="form-header">
        <a href="{{ route('job-posts.show', $post->id) }}" class="back-link"><i class="fa fa-arrow-left"></i> İlan Detayı</a>
        <h1>İlanı Düzenle</h1>
    </div>

    <form action="{{ route('job-posts.update', $post->id) }}" method="POST" id="postForm">
        @csrf
        @method('PUT')

        <div class="form-sections">
            {{-- SECTION: Temel Bilgiler --}}
            <div class="form-section">
                <div class="section-title"><i class="fa fa-info-circle"></i> Temel Bilgiler</div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group-item">
                            <label>Başlık <span class="req">*</span></label>
                            <input type="text" name="title" class="form-ctrl" value="{{ old('title', $post->title) }}"
                                placeholder="Örn: Yaşlı Bakım Personeli Arıyorum" maxlength="200" required>
                            @error('title')<span class="err">{{ $message }}</span>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group-item">
                            <label>İlan Türü <span class="req">*</span></label>
                            <select name="category_type" class="form-ctrl" required>
                                <option value="service" {{ old('category_type', $post->category_type) == 'service' ? 'selected' : '' }}>🔧 Hizmet Personeli</option>
                                <option value="caregiver" {{ old('category_type', $post->category_type) == 'caregiver' ? 'selected' : '' }}>🧑‍⚕️ Bakıcı</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group-item">
                            <label>Kategori</label>
                            <select name="category_id" class="form-ctrl">
                                <option value="">Seçiniz</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}" {{ old('category_id', $post->category_id) == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->category_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION: Lokasyon --}}
            <div class="form-section">
                <div class="section-title"><i class="fa fa-map-marker"></i> Lokasyon</div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group-item">
                            <label>İl</label>
                            <select name="state_id" class="form-ctrl" id="stateSelect">
                                <option value="">Seçiniz</option>
                                @foreach($states as $state)
                                    <option value="{{ $state->state_id }}" {{ old('state_id', $post->state_id) == $state->state_id ? 'selected' : '' }}>
                                        {{ $state->state }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group-item">
                            <label>İlçe</label>
                            <select name="city_id" class="form-ctrl" id="citySelect">
                                @if($post->city)
                                    <option value="{{ $post->city_id }}" selected>{{ $post->city->city }}</option>
                                @else
                                    <option value="">Önce İl Seçiniz</option>
                                @endif
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- SECTION: Çalışma Koşulları --}}
            <div class="form-section">
                <div class="section-title"><i class="fa fa-briefcase"></i> Çalışma Koşulları</div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group-item">
                            <label>Çalışma Tipi <span class="req">*</span></label>
                            <select name="work_type" class="form-ctrl" required>
                                @foreach($workTypes as $key => $label)
                                    <option value="{{ $key }}" {{ old('work_type', $post->work_type) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group-item">
                            <label>Çalışma Başlangıç Saati</label>
                            <input type="time" name="work_hours_start" class="form-ctrl"
                                value="{{ old('work_hours_start', $post->work_hours_start ? substr($post->work_hours_start, 0, 5) : '09:00') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group-item">
                            <label>Çalışma Bitiş Saati</label>
                            <input type="time" name="work_hours_end" class="form-ctrl"
                                value="{{ old('work_hours_end', $post->work_hours_end ? substr($post->work_hours_end, 0, 5) : '18:00') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group-item">
                            <label>Min. Deneyim (Yıl)</label>
                            <input type="number" name="min_experience_years" class="form-ctrl"
                                value="{{ old('min_experience_years', $post->min_experience_years) }}" min="0" max="50">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group-item">
                            <label>Ücret Min (₺)</label>
                            <input type="number" name="salary_min" class="form-ctrl"
                                value="{{ old('salary_min', $post->salary_min) }}" min="0" step="100">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group-item">
                            <label>Ücret Max (₺)</label>
                            <input type="number" name="salary_max" class="form-ctrl"
                                value="{{ old('salary_max', $post->salary_max) }}" min="0" step="100">
                        </div>
                    </div>
                </div>

                <div class="row" style="margin-top:10px;">
                    <div class="col-md-6">
                        <label class="checkbox-label">
                            <input type="checkbox" name="requires_certificate" value="1"
                                {{ old('requires_certificate', $post->requires_certificate) ? 'checked' : '' }}>
                            <span>Sertifika / Belge Gerekiyor</span>
                        </label>
                    </div>
                    <div class="col-md-6">
                        <label class="checkbox-label">
                            <input type="checkbox" name="requires_reference" value="1"
                                {{ old('requires_reference', $post->requires_reference) ? 'checked' : '' }}>
                            <span>Referans Zorunlu</span>
                        </label>
                    </div>
                </div>
            </div>

            {{-- SECTION: Gereksinimler --}}
            <div class="form-section">
                <div class="section-title"><i class="fa fa-list"></i> Gereksinimler</div>
                <div id="requirementsList">
                    @if($post->requirements->isNotEmpty())
                        @foreach($post->requirements as $i => $req)
                            <div class="requirement-row" data-index="{{ $i }}">
                                <select name="requirements[{{ $i }}][type]" class="form-ctrl" style="width:180px; display:inline-block; margin-right:8px;">
                                    <option value="certificate" {{ $req->requirement_type == 'certificate' ? 'selected' : '' }}>Sertifika</option>
                                    <option value="language" {{ $req->requirement_type == 'language' ? 'selected' : '' }}>Dil</option>
                                    <option value="skill" {{ $req->requirement_type == 'skill' ? 'selected' : '' }}>Beceri</option>
                                    <option value="document" {{ $req->requirement_type == 'document' ? 'selected' : '' }}>Belge</option>
                                </select>
                                <input type="text" name="requirements[{{ $i }}][value]" class="form-ctrl"
                                    style="width:280px; display:inline-block;" value="{{ $req->requirement_value }}">
                                <label style="margin-left:8px;">
                                    <input type="checkbox" name="requirements[{{ $i }}][is_mandatory]" value="1"
                                        {{ $req->is_mandatory ? 'checked' : '' }}> Zorunlu
                                </label>
                                <button type="button" onclick="this.parentNode.remove()" class="btn btn-xs btn-danger" style="margin-left:8px;">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        @endforeach
                    @else
                        <div class="requirement-row" data-index="0">
                            <select name="requirements[0][type]" class="form-ctrl" style="width:180px; display:inline-block; margin-right:8px;">
                                <option value="certificate">Sertifika</option>
                                <option value="language">Dil</option>
                                <option value="skill">Beceri</option>
                                <option value="document">Belge</option>
                            </select>
                            <input type="text" name="requirements[0][value]" class="form-ctrl" style="width:280px; display:inline-block;" placeholder="Örn: İlk Yardım Sertifikası">
                            <label style="margin-left:8px;">
                                <input type="checkbox" name="requirements[0][is_mandatory]" value="1" checked> Zorunlu
                            </label>
                        </div>
                    @endif
                </div>
                <button type="button" class="btn btn-sm btn-default" onclick="addRequirement()" style="margin-top:10px;">
                    <i class="fa fa-plus"></i> Gereksinim Ekle
                </button>
            </div>

            {{-- SECTION: Açıklama --}}
            <div class="form-section">
                <div class="section-title"><i class="fa fa-file-text"></i> İlan Açıklaması</div>
                <textarea name="description" class="form-ctrl" rows="6" maxlength="5000"
                    placeholder="Aradığınız kişinin özellikleri, görevler, özel koşullar...">{{ old('description', $post->description) }}</textarea>
            </div>
        </div>

        <div class="submit-bar">
            <a href="{{ route('job-posts.show', $post->id) }}" class="btn-cancel">
                <i class="fa fa-times"></i> Vazgeç
            </a>
            <button type="submit" class="btn-publish">
                <i class="fa fa-save"></i> Değişiklikleri Kaydet
            </button>
        </div>
    </form>
</div>

<style>
.create-post-page { max-width:820px; margin:0 auto; padding:25px 20px; }
.form-header { margin-bottom:25px; }
.back-link { color:#667eea; text-decoration:none; font-size:14px; }
.form-header h1 { margin:8px 0 0; font-size:22px; font-weight:700; }
.form-sections { display:flex; flex-direction:column; gap:20px; }
.form-section { background:#fff; border-radius:12px; padding:22px; box-shadow:0 2px 12px rgba(0,0,0,.06); }
.section-title { font-weight:700; font-size:15px; margin-bottom:18px; color:#374151; border-bottom:1px solid #f0f0f0; padding-bottom:10px; }
.form-group-item { margin-bottom:15px; }
.form-group-item label { display:block; font-weight:600; font-size:13px; margin-bottom:6px; color:#374151; }
.form-ctrl { width:100%; padding:10px 14px; border:1px solid #e5e7eb; border-radius:8px; font-size:14px; }
.form-ctrl:focus { border-color:#667eea; outline:none; box-shadow:0 0 0 3px rgba(102,126,234,.1); }
.req { color:#dc3545; }
.err { color:#dc3545; font-size:12px; }
.checkbox-label { display:flex; align-items:center; gap:8px; font-size:14px; cursor:pointer; padding:8px 0; }
.requirement-row { display:flex; align-items:center; gap:8px; margin-bottom:10px; flex-wrap:wrap; }
.submit-bar { display:flex; gap:12px; justify-content:flex-end; margin-top:25px; }
.btn-cancel { padding:12px 24px; border:2px solid #6b7280; background:#fff; color:#374151; border-radius:8px; font-weight:600; text-decoration:none; display:inline-flex; align-items:center; gap:6px; }
.btn-publish { padding:12px 28px; background:linear-gradient(135deg,#667eea,#764ba2); color:#fff; border:none; border-radius:8px; font-weight:700; cursor:pointer; }
.btn-publish:hover { opacity:.9; }
</style>

<script>
var reqIndex = {{ $post->requirements->count() }};
function addRequirement() {
    var html = '<div class="requirement-row">' +
        '<select name="requirements[' + reqIndex + '][type]" class="form-ctrl" style="width:180px;display:inline-block;margin-right:8px;">' +
        '<option value="certificate">Sertifika</option><option value="language">Dil</option><option value="skill">Beceri</option><option value="document">Belge</option>' +
        '</select>' +
        '<input type="text" name="requirements[' + reqIndex + '][value]" class="form-ctrl" style="width:280px;display:inline-block;" placeholder="Örn: İlk Yardım Sertifikası">' +
        '<label style="margin-left:8px;"><input type="checkbox" name="requirements[' + reqIndex + '][is_mandatory]" value="1" checked> Zorunlu</label>' +
        '<button type="button" onclick="this.parentNode.remove()" class="btn btn-xs btn-danger" style="margin-left:8px;"><i class="fa fa-times"></i></button>' +
        '</div>';
    document.getElementById('requirementsList').insertAdjacentHTML('beforeend', html);
    reqIndex++;
}

// Load cities
var preselectedCityId = {{ $post->city_id ?? 'null' }};
var preselectedCityName = "{{ $post->city ? $post->city->city : '' }}";

document.getElementById('stateSelect').addEventListener('change', function () {
    var stateId = this.value;
    var citySelect = document.getElementById('citySelect');
    citySelect.innerHTML = '<option value="">Yükleniyor...</option>';
    if (!stateId) { citySelect.innerHTML = '<option value="">Önce İl Seçiniz</option>'; return; }
    fetch('{{ route("job-posts.get-cities") }}?state_id=' + stateId)
        .then(r => r.json())
        .then(function (data) {
            var html = '<option value="">İlçe Seçiniz</option>';
            data.forEach(function (c) {
                var selected = (c.city_id == preselectedCityId) ? ' selected' : '';
                html += '<option value="' + c.city_id + '"' + selected + '>' + c.name + '</option>';
            });
            citySelect.innerHTML = html;
        });
});
</script>
    </div>
</div>
@include('includes.footer')
@endsection
