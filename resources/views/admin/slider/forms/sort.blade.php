{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <h3>Sliderları Sıralamak İçin Sürükle ve Bırak</h3>
    {!! Form::select('lang', ['' => 'Language Seçin']+$languages, config('default_lang'), array('class'=>'form-control', 'id'=>'lang', 'onchange'=>'refreshSliderSortData();')) !!}
    <div id="sliderSortDataDiv"></div>
</div>
@push('scripts') 
<script>
    $(document).ready(function () {
        refreshSliderSortData();
    });
    function refreshSliderSortData() {
        var Language = $('#lang').val();
        $.ajax({
            type: "GET",
            url: "{{ route('slider.sort.data') }}",
            data: {lang: Language},
            success: function (responseData) {
                $("#sliderSortDataDiv").html('');
                $("#sliderSortDataDiv").html(responseData);
                /**************************/
                $('#sortable').sortable({
                    update: function (event, ui) {
                        var sliderOrder = $(this).sortable('toArray').toString();
                        $.post("{{ route('slider.sort.update') }}", {sliderOrder: sliderOrder, _method: 'PUT', _token: '{{ csrf_token() }}'})
                    }
                });
                $("#sortable").disableSelection();
                /***************************/
            }
        });
    }
</script> 
@endpush







