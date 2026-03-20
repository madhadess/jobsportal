@extends('layouts.app')

@section('content')
    @include('includes.header')

    <!-- All Services Header -->
    <section style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); padding: 60px 0; color: white;">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <h1 style="font-size: 36px; font-weight: 700; margin-bottom: 15px;">
                        {{ $type == 'caregiver' ? 'Tüm Bakıcı Türleri' : 'Tüm Hizmetler' }}</h1>
                    <p style="font-size: 16px; opacity: 0.9;">
                        {{ $type == 'caregiver' ? 'İhtiyacınız olan bakıcı türünü bulun ve hemen talep oluşturun.' : 'İhtiyacınız olan hizmeti bulun ve hemen talep oluşturun.' }}
                    </p>
                </div>
                <div class="col-md-4">
                    <form method="GET"
                        action="{{ $type == 'caregiver' ? route('caregiver.all') : route('home-services.all') }}">
                        <div class="input-group" style="margin-top: 20px;">
                            <input type="text" class="form-control" name="search"
                                placeholder="{{ $type == 'caregiver' ? 'Bakıcı ara...' : 'Hizmet ara...' }}"
                                value="{{ request('search') }}"
                                style="padding: 12px 20px; border-radius: 25px 0 0 25px; border: none;">
                            <span class="input-group-btn">
                                <button class="btn" type="submit"
                                    style="background: white; color: #1e3c72; padding: 12px 25px; border-radius: 0 25px 25px 0;">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Services List -->
    <section style="padding: 60px 0;">
        <div class="container">
            <div class="row">
                <!-- Sidebar -->
                <div class="col-md-3">
                    <div
                        style="background: white; border-radius: 15px; padding: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.08); position: sticky; top: 20px;">
                        <h4
                            style="font-weight: 600; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0;">
                            Kategoriler</h4>
                        <ul style="list-style: none; padding: 0; margin: 0;">
                            <li style="margin-bottom: 10px;">
                                <a href="{{ $type == 'caregiver' ? route('caregiver.all') : route('home-services.all') }}"
                                    style="color: {{ !request('category') ? '#1e3c72' : '#666' }}; text-decoration: none; display: block; padding: 10px 15px; border-radius: 8px; background: {{ !request('category') ? '#e8f0fe' : 'transparent' }}; font-weight: {{ !request('category') ? '600' : '400' }};">
                                    <i class="fa fa-th-large" style="margin-right: 10px;"></i>
                                    {{ $type == 'caregiver' ? 'Tüm Bakıcı Türleri' : 'Tüm Hizmetler' }}
                                </a>
                            </li>
                            @foreach($categories as $category)
                                <li style="margin-bottom: 10px;">
                                    <a href="{{ $type == 'caregiver' ? route('caregiver.all', ['category' => $category->id]) : route('home-services.all', ['category' => $category->id]) }}"
                                        style="color: {{ request('category') == $category->id ? '#1e3c72' : '#666' }}; text-decoration: none; display: block; padding: 10px 15px; border-radius: 8px; background: {{ request('category') == $category->id ? '#e8f0fe' : 'transparent' }}; font-weight: {{ request('category') == $category->id ? '600' : '400' }};">
                                        {{ $category->category_name }}
                                        <span style="float: right; color: #999;">{{ $category->getServicesCount() }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Services Grid -->
                <div class="col-md-9">
                    @if(request('search'))
                        <div style="margin-bottom: 20px;">
                            <span style="color: #666;">"<strong>{{ request('search') }}</strong>" için arama sonuçları</span>
                            <a href="{{ route('home-services.all') }}" style="margin-left: 15px; color: #1e3c72;">Aramayı
                                Temizle</a>
                        </div>
                    @endif

                    @if($services->count() > 0)
                        <div class="row">
                            @foreach($services as $service)
                                <div class="col-md-4 col-sm-6" style="margin-bottom: 30px;">
                                    <div style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.08); height: 100%; transition: transform 0.3s, box-shadow 0.3s;"
                                        onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 30px rgba(0,0,0,0.15)';"
                                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 5px 20px rgba(0,0,0,0.08)';">
                                        @if($service->service_image)
                                            <img src="{{ asset('uploads/services/' . $service->service_image) }}"
                                                alt="{{ $service->service_name }}"
                                                style="width: 100%; height: 180px; object-fit: cover;">
                                        @else
                                            <div
                                                style="width: 100%; height: 180px; background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); display: flex; align-items: center; justify-content: center;">
                                                <i class="fa fa-cog" style="font-size: 50px; color: white;"></i>
                                            </div>
                                        @endif
                                        <div style="padding: 20px;">
                                            @if($service->category)
                                                <span
                                                    style="background: #e8f0fe; color: #1e3c72; padding: 4px 10px; border-radius: 15px; font-size: 11px; font-weight: 500;">
                                                    {{ $service->category->category_name }}
                                                </span>
                                            @endif
                                            @if($service->is_featured)
                                                <span
                                                    style="background: #fff3cd; color: #856404; padding: 4px 10px; border-radius: 15px; font-size: 11px; font-weight: 500; margin-left: 5px;">
                                                    <i class="fa fa-star"></i> Öne Çıkan
                                                </span>
                                            @endif
                                            <h4 style="font-weight: 600; margin: 12px 0 8px; font-size: 16px;">
                                                {{ $service->service_name }}</h4>
                                            <p style="color: #666; font-size: 13px; margin-bottom: 15px; min-height: 40px;">
                                                {{ \Illuminate\Support\Str::limit($service->service_desc, 60) }}</p>
                                            <div
                                                style="display: flex; justify-content: space-between; align-items: center; padding-top: 15px; border-top: 1px solid #eee;">
                                                <span
                                                    style="font-size: 16px; font-weight: 700; color: #1e3c72;">{{ $service->getFormattedPrice() }}</span>
                                            </div>
                                            <a href="{{ $type == 'caregiver' ? route('caregiver.show', $service->service_slug) : route('home-services.show', $service->service_slug) }}"
                                                style="display: block; text-align: center; background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); color: white; padding: 10px; border-radius: 8px; text-decoration: none; margin-top: 15px; font-weight: 500;">
                                                Detay Gör
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="text-center">
                            {{ $services->appends(request()->query())->links() }}
                        </div>
                    @else
                        <div style="text-align: center; padding: 80px 0;">
                            <i class="fa fa-search" style="font-size: 80px; color: #ddd; margin-bottom: 30px;"></i>
                            <h3 style="color: #999; margin-bottom: 15px;">
                                {{ $type == 'caregiver' ? 'Bakıcı türü bulunamadı.' : 'Hizmet bulunamadı.' }}</h3>
                            <p style="color: #999;">Farklı bir arama terimi veya kategori deneyin.</p>
                            <a href="{{ $type == 'caregiver' ? route('caregiver.all') : route('home-services.all') }}"
                                class="btn btn-primary" style="margin-top: 20px; border-radius: 25px; padding: 12px 30px;">
                                Tümünü Gör
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    @include('includes.footer')
@endsection