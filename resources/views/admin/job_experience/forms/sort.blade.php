{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <h3>İş Deneyimlerini Sıralamak İçin Sürükle ve Bırak</h3>
    {!! Form::select('lang', ['' => 'Language Seçin']+$languages, config('default_lang'), array('class'=>'form-control', 'id'=>'lang', 'onchange'=>'refreshJobExperienceSortData();')) !!}
    <div id="jobExperienceSortDataDiv"></div>
</div>
@push('scripts') 
<script>
    $(document).ready(function () {
        refreshJobExperienceSortData();
    });
    function refreshJobExperienceSortData() {
        var Language = $('#lang').val();
        $.ajax({
            type: "GET",
            url: "{{ route('job.experience.sort.data') }}",
            data: {lang: Language},
            success: function (responseData) {
                $("#jobExperienceSortDataDiv").html('');
                $("#jobExperienceSortDataDiv").html(responseData);
                /**************************/
                $('#sortable').sortable({
                    update: function (event, ui) {
                        var jobExperienceOrder = $(this).sortable('toArray').toString();
                        $.post("{{ route('job.experience.sort.update') }}", {jobExperienceOrder: jobExperienceOrder, _method: 'PUT', _token: '{{ csrf_token() }}'})
                    }
                });
                $("#sortable").disableSelection();
                /***************************/
            }
        });
    }
</script> 
@endpush







