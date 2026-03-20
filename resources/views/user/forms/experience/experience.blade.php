<div class="newcvcard">
    <div class="cardhead">
        <h4 onclick="showExperience();">{{__('Deneyim')}}</h4>
        <a href="javascript:;" onclick="showProfileExperienceModal();"><i class="fas fa-plus"></i></a>
    </div>
    <div class="cardintbody">
        <div class="" id="experience_div"></div>
    </div>
</div>

<div class="modal fade" id="add_experience_modal" tabindex="-1" aria-labelledby="addexpModalLabel" aria-hidden="true" role="dialog"></div>

@push('styles')
<style type="text/css">
    .datepicker>div { display: block; }
</style>
@endpush

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

    function showProfileExperienceModal() {
        loadProfileExperienceForm();
    }

    function loadProfileExperienceForm() {
        $.ajax({
            type: "POST",
            url: "{{ route('get.front.profile.experience.form', $user->id) }}",
            data: { "_token": "{{ csrf_token() }}" },
            dataType: 'json',
            success: function (json) {
                $("#add_experience_modal").html(json.html);
                openModal('add_experience_modal');
                initdatepicker();
                filterDefaultStatesExperience(0, 0);
            },
            error: function(xhr, status, error) {
                ajaxError(xhr, status, error, 'Loading Experience Form');
            }
        });
    }

    function showProfileExperienceEditModal(profile_experience_id, state_id, city_id) {
        loadProfileExperienceEditForm(profile_experience_id, state_id, city_id);
    }

    function loadProfileExperienceEditForm(profile_experience_id, state_id, city_id) {
        $.ajax({
            type: "POST",
            url: "{{ route('get.front.profile.experience.edit.form', $user->id) }}",
            data: { "profile_experience_id": profile_experience_id, "_token": "{{ csrf_token() }}" },
            dataType: 'json',
            success: function (json) {
                $("#add_experience_modal").html(json.html);
                openModal('add_experience_modal');
                initdatepicker();
                filterDefaultStatesExperience(state_id, city_id);
            },
            error: function(xhr, status, error) {
                ajaxError(xhr, status, error, 'Loading Experience Edit Form');
            }
        });
    }

    function submitProfileExperienceForm() {
        var form = $('#add_edit_profile_experience');
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            dataType: 'json',
            success: function (json) {
                $("#add_experience_modal").html(json.html);
                showExperience();
                setTimeout(function(){
                    var modalEl = document.getElementById('add_experience_modal');
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
                    ajaxError(xhr, status, error, 'Saving Experience');
                }
            }
        });
    }

    function delete_profile_experience(id) {
        if (confirm("{{__('Are you sure! you want to delete?')}}")) {
            $.post("{{ route('delete.front.profile.experience') }}", { id: id, _method: 'DELETE', _token: '{{ csrf_token() }}' })
                .done(function (response) {
                    if (response == 'ok') {
                        $('#experience_' + id).remove();
                    } else {
                        alert('Request Failed!');
                    }
                })
                .fail(function(xhr, status, error){
                    ajaxError(xhr, status, error, 'Deleting Experience');
                });
        }
    }

    function initdatepicker() {
        if ($.fn.datepicker) {
            $(".datepicker").datepicker({ autoclose: true, format: 'yyyy-m-d' });
        }
    }

    $(document).ready(function () {
        showExperience();
        initdatepicker();
        $(document).on('change', '#experience_country_id', function (e) {
            filterDefaultStatesExperience(0, 0);
        });
        $(document).on('change', '#experience_state_id', function (e) {
            filterDefaultCitiesExperience(0);
        });
    });

    function showExperience() {
        $.post("{{ route('show.front.profile.experience', $user->id) }}", { user_id: {{$user->id}}, _token: '{{ csrf_token() }}' })
            .done(function (response) {
                $('#experience_div').html(response);
            });
    }

    function filterDefaultStatesExperience(state_id, city_id) {
        var country_id = $('#experience_country_id').val();
        if (country_id != '') {
            $.post("{{ route('filter.lang.states.dropdown') }}", { country_id: country_id, state_id: state_id, new_state_id: 'experience_state_id', _token: '{{ csrf_token() }}' })
                .done(function (response) {
                    $('#default_state_experience_dd').html(response);
                    filterDefaultCitiesExperience(city_id);
                });
        }
    }

    function filterDefaultCitiesExperience(city_id) {
        var state_id = $('#experience_state_id').val();
        if (state_id != '') {
            $.post("{{ route('filter.lang.cities.dropdown') }}", { state_id: state_id, city_id: city_id, _token: '{{ csrf_token() }}' })
                .done(function (response) {
                    $('#default_city_experience_dd').html(response);
                });
        }
    }
</script>
@endpush