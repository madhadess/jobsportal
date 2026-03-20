@extends('admin.layouts.admin_layout')
@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li> <a href="{{ route('admin.home') }}">Anasayfa</a> <i class="fa fa-circle"></i> </li>
                    <li> <span>CRM - Personel Takibi</span> </li>
                </ul>
            </div>

            <h3 class="page-title"> Personel Takip Sistemi <small>Çevrimiçi Durum & Etkinlik</small> </h3>

            <div class="row" id="staff-grid">
                <!-- Staff cards will be loaded here -->
                <div class="col-md-12 text-center" id="loading-spinner">
                    <i class="fa fa-spinner fa-spin fa-3x"></i>
                    <p class="mt-2">Personel verileri yükleniyor...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="notificationModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Mesaj Gönder</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="notificationForm">
                    @csrf
                    <input type="hidden" name="admin_id" id="notify_admin_id">
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Mesaj İçeriği</label>
                            <textarea name="message" class="form-control" rows="4"
                                placeholder="Örn: Yeni hizmet geldi lütfen kontrol et" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>Bildirim Tipi</label>
                            <select name="type" class="form-control">
                                <option value="modal">Modal (Ekranda Üstte)</option>
                                <option value="alert">Alert (Sarı Uyarı)</option>
                                <option value="toast">Toast (Sağ Alt Köşe)</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">İptal</button>
                        <button type="submit" class="btn btn-primary">Gönder</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            function fetchActivities() {
                $.get("{{ route('admin.crm.getStaffActivities') }}", function (data) {
                    let html = '';
                    if (data.length > 0) {
                        data.forEach(function (activity) {
                            // Status Badge
                            let statusDetails = activity.status_details;

                            // Friendly URL
                            let currentPage = activity.friendly_url ? activity.friendly_url : activity.url;

                            // Calculate formatting
                            let statusDuration = formatTime(activity.status_duration_seconds);
                            let pageDuration = formatTime(activity.page_duration_seconds);

                            // Avatar logic
                            let avatarUrl = activity.admin.avatar ?
                                `{{ asset('/') }}admin_assets/avatars/${activity.admin.avatar}` :
                                `https://ui-avatars.com/api/?name=${activity.admin.name}&color=7F9CF5&background=EBF4FF`;

                            html += `
                                                                    <div class="col-md-3 col-sm-6 mb-4">
                                                                        <div class="portlet light bordered" style="border-radius: 12px !important; overflow: hidden; height: 100%;">
                                                                            <div class="portlet-body" style="padding: 20px !important;">
                                                                                <div class="text-center mb-3">
                                                                                    <img class="img-circle" src="${avatarUrl}" style="width: 80px; height: 80px; object-fit: cover; border: 3px solid #f1f5f9; margin-bottom: 10px;">
                                                                                    <h4 style="font-weight: 700; margin: 0; color: #354a5f;">${activity.admin.name}</h4>
                                                                                    <p style="color: #7f8c8d; font-size: 13px; margin: 0;">${activity.admin.role.display_name || activity.admin.role.role_name}</p>
                                                                                </div>

                                                                                <div style="background: #f8fafc; border-radius: 8px; padding: 15px; margin-bottom: 15px;">
                                                                                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                                                                                        <span class="text-muted" style="font-size: 12px; font-weight: 600;">DURUM</span>
                                                                                        <div style="display: flex; gap: 5px; align-items: center;">
                                                                                            ${activity.is_late ? `<span class="badge badge-danger" style="font-size: 10px; padding: 2px 5px;" title="Geç Kaldı (${activity.arrival_time})">GEÇ</span>` : ''}
                                                                                            ${activity.is_early_leave ? `<span class="badge badge-danger" style="font-size: 10px; padding: 2px 5px;" title="Erken Çıktı (${activity.departure_time})">ERKEN</span>` : ''}
                                                                                            <span class="badge badge-${statusDetails.class}" style="padding: 5px 10px;">${statusDetails.text}</span>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div style="text-align: right;">
                                                                                         <small class="status-timer" data-seconds="${activity.status_duration_seconds}" data-status="${activity.current_status}" style="color: #354a5f; font-family: monospace; font-weight: 700;">${statusDuration}</small>
                                                                                    </div>
                                                                                </div>

                                                                                <div style="background: #f1f5f9; border-radius: 8px; padding: 10px; margin-bottom: 15px; border: 1px solid #e2e8f0;">
                                                                                    <div style="display: flex; text-align: center;">
                                                                                        <div style="flex: 1; border-right: 1px solid #cbd5e1;">
                                                                                            <p style="margin: 0; font-size: 10px; color: #64748b; font-weight: 700;">GÜNLÜK ÇAĞRI</p>
                                                                                            <p style="margin: 0; font-size: 12px; font-weight: 700; color: #3b82f6;">${formatTime(activity.today_in_call_seconds)}</p>
                                                                                        </div>
                                                                                        <div style="flex: 1;">
                                                                                            <p style="margin: 0; font-size: 10px; color: #64748b; font-weight: 700;">GÜNLÜK MOLA</p>
                                                                                            <p style="margin: 0; font-size: 12px; font-weight: 700; color: #f59e0b;">${formatTime(activity.today_break_seconds)}</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div style="margin-bottom: 20px;">
                                                                                    <p class="text-muted" style="font-size: 11px; font-weight: 700; text-transform: uppercase; margin-bottom: 5px;">Şu Anki İşlem</p>
                                                                                    <div style="height: 40px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                                                                        <i class="fa fa-link text-primary" style="margin-right: 5px;"></i> ${currentPage}
                                                                                    </div>
                                                                                    <div style="text-align: right; margin-top: 5px;">
                                                                                        <small class="page-timer text-muted" data-seconds="${activity.page_duration_seconds}" data-status="${activity.current_status}" style="font-family: monospace;">Sayfada: ${pageDuration}</small>
                                                                                    </div>
                                                                                </div>

                                                                                <div style="display: flex; gap: 10px;">
                                                                                    <button class="btn btn-default btn-block send-notify-btn" data-id="${activity.admin_id}" data-name="${activity.admin.name}" style="margin: 0;">
                                                                                        <i class="fa fa-paper-plane"></i> Mesaj
                                                                                    </button>
                                                                                    <a href="{{ url('admin/crm/profile') }}/${activity.admin_id}" class="btn btn-primary btn-block" style="margin: 0; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;">
                                                                                        <i class="fa fa-user"></i> Profil
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                `;
                        });
                    } else {
                        html = '<div class="col-md-12 text-center text-muted"><h4>Hiç personel bulunamadı.</h4></div>';
                    }

                    $('#staff-grid').html(html);
                });
            }

            function formatTime(seconds) {
                var date = new Date(0);
                date.setSeconds(seconds);
                return date.toISOString().substr(11, 8);
            }

            function isOfflineStatus(status) {
                if (!status) return true;
                var normalized = String(status).trim().toUpperCase();
                return normalized === 'OFFLINE' || normalized === 'ÇEVRİMDIŞI' || normalized === 'ÇEVRIMDIŞI' || normalized === 'CEVRIMDISI';
            }

            // Live Timer Tick
            setInterval(function () {
                $('.status-timer').each(function () {
                    // Don't increment if status is OFFLINE
                    var status = $(this).attr('data-status');
                    if (isOfflineStatus(status)) return;

                    let sec = (parseInt($(this).attr('data-seconds'), 10) || 0) + 1;
                    $(this).attr('data-seconds', sec);
                    $(this).text(formatTime(sec));
                });
                $('.page-timer').each(function () {
                    // Don't increment if status is OFFLINE
                    var status = $(this).attr('data-status');
                    if (isOfflineStatus(status)) return;

                    let sec = (parseInt($(this).attr('data-seconds'), 10) || 0) + 1;
                    $(this).attr('data-seconds', sec);
                    $(this).text("Sayfada: " + formatTime(sec));
                });
            }, 1000);

            // Resync execution
            window.fetchActivities = fetchActivities; // Expose globally for status updates
            setInterval(fetchActivities, 5000); // Reduce to 5 seconds
            fetchActivities();

            $(document).on('click', '.send-notify-btn', function () {
                $('#notify_admin_id').val($(this).data('id'));
                $('#notificationModal .modal-title').text($(this).data('name') + ' Kullanıcısına Mesaj Gönder');
                $('#notificationModal').modal('show');
            });

            $('#notificationForm').submit(function (e) {
                e.preventDefault();
                $.post("{{ route('admin.crm.sendNotification') }}", $(this).serialize(), function (response) {
                    if (response.success) {
                        alert(response.message);
                        $('#notificationModal').modal('hide');
                        $('#notificationForm')[0].reset();
                    }
                });
            });
        });
    </script>
@endpush