{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <h3>Language Seviyelerini Sıralamak İçin Sürükle ve Bırak</h3>
    {!! Form::select('lang', ['' => 'Language Seçin']+$languages, 'en', array('class'=>'form-control', 'id'=>'lang', 'onchange'=>'refreshLanguageLevelSortData();')) !!}
    <div id="languageLevelSortDataDiv"></div>
</div>
@push('scripts') 
<script>
    $(document).ready(function () {
        refreshLanguageLevelSortData();
    });
    function refreshLanguageLevelSortData() {
        var Language = $('#lang').val();
        $.ajax({
            type: "GET",
            url: "{{ route('Language.level.sort.data') }}",
            data: {lang: Language},
            success: function (responseData) {
                $("#languageLevelSortDataDiv").html('');
                $("#languageLevelSortDataDiv").html(responseData);
                /**************************/
                $('#sortable').sortable({
                    update: function (event, ui) {
                        var languageLevelOrder = $(this).sortable('toArray').toString();
                        $.post("{{ route('Language.level.sort.update') }}", {languageLevelOrder: languageLevelOrder, _method: 'PUT', _token: '{{ csrf_token() }}'})
                    }
                });
                $("#sortable").disableSelection();
                /***************************/
            }
        });
    }
</script> 
@endpush







