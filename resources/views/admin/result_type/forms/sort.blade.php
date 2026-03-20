{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <h3>Sonuç Tiplerini Sıralamak İçin Sürükle ve Bırak</h3>
    {!! Form::select('lang', ['' => 'Language Seçin']+$languages, 'en', array('class'=>'form-control', 'id'=>'lang', 'onchange'=>'refreshResultTypeSortData();')) !!}
    <div id="resultTypeSortDataDiv"></div>
</div>
@push('scripts') 
<script>
    $(document).ready(function () {
        refreshResultTypeSortData();
    });
    function refreshResultTypeSortData() {
        var Language = $('#lang').val();
        $.ajax({
            type: "GET",
            url: "{{ route('result.type.sort.data') }}",
            data: {lang: Language},
            success: function (responseData) {
                $("#resultTypeSortDataDiv").html('');
                $("#resultTypeSortDataDiv").html(responseData);
                /**************************/
                $('#sortable').sortable({
                    update: function (event, ui) {
                        var resultTypeOrder = $(this).sortable('toArray').toString();
                        $.post("{{ route('result.type.sort.update') }}", {resultTypeOrder: resultTypeOrder, _method: 'PUT', _token: '{{ csrf_token() }}'})
                    }
                });
                $("#sortable").disableSelection();
                /***************************/
            }
        });
    }
</script> 
@endpush







