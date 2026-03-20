<div class="newcvcard">
    <div class="cardhead">
        <h4 onclick="showCvs();">{{__('EK' . 'İ' . 'L CV')}}</h4>
        <a href="javascript:;" onclick="showProfileCvModal();"><i class="fas fa-plus"></i></a>
    </div>
    <div class="cardintbody">
        <div class="" id="cv_div"></div>
    </div>
</div>

<div class="modal fade" id="add_cv_modal" tabindex="-1" aria-labelledby="addcvModalLabel" aria-hidden="true" role="dialog"></div>

@push('scripts')
<script type="text/javascript">
    function showProfileCvModal() {
        loadProfileCvForm();
    }

    function loadProfileCvForm() {
        $.ajax({
            type: "POST",
            url: "{{ route('get.front.profile.cv.form', $user->id) }}",
            data: { "_token": "{{ csrf_token() }}" },
            dataType: 'json',
            success: function (json) {
                $("#add_cv_modal").html(json.html);
                openModal('add_cv_modal');
            },
            error: function(xhr, status, error) {
                ajaxError(xhr, status, error, 'Loading CV Form');
            }
        });
    }

    function showProfileCvEditModal(cv_id) {
        loadProfileCvEditForm(cv_id);
    }

    function loadProfileCvEditForm(cv_id) {
        $.ajax({
            type: "POST",
            url: "{{ route('get.front.profile.cv.edit.form', $user->id) }}",
            data: { "cv_id": cv_id, "_token": "{{ csrf_token() }}" },
            dataType: 'json',
            success: function (json) {
                $("#add_cv_modal").html(json.html);
                openModal('add_cv_modal');
            },
            error: function(xhr, status, error) {
                ajaxError(xhr, status, error, 'Loading CV Edit Form');
            }
        });
    }

    function submitProfileCvForm() {
        var form = $('#add_edit_profile_cv');
        var formData = new FormData(form[0]);
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function (json) {
                $("#add_cv_modal").html(json.html);
                showCvs();
                setTimeout(function(){
                    var modalEl = document.getElementById('add_cv_modal');
                    if (modalEl && $(modalEl).find('.alert-success').length > 0) {
                        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                            var modal = bootstrap.Modal.getInstance(modalEl);
                            if (modal) modal.hide();
                        } else {
                            $(modalEl).modal('hide');
                        }
                    }
                }, 1000);
            },
            error: function (xhr, status, error) {
                if (xhr.status === 422) {
                    var resJSON = xhr.responseJSON;
                    $('.help-block').html('');
                    $.each(resJSON.errors, function (key, value) {
                        $('.' + key + '-error').html('<strong>' + value + '</strong>');
                        $('#div_' + key).addClass('has-error');
                    });
                } else {
                    ajaxError(xhr, status, error, 'Saving CV');
                }
            }
        });
    }

    function delete_profile_cv(id) {
        if (confirm("{{__('Are you sure! you want to delete?')}}")) {
            $.post("{{ route('delete.front.profile.cv') }}", { id: id, _method: 'DELETE', _token: '{{ csrf_token() }}' })
                .done(function (response) {
                    if (response == 'ok') {
                        $('#cv_' + id).remove();
                    } else {
                        alert('Request Failed!');
                    }
                })
                .fail(function(xhr, status, error){
                    ajaxError(xhr, status, error, 'Deleting CV');
                });
        }
    }

    function showCvs() {
        $.post("{{ route('show.front.profile.cvs', $user->id) }}", { user_id: {{$user->id}}, _token: '{{ csrf_token() }}' })
            .done(function (response) {
                $('#cv_div').html(response);
            });
    }

    $(document).ready(function () {
        showCvs();
    });
</script>
@endpush