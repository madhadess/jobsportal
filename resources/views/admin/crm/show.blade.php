@extends('admin.layouts.admin_layout')

@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <!-- Breadcrumb -->
            <div class="page-bar"
                style="margin-bottom: 30px; border-radius: 0; border: none; background: transparent; box-shadow: none;">
                <ul class="page-breadcrumb">
                    <li> <a href="{{ route('admin.home') }}">Anasayfa</a> <i class="fa fa-circle"
                            style="font-size: 6px; margin: 0 10px; color: #cbd5e1;"></i> </li>
                    <li> <a href="{{ route('admin.crm.index') }}">Personel Takip</a> <i class="fa fa-circle"
                            style="font-size: 6px; margin: 0 10px; color: #cbd5e1;"></i> </li>
                    <li> <span style="color: #64748b; font-weight: 600;">{{ $admin->name }}</span> </li>
                </ul>
            </div>

            <!-- NEW Hero Header Card -->
            <div class="portlet light bordered"
                style="border-radius: 15px !important; border: none !important; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05) !important; background: #fff !important; margin-bottom: 30px !important;">
                <div class="portlet-body" style="padding: 30px !important;">
                    <div class="row" style="display: flex; align-items: center; flex-wrap: wrap;">
                        <div class="col-md-2 text-center mb-3 mb-md-0">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($admin->name) }}&color=7F9CF5&background=EBF4FF&size=200"
                                style="width: 120px; height: 120px; border-radius: 50%; border: 4px solid #fff; box-shadow: 0 10px 20px rgba(0,0,0,0.1);">
                        </div>
                        <div class="col-md-6 mb-4 mb-md-0">
                            <h2
                                style="margin: 0; font-weight: 800; color: #1e293b; font-size: 28px; letter-spacing: -0.5px;">
                                {{ $admin->name }}
                            </h2>
                            <p style="color: #64748b; font-size: 16px; margin: 8px 0 20px; font-weight: 500;">
                                {{ $admin->role->display_name ?? $admin->role->role_name }}
                            </p>

                            <div style="display: flex; gap: 15px; align-items: center; flex-wrap: wrap;">
                                <span class="badge badge-{{ $statusDetails['class'] }}"
                                    style="padding: 10px 20px; font-weight: 700; font-size: 13px; border-radius: 10px; text-transform: uppercase; letter-spacing: 0.5px;">
                                    {{ $statusDetails['text'] }}
                                </span>
                                <div
                                    style="display: flex; align-items: center; background: #f8fafc; padding: 8px 18px; border-radius: 12px; border: 1px solid #f1f5f9;">
                                    <i class="fa fa-clock-o"
                                        style="color: #64748b; margin-right: 10px; font-size: 18px;"></i>
                                    <span id="profile-status-timer"
                                        style="font-family: 'JetBrains Mono', monospace; font-size: 22px; font-weight: 700; color: #334155;">00:00:00</span>
                                </div>
                                @if(($effectiveStatus ?? 'OFFLINE') == 'OFFLINE' || ($effectiveStatus ?? 'OFFLINE') == 'Çevrimdışı')
                                    <div
                                        style="color: #e7505a; font-weight: 700; font-size: 13px; display: flex; align-items: center; background: #fff1f2; padding: 8px 15px; border-radius: 10px;">
                                        <i class="fa fa-sign-out" style="margin-right: 8px;"></i> Çıkış:
                                        {{ $admin->status_updated_at ? \Carbon\Carbon::parse($admin->status_updated_at)->format('H:i:s') : '-' }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4 text-md-right text-center" style="align-self: flex-start;">
                            <div style="display: inline-flex; gap: 12px;">
                                <a href="{{ route('admin.crm.index') }}" class="btn btn-default"
                                    style="border-radius: 12px; padding: 12px 24px; font-weight: 700; background: #f8fafc; border: 1px solid #e2e8f0; color: #475569;">
                                    <i class="fa fa-arrow-left" style="margin-right: 5px;"></i> Geri
                                </a>
                                <button class="btn btn-primary" id="header-msg-btn"
                                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important; border: none !important; border-radius: 12px !important; padding: 12px 24px !important; font-weight: 700; box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3) !important;">
                                    <i class="fa fa-envelope" style="margin-right: 5px;"></i> Mesaj Gönder
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="row">
                <!-- Left: Stats & Compliance -->
                <div class="col-md-8">
                    <!-- Daily Stats -->
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div
                                style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border-radius: 18px; padding: 25px; color: white; box-shadow: 0 10px 20px rgba(59, 130, 246, 0.15); height: 100%;">
                                <div
                                    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                    <div
                                        style="background: rgba(255,255,255,0.2); width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fa fa-phone" style="font-size: 22px;"></i>
                                    </div>
                                    <span
                                        style="font-size: 11px; font-weight: 800; opacity: 0.8; letter-spacing: 1px;">ÖZET</span>
                                </div>
                                <h3 style="margin: 0; font-weight: 800; font-size: 26px; letter-spacing: -0.5px;">
                                    {{ gmdate("H:i:s", $dailyStats['online']) }}
                                </h3>
                                <p style="margin: 8px 0 0; font-size: 14px; font-weight: 500; opacity: 0.9;">Toplam
                                    Çevrimiçi</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div
                                style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 18px; padding: 25px; color: white; box-shadow: 0 10px 20px rgba(245, 158, 11, 0.15); height: 100%;">
                                <div
                                    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                    <div
                                        style="background: rgba(255,255,255,0.2); width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fa fa-coffee" style="font-size: 22px;"></i>
                                    </div>
                                    <span
                                        style="font-size: 11px; font-weight: 800; opacity: 0.8; letter-spacing: 1px;">MOLA</span>
                                </div>
                                <h3 style="margin: 0; font-weight: 800; font-size: 26px; letter-spacing: -0.5px;">
                                    {{ gmdate("H:i:s", $dailyStats['break']) }}
                                </h3>
                                <p style="margin: 8px 0 0; font-size: 14px; font-weight: 500; opacity: 0.9;">Günlük Mola</p>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            @php
                                $limitSeconds = $dailyStats['break_limit_mins'] * 60;
                                $remainingSeconds = max(0, $limitSeconds - $dailyStats['break']);
                                $statGrad = $remainingSeconds > 0 ? 'linear-gradient(135deg, #10b981 0%, #059669 100%)' : 'linear-gradient(135deg, #ef4444 0%, #dc2626 100%)';
                                $statShadow = $remainingSeconds > 0 ? 'rgba(16, 185, 129, 0.15)' : 'rgba(239, 68, 68, 0.15)';
                            @endphp
                            <div
                                style="background: {{ $statGrad }}; border-radius: 18px; padding: 25px; color: white; box-shadow: 0 10px 20px {{ $statShadow }}; height: 100%;">
                                <div
                                    style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                    <div
                                        style="background: rgba(255,255,255,0.2); width: 45px; height: 45px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fa fa-clock-o" style="font-size: 24px;"></i>
                                    </div>
                                    <span
                                        style="font-size: 11px; font-weight: 800; opacity: 0.8; letter-spacing: 1px;">KALAN</span>
                                </div>
                                <h3 style="margin: 0; font-weight: 800; font-size: 26px; letter-spacing: -0.5px;">
                                    {{ floor($remainingSeconds / 60) }}:{{ str_pad($remainingSeconds % 60, 2, '0', STR_PAD_LEFT) }}
                                </h3>
                                <p style="margin: 8px 0 0; font-size: 14px; font-weight: 500; opacity: 0.9;">Kalan Mola
                                    Hakkı</p>
                            </div>
                        </div>
                    </div>

                    <!-- Shift Compliance Card -->
                    <div class="portlet light bordered"
                        style="border-radius: 18px !important; border: none !important; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05) !important; background: #fff !important; margin-bottom: 30px !important;">
                        <div class="portlet-title"
                            style="border: none !important; padding: 20px 25px 0 !important; background: transparent !important;">
                            <div class="caption">
                                <i class="icon-calendar font-blue-madison" style="margin-right: 10px;"></i>
                                <span class="caption-subject font-blue-madison bold uppercase"
                                    style="font-size: 14px; letter-spacing: 1px;">Mesai Uyumu (Bugün)</span>
                            </div>
                        </div>
                        <div class="portlet-body" style="padding: 25px !important;">
                            <div class="row">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <div
                                        style="background: #f8fafc; border-radius: 15px; padding: 20px; border: 1px solid #f1f5f9; display: flex; align-items: center; gap: 20px;">
                                        <div
                                            style="background: #fff; width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                                            <i class="fa fa-sign-in" style="font-size: 20px; color: #3b82f6;"></i>
                                        </div>
                                        <div style="flex: 1;">
                                            <span
                                                style="font-size: 11px; color: #94a3b8; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">GİRİŞ
                                                SAATİ</span>
                                            <div style="display: flex; align-items: center; gap: 10px; margin-top: 5px;">
                                                <h3
                                                    style="margin: 0; font-weight: 800; color: {{ $compliance['is_late'] ? '#ef4444' : '#1e293b' }};">
                                                    {{ $compliance['arrival'] ?: 'Giriş Yok' }}
                                                </h3>
                                                @if($compliance['is_late'])
                                                    <span
                                                        style="font-size: 10px; font-weight: 800; color: #b91c1c; background: #fee2e2; padding: 4px 8px; border-radius: 6px;">GEÇ
                                                        KALDI</span>
                                                @endif
                                            </div>
                                            <small style="color: #64748b; font-weight: 500;">Mesai Başlangıç:
                                                {{ $compliance['shift_start'] }}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div
                                        style="background: #f8fafc; border-radius: 15px; padding: 20px; border: 1px solid #f1f5f9; display: flex; align-items: center; gap: 20px;">
                                        <div
                                            style="background: #fff; width: 50px; height: 50px; border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 6px rgba(0,0,0,0.02);">
                                            <i class="fa fa-sign-out" style="font-size: 20px; color: #64748b;"></i>
                                        </div>
                                        <div style="flex: 1;">
                                            <span
                                                style="font-size: 11px; color: #94a3b8; font-weight: 800; text-transform: uppercase; letter-spacing: 1px;">SON
                                                ÇIKIŞ</span>
                                            <div style="display: flex; align-items: center; gap: 10px; margin-top: 5px;">
                                                <h3
                                                    style="margin: 0; font-weight: 800; color: {{ $compliance['is_early'] ? '#ef4444' : '#1e293b' }};">
                                                    {{ $compliance['departure'] ?: '--:--' }}
                                                </h3>
                                                @if($compliance['is_early'])
                                                    <span
                                                        style="font-size: 10px; font-weight: 800; color: #b91c1c; background: #fee2e2; padding: 4px 8px; border-radius: 6px;">ERKEN
                                                        ÇIKTI</span>
                                                @endif
                                            </div>
                                            <small style="color: #64748b; font-weight: 500;">Mesai Bitiş:
                                                {{ $compliance['shift_end'] }}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Timeline/History -->
                <div class="col-md-4">
                    <div class="portlet light bordered"
                        style="border-radius: 18px !important; border: none !important; box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05) !important; background: #fff !important; min-height: 550px;">
                        <div class="portlet-title tabbable-line"
                            style="border: none !important; padding: 20px 0 0 !important; background: transparent !important; margin: 0;">
                            <ul class="nav nav-tabs"
                                style="border: none; display: flex; justify-content: center; gap: 20px; width: 100%;">
                                <li class="active" style="float: none; margin: 0;">
                                    <a href="#tab_timeline" data-toggle="tab"
                                        style="font-weight: 700; color: #64748b; border: none !important; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; padding: 10px 5px !important; border-bottom: 3px solid transparent !important;">Aktivite</a>
                                </li>
                                <li style="float: none; margin: 0;">
                                    <a href="#tab_info" data-toggle="tab"
                                        style="font-weight: 700; color: #64748b; border: none !important; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; padding: 10px 5px !important; border-bottom: 3px solid transparent !important;">Detay</a>
                                </li>
                                <li style="float: none; margin: 0;">
                                    <a href="#tab_messages" data-toggle="tab" id="msg-tab-link"
                                        style="font-weight: 700; color: #64748b; border: none !important; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; padding: 10px 5px !important; border-bottom: 3px solid transparent !important;">Mesajlar</a>
                                </li>
                                <li style="float: none; margin: 0;">
                                    <a href="#tab_notes" data-toggle="tab" id="notes-tab-link"
                                        style="font-weight: 700; color: #64748b; border: none !important; font-size: 14px; text-transform: uppercase; letter-spacing: 1px; padding: 10px 5px !important; border-bottom: 3px solid transparent !important;">Notlar
                                        & Etkinlikler</a>
                                </li>
                            </ul>
                        </div>
                        <div class="portlet-body" style="padding: 25px 20px !important;">
                            <div class="tab-content">
                                <!-- TIMELINE -->
                                <div class="tab-pane active" id="tab_timeline">
                                    <div class="custom-timeline"
                                        style="max-height: 400px; overflow-y: auto; padding-right: 10px; position: relative;">
                                        <div class="timeline-line"
                                            style="position: absolute; left: 10px; top: 0; bottom: 0; width: 2px; background: #f1f5f9;">
                                        </div>
                                        @forelse($history as $log)
                                            <div
                                                style="display: flex; gap: 20px; margin-bottom: 25px; position: relative; z-index: 1;">
                                                <div
                                                    style="width: 22px; height: 22px; border: 4px solid #fff; border-radius: 50%; background: #667eea; margin-top: 3px; flex-shrink: 0; box-shadow: 0 2px 4px rgba(102, 126, 234, 0.3);">
                                                </div>
                                                <div style="flex: 1;">
                                                    <p
                                                        style="margin: 0; font-size: 14px; font-weight: 600; color: #334155; line-height: 1.5;">
                                                        {{ $log->action_sentence }}
                                                    </p>
                                                    <small
                                                        style="color: #94a3b8; font-weight: 600; font-size: 11px; text-transform: uppercase;">{{ $log->created_at->diffForHumans() }}</small>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="text-center py-5">
                                                <div
                                                    style="background: #f8fafc; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px;">
                                                    <i class="fa fa-history" style="font-size: 30px; color: #cbd5e1;"></i>
                                                </div>
                                                <p style="color: #64748b; font-weight: 600;">İşlem kaydı bulunmuyor.</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                                <!-- DETAYLAR -->
                                <div class="tab-pane" id="tab_info">
                                    <div style="display: flex; flex-direction: column; gap: 25px;">
                                        <div>
                                            <label
                                                style="display: block; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">E-POSTA
                                                ADRESİ</label>
                                            <div
                                                style="background: #f8fafc; padding: 12px 15px; border-radius: 12px; border: 1px solid #f1f5f9; color: #334155; font-weight: 600;">
                                                {{ $admin->email }}
                                            </div>
                                        </div>
                                        <div>
                                            <label
                                                style="display: block; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">YETKİ
                                                GRUBU</label>
                                            <div
                                                style="background: #f8fafc; padding: 12px 15px; border-radius: 12px; border: 1px solid #f1f5f9; color: #1e293b; font-weight: 700;">
                                                {{ $admin->role->role_name }}
                                            </div>
                                        </div>
                                        <div>
                                            <label
                                                style="display: block; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">HESAP
                                                KAYDI</label>
                                            <div
                                                style="background: #f8fafc; padding: 12px 15px; border-radius: 12px; border: 1px solid #f1f5f9; color: #334155; font-weight: 600;">
                                                <i class="fa fa-calendar-o" style="margin-right: 8px; color: #94a3b8;"></i>
                                                {{ $admin->created_at->format('d.m.Y H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- MESSAGES TAB -->
                                <div class="tab-pane" id="tab_messages">
                                    <div id="chat-container" style="display: flex; flex-direction: column; height: 450px;">
                                        <div id="chat-messages"
                                            style="flex: 1; overflow-y: auto; padding: 10px; background: #f8fafc; border-radius: 12px; margin-bottom: 15px; border: 1px solid #f1f5f9; display: flex; flex-direction: column;">
                                            <!-- Messages will be loaded here via JS -->
                                            <div style="text-align: center; color: #94a3b8; margin-top: 20px;">
                                                <i class="fa fa-spinner fa-spin" style="font-size: 24px;"></i>
                                                <p style="font-size: 12px; margin-top: 10px;">Mesajlar yükleniyor...</p>
                                            </div>
                                        </div>
                                        <div style="display: flex; gap: 10px; align-items: flex-end;">
                                            <textarea id="chat-input" class="form-control" rows="2"
                                                placeholder="Mesajınızı yazın..."
                                                style="resize: none; border-radius: 12px !important; padding: 12px !important; font-size: 13px !important;"></textarea>
                                            <button id="btn-send-message" class="btn btn-primary"
                                                style="height: 45px; width: 45px; padding: 0 !important; border-radius: 12px !important; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                                <i class="fa fa-paper-plane" style="font-size: 18px;"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- NOTES TAB -->
                                <div class="tab-pane" id="tab_notes">
                                    <div
                                        style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                                        <h4 style="margin: 0; font-weight: 700; color: #1e293b;">Notlar & Etkinlikler</h4>
                                        <button class="btn btn-sm btn-primary" data-toggle="modal"
                                            data-target="#modal-add-note" style="border-radius: 8px !important;">
                                            <i class="fa fa-plus" style="margin-right: 5px;"></i> Yeni Not
                                        </button>
                                    </div>
                                    <div id="notes-container"
                                        style="max-height: 450px; overflow-y: auto; padding-right: 5px;">
                                        <!-- Notes will be loaded here via JS -->
                                        <div class="text-center py-5">
                                            <i class="fa fa-spinner fa-spin" style="font-size: 24px; color: #cbd5e1;"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .custom-timeline::-webkit-scrollbar {
            width: 4px;
        }

        .custom-timeline::-webkit-scrollbar-track {
            background: #f8fafc;
            border-radius: 10px;
        }

        .custom-timeline::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }

        .tabbable-line>.nav-tabs>li.active>a {
            color: #667eea !important;
            border-bottom: 3px solid #667eea !important;
            background: transparent !important;
        }

        .tabbable-line>.nav-tabs>li>a:hover {
            color: #1e293b !important;
        }
    </style>
    <!-- ADD NOTE MODAL -->
    <div class="modal fade" id="modal-add-note" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 15px !important; border: none !important;">
                <div class="modal-header"
                    style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; border-radius: 15px 15px 0 0;">
                    <h4 class="modal-title" style="font-weight: 800; color: #1e293b;">Yeni Not / Etkinlik Ekle</h4>
                </div>
                <div class="modal-body" style="padding: 25px !important;">
                    <form id="form-add-note">
                        <input type="hidden" name="admin_id" value="{{ $admin->id }}">
                        <div class="form-group">
                            <label style="font-weight: 700; color: #475569;">Başlık / Konu</label>
                            <input type="text" name="title" class="form-control" placeholder="Örn: Müşteri Takibi" required>
                        </div>
                        <div class="form-group">
                            <label style="font-weight: 700; color: #475569;">İçerik</label>
                            <textarea name="content" class="form-control" rows="4" placeholder="Not detaylarını yazın..."
                                required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="font-weight: 700; color: #475569;">Etkinlik Tarihi (Opsiyonel)</label>
                                    <input type="datetime-local" name="event_date" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label style="font-weight: 700; color: #475569;">Öncelik</label>
                                    <select name="priority" class="form-control">
                                        <option value="Low">Düşük</option>
                                        <option value="Medium" selected>Orta</option>
                                        <option value="High">Yüksek</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer"
                    style="background: #f8fafc; border-top: 1px solid #e2e8f0; border-radius: 0 0 15px 15px;">
                    <button type="button" class="btn btn-default" data-dismiss="modal"
                        style="border-radius: 10px !important;">Vazgeç</button>
                    <button type="button" id="btn-save-note" class="btn btn-primary"
                        style="border-radius: 10px !important;">Kaydet</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var statusSeconds = {{ $statusDuration }};
        var currentStatus = "{{ $effectiveStatus ?? 'OFFLINE' }}";

        function isOfflineStatus(status) {
            if (!status) return true;
            var normalized = String(status).trim().toUpperCase();
            return normalized === 'OFFLINE' || normalized === 'ÇEVRİMDIŞI' || normalized === 'ÇEVRIMDIŞI' || normalized === 'CEVRIMDISI';
        }

        function startProfileTimer() {
            setInterval(function () {
                // Don't increment if offline
                if (isOfflineStatus(currentStatus)) return;

                statusSeconds++;
                var date = new Date(0);
                date.setSeconds(statusSeconds);
                var timeString = date.toISOString().substr(11, 8);
                $('#profile-status-timer').text(timeString);
            }, 1000);
        }

        startProfileTimer();

        // Header Message Button Switcher
        $('#header-msg-btn').on('click', function () {
            $('#msg-tab-link').tab('show');
            $('html, body').animate({
                scrollTop: $("#tab_messages").offset().top - 100
            }, 500);
        });

        // Messaging Logic
        const adminId = {{ $admin->id }};
        const chatMessages = $('#chat-messages');
        const chatInput = $('#chat-input');
        const btnSend = $('#btn-send-message');

        function loadMessages() {
            $.get('{{ route('admin.messages.history', '') }}/' + adminId, function (data) {
                chatMessages.empty();
                if (data.length === 0) {
                    chatMessages.append('<div style="text-align: center; color: #94a3b8; margin-top: 20px;">Henüz mesaj bulunmuyor.</div>');
                } else {
                    data.forEach(function (msg) {
                        const isMe = msg.sender_id == {{ Auth::guard('admin')->id() }};
                        const align = isMe ? 'flex-end' : 'flex-start';
                        const bg = isMe ? '#e0f2fe' : '#fff';
                        const color = '#334155';
                        const shadow = '0 2px 4px rgba(0,0,0,0.02)';

                        const msgHtml = `
                                            <div style="display: flex; flex-direction: column; align-items: ${align}; margin-bottom: 15px; width: 100%;">
                                                <div style="display: flex; flex-direction: column; align-items: ${align}; max-width: 85%;">
                                                    <div style="background: ${bg}; color: ${color}; padding: 12px 16px; border-radius: 12px; box-shadow: ${shadow}; font-size: 13px; font-weight: 500; border: 1px solid #f1f5f9; position: relative;">
                                                        ${msg.message}
                                                    </div>
                                                    <small style="font-size: 10px; color: #94a3b8; margin-top: 6px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">
                                                        ${new Date(msg.created_at).toLocaleString('tr-TR', { hour: '2-digit', minute: '2-digit', day: '2-digit', month: 'short' })}
                                                    </small>
                                                </div>
                                            </div>
                                        `;
                        chatMessages.append(msgHtml);
                    });
                    chatMessages.scrollTop(chatMessages[0].scrollHeight);
                }
            });
        }

        $('#msg-tab-link').on('shown.bs.tab', function () {
            loadMessages();
        });

        btnSend.on('click', function () {
            const val = chatInput.val().trim();
            if (!val) return;

            btnSend.prop('disabled', true);
            $.post('{{ route('admin.messages.send') }}', {
                _token: '{{ csrf_token() }}',
                receiver_id: adminId,
                message: val
            }, function (res) {
                chatInput.val('');
                btnSend.prop('disabled', false);
                loadMessages();
            });
        });

        chatInput.on('keypress', function (e) {
            if (e.which == 13 && !e.shiftKey) {
                e.preventDefault();
                btnSend.click();
            }
        });

        // Notes Logic
        const notesContainer = $('#notes-container');
        const btnSaveNote = $('#btn-save-note');
        const formAddNote = $('#form-add-note');

        function loadNotes() {
            notesContainer.html('<div class="text-center py-5"><i class="fa fa-spinner fa-spin" style="font-size: 24px; color: #cbd5e1;"></i></div>');
            $.get('{{ route('admin.crm.notes.get', '') }}/' + adminId, function (data) {
                notesContainer.empty();
                if (data.length === 0) {
                    notesContainer.append('<div class="text-center py-5" style="color: #64748b; font-weight: 600;">Henüz not bulunmuyor.</div>');
                } else {
                    data.forEach(function (note) {
                        const priorityColor = note.priority === 'High' ? '#ef4444' : (note.priority === 'Medium' ? '#f59e0b' : '#3b82f6');
                        const isDone = note.is_completed;

                        const noteHtml = `
                                    <div class="note-item" style="background: #fff; border: 1px solid #f1f5f9; border-radius: 12px; padding: 15px; margin-bottom: 15px; box-shadow: 0 2px 4px rgba(0,0,0,0.02); position: relative; border-left: 4px solid ${priorityColor};">
                                        <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px;">
                                            <h5 style="margin: 0; font-weight: 700; color: #1e293b; text-decoration: ${isDone ? 'line-through' : 'none'}; opacity: ${isDone ? '0.6' : '1'};">${note.title}</h5>
                                            <div style="display: flex; gap: 8px;">
                                                <button class="btn-toggle-note" data-id="${note.id}" style="background: none; border: none; padding: 0; color: ${isDone ? '#10b981' : '#94a3b8'}; cursor: pointer;">
                                                    <i class="fa ${isDone ? 'fa-check-circle' : 'fa-circle-o'}" style="font-size: 18px;"></i>
                                                </button>
                                                <button class="btn-delete-note" data-id="${note.id}" style="background: none; border: none; padding: 0; color: #ef4444; opacity: 0.6; cursor: pointer;">
                                                    <i class="fa fa-trash-o" style="font-size: 16px;"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <p style="margin: 0 0 10px; font-size: 13px; color: #475569; text-decoration: ${isDone ? 'line-through' : 'none'}; opacity: ${isDone ? '0.6' : '1'};">${note.content}</p>
                                        <div style="display: flex; gap: 15px; flex-wrap: wrap;">
                                            ${note.formatted_date ? `<small style="color: #64748b; font-weight: 700; background: #f1f5f9; padding: 2px 8px; border-radius: 6px;"><i class="fa fa-calendar" style="margin-right: 5px;"></i> ${note.formatted_date}</small>` : ''}
                                            <small style="color: #94a3b8; font-weight: 600;">Oluşturan: ${note.creator ? note.creator.name : 'Sistem'} • ${note.created_human}</small>
                                        </div>
                                    </div>
                                `;
                        notesContainer.append(noteHtml);
                    });
                }
            });
        }

        $('#notes-tab-link').on('shown.bs.tab', function () {
            loadNotes();
        });

        btnSaveNote.on('click', function () {
            const formData = formAddNote.serialize();
            btnSaveNote.prop('disabled', true).text('Kaydediliyor...');

            $.post('{{ route('admin.crm.notes.store') }}', formData + '&_token={{ csrf_token() }}', function (res) {
                if (res.success) {
                    $('#modal-add-note').modal('hide');
                    formAddNote[0].reset();
                    loadNotes();
                }
                btnSaveNote.prop('disabled', false).text('Kaydet');
            });
        });

        $(document).on('click', '.btn-toggle-note', function () {
            const id = $(this).data('id');
            $.post('{{ url("admin/crm/notes/toggle") }}/' + id, { _token: '{{ csrf_token() }}' }, function (res) {
                if (res.success) loadNotes();
            });
        });

        $(document).on('click', '.btn-delete-note', function () {
            if (!confirm('Bu notu silmek istediğinize emin misiniz?')) return;
            const id = $(this).data('id');
            $.ajax({
                url: '{{ url("admin/crm/notes/delete") }}/' + id,
                type: 'DELETE',
                data: { _token: '{{ csrf_token() }}' },
                success: function (res) {
                    if (res.success) loadNotes();
                }
            });
        });
    </script>
@endpush