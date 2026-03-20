@extends('layouts.app')

@section('content')
    @include('includes.header')

    <!-- My Requests Header -->
    <section style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); padding: 40px 0; color: white;">
        <div class="container">
            <h1 style="font-size: 28px; font-weight: 700;">Hizmet Taleplerim</h1>
            <p style="opacity: 0.9;">Oluşturduğunuz tüm hizmet taleplerini buradan takip edebilirsiniz.</p>
        </div>
    </section>

    <!-- Requests List -->
    <section style="padding: 60px 0; background: #f8f9fa;">
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success" style="border-radius: 10px;">
                    <i class="fa fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if($requests->count() > 0)
                <div class="row">
                    @foreach($requests as $request)
                        <div class="col-md-12" style="margin-bottom: 20px;">
                            <div
                                style="background: white; border-radius: 15px; padding: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.08);">
                                <div class="row">
                                    <div class="col-md-2 col-sm-3">
                                        @if($request->service && $request->service->service_image)
                                            <img src="{{ asset('uploads/services/' . $request->service->service_image) }}"
                                                alt="{{ $request->service->service_name }}"
                                                style="width: 100%; height: 100px; object-fit: cover; border-radius: 10px;">
                                        @else
                                            <div
                                                style="width: 100%; height: 100px; background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                                <i class="fa fa-cog" style="font-size: 40px; color: white;"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-7 col-sm-6">
                                        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 10px;">
                                            <span
                                                style="background: 
                                                                        @if($request->status == 'pending') #ffc107
                                                                        @elseif($request->status == 'approved') #17a2b8
                                                                        @elseif($request->status == 'in_progress') #007bff
                                                                        @elseif($request->status == 'completed') #28a745
                                                                        @else #dc3545 @endif; 
                                                                        color: white; padding: 5px 15px; border-radius: 20px; font-size: 12px; font-weight: 500;">
                                                {{ $request->getStatusLabel() }}
                                            </span>
                                            <span style="color: #999; font-size: 13px;">
                                                <i class="fa fa-clock-o"></i>
                                                {{ $request->created_at->translatedFormat('d.m.Y H:i') }}
                                            </span>
                                        </div>
                                        <h4 style="font-weight: 600; margin-bottom: 8px;">
                                            @if($request->service)
                                                {{ $request->service->service_name }}
                                            @elseif($request->category)
                                                {{ $request->category->category_name }}
                                            @else
                                                Hizmet Bilgisi Yok
                                            @endif
                                        </h4>
                                        <p style="color: #666; font-size: 14px; margin-bottom: 5px;">
                                            <strong>Talep No:</strong> {{ $request->request_number }}
                                        </p>
                                        <p style="color: #666; font-size: 14px; margin: 0;">
                                            <i class="fa fa-map-marker"></i>
                                            {{ $request->customer_district }}/{{ $request->customer_city }}
                                            @if($request->preferred_date)
                                                &nbsp;&nbsp;|&nbsp;&nbsp;<i class="fa fa-calendar"></i>
                                                {{ $request->getFormattedDate() }}
                                            @endif
                                        </p>
                                        @if($request->matchedPersonnel)
                                            <p style="color: #555; font-size: 13px; margin: 8px 0 0;">
                                                <i class="fa fa-user"></i>
                                                <strong>Atanan Personel:</strong>
                                                {{ $request->matchedPersonnel->getName() ?: $request->matchedPersonnel->email }}
                                            </p>
                                        @endif

                                        @php
                                            $extraDetails = json_decode($request->extra_details, true);
                                        @endphp
                                        @if($extraDetails)
                                            <div style="margin-top: 10px; font-size: 13px;">
                                                @if(!empty($extraDetails['working_mode']))
                                                    <span class="badge badge-info"
                                                        style="background-color: #e8f0fe; color: #1e3c72; font-weight: 500; padding: 5px 10px; border-radius: 15px;">
                                                        {{ $extraDetails['working_mode'] }}
                                                    </span>
                                                @endif
                                                @if(!empty($extraDetails['attributes']) && is_array($extraDetails['attributes']))
                                                    @foreach(array_slice($extraDetails['attributes'], 0, 3) as $attr)
                                                        <span class="badge badge-light"
                                                            style="border: 1px solid #eee; color: #666; font-weight: normal; margin-left: 5px;">{{ $attr }}</span>
                                                    @endforeach
                                                    @if(count($extraDetails['attributes']) > 3)
                                                        <span
                                                            style="font-size: 11px; color: #999;">+{{ count($extraDetails['attributes']) - 3 }}</span>
                                                    @endif
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col-md-3 col-sm-3 text-right">
                                        <a href="{{ route('home-services.request-detail', $request->request_number) }}" class="btn"
                                            style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white; border-radius: 8px; padding: 10px 25px;">
                                            <i class="fa fa-eye"></i> Detay
                                        </a>
                                        @if($request->status == 'pending')
                                            <button class="btn btn-danger"
                                                style="border-radius: 8px; padding: 10px 20px; margin-top: 10px;"
                                                onclick="cancelRequest('{{ $request->request_number }}')">
                                                <i class="fa fa-times"></i> İptal
                                            </button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="text-center">
                    {{ $requests->links() }}
                </div>
            @else
                <div style="text-align: center; padding: 80px 0;">
                    <i class="fa fa-inbox" style="font-size: 100px; color: #ddd; margin-bottom: 30px;"></i>
                    <h3 style="color: #999; margin-bottom: 20px;">Henüz hizmet talebiniz bulunmuyor.</h3>
                    <a href="{{ route('home-services.index') }}" class="btn btn-lg"
                        style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white; padding: 15px 40px; border-radius: 30px;">
                        <i class="fa fa-search"></i> Hizmetleri İncele
                    </a>
                </div>
            @endif
        </div>
    </section>

    @include('includes.footer')

    @push('scripts')
        <script>
            function cancelRequest(requestNumber) {
                if (confirm('Bu talebi iptal etmek istediğinizden emin misiniz?')) {
                    $.ajax({
                        url: '/evine-hizmet-al/taleplerim/' + requestNumber + '/iptal',
                        type: 'POST',
                        data: { _token: '{{ csrf_token() }}' },
                        success: function (response) {
                            if (response.success) {
                                location.reload();
                            } else {
                                alert(response.message || 'Bir hata oluştu!');
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
@endsection