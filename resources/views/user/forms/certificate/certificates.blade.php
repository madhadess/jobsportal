<div class="newcvcard">
    <div class="cardhead">
        <h4>{{__('Sertifikalar')}}</h4>
        <a href="javascript:;" onclick="showCertificateModal();"><i class="fas fa-plus"></i></a>
    </div>
    <div class="cardintbody">
        <div id="certificate_div"></div>
    </div>
</div>

<div class="modal fade" id="add_certificate_modal" tabindex="-1" aria-hidden="true" role="dialog"></div>

@push('scripts')
    <script type="text/javascript">
        function showCertificateModal() {
            var html = '<div class="modal-dialog modal-dialog-centered"><div class="modal-content">' +
                '<form id="add_certificate_form" method="POST" enctype="multipart/form-data">' +
                '@csrf' +
                '<div class="modal-header"><h4 class="modal-title">Sertifika Ekle</h4>' +
                '<button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>' +
                '<div class="modal-body"><div class="form-body">' +
                '<div class="formrow mb-3"><input class="form-control" name="certificate_title" placeholder="Sertifika Başlığı" required></div>' +
                '<div class="formrow"><label class="form-label">Sertifika Dosyası (PDF, JPG, PNG)</label>' +
                '<input class="form-control" type="file" name="certificate_file" accept=".pdf,.jpg,.jpeg,.png"></div>' +
                '</div></div>' +
                '<div class="modal-footer"><button type="button" class="btn btn-primary" onclick="submitCertificateForm();">Kaydet <i class="fa fa-check"></i></button></div>' +
                '</form></div></div>';
            $("#add_certificate_modal").html(html);
            openModal('add_certificate_modal');
        }

        function submitCertificateForm() {
            var form = document.getElementById('add_certificate_form');
            var formData = new FormData(form);
            $.ajax({
                url: "{{ route('store.front.profile.certificate', $user->id) }}",
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (json) {
                    showCertificates();
                    var modalEl = document.getElementById('add_certificate_modal');
                    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                        var modal = bootstrap.Modal.getInstance(modalEl);
                        if (modal) modal.hide();
                    } else {
                        $(modalEl).modal('hide');
                    }
                },
                error: function (xhr) {
                    if (xhr.status === 422) {
                        var errors = xhr.responseJSON.errors;
                        var msg = '';
                        $.each(errors, function (key, val) { msg += val[0] + '\n'; });
                        alert(msg);
                    }
                }
            });
        }

        function delete_profile_certificate(id) {
            if (confirm('Silmek istediğinize emin misiniz?')) {
                $.post("{{ route('delete.front.profile.certificate') }}", { id: id, _method: 'DELETE', _token: '{{ csrf_token() }}' })
                    .done(function (response) {
                        if (response == 'ok') {
                            $('#certificate_' + id).remove();
                        }
                    });
            }
        }

        function showCertificates() {
            $.post("{{ route('show.front.profile.certificates', $user->id) }}", { user_id: {{ $user->id }}, _token: '{{ csrf_token() }}' })
                .done(function (response) {
                    $('#certificate_div').html(response);
                });
        }

        $(document).ready(function () {
            showCertificates();
        });
    </script>
@endpush