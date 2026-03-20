<div class="newcvcard">
    <div class="cardhead">
        <h4 onclick="showSkills();">{{__('Yetenekler')}}</h4>
        <a href="javascript:;" onclick="showProfileSkillModal();"><i class="fas fa-plus"></i></a>
    </div>
    <div class="cardintbody">
        <div class="" id="skill_div"></div>
    </div>
</div>

<div class="modal fade" id="add_skill_modal" tabindex="-1" aria-labelledby="addskillModalLabel" aria-hidden="true" role="dialog"></div>

@push('scripts')
<script type="text/javascript">
    if (typeof window.openModal !== 'function') {
        window.openModal = function(modalId) {
            var modalEl = document.getElementById(modalId);
            if (!modalEl) return;
            if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
                modal.show();
            } else if (typeof $ !== 'undefined' && $.fn.modal) {
                $(modalEl).modal('show');
            } else {
                console.error('Bootstrap modal library not found');
            }
        };
    }

    if (typeof window.ajaxError !== 'function') {
        window.ajaxError = function(xhr, status, error, title) {
            console.log(xhr.responseText);
            var msg = 'Error ' + title + ': ' + xhr.status + ' ' + error;
            if (xhr.responseText) {
                var cleanResponse = xhr.responseText.replace(/<[^>]*>?/gm, '').substring(0, 300);
                msg += '\n\nResponse snippet: ' + cleanResponse;
            }
            alert(msg);
        };
    }

    function showProfileSkillModal() {
        loadProfileSkillForm();
    }

    function loadProfileSkillForm() {
        $.ajax({
            type: "POST",
            url: "{{ route('get.front.profile.skill.form', $user->id) }}",
            data: { "_token": "{{ csrf_token() }}" },
            dataType: 'json',
            success: function (json) {
                $("#add_skill_modal").html(json.html);
                openModal('add_skill_modal');
            },
            error: function(xhr, status, error) {
                ajaxError(xhr, status, error, 'Loading Skill Form');
            }
        });
    }

    function showProfileSkillEditModal(skill_id) {
        loadProfileSkillEditForm(skill_id);
    }

    function loadProfileSkillEditForm(skill_id) {
        $.ajax({
            type: "POST",
            url: "{{ route('get.front.profile.skill.edit.form', $user->id) }}",
            data: { "skill_id": skill_id, "_token": "{{ csrf_token() }}" },
            dataType: 'json',
            success: function (json) {
                $("#add_skill_modal").html(json.html);
                openModal('add_skill_modal');
            },
            error: function(xhr, status, error) {
                ajaxError(xhr, status, error, 'Loading Skill Edit Form');
            }
        });
    }

    function submitProfileSkillForm() {
        var form = $('#add_edit_profile_skill');
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            dataType: 'json',
            success: function (json) {
                $("#add_skill_modal").html(json.html);
                showSkills();
                setTimeout(function(){
                    var modalEl = document.getElementById('add_skill_modal');
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
                    ajaxError(xhr, status, error, 'Saving Skill');
                }
            }
        });
    }

    function delete_profile_skill(id) {
        if (confirm("{{__('Are you sure! you want to delete?')}}")) {
            $.post("{{ route('delete.front.profile.skill') }}", { id: id, _method: 'DELETE', _token: '{{ csrf_token() }}' })
                .done(function (response) {
                    if (response == 'ok') {
                        $('#skill_' + id).remove();
                    } else {
                        alert('Request Failed!');
                    }
                })
                .fail(function(xhr, status, error){
                    ajaxError(xhr, status, error, 'Deleting Skill');
                });
        }
    }

    function showSkills() {
        $.post("{{ route('show.front.profile.skills', $user->id) }}", { user_id: {{$user->id}}, _token: '{{ csrf_token() }}' })
            .done(function (response) {
                $('#skill_div').html(response);
            });
    }

    $(document).ready(function () {
        showSkills();
    });
</script>
@endpush