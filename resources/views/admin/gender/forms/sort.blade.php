{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <h3>Cinsiyetleri Sıralamak İçin Sürükle ve Bırak</h3>
    {!! Form::select('lang', ['' => 'Language Seçin']+$languages, config('default_lang'), array('class'=>'form-control', 'id'=>'lang', 'onchange'=>'refreshGenderSortData();')) !!}
    <div id="genderSortDataDiv"></div>
</div>
@push('scripts') 
<script>
    $(document).ready(function () {
        refreshGenderSortData();
    });
    function refreshGenderSortData() {
        var Language = $('#lang').val();
        $.ajax({
            type: "GET",
            url: "{{ route('gender.sort.data') }}",
            data: {lang: Language},
            success: function (responseData) {
                $("#genderSortDataDiv").html('');
                $("#genderSortDataDiv").html(responseData);
                /**************************/
                $('#sortable').sortable({
                    update: function (event, ui) {
                        var genderOrder = $(this).sortable('toArray').toString();
                        $.post("{{ route('gender.sort.update') }}", {genderOrder: genderOrder, _method: 'PUT', _token: '{{ csrf_token() }}'})
                    }
                });
                $("#sortable").disableSelection();
                /***************************/
            }
        });
    }
</script> 
@endpush







