<div class="newcvcard">
    <div class="cardhead">
        <h4 onclick="showProjects();">{{__('Projeler')}}</h4>
        <a href="javascript:;" onclick="showProfileProjectModal();"><i class="fas fa-plus"></i></a>
    </div>
    <div class="cardintbody">
        <div class="" id="project_div"></div>
    </div>
</div>

<div class="modal fade" id="add_project_modal" tabindex="-1" aria-labelledby="addprojectModalLabel" aria-hidden="true" role="dialog"></div>

@push('scripts')
<script type="text/javascript">
    function showProfileProjectModal() {
        loadProfileProjectForm();
    }

    function loadProfileProjectForm() {
        $.ajax({
            type: "POST",
            url: "{{ route('get.front.profile.project.form', $user->id) }}",
            data: { "_token": "{{ csrf_token() }}" },
            dataType: 'json',
            success: function (json) {
                $("#add_project_modal").html(json.html);
                openModal('add_project_modal');
                createDropZone();
                initdatepicker();
            },
            error: function(xhr, status, error) {
                ajaxError(xhr, status, error, 'Loading Project Form');
            }
        });
    }

    function showProfileProjectEditModal(profile_project_id) {
        loadProfileProjectEditForm(profile_project_id);
    }

    function loadProfileProjectEditForm(profile_project_id) {
        $.ajax({
            type: "POST",
            url: "{{ route('get.front.profile.project.edit.form', $user->id) }}",
            data: { "profile_project_id": profile_project_id, "_token": "{{ csrf_token() }}" },
            dataType: 'json',
            success: function (json) {
                $("#add_project_modal").html(json.html);
                openModal('add_project_modal');
                createDropZone();
                initdatepicker();
            },
            error: function(xhr, status, error) {
                ajaxError(xhr, status, error, 'Loading Project Edit Form');
            }
        });
    }

    function submitProfileProjectForm() {
        var form = $('#add_edit_profile_project');
        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            dataType: 'json',
            success: function (json) {
                $("#add_project_modal").html(json.html);
                showProjects();
                setTimeout(function(){
                    var modalEl = document.getElementById('add_project_modal');
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
                    ajaxError(xhr, status, error, 'Saving Project');
                }
            }
        });
    }

    function delete_profile_project(id) {
        if (confirm("{{__('Are you sure! you want to delete?')}}")) {
            $.post("{{ route('delete.front.profile.project') }}", { id: id, _method: 'DELETE', _token: '{{ csrf_token() }}' })
                .done(function (response) {
                    if (response == 'ok') {
                        $('#project_' + id).remove();
                    } else {
                        alert('Request Failed!');
                    }
                })
                .fail(function(xhr, status, error){
                    ajaxError(xhr, status, error, 'Deleting Project');
                });
        }
    }

    function showProjects() {
        $.post("{{ route('show.front.profile.projects', $user->id) }}", { user_id: {{$user->id}}, _token: '{{ csrf_token() }}' })
            .done(function (response) {
                $('#project_div').html(response);
            });
    }

    function createDropZone() {
        if (typeof Dropzone !== 'undefined') {
            var myDropzone = new Dropzone("#dropzone", {
                url: "{{ route('upload.front.project.temp.image') }}",
                paramName: "image",
                maxFilesize: 2,
                addRemoveLinks: true,
                acceptedFiles: "image/*",
                params: { "_token": "{{ csrf_token() }}" }
            });
            myDropzone.on("success", function (file, response) {
                $('#image').val(response);
            });
        }
    }

    $(document).ready(function () {
        showProjects();
    });
</script>
@endpush