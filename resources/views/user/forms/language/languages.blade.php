<div class="newcvcard">
    <div class="cardhead">
        <h4 onclick="showLanguages();">{{__('Diller')}}</h4>
        <a href="javascript:;" onclick="showProfileLanguageModal();"><i class="fas fa-plus"></i></a>
    </div>
    <div class="cardintbody">
        <div class="" id="language_div"></div>
    </div>
</div>

<div class="modal fade" id="add_language_modal" tabindex="-1" aria-labelledby="addlangModalLabel" aria-hidden="true" role="dialog"></div>

@push('scripts')
<script type="text/javascript">
    function showProfileLanguageModal() {
        loadProfileLanguageForm();
    }

    function loadProfileLanguageForm() {
        $.ajax({
            type: "POST",
            url: "{{ route('get.front.profile.language.form', $user->id) }}",
            data: { "_token": "{{ csrf_token() }}" },
            dataType: 'json',
            success: function (json) {
                $("#add_language_modal").html(json.html);
                openModal('add_language_modal');
            },
            error: function(xhr, status, error) {
                ajaxError(xhr, status, error, 'Loading Language Form');
            }
        });
    }

    function showProfileLanguageEditModal(language_id) {
        loadProfileLanguageEditForm(language_id);
    }

    function loadProfileLanguageEditForm(language_id) {
        $.ajax({
            type: "POST",
            url: "{{ route('get.front.profile.language.edit.form', $user->id) }}",
            data: { "language_id": language_id, "_token": "{{ csrf_token() }}" },
            dataType: 'json',
            success: function (json) {
                $("#add_language_modal").html(json.html);
                openModal('add_language_modal');
            },
            error: function(xhr, status, error) {
                ajaxError(xhr, status, error, 'Loading Language Edit Form');
            }
        });
    }

    function submitProfileLanguageForm() {
        var form = $('#add_edit_profile_language');
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            dataType: 'json',
            success: function (json) {
                $("#add_language_modal").html(json.html);
                showLanguages();
                setTimeout(function(){
                    var modalEl = document.getElementById('add_language_modal');
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
                    ajaxError(xhr, status, error, 'Saving Language');
                }
            }
        });
    }

    function delete_profile_language(id) {
        if (confirm("{{__('Are you sure! you want to delete?')}}")) {
            $.post("{{ route('delete.front.profile.language') }}", { id: id, _method: 'DELETE', _token: '{{ csrf_token() }}' })
                .done(function (response) {
                    if (response == 'ok') {
                        $('#language_' + id).remove();
                    } else {
                        alert('Request Failed!');
                    }
                })
                .fail(function(xhr, status, error){
                    ajaxError(xhr, status, error, 'Deleting Language');
                });
        }
    }

    function showLanguages() {
        $.post("{{ route('show.front.profile.languages', $user->id) }}", { user_id: {{$user->id}}, _token: '{{ csrf_token() }}' })
            .done(function (response) {
                $('#language_div').html(response);
            });
    }

    $(document).ready(function () {
        showLanguages();
    });
</script>
@endpush