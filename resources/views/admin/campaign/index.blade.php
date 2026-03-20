@extends('admin.layouts.admin_layout')

@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li><a href="{{ route('admin.home') }}">Anasayfa</a><i class="fa fa-circle"></i></li>
                    <li><span>E-posta Kampanya Yönetimi</span></li>
                </ul>
            </div>

            <h3 class="page-title">Profesyonel Kampanya Hazırlama</h3>

            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="icon-envelope font-blue-hoki"></i>
                                <span class="caption-subject font-blue-hoki bold uppercase">Yeni Kampanya Oluştur</span>
                            </div>
                        </div>
                        <div class="portlet-body form">
                            <form action="{{ route('admin.campaign.send') }}" method="POST" class="form-horizontal"
                                onsubmit="tinyMCE.triggerSave();">
                                @csrf
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label class="col-md-2 control-label">Konu</label>
                                                <div class="col-md-10">
                                                    <input type="text" name="subject" class="form-control input-lg"
                                                        placeholder="Kampanya Başlığı / E-posta Konusu" required>
                                                    <span class="help-block">Alıcının e-posta kutusunda göreceği ilgi çekici
                                                        bir konu başlığı yazın.</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label class="col-md-4 control-label">Alıcı Grubu</label>
                                                <div class="col-md-8">
                                                    <select name="recipient_type" class="form-control" required>
                                                        <option value="jobseeker">Tüm Adaylar (Personeller)</option>
                                                        <option value="employer">Tüm Şirketler</option>
                                                        <option value="both">Tüm Kullanıcılar (Aday + Şirket)</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="control-label"
                                                style="display: block; text-align: left; margin-bottom: 10px; font-weight: bold;">E-posta
                                                İçeriği</label>
                                            <textarea name="message" class="form-control" rows="20" id="campaign_message"
                                                required></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-actions right">
                                    <button type="button" class="btn default">İptal</button>
                                    <button type="submit" class="btn blue-hoki"><i class="fa fa-paper-plane"></i> Kampanyayı
                                        Şimdi Başlat</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('admin_assets/global/plugins/tinymce/js/tinymce/jquery.tinymce.min.js') }}"></script>
    <script src="{{ asset('admin_assets/global/plugins/tinymce/js/tinymce/tinymce.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: '#campaign_message',
            height: 500,
            forced_root_block: '',
            entity_encoding: "raw",
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table contextmenu paste code textcolor colorpicker'
            ],
            toolbar: 'insertfile undo redo | styleselect | bold italic underline strikethrough | forecolor backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | code preview',
            relative_urls: false,
            remove_script_host: false,
            convert_urls: true,
            images_upload_url: "{{ route('tinymce.image_upload') }}",
            images_upload_handler: function (blobInfo, success, failure) {
                var xhr, formData;
                xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', "{{ route('tinymce.image_upload') }}");

                // Add CSRF token to headers
                xhr.setRequestHeader('X-CSRF-TOKEN', "{{ csrf_token() }}");

                xhr.onload = function () {
                    var json;
                    if (xhr.status != 200) {
                        failure('HTTP Error: ' + xhr.status);
                        return;
                    }
                    json = JSON.parse(xhr.responseText);
                    if (!json || typeof json.location != 'string') {
                        failure('Invalid JSON: ' + xhr.responseText);
                        return;
                    }
                    success(json.location);
                };
                formData = new FormData();
                formData.append('image', blobInfo.blob(), blobInfo.filename());
                xhr.send(formData);
            },
        });
    </script>
@endpush