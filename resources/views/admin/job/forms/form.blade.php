{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
<div class="form-body">
    {!! Form::hidden('id', null) !!}
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'company_id') !!}" id="company_id_div">
        {!! Form::label('company_id', 'Şirket', ['class' => 'bold']) !!}
        {!! Form::select('company_id', ['' => 'Şirket Seçin'] + $companies, null, array('class' => 'form-control', 'id' => 'company_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'company_id') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'title') !!}">
        {!! Form::label('title', 'İş Başlığı', ['class' => 'bold']) !!}
        {!! Form::text('title', null, array('class' => 'form-control', 'id' => 'title', 'placeholder' => 'İş Başlığı')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'title') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'description') !!}">
        {!! Form::label('description', 'İş Açıklaması', ['class' => 'bold']) !!}
        {!! Form::textarea('description', null, array('class' => 'form-control', 'id' => 'description', 'placeholder' => 'İş Açıklaması')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'description') !!}
    </div>


    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'benefits') !!}">
        {!! Form::label('description', 'Yan Haklar', ['class' => 'bold']) !!}
        {!! Form::textarea('benefits', null, array('class' => 'form-control', 'id' => 'benefits', 'placeholder' => 'Yan Haklar')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'benefits') !!}
    </div>





    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'skills') !!}">
        {!! Form::label('skills', 'İş Yetenekleri', ['class' => 'bold']) !!}
        <?php
