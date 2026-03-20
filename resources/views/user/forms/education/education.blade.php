<div class="newcvcard">
    <div class="cardhead">
        <h4 onclick="showEducation();">{{__('Eğitim')}}</h4>
        <a href="javascript:;" onclick="showProfileEducationModal();"><i class="fas fa-plus"></i></a>
    </div>
    <div class="cardintbody">
        <div class="" id="education_div"></div>
    </div>
</div>

<div class="modal fade" id="add_education_modal" tabindex="-1" aria-labelledby="addeducationModalLabel"
    aria-hidden="true" role="dialog"></div>

@push('scripts')
    <script type="text/javascript">
        function showProfileEducationModal() {
            loadProfileEducationForm();
        }

        function loadProfileEducationForm() {
            $.ajax({
                type: "POST",
                url: "{{ route('get.front.profile.education.form', $user->id) }}",
                data: { "_token": "{{ csrf_token() }}" },
                dataType: 'json',
                success: function (json) {
                    $("#add_education_modal").html(json.html);
                    openModal('add_education_modal');
                    initEducationPlugins();
                    filterDefaultStatesEducation(0, 0);
                },
                error: function (xhr, status, error) {
                    ajaxError(xhr, status, error, 'Loading Education Form');
                }
            });
        }

        function showProfileEducationEditModal(education_id, state_id, city_id, degree_type_id) {
            loadProfileEducationEditForm(education_id, state_id || 0, city_id || 0, degree_type_id || 0);
        }

        function loadProfileEducationEditForm(education_id, state_id, city_id, degree_type_id) {
            $.ajax({
                type: "POST",
                url: "{{ route('get.front.profile.education.edit.form', $user->id) }}",
                data: { "education_id": education_id, "_token": "{{ csrf_token() }}" },
                dataType: 'json',
                success: function (json) {
                    $("#add_education_modal").html(json.html);
                    openModal('add_education_modal');
                    initEducationPlugins();
                    filterDefaultStatesEducation(state_id, city_id);
                },
                error: function (xhr, status, error) {
                    ajaxError(xhr, status, error, 'Loading Education Edit Form');
                }
            });
        }

        function submitProfileEducationForm() {
            var form = $('#add_edit_profile_education');
            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: form.serialize(),
                dataType: 'json',
                success: function (json) {
                    $("#add_education_modal").html(json.html);
                    showEducation();
                    setTimeout(function () {
                        var modalEl = document.getElementById('add_education_modal');
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
                        ajaxError(xhr, status, error, 'Saving Education');
                    }
                }
            });
        }

        function delete_profile_education(id) {
            if (confirm("{{__('Are you sure! you want to delete?')}}")) {
                $.post("{{ route('delete.front.profile.education') }}", { id: id, _method: 'DELETE', _token: '{{ csrf_token() }}' })
                    .done(function (response) {
                        if (response == 'ok') {
                            $('#education_' + id).remove();
                        } else {
                            alert('Request Failed!');
                        }
                    })
                    .fail(function (xhr, status, error) {
                        ajaxError(xhr, status, error, 'Deleting Education');
                    });
            }
        }

        function showEducation() {
            $.post("{{ route('show.front.profile.education', $user->id) }}", { user_id: {{$user->id}}, _token: '{{ csrf_token() }}' })
                .done(function (response) {
                    $('#education_div').html(response);
                });
        }

        function initEducationPlugins() {
            if ($.fn.select2) {
                $('.select2-multiple').select2({
                    placeholder: "Bölüm Seçin",
                    allowClear: true
                });
            }
        }

        function filterDefaultStatesEducation(state_id, city_id) {
            var country_id = $('#education_country_id').val();
            if (country_id != '') {
                $.post("{{ route('filter.default.states.dropdown') }}", { country_id: country_id, state_id: state_id, new_state_id: 'education_state_id', _method: 'POST', _token: '{{ csrf_token() }}' })
                    .done(function (response) {
                        $('#default_state_education_dd').html(response);
                    });
            }
        }

        $(document).ready(function () {
            showEducation();

            $(document).on('change', '#education_country_id', function (e) {
                e.preventDefault();
                filterDefaultStatesEducation(0, 0);
            });
        });
    </script>
@endpush