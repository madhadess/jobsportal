{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    <h3>Maaş Periyotlarını Sıralamak İçin Sürükle ve Bırak</h3>
    {!! Form::select('lang', ['' => 'Language Seçin']+$languages, config('default_lang'), array('class'=>'form-control', 'id'=>'lang', 'onchange'=>'refreshSalaryPeriodSortData();')) !!}
    <div id="salaryPeriodSortDataDiv"></div>
</div>
@push('scripts') 
<script>
    $(document).ready(function () {
        refreshSalaryPeriodSortData();
    });
    function refreshSalaryPeriodSortData() {
        var Language = $('#lang').val();
        $.ajax({
            type: "GET",
            url: "{{ route('salary.period.sort.data') }}",
            data: {lang: Language},
            success: function (responseData) {
                $("#salaryPeriodSortDataDiv").html('');
                $("#salaryPeriodSortDataDiv").html(responseData);
                /**************************/
                $('#sortable').sortable({
                    update: function (event, ui) {
                        var salaryPeriodOrder = $(this).sortable('toArray').toString();
                        $.post("{{ route('salary.period.sort.update') }}", {salaryPeriodOrder: salaryPeriodOrder, _method: 'PUT', _token: '{{ csrf_token() }}'})
                    }
                });
                $("#sortable").disableSelection();
                /***************************/
            }
        });
    }
</script> 
@endpush







