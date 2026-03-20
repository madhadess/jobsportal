@extends('layouts.app')

@section('content')
    @include('includes.header')

    <!-- Request Detail Header -->
    <section style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); padding: 40px 0; color: white;">
        <div class="container">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb" style="background: transparent; padding: 0; margin-bottom: 10px;">
                    <li><a href="{{ route('index') }}" style="color: rgba(255,255,255,0.8);">Ana Sayfa</a></li>
                    <li><a href="{{ route('home-services.my-requests') }}"
                            style="color: rgba(255,255,255,0.8);">Taleplerim</a></li>
                    <li class="active" style="color: white;">{{ $serviceRequest->request_number }}</li>
                </ol>
            </nav>
            <h1 style="font-size: 28px; font-weight: 700;">
                {{ ($serviceRequest->service && $serviceRequest->service->category && $serviceRequest->service->category->type == 'caregiver') ? 'Bakıcı Talep Detayı' : 'Hizmet Talep Detayı' }}
            </h1>
        </div>
    </section>

    <!-- Request Detail -->
    <section style="padding: 60px 0; background: #f8f9fa;">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <!-- Request Info -->
                    <div
                        style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.08); margin-bottom: 30px;">
                        <div
                            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; padding-bottom: 20px; border-bottom: 2px solid #f0f0f0;">
                            <h3 style="font-weight: 600; margin: 0;">
                                <i class="fa fa-file-text" style="color: #1e3c72;"></i> Talep Bilgileri
                            </h3>
                            <span style="background: 
                                            @if($serviceRequest->status == 'pending') #ffc107
                                            @elseif($serviceRequest->status == 'approved') #17a2b8
                                            @elseif($serviceRequest->status == 'in_progress') #007bff
                                            @elseif($serviceRequest->status == 'completed') #28a745
                                            @else #dc3545 @endif; 
                                            color: white; padding: 8px 20px; border-radius: 25px; font-weight: 500;">
                                {{ $serviceRequest->getStatusLabel() }}
                            </span>
                        </div>

                        <table class="table" style="margin: 0;">
                            <tr>
                                <th style="width: 35%; border-top: none; padding: 12px 0;">Talep Numarası</th>
                                <td style="border-top: none; padding: 12px 0;">
                                    <strong>{{ $serviceRequest->request_number }}</strong>
                                </td>
                            </tr>
                            <tr>
                                <th style="padding: 12px 0;">Talep Tarihi</th>
                                <td style="padding: 12px 0;">
                                    {{ $serviceRequest->created_at->translatedFormat('d.m.Y H:i') }}
                                </td>
                            </tr>
                            <tr>
                                <th style="padding: 12px 0;">Tercih Edilen Tarih</th>
                                <td style="padding: 12px 0;">{{ $serviceRequest->getFormattedDate() }}</td>
                            </tr>
                            <tr>
                                <th style="padding: 12px 0;">Tercih Edilen Saat</th>
                                <td style="padding: 12px 0;">{{ $serviceRequest->getFormattedTime() }}</td>
                            </tr>
                            <tr>
                                <th style="padding: 12px 0;">Atanan Personel</th>
                                <td style="padding: 12px 0;">
                                    @if($serviceRequest->assignedPersonnel && $serviceRequest->assignedPersonnel->count() > 0)
                                        @foreach($serviceRequest->assignedPersonnel as $assigned)
                                            <div>
                                                {{ $assigned->getName() ?: $assigned->email }}
                                                @if(!$loop->last)
                                                    <span style="color:#999;">,</span>
                                                @endif
                                            </div>
                                        @endforeach
                                    @elseif($serviceRequest->matchedPersonnel)
                                        {{ $serviceRequest->matchedPersonnel->getName() ?: $serviceRequest->matchedPersonnel->email }}
                                    @else
                                        <span style="color:#999;">Henüz personel atanmadı</span>
                                    @endif
                                </td>
                            </tr>
                            @if($serviceRequest->final_price)
                                <tr>
                                    <th style="padding: 12px 0;">Son Fiyat</th>
                                    <td style="padding: 12px 0;"><strong
                                            style="color: #1e3c72; font-size: 18px;">{{ number_format($serviceRequest->final_price, 2, ',', '.') }}
                                            TL</strong></td>
                                </tr>
                            @endif
                        </table>
                    </div>

                    <!-- Address Info -->
                    <div
                        style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.08); margin-bottom: 30px;">
                        <h4
                            style="font-weight: 600; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0;">
                            <i class="fa fa-map-marker" style="color: #1e3c72;"></i> Adres Bilgileri
                        </h4>
                        <table class="table" style="margin: 0;">
                            <tr>
                                <th style="width: 35%; border-top: none; padding: 12px 0;">Telefon</th>
                                <td style="border-top: none; padding: 12px 0;">{{ $serviceRequest->customer_phone }}</td>
                            </tr>
                            <tr>
                                <th style="padding: 12px 0;">Şehir / İlçe</th>
                                <td style="padding: 12px 0;">{{ $serviceRequest->customer_state_name }} /
                                    {{ $serviceRequest->customer_district_name }}
                                </td>
                            </tr>
                            <tr>
                                <th style="padding: 12px 0;">Adres</th>
                                <td style="padding: 12px 0;">{{ $serviceRequest->customer_address }}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Notes -->
                    @if($serviceRequest->customer_notes)
                        <div
                            style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 5px 20px rgba(0,0,0,0.08);">
                            <h4
                                style="font-weight: 600; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0;">
                                <i class="fa fa-comment" style="color: #1e3c72;"></i> Notlarınız
                            </h4>
                            <p style="color: #666; line-height: 1.8; margin: 0;">{{ $serviceRequest->customer_notes }}</p>
                        </div>
                    @endif
                </div>

                <!-- Sidebar - Service Info -->
                <div class="col-md-4">
                    <div
                        style="background: white; border-radius: 15px; padding: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.08); position: sticky; top: 20px;">
                        <h4
                            style="font-weight: 600; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0;">
                            <i class="fa fa-info-circle" style="color: #1e3c72;"></i> Talep Detayları
                        </h4>

                        @if($serviceRequest->category)
                            <div style="margin-bottom: 15px;">
                                <label
                                    style="display: block; font-size: 12px; color: #999; text-transform: uppercase;">Kategori</label>
                                <strong
                                    style="color: #1e3c72; font-size: 16px;">{{ $serviceRequest->category->category_name }}</strong>
                            </div>
                        @elseif($serviceRequest->service)
                            <div style="margin-bottom: 15px;">
                                <label
                                    style="display: block; font-size: 12px; color: #999; text-transform: uppercase;">Hizmet</label>
                                <strong
                                    style="color: #1e3c72; font-size: 16px;">{{ $serviceRequest->service->service_name }}</strong>
                            </div>
                        @endif

                        @php
                            $extraDetails = json_decode($serviceRequest->extra_details, true);
                        @endphp

                        @if($extraDetails)
                            @if(!empty($extraDetails['working_mode']))
                                <div style="margin-bottom: 15px;">
                                    <label style="display: block; font-size: 12px; color: #999; text-transform: uppercase;">Çalışma
                                        Şekli</label>
                                    <span
                                        style="display: inline-block; background: #e8f0fe; color: #1e3c72; padding: 5px 15px; border-radius: 20px; font-weight: 600; font-size: 13px; margin-top: 5px;">
                                        {{ $extraDetails['working_mode'] }}
                                    </span>
                                </div>
                            @endif

                            @if(!empty($extraDetails['attributes']))
                                <div style="margin-bottom: 15px;">
                                    <label style="display: block; font-size: 12px; color: #999; text-transform: uppercase;">İstenen
                                        Özellikler</label>
                                    <div style="display: flex; flex-wrap: wrap; gap: 8px; margin-top: 8px;">
                                        @foreach($extraDetails['attributes'] as $attr)
                                            <span
                                                style="background: #f8f9fa; border: 1px solid #eee; color: #555; padding: 4px 10px; border-radius: 6px; font-size: 12px;">
                                                <i class="fa fa-check text-success" style="margin-right: 5px;"></i>{{ $attr }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endif

                        @if(!empty($extraDetails['dynamic_questions']))
                            <div style="margin-top: 20px; padding-top: 15px; border-top: 1px dashed #eee;">
                                <label
                                    style="display: block; font-size: 12px; color: #999; text-transform: uppercase; margin-bottom: 10px;">Sorular
                                    & Cevaplar</label>
                                @foreach($extraDetails['dynamic_questions'] as $qId => $answer)
                                    @php
                                        $question = \App\ServiceQuestion::find($qId);
                                        $answerText = $answer;

                                        if ($question) {
                                            if (in_array($question->type, ['select', 'radio'])) {
                                                $option = \App\ServiceQuestionOption::find($answer);
                                                if ($option)
                                                    $answerText = $option->option_text;
                                            } elseif ($question->type == 'checkbox' && is_array($answer)) {
                                                $options = \App\ServiceQuestionOption::whereIn('id', $answer)->pluck('option_text')->toArray();
                                                $answerText = implode(', ', $options);
                                            }
                                        }
                                    @endphp
                                    <div style="margin-bottom: 10px; font-size: 13px;">
                                        <div style="font-weight: 600; color: #555;">{{ $question ? $question->question : 'Soru' }}
                                        </div>
                                        <div style="color: #1e3c72;">
                                            {{ is_array($answerText) ? implode(', ', $answerText) : $answerText }}</div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div style="margin-top: 25px; padding-top: 20px; border-top: 1px solid #eee;">
                            <a href="{{ route('home-services.my-requests') }}" class="btn btn-block"
                                style="background: #1e3c72; color: white; padding: 12px; border-radius: 8px; font-weight: 600;">
                                <i class="fa fa-arrow-left"></i> Taleplerime Dön
                            </a>
                        </div>
                    </div>

                    <!-- Status Timeline -->
                    <div
                        style="background: white; border-radius: 15px; padding: 25px; box-shadow: 0 5px 20px rgba(0,0,0,0.08); margin-top: 20px;">
                        <h4 style="font-weight: 600; margin-bottom: 20px;">Durum Takibi</h4>
                        <div style="position: relative; padding-left: 30px;">
                            <div style="position: absolute; left: 8px; top: 0; bottom: 0; width: 2px; background: #e0e0e0;">
                            </div>

                            <div style="position: relative; margin-bottom: 20px;">
                                <div
                                    style="position: absolute; left: -26px; width: 16px; height: 16px; border-radius: 50%; background: #28a745;">
                                </div>
                                <strong>Talep Oluşturuldu</strong>
                                <p style="color: #999; font-size: 12px; margin: 5px 0 0;">
                                    {{ $serviceRequest->created_at->translatedFormat('d.m.Y H:i') }}
                                </p>
                            </div>

                            @if($serviceRequest->approved_at)
                                <div style="position: relative; margin-bottom: 20px;">
                                    <div
                                        style="position: absolute; left: -26px; width: 16px; height: 16px; border-radius: 50%; background: #17a2b8;">
                                    </div>
                                    <strong>Onaylandı</strong>
                                    <p style="color: #999; font-size: 12px; margin: 5px 0 0;">
                                        {{ \Illuminate\Support\Carbon::parse($serviceRequest->approved_at)->translatedFormat('d.m.Y H:i') }}
                                    </p>
                                </div>
                            @endif

                            @if($serviceRequest->completed_at)
                                <div style="position: relative;">
                                    <div
                                        style="position: absolute; left: -26px; width: 16px; height: 16px; border-radius: 50%; background: #28a745;">
                                    </div>
                                    <strong>Tamamlandı</strong>
                                    <p style="color: #999; font-size: 12px; margin: 5px 0 0;">
                                        {{ \Illuminate\Support\Carbon::parse($serviceRequest->completed_at)->translatedFormat('d.m.Y H:i') }}
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('includes.footer')
@endsection