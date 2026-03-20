
<div class="form-body">
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'package_title') !!}">
        {!! Form::label('package_title', 'Paket Başlığı', ['class' => 'bold']) !!}
        {!! Form::text('package_title', null, array('class' => 'form-control', 'id' => 'package_title', 'placeholder' => 'Paket Başlığı')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'package_title') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'package_price') !!}">
        {!! Form::label('package_price', 'Paket Fiyatı', ['class' => 'bold']) !!}
        {!! Form::number('package_price', null, array('class' => 'form-control', 'id' => 'package_price', 'placeholder' => 'Paket Fiyatı')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'package_price') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'package_num_days') !!}">
        {!! Form::label('package_num_days', 'Paket Gün Sayısı', ['class' => 'bold']) !!}
        {!! Form::number('package_num_days', null, array('class' => 'form-control', 'id' => 'package_num_days', 'placeholder' => 'Paket Gün Sayısı')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'package_num_days') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'package_num_listings') !!}">
        {!! Form::label('package_num_listings', 'Paket İlan Sayısı', ['class' => 'bold']) !!}
        {!! Form::number('package_num_listings', null, array('class' => 'form-control', 'id' => 'package_num_listings', 'placeholder' => 'Paket İlan Sayısı')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'package_num_listings') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'package_for') !!}">
        {!! Form::label('package_for', 'Paket Kime?', ['class' => 'bold']) !!}
        <div class="radio-list">
            <?php
$package_for_1 = 'checked="checked"';
$package_for_2 = '';
$package_for_3 = '';
$package_for_4 = '';
if (old('package_for', ((isset($package)) ? $package->package_for : 'job_seeker')) == 'employer') {
    $package_for_1 = '';
    $package_for_2 = 'checked="checked"';
    $package_for_3 = '';
    $package_for_4 = '';
}
if (old('package_for', ((isset($package)) ? $package->package_for : 'job_seeker')) == 'job_seeker') {
    $package_for_1 = 'checked="checked"';
    $package_for_2 = '';
    $package_for_3 = '';
    $package_for_4 = '';
}
if (old('package_for', ((isset($package)) ? $package->package_for : 'job_seeker')) == 'candidate') {
    $package_for_1 = '';
    $package_for_2 = '';
    $package_for_3 = 'checked="checked"';
    $package_for_4 = '';
}

if (old('package_for', ((isset($package)) ? $package->package_for : 'job_seeker')) == 'cv_search') {
    $package_for_1 = '';
    $package_for_2 = '';
    $package_for_3 = '';
    $package_for_4 = 'checked="checked"';
}

            ?>
            <label class="radio-inline">
                <input id="job_seeker" name="package_for" type="radio" value="job_seeker" {{$package_for_1}}>
                İş Arayan </label>
            <label class="radio-inline">
                <input id="employer" name="package_for" type="radio" value="employer" {{$package_for_2}}>
                İşveren </label>
            <label class="radio-inline">
                <input id="candidate" name="package_for" type="radio" value="candidate" {{$package_for_3}}>
                Aday </label>
            <label class="radio-inline">
                <input id="cv_search" name="package_for" type="radio" value="cv_search" {{$package_for_4}}>
                CV Arama </label>
            <label class="radio-inline">
                <input id="featured_job" name="package_for" type="radio" value="featured_job" {{ old('package_for', (isset($package) ? $package->package_for : '')) == 'featured_job' ? 'checked="checked"' : '' }}>
                İlan Öne Çıkarma </label>
        </div>
        {!! APFrmErrHelp::showErrors($errors, 'package_for') !!}
    </div>
    <div class="form-actions">
        {!! Form::button('Güncelle <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>', array('class' => 'btn btn-large btn-primary', 'type' => 'submit')) !!}
    </div>
</div>
<script>
    function togglePackageListings() {
        var employerRadio = document.getElementById('employer');
        var packageNumListingsInput = document.getElementById('package_num_listings');
        var packageNumListingsContainer = packageNumListingsInput.closest('.form-group');

        var radios = document.querySelectorAll('input[name="package_for"]');
        var selectedValue = '';
        radios.forEach(function (radio) {
            if (radio.checked) {
                selectedValue = radio.value;
            }
        });

        if (selectedValue === 'employer' || selectedValue === 'featured_job') {
            packageNumListingsContainer.style.display = 'block';
        } else {
            packageNumListingsContainer.style.display = 'none';
            packageNumListingsInput.value = '';
        }
    }

    document.addEventListener('DOMContentLoaded', function () {
        togglePackageListings();

        var radios = document.querySelectorAll('input[name="package_for"]');
        radios.forEach(function (radio) {
            radio.addEventListener('change', togglePackageListings);
        });
    });
</script>