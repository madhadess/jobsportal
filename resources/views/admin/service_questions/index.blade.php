@extends('admin.layouts.admin_layout')
@section('title', $category->category_name . ' - Sorular')
@section('breadcrumb')
    <div class="breadcrumb-item"><a href="{{ route('admin.service-categories.index') }}">Kategoriler</a></div>
    <div class="breadcrumb-item active">Sorular</div>
@endsection
@section('content')
    <div class="content-wrapper">
        <div class="page-content-wrapper">
            <div class="page-content">
                <div class="row">
                    <div class="col-lg-12">
                         <h1 class="page-header">{{ $category->category_name }} - Soru Yönetimi</h1>
                    </div>
                </div>
                
                <div class="row">
                    <!-- Form Section -->
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-plus"></i> Yeni Soru Ekle</h3>
                            </div>
                            <div class="panel-body">
                                <form action="{{ route('admin.service-questions.store', $category->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <label>Soru Metni</label>
                                        <input type="text" name="question" class="form-control" required placeholder="Örn: Kaç personel lazım?">
                                    </div>
                                    <div class="form-group">
                                        <label>Soru Tipi</label>
                                        <select name="type" class="form-control" id="questionType">
                                            <option value="radio">Tek Seçim (Radio)</option>
                                            <option value="checkbox">Çoklu Seçim (Checkbox)</option>
                                            <option value="text">Kısa Metin</option>
                                            <option value="textarea">Uzun Metin</option>
                                            <option value="number">Sayı</option>
                                            <option value="date">Tarih</option>
                                            <option value="time">Saat</option>
                                        </select>
                                    </div>
                                    <div class="form-group" id="optionsGroup">
                                        <label>Seçenekler (Virgülle Ayırın)</label>
                                        <textarea name="options" class="form-control" placeholder="Örn: 1, 2, 3, 4"></textarea>
                                        <small class="text-muted">Sadece seçimli sorular için.</small>
                                    </div>
                                    <div class="form-group">
                                        <label>Sıra No</label>
                                        <input type="number" name="sort_order" class="form-control" value="0">
                                    </div>
                                    <div class="form-group">
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="is_required" checked> Zorunlu Alan
                                            </label>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block">Ekle</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- List Section -->
                    <div class="col-md-8">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-list"></i> Mevcut Sorular</h3>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th width="10%">Sıra</th>
                                                <th width="30%">Soru</th>
                                                <th width="15%">Tip</th>
                                                <th width="35%">Seçenekler</th>
                                                <th width="10%">İşlem</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($questions as $q)
                                                <tr>
                                                    <td>{{ $q->sort_order }}</td>
                                                    <td>{{ $q->question }} @if($q->is_required) <span class="text-danger">*</span> @endif</td>
                                                    <td><span class="label label-info">{{ $q->type }}</span></td>
                                                    <td>
                                                        @foreach($q->options as $opt)
                                                            <span class="label label-default">{{ $opt->option_text }}</span>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        <form action="{{ route('admin.service-questions.destroy', $q->id) }}" method="POST" onsubmit="return confirm('Silmek istediğinize emin misiniz?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            @if($questions->isEmpty())
                                                <tr>
                                                    <td colspan="5" class="text-center">Henüz soru eklenmemiş.</td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('questionType').addEventListener('change', function () {
            const val = this.value;
            const opts = document.getElementById('optionsGroup');
            if (val === 'radio' || val === 'checkbox' || val === 'select') {
                opts.style.display = 'block';
            } else {
                opts.style.display = 'none';
            }
        });
    </script>
@endsection