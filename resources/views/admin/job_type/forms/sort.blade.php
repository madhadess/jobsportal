{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <h3>İş Türlerini Sıralamak İçin Sürükle ve Bırak</h3>
    {!! Form::select('lang', ['' => 'Language Seçin']+$languages, config('default_lang'), array('class'=>'form-control', 'id'=>'lang', 'onchange'=>'refreshJobTypeSortData();')) !!}
    <div id="jobTypeSortDataDiv"></div>
</div>
@push('scripts') 
<script>
    $(document).ready(function () {
        refreshJobTypeSortData();
    });
    function refreshJobTypeSortData() {
        var Language = $('#lang').val();
        $.ajax({
            type: "GET",
            url: "{{ route('job.type.sort.data') }}",
            data: {lang: Language},
            success: function (responseData) {
                $("#jobTypeSortDataDiv").html('');
                $("#jobTypeSortDataDiv").html(responseData);
                /**************************/
                $('#sortable').sortable({
                    update: function (event, ui) {
                        var jobTypeOrder = $(this).sortable('toArray').toString();
                        $.post("{{ route('job.type.sort.update') }}", {jobTypeOrder: jobTypeOrder, _method: 'PUT', _token: '{{ csrf_token() }}'})
                    }
                });
                $("#sortable").disableSelection();
                /***************************/
            }
        });
    }
</script> 
@endpush