$skills = old('skills', $jobSkillIds);
        ?>
        {!! Form::select('skills[]', $jobSkills, $skills, array('class' => 'form-control select2-multiple', 'id' => 'skills', 'multiple' => 'multiple')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'skills') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'country_id') !!}" id="country_id_div">
        {!! Form::label('country_id', 'Ülke', ['class' => 'bold']) !!}
        {!! Form::select('country_id', ['' => 'Ülke Seçin'] + $countries, old('country_id', (isset($job)) ? $job->country_id : $siteSetting->default_country_id), array('class' => 'form-control', 'id' => 'country_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'country_id') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'state_id') !!}" id="state_id_div">
        {!! Form::label('state_id', 'Şehir', ['class' => 'bold']) !!}
        <span id="default_state_dd">
            {!! Form::select('state_id', ['' => 'Şehir Seçin'], null, array('class' => 'form-control', 'id' => 'state_id')) !!}
        </span>
        {!! APFrmErrHelp::showErrors($errors, 'state_id') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'city_id') !!}" id="city_id_div">
        {!! Form::label('city_id', 'İlçe', ['class' => 'bold']) !!}
        <span id="default_city_dd">
            {!! Form::select('city_id', ['' => 'İlçe Seçin'], null, array('class' => 'form-control', 'id' => 'city_id')) !!}
        </span>
        {!! APFrmErrHelp::showErrors($errors, 'city_id') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_freelance') !!}">
        {!! Form::label('is_freelance', 'Serbest Çalışma mı?', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
$is_freelance_1 = '';
$is_freelance_2 = 'checked="checked"';
if (old('is_freelance', ((isset($job)) ? $job->is_freelance : 0)) == 1) {
    $is_freelance_1 = 'checked="checked"';
    $is_freelance_2 = '';
}
            ?>
            <label class="radio-inline">
                <input id="is_freelance_yes" name="is_freelance" type="radio" value="1" {{$is_freelance_1}}>
                Evet </label>
            <label class="radio-inline">
                <input id="is_freelance_no" name="is_freelance" type="radio" value="0" {{$is_freelance_2}}>
                Hayır </label>
        </div>
        {!! APFrmErrHelp::showErrors($errors, 'is_freelance') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'career_level_id') !!}" id="career_level_id_div">
        {!! Form::label('career_level_id', 'Kariyer Seviyesi', ['class' => 'bold']) !!}
        {!! Form::select('career_level_id', ['' => 'Kariyer Seviyesi Seçin'] + $careerLevels, null, array('class' => 'form-control', 'id' => 'career_level_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'career_level_id') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'salary_from') !!}" id="salary_from_div">
        {!! Form::label('salary_from', 'Maaş (Başlangıç)', ['class' => 'bold']) !!}
        {!! Form::number('salary_from', null, array('class' => 'form-control', 'id' => 'salary_from')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'salary_from') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'salary_to') !!}" id="salary_to_div">
        {!! Form::label('salary_to', 'Maaş (Bitiş)', ['class' => 'bold']) !!}
        {!! Form::number('salary_to', null, array('class' => 'form-control', 'id' => 'salary_to')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'salary_to') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'salary_currency') !!}" id="salary_currency_div">
        {!! Form::label('salary_currency', 'Para Birimi', ['class' => 'bold']) !!}
        {!! Form::select('salary_currency', ['' => 'Para Birimi Seçin'] + $currencies, null, array('class' => 'form-control', 'id' => 'salary_currency')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'salary_currency') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'salary_period_id') !!}" id="salary_period_id_div">
        {!! Form::label('salary_period_id', 'Maaş Periyodu', ['class' => 'bold']) !!}
        {!! Form::select('salary_period_id', ['' => 'Maaş Periyodu Seçin'] + $salaryPeriods, null, array('class' => 'form-control', 'id' => 'salary_period_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'salary_period_id') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'hide_salary') !!}">
        {!! Form::label('hide_salary', 'Maaşı Gizle?', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
$hide_salary_1 = '';
$hide_salary_2 = 'checked="checked"';
if (old('hide_salary', ((isset($job)) ? $job->hide_salary : 0)) == 1) {
    $hide_salary_1 = 'checked="checked"';
    $hide_salary_2 = '';
}
            ?>
            <label class="radio-inline">
                <input id="hide_salary_yes" name="hide_salary" type="radio" value="1" {{$hide_salary_1}}>
                Evet </label>
            <label class="radio-inline">
                <input id="hide_salary_no" name="hide_salary" type="radio" value="0" {{$hide_salary_2}}>
                Hayır </label>
        </div>
        {!! APFrmErrHelp::showErrors($errors, 'hide_salary') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'functional_area_id') !!}" id="functional_area_id_div">
        {!! Form::label('functional_area_id', 'Fonksiyonel Alan', ['class' => 'bold']) !!}
        {!! Form::select('functional_area_id', ['' => 'Fonksiyonel Alan Seçin'] + $functionalAreas, null, array('class' => 'form-control', 'id' => 'functional_area_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'functional_area_id') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'job_type_id') !!}" id="job_type_id_div">
        {!! Form::label('job_type_id', 'İş Tipi', ['class' => 'bold']) !!}
        {!! Form::select('job_type_id', ['' => 'İş Tipi Seçin'] + $jobTypes, null, array('class' => 'form-control', 'id' => 'job_type_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'job_type_id') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'job_shift_id') !!}" id="job_shift_id_div">
        {!! Form::label('job_shift_id', 'Vardiya', ['class' => 'bold']) !!}
        {!! Form::select('job_shift_id', ['' => 'Vardiya Seçin'] + $jobShifts, null, array('class' => 'form-control', 'id' => 'job_shift_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'job_shift_id') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'num_of_positions') !!}" id="num_of_positions_div">
        {!! Form::label('num_of_positions', 'Pozisyon Sayısı', ['class' => 'bold']) !!}
        {!! Form::select('num_of_positions', ['' => 'Pozisyon Sayısı Seçin'] + MiscHelper::getNumPositions(), null, array('class' => 'form-control', 'id' => 'num_of_positions')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'num_of_positions') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'gender_id') !!}" id="gender_id_div">
        {!! Form::label('gender_id', 'Cinsiyet', ['class' => 'bold']) !!}
        {!! Form::select('gender_id', ['' => __('No preference')] + $genders, null, array('class' => 'form-control', 'id' => 'gender_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'gender_id') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'expiry_date') !!}">
        {!! Form::label('expiry_date', 'İlan Bitiş Tarihi', ['class' => 'bold']) !!}
        <div class="input-group">
            {!! Form::text('expiry_date', (isset($job) && $job->expiry_date) ? date('d-m-Y', strtotime($job->expiry_date)) : null, array('class' => 'form-control', 'id' => 'expiry_date', 'placeholder' => 'İlan Bitiş Tarihi', 'autocomplete' => 'off', 'data-date-format' => 'dd-mm-yyyy')) !!}
            <span class="input-group-addon calendar-icon-trigger" id="expiry_date_icon" style="cursor: pointer;">
                <i class="fa fa-calendar"></i>
            </span>
        </div>
        <span class="help-block">
            <i class="fa fa-info-circle"></i> Lütfen GG-AA-YYYY formatında giriniz veya takvimden seçiniz.
        </span>
        {!! APFrmErrHelp::showErrors($errors, 'expiry_date') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'degree_level_id') !!}" id="degree_level_id_div">
        {!! Form::label('degree_level_id', 'Gerekli Eğitim Seviyesi', ['class' => 'bold']) !!}
        {!! Form::select('degree_level_id', ['' => 'Eğitim Seviyesi Seçin'] + $degreeLevels, null, array('class' => 'form-control', 'id' => 'degree_level_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'degree_level_id') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'job_experience_id') !!}" id="job_experience_id_div">
        {!! Form::label('job_experience_id', 'Gerekli İş Deneyimi', ['class' => 'bold']) !!}
        {!! Form::select('job_experience_id', ['' => 'İş Deneyimi Seçin'] + $jobExperiences, null, array('class' => 'form-control', 'id' => 'job_experience_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'job_experience_id') !!}
    </div>




    <div class="formrow">
        {!! Form::label('external_job', 'Harici İş İlanı mı?', ['class' => 'bold']) !!}
        <?php
$is_external_1 = '';
$is_external_2 = 'checked="checked"';
if (old('is_external', ((isset($job)) ? $job->external_job : 'no')) == 'yes') {
    $is_external_1 = 'checked="checked"';
    $is_external_2 = '';
}
            ?>
        <div class="radio-list">
            <label class="radio-inline">
                <input id="external" name="external_job" type="radio" value="yes" {{$is_external_1}}>
                Evet
            </label>
            <label class="radio-inline">
                <input id="not_external" name="external_job" type="radio" value="no" {{$is_external_2}}>
                Hayır
            </label>
        </div>
    </div>


    <div class="form-group">
        <div id="externalLinkField" class="formrow" style="display: {{$is_external_1 ? 'block' : 'none'}}">
            {!! Form::label('job_link', 'Harici Link', ['class' => 'bold']) !!}
            {!! Form::text('job_link', isset($job) ? $job->job_link : '', ['class' => 'form-control']) !!}
        </div>

    </div>





    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_active') !!}">
        {!! Form::label('is_active', 'Aktif mi?', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
$is_active_1 = 'checked="checked"';
$is_active_2 = '';
if (old('is_active', ((isset($job)) ? $job->is_active : 1)) == 0) {
    $is_active_1 = '';
    $is_active_2 = 'checked="checked"';
}
            ?>
            <label class="radio-inline">
                <input id="Aktif" name="is_active" type="radio" value="1" {{$is_active_1}}>
                Aktif </label>
            <label class="radio-inline">
                <input id="not_active" name="is_active" type="radio" value="0" {{$is_active_2}}>
                Pasif </label>
        </div>
        {!! APFrmErrHelp::showErrors($errors, 'is_active') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_featured') !!}">
        {!! Form::label('is_featured', 'Öne Çıkan mı?', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
$is_featured_1 = '';
$is_featured_2 = 'checked="checked"';
if (old('is_featured', ((isset($job)) ? $job->is_featured : 0)) == 1) {
    $is_featured_1 = 'checked="checked"';
    $is_featured_2 = '';
}
            ?>
            <label class="radio-inline">
                <input id="featured" name="is_featured" type="radio" value="1" {{$is_featured_1}}>
                Öne Çıkan </label>
            <label class="radio-inline">
                <input id="not_featured" name="is_featured" type="radio" value="0" {{$is_featured_2}}>
                Normal </label>
        </div>
        {!! APFrmErrHelp::showErrors($errors, 'is_featured') !!}
    </div>
    <div class="form-Actionler">
        {!! Form::button('Güncelle <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>', array('class' => 'btn btn-large btn-primary', 'type' => 'submit')) !!}
    </div>
</div>
@push('css')
    <style type="text/css">
        .datepicker>div {
            display: block;
        }

        /* Z-index fix for datepicker */
        .datepicker.datepicker-dropdown {
            z-index: 99999 !important;
        }
    </style>
@endpush
@push('scripts')
    @include('admin.shared.tinyMCEFront')

    <script>
        $(document).ready(function () {
            function toggleExternalLinkField() {
                var isExternalChecked = $('#external').is(':checked');
                if (isExternalChecked) {
                    $('#externalLinkField').show();
                } else {
                    $('#externalLinkField').hide();
                }
            }
            toggleExternalLinkField();
            $('input[name="external_job"]').change(function () {
                toggleExternalLinkField();
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('.select2-multiple').select2({
                placeholder: "Gerekli Yetenekleri Seçin",
                allowClear: true
            });
            var $expiryDate = $("#expiry_date");
            var datepickerOptions = {
                autoclose: true,
                startDate: new Date(),
                format: 'dd-mm-yyyy',
                todayHighlight: true,
                language: 'tr',
                forceParse: false
            };

            // Use the aliased bootstrapDatepicker if available, otherwise fallback
            if ($.fn.bootstrapDatepicker) {
                $expiryDate.bootstrapDatepicker(datepickerOptions);
            } else if ($.fn.datepicker) {
                $expiryDate.datepicker(datepickerOptions);
            }

            $('#expiry_date_icon').click(function (e) {
                e.preventDefault();
                $expiryDate.focus();
                if ($.fn.bootstrapDatepicker) {
                    $expiryDate.bootstrapDatepicker('show');
                } else if ($.fn.datepicker) {
                    $expiryDate.datepicker('show');
                }
            });

            $expiryDate.click(function () {
                if ($.fn.bootstrapDatepicker) {
                    $(this).bootstrapDatepicker('show');
                } else if ($.fn.datepicker) {
                    $(this).datepicker('show');
                }
            });
            $('#country_id').on('change', function (e) {
                e.preventDefault();
                filterDefaultStates(0);
            });
            $(document).on('change', '#state_id', function (e) {
                e.preventDefault();
                filterDefaultCities(0);
            });
            filterDefaultStates(<?php echo old('state_id', (isset($job)) ? $job->state_id : 0); ?>);
        });
        function filterDefaultStates(state_id) {
            var country_id = $('#country_id').val();
            if (country_id != '') {
                $.post("{{ route('filter.default.states.dropdown') }}", { country_id: country_id, state_id: state_id, _method: 'POST', _token: '{{ csrf_token() }}' })
                    .done(function (response) {
                        $('#default_state_dd').html(response);
                        filterDefaultCities(<?php echo old('city_id', (isset($job)) ? $job->city_id : 0); ?>);
                    });
            }
        }
        function filterDefaultCities(city_id) {
            var state_id = $('#state_id').val();
            if (state_id != '') {
                $.post("{{ route('filter.default.cities.dropdown') }}", { state_id: state_id, city_id: city_id, _method: 'POST', _token: '{{ csrf_token() }}' })
                    .done(function (response) {
                        $('#default_city_dd').html(response);
                    });
            }
        }
    </script>
@endpush