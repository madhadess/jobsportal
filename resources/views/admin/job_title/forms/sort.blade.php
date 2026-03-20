{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <h3>İş Unvanlarını Sıralamak İçin Sürükle ve Bırak</h3>
    {!! Form::select('lang', ['' => 'Language Seçin']+$languages, config('default_lang'), array('class'=>'form-control', 'id'=>'lang', 'onchange'=>'refreshJobTitleSortData();')) !!}
    <div id="jobTitleSortDataDiv"></div>
</div>
@push('scripts') 
<script>
    $(document).ready(function () {
        refreshJobTitleSortData();
    });
    function refreshJobTitleSortData() {
        var Language = $('#lang').val();
        $.ajax({
            type: "GET",
            url: "{{ route('job.title.sort.data') }}",
            data: {lang: Language},
            success: function (responseData) {
                $("#jobTitleSortDataDiv").html('');
                $("#jobTitleSortDataDiv").html(responseData);
                /**************************/
                $('#sortable').sortable({
                    update: function (event, ui) {
                        var jobTitleOrder = $(this).sortable('toArray').toString();
                        $.post("{{ route('job.title.sort.update') }}", {jobTitleOrder: jobTitleOrder, _method: 'PUT', _token: '{{ csrf_token() }}'})
                    }
                });
                $("#sortable").disableSelection();
                /***************************/
            }
        });
    }
</script> 
@endpush







