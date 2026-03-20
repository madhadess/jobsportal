{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
@if(isset($user))
    {!! Form::model($user, array('method' => 'put', 'route' => array('update.user', $user->id), 'class' => 'form', 'files' => true)) !!}
    {!! Form::hidden('id', $user->id) !!}
@else
    {!! Form::open(array('method' => 'post', 'route' => 'store.user', 'class' => 'form', 'files' => true)) !!}
@endif

<div class="form-body"> <input type="hidden" name="front_or_admin" value="admin" />
    <div class="row">
        <div class="col-md-6">
            <div class="form-group {!! APFrmErrHelp::hasError($errors, 'image') !!}">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-new thumbnail" style="width: 200px; height: 150px;"> <img
                            src="{{ asset('/') }}admin_assets/no-image.png" alt="" /> </div>
                    <div class="fileinput-preview fileinput-exists thumbnail"
                        style="max-width: 200px; max-height: 150px;"> </div>
                    <div> <span class="btn default btn-file"> <span class="fileinput-new"> Profil Resmi Seç </span>
                            <span class="fileinput-exists"> Değiştir </span>
                            {!! Form::file('image', null, array('id' => 'image')) !!} </span> <a href="javascript:;"
                            class="btn red fileinput-exists" data-dismiss="fileinput"> Kaldır </a> </div>
                </div> {!! APFrmErrHelp::showErrors($errors, 'image') !!}
            </div>
        </div> @if(isset($user))
        <div class="col-md-6"> {{ ImgUploader::print_image("user_images/$user->image") }} </div> @endif
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'first_name') !!}">
        {!! Form::label('first_name', 'Ad', ['class' => 'bold']) !!}
        {!! Form::text('first_name', null, array('class' => 'form-control', 'id' => 'first_name', 'placeholder' => 'Ad')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'first_name') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'middle_name') !!}">
        {!! Form::label('middle_name', 'İkinci Ad', ['class' => 'bold']) !!}
        {!! Form::text('middle_name', null, array('class' => 'form-control', 'id' => 'middle_name', 'placeholder' => 'İkinci Ad')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'middle_name') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'last_name') !!}">
        {!! Form::label('last_name', 'Soyad', ['class' => 'bold']) !!}
        {!! Form::text('last_name', null, array('class' => 'form-control', 'id' => 'last_name', 'placeholder' => 'Soyad')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'last_name') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'email') !!}">
        {!! Form::label('email', 'E-posta', ['class' => 'bold']) !!}
        {!! Form::text('email', null, array('class' => 'form-control', 'id' => 'email', 'placeholder' => 'E-posta')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'email') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'user_type') !!}">
        {!! Form::label('user_type', 'Kullanıcı Tipi', ['class' => 'bold']) !!}
        {!! Form::select('user_type', ['candidate' => 'İş Arayan', 'member' => 'Hizmet Alan', 'personnel' => 'Hizmet Personeli', 'caregiver' => 'Bakıcı'], null, array('class' => 'form-control', 'id' => 'user_type')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'user_type') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'password') !!}">
        {!! Form::label('password', 'Şifre', ['class' => 'bold']) !!}
        {!! Form::password('password', array('class' => 'form-control', 'id' => 'password', 'placeholder' => 'Şifre')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'password') !!}
    </div>

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'date_of_birth') !!}">
        {!! Form::label('date_of_birth', 'Doğum Tarihi', ['class' => 'bold']) !!}
        {!! Form::date('date_of_birth', null, array('class' => 'form-control', 'id' => 'date_of_birth', 'placeholder' => 'Doğum Tarihi', 'autocomplete' => 'off')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'date_of_birth') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'gender_id') !!}">
        {!! Form::label('gender_id', 'Cinsiyet', ['class' => 'bold']) !!}
        {!! Form::select('gender_id', ['' => 'Cinsiyet Seçin'] + $genders, null, array('class' => 'form-control', 'id' => 'gender_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'gender_id') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'marital_status_id') !!}">
        {!! Form::label('marital_status_id', 'Medeni Durum', ['class' => 'bold']) !!}
        {!! Form::select('marital_status_id', ['' => 'Medeni Durum Seçin'] + $maritalStatuses, null, array('class' => 'form-control', 'id' => 'marital_status_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'marital_status_id') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'nationality_id') !!}">
        {!! Form::label('nationality_id', 'Uyruk', ['class' => 'bold']) !!}
        {!! Form::select('nationality_id', ['' => 'Uyruk Seçin'] + $nationalities, null, array('class' => 'form-control', 'id' => 'nationality_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'nationality_id') !!}
    </div>

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'country_id') !!}">
        {!! Form::label('country_id', 'Ülke', ['class' => 'bold']) !!}
        {!! Form::select('country_id', ['' => 'Ülke Seçin'] + $countries, old('country_id', (isset($user)) ? $user->country_id : $siteSetting->default_country_id), array('class' => 'form-control', 'id' => 'country_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'country_id') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'state_id') !!}">
        {!! Form::label('state_id', 'Şehir', ['class' => 'bold']) !!} <span id="default_state_dd">
            {!! Form::select('state_id', ['' => 'Şehir Seçin'], null, array('class' => 'form-control', 'id' => 'state_id')) !!}
        </span> {!! APFrmErrHelp::showErrors($errors, 'state_id') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'city_id') !!}">
        {!! Form::label('city_id', 'İlçe', ['class' => 'bold']) !!} <span id="default_city_dd">
            {!! Form::select('city_id', ['' => 'İlçe Seçin'], null, array('class' => 'form-control', 'id' => 'city_id')) !!}
        </span> {!! APFrmErrHelp::showErrors($errors, 'city_id') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'neighborhood') !!}">
        {!! Form::label('neighborhood', 'Mahalle', ['class' => 'bold']) !!}
        {!! Form::text('neighborhood', null, array('class' => 'form-control', 'id' => 'neighborhood', 'placeholder' => 'Mahalle')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'neighborhood') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'street') !!}">
        {!! Form::label('street', 'Sokak', ['class' => 'bold']) !!}
        {!! Form::text('street', null, array('class' => 'form-control', 'id' => 'street', 'placeholder' => 'Sokak')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'street') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'phone') !!}">
        {!! Form::label('phone', 'Telefon', ['class' => 'bold']) !!}
        {!! Form::text('phone', null, array('class' => 'form-control', 'id' => 'phone', 'placeholder' => 'Telefon')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'phone') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'mobile_num') !!}">
        {!! Form::label('mobile_num', 'Cep Telefonu', ['class' => 'bold']) !!}
        {!! Form::text('mobile_num', null, array('class' => 'form-control', 'id' => 'mobile_num', 'placeholder' => 'Cep Telefonu')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'mobile_num') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'job_experience_id') !!}">
        {!! Form::label('job_experience_id', 'İş Deneyimi', ['class' => 'bold']) !!}
        {!! Form::select('job_experience_id', ['' => 'İş Deneyimi Seçin'] + $jobExperiences, null, array('class' => 'form-control', 'id' => 'job_experience_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'job_experience_id') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'career_level_id') !!}">
        {!! Form::label('career_level_id', 'Kariyer Seviyesi', ['class' => 'bold']) !!}
        {!! Form::select('career_level_id', ['' => 'Kariyer Seviyesi Seçin'] + $careerLevels, null, array('class' => 'form-control', 'id' => 'career_level_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'career_level_id') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'industry_id') !!}">
        {!! Form::label('industry_id', 'Sektör', ['class' => 'bold']) !!}
        {!! Form::select('industry_id', ['' => 'Sektör Seçin'] + $industries, null, array('class' => 'form-control', 'id' => 'industry_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'industry_id') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'functional_area_id') !!}">
        {!! Form::label('functional_area_id', 'Fonksiyonel Alan', ['class' => 'bold']) !!}
        {!! Form::select('functional_area_id', ['' => 'Fonksiyonel Alan Seçin'] + $functionalAreas, null, array('class' => 'form-control', 'id' => 'functional_area_id')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'functional_area_id') !!}
    </div>

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'expected_salary') !!}">
        {!! Form::label('expected_salary', 'Beklenen Maaş', ['class' => 'bold']) !!}
        {!! Form::text('expected_salary', null, array('class' => 'form-control', 'id' => 'expected_salary', 'placeholder' => 'Beklenen Maaş')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'expected_salary') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'salary_currency') !!}">
        {!! Form::label('salary_currency', 'Maaş Para Birimi', ['class' => 'bold']) !!}
        {!! Form::text('salary_currency', null, array('class' => 'form-control', 'id' => 'salary_currency', 'placeholder' => 'Maaş Para Birimi', 'autocomplete' => 'off')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'salary_currency') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'street_address') !!}">
        {!! Form::label('street_address', 'Cadde Adresi', ['class' => 'bold']) !!}
        {!! Form::textarea('street_address', null, array('class' => 'form-control', 'id' => 'street_address', 'placeholder' => 'Cadde Adresi')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'street_address') !!}
    </div>
    @if((bool) config('jobseeker.is_jobseeker_package_active'))
        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'job_seeker_package_id') !!}">
            {!! Form::label('job_seeker_package_id', 'Paket', ['class' => 'bold']) !!}
            {!! Form::select('job_seeker_package_id', ['' => 'Paket Seçin'] + $packages, null, array('class' => 'form-control', 'id' => 'job_seeker_package_id')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'job_seeker_package_id') !!}
        </div>

        @if(isset($user) && $user->package_id > 0)
            <div class="form-group">
                {!! Form::label('package', 'Paket : ', ['class' => 'bold']) !!}
                <strong>{{$user->getPackage('package_title')}}</strong>
            </div>
            <div class="form-group">
                {!! Form::label('package_Duration', 'Paket Süresi : ', ['class' => 'bold']) !!}
                <strong>{{\Carbon\Carbon::parse($user->package_start_date)->translatedFormat('d F Y')}}</strong> -
                <strong>{{\Carbon\Carbon::parse($user->package_end_date)->translatedFormat('d F Y')}}</strong>
            </div>
            <div class="form-group">
                {!! Form::label('package_quota', 'Kullanılan kota : ', ['class' => 'bold']) !!}
                <strong>{{$user->availed_jobs_quota}}</strong> / <strong>{{$user->jobs_quota}}</strong>
            </div>
            <hr />
        @endif
    @endif


    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_immediate_available') !!}">
        {!! Form::label('is_immediate_available', 'Hemen İşe Başlayabilir mi?', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
$is_immediate_available_1 = 'checked="checked"';
$is_immediate_available_2 = '';
if (old('is_immediate_available', ((isset($user)) ? $user->is_immediate_available : 1)) == 0) {
    $is_immediate_available_1 = '';
    $is_immediate_available_2 = 'checked="checked"';
}
        ?>
            <label class="radio-inline">
                <input id="immediate_available" name="is_immediate_available" type="radio" value="1"
                    {{$is_immediate_available_1}}>
                Hemen Başlayabilir </label>
            <label class="radio-inline">
                <input id="not_immediate_available" name="is_immediate_available" type="radio" value="0"
                    {{$is_immediate_available_2}}>
                Hemen Başlayamaz </label>
        </div>
        {!! APFrmErrHelp::showErrors($errors, 'is_immediate_available') !!}
    </div>


    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_active') !!}">
        {!! Form::label('is_active', 'Aktif', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
$is_active_1 = 'checked="checked"';
$is_active_2 = '';
if (old('is_active', ((isset($user)) ? $user->is_active : 1)) == 0) {
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
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'verified') !!}">
        {!! Form::label('verified', 'Doğrulandı', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
$verified_1 = 'checked="checked"';
$verified_2 = '';
if (old('verified', ((isset($user)) ? $user->verified : 1)) == 0) {
    $verified_1 = '';
    $verified_2 = 'checked="checked"';
}
        ?>
            <label class="radio-inline">
                <input id="verified" name="verified" type="radio" value="1" {{$verified_1}}>
                Doğrulandı </label>
            <label class="radio-inline">
                <input id="not_verified" name="verified" type="radio" value="0" {{$verified_2}}>
                Doğrulanmadı </label>
        </div>
        {!! APFrmErrHelp::showErrors($errors, 'verified') !!}
    </div>

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_featured') !!}">
        {!! Form::label('is_featured', 'Öne Çıkarılmış', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
$is_featured_1 = 'checked="checked"';
$is_featured_2 = '';
if (old('is_featured', ((isset($user)) ? $user->is_featured : 1)) == 0) {
    $is_featured_1 = '';
    $is_featured_2 = 'checked="checked"';
}
        ?>
            <label class="radio-inline">
                <input id="is_featured" name="is_featured" type="radio" value="1" {{$is_featured_1}}>
                Öne Çıkarıldı </label>
            <label class="radio-inline">
                <input id="not_verified" name="is_featured" type="radio" value="0" {{$is_featured_2}}>
                Öne Çıkarılmadı </label>
        </div>
        {!! APFrmErrHelp::showErrors($errors, 'is_featured') !!}
    </div>

    @if(isset($user) && ($user->isPersonnel() || $user->isCaregiver()))
        <hr>
        <h3>Otomatik Atama Ayarları</h3>
        <div class="form-group">
            {!! Form::label('is_eligible_for_auto_assignment', 'Otomatik Atamaya Uygun mu?', ['class' => 'bold']) !!}
            <div class="radio-list">
                <label class="radio-inline">
                    {!! Form::radio('is_eligible_for_auto_assignment', 1, true) !!} Uygun
                </label>
                <label class="radio-inline">
                    {!! Form::radio('is_eligible_for_auto_assignment', 0) !!} Uygun Değil
                </label>
            </div>
        </div>

        <div class="form-group">
            {!! Form::label('max_daily_tasks', 'Günlük Maksimum İş Sayısı', ['class' => 'bold']) !!}
            {!! Form::number('max_daily_tasks', null, ['class' => 'form-control', 'min' => 1, 'max' => 20]) !!}
        </div>

        <div class="form-group">
            {!! Form::label('service_types', 'Verdiği Hizmetler', ['class' => 'bold']) !!}
            {!! Form::select('service_types[]', App\Service::active()->pluck('service_name', 'id'), null, ['class' => 'form-control select2-multiple', 'multiple' => 'multiple']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('work_locations', 'Hizmet Bölgeleri (Şehir)', ['class' => 'bold']) !!}
            {!! Form::select('work_locations[]', App\State::where('country_id', 805)->pluck('state', 'id'), null, ['class' => 'form-control select2-multiple', 'multiple' => 'multiple', 'placeholder' => 'Şehirleri Seçin']) !!}
        </div>
    @endif

    <hr>
    {!! Form::button((isset($user) ? 'Kullanıcıyı Güncelle' : 'Kullanıcı Oluştur') . ' <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>', array('class' => 'btn btn-large btn-primary', 'type' => 'submit')) !!}
</div> {!! Form::close() !!}
<style type="text/css">
    .datepicker-dropdown {
        z-index: 9999 !important;
    }
</style>
<script type="text/javascript">
    function loadAndInit() {
        if (typeof window.jQuery === 'undefined' || typeof window.jQuery.fn === 'undefined') {
            setTimeout(loadAndInit, 100);
            return;
        }

        var $ = window.jQuery;

        if (typeof $.fn.datepicker === 'undefined') {
            var basePath = "{{ asset('/') }}admin_assets/global/plugins/bootstrap-datepicker/";
            $.getScript(basePath + 'js/bootstrap-datepicker.min.js', function () {
                $.getScript(basePath + 'locales/bootstrap-datepicker.tr.min.js', function () {
                    runFormInit($);
                });
            });
        } else {
            runFormInit($);
        }
    }

    function runFormInit($) {
        $(document).ready(function () {
            initdatepicker($);
            $('#salary_currency').typeahead({ source: function (query, process) { return $.get("{{ route('typeahead.currency_codes') }}", { query: query }, function (data) { console.log(data); data = $.parseJSON(data); return process(data); }); } });
            $('#country_id').on('change', function (e) {
                e.preventDefault();
                filterDefaultStates(0, $);
            });
            $(document).on('change', '#state_id', function (e) {
                e.preventDefault();
                filterDefaultCities(0, $);
            });
            filterDefaultStates(<?php echo old('state_id', (isset($user)) ? $user->state_id : 0); ?>, $);
        });
    }

    function filterDefaultStates(state_id, $) {
        var country_id = $('#country_id').val();
        if (country_id != '') {
            $.post("{{ route('filter.default.states.dropdown') }}", { country_id: country_id, state_id: state_id, _method: 'POST', _token: '{{ csrf_token() }}' })
                .done(function (response) {
                    $('#default_state_dd').html(response);
                    filterDefaultCities(<?php echo old('city_id', (isset($user)) ? $user->city_id : 0); ?>, $);
                });
        }
    }

    function filterDefaultCities(city_id, $) {
        var state_id = $('#state_id').val();
        if (state_id != '') {
            $.post("{{ route('filter.default.cities.dropdown') }}", { state_id: state_id, city_id: city_id, _method: 'POST', _token: '{{ csrf_token() }}' })
                .done(function (response) {
                    $('#default_city_dd').html(response);
                });
        }
    }

    function initdatepicker($) {
        $(".datepicker").datepicker({
            autoclose: true,
            format: 'yyyy-mm-dd',
            endDate: new Date(),
            startView: 2,
            language: 'tr'
        });
    }

    loadAndInit();
</script>