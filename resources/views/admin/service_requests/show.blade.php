@extends('admin.layouts.admin_layout')

@section('content')
    <style>
        .sr-page {
            padding: 20px;
            background: #f5f7fa;
            min-height: 100vh;
        }

        .sr-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 25px 30px;
            border-radius: 12px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .sr-header h1 {
            margin: 0;
            font-size: 22px;
            font-weight: 600;
        }

        .sr-header .btn-back {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
        }

        .sr-header .btn-back:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
            text-decoration: none;
        }

        .sr-breadcrumb {
            background: white;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .sr-breadcrumb a {
            color: #667eea;
            text-decoration: none;
        }

        .sr-breadcrumb span {
            color: #999;
            margin: 0 8px;
        }

        .sr-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.08);
            margin-bottom: 25px;
            overflow: hidden;
        }

        .sr-card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 15px 20px;
            color: white;
            font-weight: 600;
            font-size: 15px;
        }

        .sr-card-header i {
            margin-right: 10px;
        }

        .sr-card-body {
            padding: 20px;
        }

        .sr-info-row {
            display: flex;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .sr-info-row:last-child {
            border-bottom: none;
        }

        .sr-info-label {
            width: 140px;
            color: #666;
            font-weight: 500;
            flex-shrink: 0;
        }

        .sr-info-value {
            flex: 1;
            color: #333;
            font-weight: 500;
        }

        .sr-info-value a {
            color: #667eea;
            text-decoration: none;
        }

        .sr-status {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .sr-status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .sr-status-approved {
            background: #d4edda;
            color: #155724;
        }

        .sr-status-in_progress {
            background: #cce5ff;
            color: #004085;
        }

        .sr-status-completed {
            background: #d1ecf1;
            color: #0c5460;
        }

        .sr-status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }

        .sr-form-group {
            margin-bottom: 18px;
        }

        .sr-form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
            font-size: 14px;
        }

        .sr-form-control {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
        }

        .sr-form-control:focus {
            border-color: #667eea;
            outline: none;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .sr-btn-update {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 14px 28px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            font-size: 15px;
        }

        .sr-btn-update:hover {
            opacity: 0.9;
        }

        .sr-quick-Actionler {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .sr-btn-Action {
            flex: 1;
            min-width: 80px;
            padding: 12px 16px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            font-size: 13px;
            text-align: center;
        }

        .sr-btn-approve {
            background: #28a745;
            color: white;
        }

        .sr-btn-complete {
            background: #17a2b8;
            color: white;
        }

        .sr-btn-cancel {
            background: #dc3545;
            color: white;
        }

        .sr-btn-Action:hover {
            opacity: 0.9;
        }

        .sr-personnel-item {
            display: flex;
            align-items: center;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .sr-personnel-item img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            margin-right: 15px;
            object-fit: cover;
            background: #ddd;
        }

        .sr-personnel-info h5 {
            margin: 0 0 4px 0;
            font-size: 14px;
            font-weight: 600;
        }

        .sr-personnel-info small {
            color: #666;
        }

        .sr-personnel-remove {
            margin-left: auto;
            background: #dc3545;
            color: white;
            border: none;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 12px;
        }

        .sr-btn-assign {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            width: 100%;
            margin-top: 10px;
        }

        .sr-empty {
            text-align: center;
            padding: 30px;
            color: #999;
        }
    </style>

    <div class="content-wrapper">
        <div class="page-content-wrapper">
            <div class="page-content sr-page">
                @if(session()->has('message.updated'))
                    <div class="alert alert-success" style="border-radius: 8px; margin-bottom: 20px;">
                        {!! session('message.content') !!}
                    </div>
                @endif

                <div class="sr-header">
                    <h1><i class="fa fa-file-text"></i> Talep: {{ $serviceRequest->request_number }}</h1>
                    <a href="{{ route('admin.service-requests.index') }}" class="btn-back">
                        <i class="fa fa-arrow-left"></i> Geri Dön
                    </a>
                </div>

                <div class="sr-breadcrumb">
                    <a href="{{ route('admin.home') }}"><i class="fa fa-dashboard"></i> Kontrol Paneli</a>
                    <span>/</span>
                    <a href="{{ route('admin.service-requests.index') }}">Hizmet Talepleri</a>
                    <span>/</span>
                    <strong>{{ $serviceRequest->request_number }}</strong>
                </div>

                <div class="row">
                    <div class="col-md-8">
                        <div class="sr-card">
                            <div class="sr-card-header"><i class="fa fa-info-circle"></i> Talep Bilgileri</div>
                            <div class="sr-card-body">
                                <div class="sr-info-row">
                                    <div class="sr-info-label">Talep No</div>
                                    <div class="sr-info-value" style="color: #667eea; font-weight: 700;">
                                        {{ $serviceRequest->request_number }}
                                    </div>
                                </div>
                                <div class="sr-info-row">
                                    <div class="sr-info-label">Hizmet</div>
                                    <div class="sr-info-value">
                                        @if($serviceRequest->service)
                                            <strong>{{ $serviceRequest->service->service_name }}</strong>
                                            @if($serviceRequest->service->category)
                                                <br><small
                                                    style="color: #888;">{{ $serviceRequest->service->category->category_name }}</small>
                                            @endif
                                        @elseif($serviceRequest->category)
                                            <strong>{{ $serviceRequest->category->category_name }}</strong>
                                            <br><small style="color: #888;">Kategori bazlı talep</small>
                                        @else
                                            <span style="color: #999;">Belirtilmemiş</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="sr-info-row">
                                    <div class="sr-info-label">Durum</div>
                                    <div class="sr-info-value">
                                        <span
                                            class="sr-status sr-status-{{ $serviceRequest->status }}">{{ $serviceRequest->getStatusLabel() }}</span>
                                    </div>
                                </div>
                                <div class="sr-info-row">
                                    <div class="sr-info-label">Talep Tarihi</div>
                                    <div class="sr-info-value">{{ $serviceRequest->created_at->format('d.m.Y H:i') }}</div>
                                </div>
                                <div class="sr-info-row">
                                    <div class="sr-info-label">Tercih Tarihi</div>
                                    <div class="sr-info-value"><strong>{{ $serviceRequest->getFormattedDate() }} -
                                            {{ $serviceRequest->getFormattedTime() }}</strong></div>
                                </div>
                                @if($serviceRequest->final_price)
                                    <div class="sr-info-row">
                                        <div class="sr-info-label">Son Fiyat</div>
                                        <div class="sr-info-value" style="color: #667eea; font-weight: 700; font-size: 18px;">
                                            ₺{{ number_format($serviceRequest->final_price, 2) }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="sr-card">
                            <div class="sr-card-header"><i class="fa fa-user"></i> Müşteri Bilgileri</div>
                            <div class="sr-card-body">
                                <div class="sr-info-row">
                                    <div class="sr-info-label">Müşteri Adı</div>
                                    <div class="sr-info-value">
                                        <strong>{{ $serviceRequest->user ? $serviceRequest->user->getName() : '-' }}</strong>
                                    </div>
                                </div>
                                <div class="sr-info-row">
                                    <div class="sr-info-label">E-posta</div>
                                    <div class="sr-info-value">
                                        @if($serviceRequest->user)
                                            <a
                                                href="mailto:{{ $serviceRequest->user->email }}">{{ $serviceRequest->user->email }}</a>
                                        @else - @endif
                                    </div>
                                </div>
                                <div class="sr-info-row">
                                    <div class="sr-info-label">Telefon</div>
                                    <div class="sr-info-value"><a
                                            href="tel:{{ $serviceRequest->customer_phone }}"><strong>{{ $serviceRequest->customer_phone }}</strong></a>
                                    </div>
                                </div>
                                <div class="sr-info-row">
                                    <div class="sr-info-label">Adres</div>
                                    <div class="sr-info-value">{{ $serviceRequest->customer_address }}</div>
                                </div>
                                <div class="sr-info-row">
                                    <div class="sr-info-label">İlçe / Şehir</div>
                                    <div class="sr-info-value"><strong>{{ $serviceRequest->customer_district }} /
                                            {{ $serviceRequest->customer_city }}</strong></div>
                                </div>
                                @if($serviceRequest->customer_notes)
                                    <div class="sr-info-row">
                                        <div class="sr-info-label">Notlar</div>
                                        <div class="sr-info-value">{{ $serviceRequest->customer_notes }}</div>
                                    </div>
                                @endif
                            </div>
                        </div>


                        {{-- Hizmet Detayları Kartı --}}
                        @php
                            $extraDetails = json_decode($serviceRequest->extra_details, true);
                        @endphp
                        @if($extraDetails)
                            <div class="sr-card">
                                <div class="sr-card-header"><i class="fa fa-list-alt"></i> Hizmet Detayları</div>
                                <div class="sr-card-body">
                                    @if(!empty($extraDetails['type']))
                                        <div class="sr-info-row">
                                            <div class="sr-info-label">Talep Türü</div>
                                            <div class="sr-info-value">
                                                <span class="badge"
                                                    style="background-color: {{ $extraDetails['type'] == 'caregiver' ? '#28a745' : '#17a2b8' }}; color: white; font-size: 12px; padding: 5px 12px;">
                                                    {{ $extraDetails['type'] == 'caregiver' ? 'Bakıcı Talebi' : 'Hizmet Talebi' }}
                                                </span>
                                            </div>
                                        </div>
                                    @endif

                                    @if(!empty($extraDetails['working_mode']))
                                        <div class="sr-info-row">
                                            <div class="sr-info-label">Çalışma Şekli</div>
                                            <div class="sr-info-value">
                                                <span class="badge"
                                                    style="background-color: #667eea; color: white; font-size: 13px; padding: 6px 14px;">{{ $extraDetails['working_mode'] }}</span>
                                            </div>
                                        </div>
                                    @endif

                                    @if(!empty($extraDetails['attributes']) && is_array($extraDetails['attributes']))
                                        <div class="sr-info-row">
                                            <div class="sr-info-label">Özellikler</div>
                                            <div class="sr-info-value">
                                                @foreach($extraDetails['attributes'] as $attr)
                                                    <span class="badge"
                                                        style="background-color: #f0f4ff; border: 1px solid #667eea; color: #667eea; margin-right: 5px; margin-bottom: 5px; display: inline-block; padding: 5px 10px; font-size: 12px;">
                                                        <i class="fa fa-check-circle" style="margin-right: 4px;"></i>{{ $attr }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    @if(!empty($extraDetails['dynamic_questions']) && is_array($extraDetails['dynamic_questions']) && count($extraDetails['dynamic_questions']) > 0)
                                        <div class="sr-info-row" style="display: block;">
                                            <div class="sr-info-label"
                                                style="width: 100%; margin-bottom: 10px; border-bottom: 1px dashed #eee; padding-bottom: 5px;">
                                                Sorular & Cevaplar</div>
                                            <div class="sr-info-value" style="width: 100%;">
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
                                                    <div style="margin-bottom: 12px;">
                                                        <strong
                                                            style="display: block; color: #555; font-size: 13px;">{{ $question ? $question->question : 'Soru' }}</strong>
                                                        <span
                                                            style="color: #667eea;">{{ is_array($answerText) ? implode(', ', $answerText) : $answerText }}</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif

                                    @if(!empty($extraDetails['notes']))
                                        <div class="sr-info-row">
                                            <div class="sr-info-label">Ek Notlar</div>
                                            <div class="sr-info-value">{{ $extraDetails['notes'] }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="sr-card">
                            <div class="sr-card-header"><i class="fa fa-users"></i> Atanan Personeller</div>
                            <div class="sr-card-body">
                                <div id="assignedPersonnel">
                                    @if($serviceRequest->assignedPersonnel && $serviceRequest->assignedPersonnel->count() > 0)
                                        @foreach($serviceRequest->assignedPersonnel as $personnel)
                                            <div class="sr-personnel-item">
                                                <img src="{{ $personnel->image ? asset('uploads/user_images/' . $personnel->image) : asset('admin_assets/no-image.png') }}"
                                                    alt="">
                                                <div class="sr-personnel-info">
                                                    <h5>{{ $personnel->getName() }}</h5>
                                                    <small>{{ $personnel->email }}</small>
                                                </div>
                                                @if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('manage_service_requests') || APAuthHelp::hasPermission('manage_services'))
                                                    <button class="sr-personnel-remove"
                                                        onclick="removePersonnel({{ $personnel->id }})"><i
                                                            class="fa fa-times"></i></button>
                                                @endif
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="sr-empty">Henüz personel atanmamış</div>
                                    @endif
                                </div>
                                @if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('manage_service_requests') || APAuthHelp::hasPermission('manage_services'))
                                    <button class="sr-btn-assign" onclick="openAssignModal()"><i class="fa fa-plus"></i>
                                        Personel Ata</button>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        @php
                            $isCaregiver = $serviceRequest->category && $serviceRequest->category->type == 'caregiver';
                            $canManageStatus = $isCaregiver
                                ? (APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('manage_caregiver_request_status'))
                                : (APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('manage_service_request_status'));

                            $canApprove = $isCaregiver
                                ? (APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('approve_caregiver_requests'))
                                : (APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('approve_service_requests'));
                            $canAssignPersonnel = APAuthHelp::check(['SUPER_ADMIN'])
                                || APAuthHelp::hasPermission('manage_service_requests')
                                || APAuthHelp::hasPermission('manage_services');
                        @endphp

                        @if($canManageStatus)
                            <div class="sr-card">
                                <div class="sr-card-header"><i class="fa fa-cog"></i> Durum Güncelle</div>
                                <div class="sr-card-body">
                                    <form Action="{{ route('admin.service-requests.update-status', $serviceRequest->id) }}"
                                        method="POST">
                                        @csrf
                                        @method('PUT')

                                        <div class="sr-form-group">
                                            <label>Durum</label>
                                            <select class="sr-form-control" name="status" required>
                                                @foreach($statusLabels as $key => $label)
                                                    <option value="{{ $key }}" {{ $serviceRequest->status == $key ? 'selected' : '' }}>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="sr-form-group">
                                            <label>Son Fiyat (TL)</label>
                                            <input type="number" class="sr-form-control" name="final_price"
                                                value="{{ $serviceRequest->final_price }}" step="0.01" min="0"
                                                placeholder="0.00">
                                        </div>

                                        <div class="sr-form-group">
                                            <label>Yönetici Notları</label>
                                            <textarea class="sr-form-control" name="admin_notes" rows="3"
                                                placeholder="Notlarınızı yazın...">{{ $serviceRequest->admin_notes }}</textarea>
                                        </div>

                                        <button type="submit" class="sr-btn-update"><i class="fa fa-save"></i> Güncelle</button>
                                    </form>
                                </div>
                            </div>
                        @endif

                        <div class="sr-card">
                            <div class="sr-card-header"><i class="fa fa-bolt"></i> Hızlı İşlemler</div>
                            <div class="sr-card-body">
                                <div class="sr-quick-Actionler">
                                    @if($serviceRequest->status == 'pending' && $canApprove)
                                        <button class="sr-btn-Action sr-btn-approve" onclick="approveRequest()"><i
                                                class="fa fa-check"></i> Onayla</button>
                                    @endif
                                    @if(($serviceRequest->status == 'approved' || $serviceRequest->status == 'in_progress') && $canManageStatus)
                                        <button class="sr-btn-Action sr-btn-complete" onclick="completeRequest()"><i
                                                class="fa fa-flag"></i> Tamamla</button>
                                    @endif
                                    @if(($serviceRequest->status != 'completed' && $serviceRequest->status != 'cancelled') && $canManageStatus)
                                        <button class="sr-btn-Action sr-btn-cancel" onclick="cancelRequest()"><i
                                                class="fa fa-times"></i> İptal</button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- *** AUTO-MATCHING PANEL *** --}}
                        <div class="sr-card">
                            <div class="sr-card-header" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                                <i class="fa fa-magic"></i> Otomatik Eşleştirme
                            </div>
                            <div class="sr-card-body">
                                {{-- Current Match Status --}}
                                <div class="sr-info-row">
                                    <div class="sr-info-label">Otomasyon</div>
                                    <div class="sr-info-value">
                                        @php
                                            $autoLabels = [
                                                'pending_matching' => ['label' => 'Kuyrukta', 'class' => 'warning'],
                                                'matched'          => ['label' => 'Eşleşti',  'class' => 'success'],
                                                'accepted'         => ['label' => 'Kabul Edildi', 'class' => 'primary'],
                                                'failed'           => ['label' => 'Başarısız', 'class' => 'danger'],
                                            ];
                                            $al = $autoLabels[$serviceRequest->automation_status] ?? ['label' => $serviceRequest->automation_status, 'class' => 'default'];
                                        @endphp
                                        <span class="label label-{{ $al['class'] }}">{{ $al['label'] }}</span>
                                        <small class="text-muted">(Deneme: {{ $serviceRequest->matching_attempts ?? 0 }}/5)</small>
                                    </div>
                                </div>

                                {{-- Matched Personnel --}}
                                <div class="sr-info-row">
                                    <div class="sr-info-label">Atanan</div>
                                    <div class="sr-info-value">
                                        @if($serviceRequest->matchedPersonnel)
                                            <strong>{{ $serviceRequest->matchedPersonnel->getName() }}</strong>
                                            <br><small class="text-muted">{{ $serviceRequest->matchedPersonnel->email }}</small>
                                        @else
                                            <span class="text-muted">— Henüz atanmadı</span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Trigger Match Button --}}
                                @if(in_array($serviceRequest->automation_status, ['pending_matching', 'failed']) || !$serviceRequest->matched_personnel_id)
                                    <form action="{{ route('admin.automation.trigger', $serviceRequest->id) }}" method="POST" style="margin-top:10px;">
                                        @csrf
                                        <button type="submit" class="btn btn-block" style="background:#11998e;color:white;border-radius:8px;font-weight:600;">
                                            <i class="fa fa-refresh"></i> Şimdi Eşleştir
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.automation.retry', $serviceRequest->id) }}" method="POST" style="margin-top:10px;">
                                        @csrf
                                        <button type="submit" class="btn btn-block btn-warning" style="border-radius:8px;font-weight:600;">
                                            <i class="fa fa-undo"></i> Yeniden Eşleştir
                                        </button>
                                    </form>
                                @endif

                                {{-- Candidates Table --}}
                                @if(isset($candidates) && $candidates->count() > 0)
                                    <hr>
                                    <strong style="font-size:13px;"><i class="fa fa-list"></i> Uygun Adaylar (Puan Sıralı)</strong>
                                    <div class="table-responsive" style="margin-top:10px;">
                                        <table class="table table-condensed table-striped" style="font-size:12px;">
                                            <thead>
                                                <tr>
                                                    <th>Ad</th>
                                                    <th>Puan</th>
                                                    <th>Bugün</th>
                                                    <th>⭐</th>
                                                    <th>Ata</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($candidates->take(8) as $cand)
                                                    <tr>
                                                        <td>{{ $cand->first_name }} {{ substr($cand->last_name ?? '', 0, 1) }}.</td>
                                                        <td><span class="label label-{{ $cand->matching_score >= 50 ? 'success' : ($cand->matching_score >= 20 ? 'warning' : 'default') }}">{{ $cand->matching_score }}</span></td>
                                                        <td>
                                                            @php
                                                                $todayCount = \App\ServiceRequest::where('matched_personnel_id', $cand->id)
                                                                    ->whereDate('preferred_date', $serviceRequest->preferred_date ?? today())
                                                                    ->count();
                                                            @endphp
                                                            {{ $todayCount }}/{{ $cand->max_daily_tasks ?? 5 }}
                                                        </td>
                                                        <td>{{ number_format($cand->average_rating ?? 0, 1) }}</td>
                                                        <td>
                                                            @if($canAssignPersonnel)
                                                                <form action="{{ route('admin.service-requests.assign-personnel', $serviceRequest->id) }}" method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="user_id" value="{{ $cand->id }}">
                                                                    <button type="submit" class="btn btn-xs btn-success" title="Zorla Ata">
                                                                        <i class="fa fa-check"></i>
                                                                    </button>
                                                                </form>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @elseif(isset($candidates))
                                    <p class="text-muted text-center" style="margin-top:10px;font-size:12px;">
                                        <i class="fa fa-exclamation-circle"></i> Uygun aday bulunamadı.
                                    </p>
                                @endif
                            </div>
                        </div>
                        {{-- *** END AUTO-MATCHING PANEL *** --}}

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="assignModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 12px; overflow: hidden;">
                <div class="modal-header"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none;">
                    <button type="button" class="close" data-dismiss="modal"
                        style="color: white; opacity: 1;">&times;</button>
                    <h4 class="modal-title"><i class="fa fa-user-plus"></i> Personel Ata</h4>
                </div>
                <div class="modal-body" style="padding: 25px;">
                    <div class="sr-form-group">
                        <label>Personel Ara</label>
                        <input type="text" class="sr-form-control" id="personnelSearch"
                            placeholder="İsim veya e-posta ile ara...">
                    </div>
                    <div id="personnelList" style="max-height: 300px; overflow-y: auto;">
                        <div class="sr-empty">Aramak için yazın...</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        var searchUrl = '{{ route("admin.service-requests.search-personnel") }}';
        var assignUrl = '{{ route("admin.service-requests.assign-personnel", $serviceRequest->id) }}';
        var removeUrl = '{{ route("admin.service-requests.remove-personnel", $serviceRequest->id) }}';
        var approveUrl = '{{ route("admin.service-requests.approve", $serviceRequest->id) }}';
        var completeUrl = '{{ route("admin.service-requests.complete", $serviceRequest->id) }}';
        var cancelUrl = '{{ route("admin.service-requests.cancel", $serviceRequest->id) }}';
        var csrfToken = '{{ csrf_token() }}';

        function postRequest(url, data, callback) {
            var formData = new FormData();
            for (var key in data) {
                formData.append(key, data[key]);
            }
            fetch(url, {
                method: 'POST',
                body: formData
            }).then(function (r) { return r.json(); }).then(callback);
        }

        function approveRequest() {
            if (confirm('Bu talebi onaylamak istediğinizden emin misiniz?')) {
                postRequest(approveUrl, { _token: csrfToken }, function (r) { if (r.success) location.reload(); });
            }
        }
        function completeRequest() {
            if (confirm('Bu talebi tamamlandı olarak işaretlemek istediğinizden emin misiniz?')) {
                postRequest(completeUrl, { _token: csrfToken }, function (r) { if (r.success) location.reload(); });
            }
        }
        function cancelRequest() {
            if (confirm('Bu talebi iptal etmek istediğinizden emin misiniz?')) {
                postRequest(cancelUrl, { _token: csrfToken }, function (r) { if (r.success) location.reload(); });
            }
        }

        function openAssignModal() {
            document.getElementById('assignModal').style.display = 'block';
            document.getElementById('assignModal').classList.add('in');
            document.body.classList.add('modal-open');
        }
        function closeAssignModal() {
            document.getElementById('assignModal').style.display = 'none';
            document.getElementById('assignModal').classList.remove('in');
            document.body.classList.remove('modal-open');
        }

        function searchPersonnel(q) {
            if (q.length >= 2) {
                fetch(searchUrl + '?q=' + encodeURIComponent(q))
                    .then(function (r) { return r.json(); })
                    .then(function (data) {
                        var html = '';
                        if (data && data.length > 0) {
                            for (var i = 0; i < data.length; i++) {
                                var u = data[i];
                                html += '<div class="sr-personnel-item" style="cursor:pointer;" onclick="assignPersonnel(' + u.id + ')">';
                                html += '<img src="' + u.image + '" alt="" onerror="this.src=\'{{ asset("admin_assets/no-image.png") }}\'">';
                                html += '<div class="sr-personnel-info"><h5>' + u.name + ' <span class="badge bg-secondary" style="font-size:10px;">' + u.role + '</span></h5><small>' + u.email + '</small></div>';
                                html += '<i class="fa fa-plus" style="color:#667eea;margin-left:auto;"></i></div>';
                            }
                        } else {
                            html = '<div class="sr-empty">Sonuç bulunamadı</div>';
                        }
                        document.getElementById('personnelList').innerHTML = html;
                    })
                    .catch(function (err) {
                        console.log('Arama hatası:', err);
                        document.getElementById('personnelList').innerHTML = '<div class="sr-empty">Arama hatası</div>';
                    });
            }
        }

        function assignPersonnel(userId) {
            postRequest(assignUrl, { _token: csrfToken, user_id: userId }, function (r) {
                if (r.success) location.reload(); else alert(r.message || 'Hata');
            });
        }
        function removePersonnel(userId) {
            if (confirm('Bu personeli kaldırmak istediğinizden emin misiniz?')) {
                postRequest(removeUrl, { _token: csrfToken, user_id: userId }, function (r) { if (r.success) location.reload(); });
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('personnelSearch').addEventListener('keyup', function () {
                searchPersonnel(this.value);
            });

            var closeBtn = document.querySelector('#assignModal .close');
            if (closeBtn) {
                closeBtn.addEventListener('click', closeAssignModal);
            }
        });
    </script>
@endsection