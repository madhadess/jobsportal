@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2>Hizmet Talepleri</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Müşteri</th>
                                <th>Hizmet</th>
                                <th>Tarih</th>
                                <th>Saat</th>
                                <th>Fiyat</th>
                                <th>Durum</th>
                                <th>İşlemler</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bookings as $booking)
                            <tr>
                                <td>
                                    @if($booking->user)
                                    <strong>{{ $booking->user->name }}</strong><br>
                                    <small>{{ $booking->user->email }}</small>
                                    @else
                                    N/A
                                    @endif
                                </td>
                                <td>{{ $booking->service->service_name ?? 'N/A' }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d.m.Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}</td>
                                <td><strong>₺{{ number_format($booking->total_price, 2) }}</strong></td>
                                <td>
                                    @if($booking->status == 'pending')
                                    <span class="badge badge-warning">Beklemede</span>
                                    @elseif($booking->status == 'confirmed')
                                    <span class="badge badge-info">Onaylandı</span>
                                    @elseif($booking->status == 'completed')
                                    <span class="badge badge-success">Tamamlandı</span>
                                    @else
                                    <span class="badge badge-danger">İptal ELanguagedi</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('admin.service-requests.show', $booking->id) }}" class="btn btn-sm btn-info">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    @if($booking->status == 'pending')
                                    <form Action="{{ route('admin.service-requests.approve', $booking->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Onaylamak istediğinizden emin misiniz?')">
                                            <i class="fa fa-check"></i>
                                        </button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Talep bulunamadı</td>
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







