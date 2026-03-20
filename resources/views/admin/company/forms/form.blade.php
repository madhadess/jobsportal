{!! APFrmErrHelp::showErrorsNotice($errors) !!}
@include('flash::message')
@if(isset($company))
    {!! Form::model($company, array('method' => 'put', 'route' => array('update.company', $company->id), 'class' => 'form', 'files' => true)) !!}
    {!! Form::hidden('id', $company->id) !!}
@else
    {!! Form::open(array('method' => 'post', 'route' => 'store.company', 'class' => 'form', 'files' => true)) !!}
@endif
<div class="form-body">
    <input type="hidden" name="front_or_admin" value="admin" />

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'name') !!}">
        {!! Form::label('name', 'Şirket Adı', ['class' => 'bold']) !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Şirket Adı']) !!}
        {!! APFrmErrHelp::showErrors($errors, 'name') !!}
    </div>

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'email') !!}">
        {!! Form::label('email', 'E-posta', ['class' => 'bold']) !!}
        {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'E-posta']) !!}
        {!! APFrmErrHelp::showErrors($errors, 'email') !!}
    </div>

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'password') !!}">
        {!! Form::label('password', 'Şifre', ['class' => 'bold']) !!}
        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Şifre']) !!}
        {!! APFrmErrHelp::showErrors($errors, 'password') !!}
    </div>

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'phone') !!}">
        {!! Form::label('phone', 'Telefon', ['class' => 'bold']) !!}
        {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => 'Telefon']) !!}
        {!! APFrmErrHelp::showErrors($errors, 'phone') !!}
    </div>

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'website') !!}">
        {!! Form::label('website', 'Web Sitesi', ['class' => 'bold']) !!}
        {!! Form::text('website', null, ['class' => 'form-control', 'placeholder' => 'Web Sitesi']) !!}
        {!! APFrmErrHelp::showErrors($errors, 'website') !!}
    </div>

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'description') !!}">
        {!! Form::label('description', 'Açıklama', ['class' => 'bold']) !!}
        {!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 4, 'placeholder' => 'Açıklama']) !!}
        {!! APFrmErrHelp::showErrors($errors, 'description') !!}
    </div>

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'country_id') !!}">
        {!! Form::label('country_id', 'Ülke', ['class' => 'bold']) !!}
        {!! Form::select('country_id', $countries, null, ['class' => 'form-control', 'id' => 'country_id']) !!}
        {!! APFrmErrHelp::showErrors($errors, 'country_id') !!}
    </div>

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'state_id') !!}">
        {!! Form::label('state_id', 'Eyalet', ['class' => 'bold']) !!}
        <div id="default_state_dd">
            {!! Form::select('state_id', $states ?? [], null, ['class' => 'form-control', 'id' => 'state_id']) !!}
        </div>
        {!! APFrmErrHelp::showErrors($errors, 'state_id') !!}
    </div>

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'city_id') !!}">
        {!! Form::label('city_id', 'Şehir', ['class' => 'bold']) !!}
        <div id="default_city_dd">
            {!! Form::select('city_id', $cities ?? [], null, ['class' => 'form-control', 'id' => 'city_id']) !!}
        </div>
        {!! APFrmErrHelp::showErrors($errors, 'city_id') !!}
    </div>

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'industry_id') !!}">
        {!! Form::label('industry_id', 'Sektör', ['class' => 'bold']) !!}
        {!! Form::select('industry_id', ['' => 'Sektör Seç'] + $industries, null, ['class' => 'form-control', 'id' => 'industry_id']) !!}
        {!! APFrmErrHelp::showErrors($errors, 'industry_id') !!}
    </div>

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'ownership_type_id') !!}">
        {!! Form::label('ownership_type_id', 'Mülkiyet Tipi', ['class' => 'bold']) !!}
        {!! Form::select('ownership_type_id', ['' => 'Mülkiyet Tipi Seç'] + $ownershipTypes, null, ['class' => 'form-control', 'id' => 'ownership_type_id']) !!}
        {!! APFrmErrHelp::showErrors($errors, 'ownership_type_id') !!}
    </div>

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'location') !!}">
        {!! Form::label('location', 'Konum', ['class' => 'bold']) !!}
        {!! Form::text('location', null, ['class' => 'form-control', 'placeholder' => 'Şirket Konumu']) !!}
        {!! APFrmErrHelp::showErrors($errors, 'location') !!}
    </div>

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'no_of_offices') !!}">
        {!! Form::label('no_of_offices', 'Ofis Sayısı', ['class' => 'bold']) !!}
        {!! Form::number('no_of_offices', null, ['class' => 'form-control', 'placeholder' => 'Ofis Sayısı', 'min' => 1]) !!}
        {!! APFrmErrHelp::showErrors($errors, 'no_of_offices') !!}
    </div>

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'no_of_employees') !!}">
        {!! Form::label('no_of_employees', 'Çalışan Sayısı', ['class' => 'bold']) !!}
        {!! Form::number('no_of_employees', null, ['class' => 'form-control', 'placeholder' => 'Çalışan Sayısı', 'min' => 1]) !!}
        {!! APFrmErrHelp::showErrors($errors, 'no_of_employees') !!}
    </div>

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'established_in') !!}">
        {!! Form::label('established_in', 'Kuruluş Yılı', ['class' => 'bold']) !!}
        {!! Form::number('established_in', null, ['class' => 'form-control', 'placeholder' => 'Kuruluş Yılı', 'min' => 1900, 'max' => date('Y')]) !!}
        {!! APFrmErrHelp::showErrors($errors, 'established_in') !!}
    </div>

    <!-- 
