{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <h3>Eğitim Türlerini Sıralamak İçin Sürükle ve Bırak</h3>
    <div class="form-group">
        {!! Form::select('lang', ['' => 'Language Seçin']+$languages, config('default_lang'), array('class'=>'form-control', 'id'=>'lang', 'onchange'=>'refreshDegreeTypeSortData();')) !!}
    </div>
    <div class="form-group">
        {!! Form::select('degree_level_id', ['' => 'Eğitim Düzeyi Seçin']+$degreeLevels, null, array('class'=>'form-control', 'id'=>'degree_level_id', 'onchange'=>'refreshDegreeTypeSortData();')) !!}
    </div>
    <div id="degreeTypeSortDataDiv"></div>
</div>
@push('scripts') 
<script>
    $(document).ready(function () {
        refreshDegreeTypeSortData();
    });
    function refreshDegreeTypeSortData() {
        var Language = $('#lang').val();
        var degree_level_id = $('#degree_level_id').val();
        $.ajax({
            type: "GET",
            url: "{{ route('degree.type.sort.data') }}",
            data: {lang: Language, degree_level_id: degree_level_id},
            success: function (responseData) {
                $("#degreeTypeSortDataDiv").html('');
                $("#degreeTypeSortDataDiv").html(responseData);
                /**************************/
                $('#sortable').sortable({
                    update: function (event, ui) {
                        var degreeTypeOrder = $(this).sortable('toArray').toString();
                        $.post("{{ route('degree.type.sort.update') }}", {degreeTypeOrder: degreeTypeOrder, _method: 'PUT', _token: '{{ csrf_token() }}'})
                    }
                });
                $("#sortable").disableSelection();
                /***************************/
            }
        });
    }
</script> 
@endpush







