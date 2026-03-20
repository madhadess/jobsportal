{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <h3>Languageleri Sıralamak İçin Sürükle ve Bırak</h3>
    {!! Form::select('lang', ['' => 'Language Seçin']+$languages, 'en', array('class'=>'form-control', 'id'=>'lang', 'onchange'=>'refreshLanguageSortData();')) !!}
    <div id="languageSortDataDiv"></div>
</div>
@push('scripts') 
<script>
    $(document).ready(function () {
        refreshLanguageSortData();
    });
    function refreshLanguageSortData() {
        var Language = $('#lang').val();
        $.ajax({
            type: "GET",
            url: "{{ route('Language.sort.data') }}",
            data: {lang: Language},
            success: function (responseData) {
                $("#languageSortDataDiv").html('');
                $("#languageSortDataDiv").html(responseData);
                /**************************/
                $('#sortable').sortable({
                    update: function (event, ui) {
                        var languageOrder = $(this).sortable('toArray').toString();
                        $.post("{{ route('Language.sort.update') }}", {languageOrder: languageOrder, _method: 'PUT', _token: '{{ csrf_token() }}'})
                    }
                });
                $("#sortable").disableSelection();
                /***************************/
            }
        });
    }
</script> 
@endpush