<div class="form-group {!! APFrmErrHelp::hasError($errors, 'logo') !!}">
        {!! Form::label('logo', 'Şirket Logosu', ['class' => 'bold']) !!}
        {!! Form::file('logo', ['class' => 'form-control', 'accept' => 'image/*']) !!}
        @if(isset($company) && !empty($company->logo))
        <div class="mt-2">
            <img src="{{ asset('uploads/company_logo/' . $company->logo) }}" alt="Logo" style="max-height: 100px;">
        </div>
        @endif
        {!! APFrmErrHelp::showErrors($errors, 'logo') !!}
    </div>
-->

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'address') !!}">
        {!! Form::label('address', 'Adres', ['class' => 'bold']) !!}
        {!! Form::text('address', null, ['class' => 'form-control', 'placeholder' => 'Adres']) !!}
        {!! APFrmErrHelp::showErrors($errors, 'address') !!}
    </div>

    @if(isset($company) && $company->package_id > 0)
        <div class="form-group">
            {!! Form::label('package', 'Paket', ['class' => 'bold']) !!}
            <strong>{{ optional($company->getPackage())->package_title }}</strong>
        </div>
        <div class="form-group">
            {!! Form::label('package_duration', 'Paket Süresi', ['class' => 'bold']) !!}
            <strong>{{ optional($company->package_start_date)->translatedFormat('d F Y') }}</strong> -
            <strong>{{ optional($company->package_end_date)->translatedFormat('d F Y') }}</strong>
        </div>
        <div class="form-group">
            {!! Form::label('package_quota', 'Kullanılan Kota', ['class' => 'bold']) !!}
            <strong>{{ $company->availed_jobs_quota }}</strong> / <strong>{{ $company->jobs_quota }}</strong>
        </div>
        <hr />
    @endif

    @if(isset($company) && $company->cvs_package_id > 0)
        <div class="form-group">
            {!! Form::label('cvs_package', 'CV Arama Paketi', ['class' => 'bold']) !!}
            <strong>{{ optional($company->cvs_getPackage())->package_title }}</strong>
        </div>
        <div class="form-group">
            {!! Form::label('cvs_package_duration', 'CV Paket Süresi', ['class' => 'bold']) !!}
            <strong>{{ $company->cvs_package_start_date ? \Carbon\Carbon::parse($company->cvs_package_start_date)->translatedFormat('d F Y') : 'N/A' }}</strong>
            -
            <strong>{{ $company->cvs_package_end_date ? \Carbon\Carbon::parse($company->cvs_package_end_date)->translatedFormat('d F Y') : 'N/A' }}</strong>
        </div>
        <div class="form-group">
            {!! Form::label('cvs_quota', 'Mevcut CV Kotası', ['class' => 'bold']) !!}
            <strong>{{ $company->availed_cvs_quota ?? 0 }}</strong> /
            <strong>{{ $company->cvs_quota ?? 0 }}</strong>
        </div>
    @endif

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_active') !!}">
        {!! Form::label('is_active', 'Durum', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
$is_active_1 = 'checked="checked"';
$is_active_2 = '';
if (old('is_active', ((isset($company)) ? $company->is_active : 1)) == 0) {
    $is_active_1 = '';
    $is_active_2 = 'checked="checked"';
}
            ?>
            <label class="radio-inline">
                <input name="is_active" type="radio" value="1" {{$is_active_1}}> Aktif
            </label>
            <label class="radio-inline">
                <input name="is_active" type="radio" value="0" {{$is_active_2}}> Pasif
            </label>
        </div>
        {!! APFrmErrHelp::showErrors($errors, 'is_active') !!}
    </div>

    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_featured') !!}">
        {!! Form::label('is_featured', 'Öne Çıkan', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
$is_featured_1 = '';
$is_featured_2 = 'checked="checked"';
if (old('is_featured', ((isset($company)) ? $company->is_featured : 0)) == 1) {
    $is_featured_1 = 'checked="checked"';
    $is_featured_2 = '';
}
            ?>
            <label class="radio-inline">
                <input name="is_featured" type="radio" value="1" {{$is_featured_1}}> Öne Çıkan
            </label>
            <label class="radio-inline">
                <input name="is_featured" type="radio" value="0" {{$is_featured_2}}> Normal
            </label>
        </div>
        {!! APFrmErrHelp::showErrors($errors, 'is_featured') !!}
    </div>

    <div class="form-actions">
        {!! Form::button('Kaydet <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>', array('class' => 'btn btn-large btn-primary', 'type' => 'submit')) !!}
    </div>
</div>
@push('scripts')
    @include('admin.shared.tinyMCEFront')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#country_id').on('change', function (e) {
                e.preventDefault();
                filterDefaultStates(0);
            });
            $(document).on('change', '#state_id', function (e) {
                e.preventDefault();
                filterDefaultCities(0);
            });
            filterDefaultStates(<?php echo old('state_id', (isset($company)) ? $company->state_id : 0); ?>);
        });

        function filterDefaultStates(state_id) {
            var country_id = $('#country_id').val();
            if (country_id != '') {
                $.post("{{ route('filter.default.states.dropdown') }}", {
                    country_id: country_id,
                    state_id: state_id,
                    _method: 'POST',
                    _token: '{{ csrf_token() }}'
                })
                    .done(function (response) {
                        $('#default_state_dd').html(response);
                        filterDefaultCities(<?php echo old('city_id', (isset($company)) ? $company->city_id : 0); ?>);
                    });
            }
        }

        function filterDefaultCities(city_id) {
            var state_id = $('#state_id').val();
            if (state_id != '') {
                $.post("{{ route('filter.default.cities.dropdown') }}", {
                    state_id: state_id,
                    city_id: city_id,
                    _method: 'POST',
                    _token: '{{ csrf_token() }}'
                })
                    .done(function (response) {
                        $('#default_city_dd').html(response);
                    });
            }
        }
    </script>
@endpush
@if(isset($company))
    {!! Form::close() !!}
@else
    {!! Form::close() !!}
@endif