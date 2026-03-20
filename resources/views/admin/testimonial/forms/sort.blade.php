{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <h3>Referansları Sıralamak İçin Sürükle ve Bırak</h3>
    {!! Form::select('lang', ['' => 'Language Seçin']+$languages, config('default_lang'), array('class'=>'form-control', 'id'=>'lang', 'onchange'=>'refreshTestimonialSortData();')) !!}
    <div id="testimonialSortDataDiv"></div>
</div>
@push('scripts') 
<script>
    $(document).ready(function () {
        refreshTestimonialSortData();
    });
    function refreshTestimonialSortData() {
        var Language = $('#lang').val();
        $.ajax({
            type: "GET",
            url: "{{ route('testimonial.sort.data') }}",
            data: {lang: Language},
            success: function (responseData) {
                $("#testimonialSortDataDiv").html('');
                $("#testimonialSortDataDiv").html(responseData);
                /**************************/
                $('#sortable').sortable({
                    update: function (event, ui) {
                        var testimonialOrder = $(this).sortable('toArray').toString();
                        $.post("{{ route('testimonial.sort.update') }}", {testimonialOrder: testimonialOrder, _method: 'PUT', _token: '{{ csrf_token() }}'})
                    }
                });
                $("#sortable").disableSelection();
                /***************************/
            }
        });
    }
</script> 
@endpush







