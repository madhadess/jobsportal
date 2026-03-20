@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-8">
            <h2>Hizmetler</h2>
        </div>
        <div class="col-md-4 text-right">
            <a href="{{ route('admin.services.create') }}" class="btn btn-primary">
                <i class="fa fa-plus"></i> Yeni Hizmet Ekle
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
                                <th>Hizmet Adı</th>
                                <th>Kategori</th>
                                <th>Fiyat</th>
                                <th>Durum</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($services as $service)
                            <tr>
                                <td><strong>{{ $service->service_name }}</strong></td>
                                <td>{{ $service->category->category_name ?? 'N/A' }}</td>
                                <td><strong>₺{{ number_format($service->price, 2) }}</strong></td>
                                <td>
                                    @if($service->is_active)
                                    <span class="badge badge-success">active</span>
                                    @else
                                    <span class="badge badge-danger">Pasif</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-sm btn-info">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <form Action="{{ route('admin.services.destroy', $service->id) }}" method="POST" style="display:inline;">
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
                                <td colspan="5" class="text-center">Hizmet bulunamadı</td>
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







