@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Hizmet Kategorileri</h2>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('admin.service-categories.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Yeni Kategori Ekle
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Kategori Adı</th>
                                <th>Açıklama</th>
                                <th>Durum</th>
                                <th>Sıra</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td><strong>{{ $category->category_name }}</strong></td>
                                <td>{{ Str::limit($category->category_desc, 50) }}</td>
                                <td>
                                    @if($category->is_active)
                                    <span class="badge badge-success">active</span>
                                    @else
                                    <span class="badge badge-danger">Pasif</span>
                                    @endif
                                </td>
                                <td>{{ $category->sort_order }}</td>
                                <td>
                                    <a href="{{ route('admin.service-categories.edit', $category->id) }}" class="btn btn-sm btn-info">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form Action="{{ route('admin.service-categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Silmek istediğinizden emin misiniz?')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Kategori bulunamadı</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection







