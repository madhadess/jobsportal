@extends('layouts.app')

@section('content')
    @include('includes.header')

    <!-- Category Header -->
    <section style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); padding: 60px 0; color: white;">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb" style="background: transparent; padding: 0; margin-bottom: 20px;">
                            <li><a href="{{ route('index') }}" style="color: rgba(255,255,255,0.8);">Ana Sayfa</a></li>
                            <li><a href="{{ $type == 'caregiver' ? route('caregiver.index') : route('home-services.index') }}"
                                    style="color: rgba(255,255,255,0.8);">{{ $type == 'caregiver' ? 'Bakıcı Noktası' : 'Evine Hizmet Al' }}</a>
                            </li>
                            <li class="active" style="color: white;">{{ $category->category_name }}</li>
                        </ol>
                    </nav>
                    <h1 style="font-size: 36px; font-weight: 700;">{{ $category->category_name }}</h1>
                    @if($category->category_desc)
                        <p style="font-size: 16px; opacity: 0.9; margin-top: 15px;">{{ $category->category_desc }}</p>
                    @endif
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
                                <a href="{{ route('home-services.all') }}"
                                    style="color: #666; text-decoration: none; display: block; padding: 10px 15px; border-radius: 8px; transition: all 0.3s;"
                                    onmouseover="this.style.background='#f8f9fa'"
                                    onmouseout="this.style.background='transparent'">
                                    <i class="fa fa-th-large" style="margin-right: 10px;"></i>
                                    {{ $type == 'caregiver' ? 'Tüm Bakıcı Türleri' : 'Tüm Hizmetler' }}
                                </a>
                            </li>
                            @foreach($categories as $cat)
                                <li style="margin-bottom: 10px;">
                                    <a href="{{ $type == 'caregiver' ? route('caregiver.category', $cat->category_slug) : route('home-services.category', $cat->category_slug) }}"
                                        style="color: {{ $cat->id == $category->id ? '#1e3c72' : '#666' }}; text-decoration: none; display: block; padding: 10px 15px; border-radius: 8px; background: {{ $cat->id == $category->id ? '#e8f0fe' : 'transparent' }}; font-weight: {{ $cat->id == $category->id ? '600' : '400' }};">
                                        {{ $cat->category_name }}
                                        <span style="float: right; color: #999;">{{ $cat->getServicesCount() }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Services Grid -->
                <div class="col-md-9">
                    @if($services->count() > 0)
                        <div class="row">
                            @foreach($services as $service)
                                <div class="col-md-4 col-sm-6" style="margin-bottom: 30px;">
                                    <div
                                        style="background: white; border-radius: 15px; overflow: hidden; box-shadow: 0 5px 20px rgba(0,0,0,0.08); height: 100%;">
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
                                            <h4 style="font-weight: 600; margin-bottom: 10px; font-size: 16px;">
                                                {{ $service->service_name }}</h4>
                                            <p style="color: #666; font-size: 13px; margin-bottom: 15px;">
                                                {{ \Illuminate\Support\Str::limit($service->service_desc, 60) }}</p>
                                            <div style="display: flex; justify-content: space-between; align-items: center;">
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
                            {{ $services->links() }}
                        </div>
                    @else
                        <div style="text-align: center; padding: 60px 0;">
                            <i class="fa fa-inbox" style="font-size: 80px; color: #ddd; margin-bottom: 20px;"></i>
                            <h3 style="color: #999;">Bu kategoride henüz {{ $type == 'caregiver' ? 'bakıcı türü' : 'hizmet' }}
                                bulunmuyor.</h3>
                            <a href="{{ $type == 'caregiver' ? route('caregiver.all') : route('home-services.all') }}"
                                class="btn btn-primary" style="margin-top: 20px;">Tümünü Gör</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    @include('includes.footer')
@endsection