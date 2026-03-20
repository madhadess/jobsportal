{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <h3>Ana Dersleri Sıralamak İçin Sürükle ve Bırak</h3>
    {!! Form::select('lang', ['' => 'Language Seçin']+$languages, config('default_lang'), array('class'=>'form-control', 'id'=>'lang', 'onchange'=>'refreshMajorSubjectSortData();')) !!}
    <div id="majorSubjectSortDataDiv"></div>
</div>
@push('scripts') 
<script>
    $(document).ready(function () {
        refreshMajorSubjectSortData();
    });
    function refreshMajorSubjectSortData() {
        var Language = $('#lang').val();
        $.ajax({
            type: "GET",
            url: "{{ route('major.subject.sort.data') }}",
            data: {lang: Language},
            success: function (responseData) {
                $("#majorSubjectSortDataDiv").html('');
                $("#majorSubjectSortDataDiv").html(responseData);
                /**************************/
                $('#sortable').sortable({
                    update: function (event, ui) {
                        var majorSubjectOrder = $(this).sortable('toArray').toString();
                        $.post("{{ route('major.subject.sort.update') }}", {majorSubjectOrder: majorSubjectOrder, _method: 'PUT', _token: '{{ csrf_token() }}'})
                    }
                });
                $("#sortable").disableSelection();
                /***************************/
            }
        });
    }
</script> 
@endpush







