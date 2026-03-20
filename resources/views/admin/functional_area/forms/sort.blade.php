{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <h3>Fonksiyonel Alanları Sıralamak İçin Sürükle ve Bırak</h3>
    {!! Form::select('lang', ['' => 'Language Seçin']+$languages, config('default_lang'), array('class'=>'form-control', 'id'=>'lang', 'onchange'=>'refreshFunctionalAreaSortData();')) !!}
    <div id="functionalAreaSortDataDiv"></div>
</div>
@push('scripts') 
<script>
    $(document).ready(function () {
        refreshFunctionalAreaSortData();
    });
    function refreshFunctionalAreaSortData() {
        var Language = $('#lang').val();
        $.ajax({
            type: "GET",
            url: "{{ route('functional.area.sort.data') }}",
            data: {lang: Language},
            success: function (responseData) {
                $("#functionalAreaSortDataDiv").html('');
                $("#functionalAreaSortDataDiv").html(responseData);
                /**************************/
                $('#sortable').sortable({
                    update: function (event, ui) {
                        var functionalAreaOrder = $(this).sortable('toArray').toString();
                        $.post("{{ route('functional.area.sort.update') }}", {functionalAreaOrder: functionalAreaOrder, _method: 'PUT', _token: '{{ csrf_token() }}'})
                    }
                });
                $("#sortable").disableSelection();
                /***************************/
            }
        });
    }
</script> 
@endpush







