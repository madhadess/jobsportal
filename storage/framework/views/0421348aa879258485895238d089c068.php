<?php echo APFrmErrHelp::showErrorsNotice($errors); ?>

<?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php if(isset($company)): ?>
    <?php echo Form::model($company, array('method' => 'put', 'route' => array('update.company', $company->id), 'class' => 'form', 'files' => true)); ?>

    <?php echo Form::hidden('id', $company->id); ?>

<?php else: ?>
    <?php echo Form::open(array('method' => 'post', 'route' => 'store.company', 'class' => 'form', 'files' => true)); ?>

<?php endif; ?>
<div class="form-body">
    <input type="hidden" name="front_or_admin" value="admin" />

    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'name'); ?>">
        <?php echo Form::label('name', 'Şirket Adı', ['class' => 'bold']); ?>

        <?php echo Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Şirket Adı']); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'name'); ?>

    </div>

    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'email'); ?>">
        <?php echo Form::label('email', 'E-posta', ['class' => 'bold']); ?>

        <?php echo Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'E-posta']); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'email'); ?>

    </div>

    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'password'); ?>">
        <?php echo Form::label('password', 'Şifre', ['class' => 'bold']); ?>

        <?php echo Form::password('password', ['class' => 'form-control', 'placeholder' => 'Şifre']); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'password'); ?>

    </div>

    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'phone'); ?>">
        <?php echo Form::label('phone', 'Telefon', ['class' => 'bold']); ?>

        <?php echo Form::text('phone', null, ['class' => 'form-control', 'placeholder' => 'Telefon']); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'phone'); ?>

    </div>

    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'website'); ?>">
        <?php echo Form::label('website', 'Web Sitesi', ['class' => 'bold']); ?>

        <?php echo Form::text('website', null, ['class' => 'form-control', 'placeholder' => 'Web Sitesi']); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'website'); ?>

    </div>

    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'description'); ?>">
        <?php echo Form::label('description', 'Açıklama', ['class' => 'bold']); ?>

        <?php echo Form::textarea('description', null, ['class' => 'form-control', 'rows' => 4, 'placeholder' => 'Açıklama']); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'description'); ?>

    </div>

    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'country_id'); ?>">
        <?php echo Form::label('country_id', 'Ülke', ['class' => 'bold']); ?>

        <?php echo Form::select('country_id', $countries, null, ['class' => 'form-control', 'id' => 'country_id']); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'country_id'); ?>

    </div>

    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'state_id'); ?>">
        <?php echo Form::label('state_id', 'Eyalet', ['class' => 'bold']); ?>

        <div id="default_state_dd">
            <?php echo Form::select('state_id', $states ?? [], null, ['class' => 'form-control', 'id' => 'state_id']); ?>

        </div>
        <?php echo APFrmErrHelp::showErrors($errors, 'state_id'); ?>

    </div>

    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'city_id'); ?>">
        <?php echo Form::label('city_id', 'Şehir', ['class' => 'bold']); ?>

        <div id="default_city_dd">
            <?php echo Form::select('city_id', $cities ?? [], null, ['class' => 'form-control', 'id' => 'city_id']); ?>

        </div>
        <?php echo APFrmErrHelp::showErrors($errors, 'city_id'); ?>

    </div>

    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'industry_id'); ?>">
        <?php echo Form::label('industry_id', 'Sektör', ['class' => 'bold']); ?>

        <?php echo Form::select('industry_id', ['' => 'Sektör Seç'] + $industries, null, ['class' => 'form-control', 'id' => 'industry_id']); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'industry_id'); ?>

    </div>

    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'ownership_type_id'); ?>">
        <?php echo Form::label('ownership_type_id', 'Mülkiyet Tipi', ['class' => 'bold']); ?>

        <?php echo Form::select('ownership_type_id', ['' => 'Mülkiyet Tipi Seç'] + $ownershipTypes, null, ['class' => 'form-control', 'id' => 'ownership_type_id']); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'ownership_type_id'); ?>

    </div>

    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'location'); ?>">
        <?php echo Form::label('location', 'Konum', ['class' => 'bold']); ?>

        <?php echo Form::text('location', null, ['class' => 'form-control', 'placeholder' => 'Şirket Konumu']); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'location'); ?>

    </div>

    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'no_of_offices'); ?>">
        <?php echo Form::label('no_of_offices', 'Ofis Sayısı', ['class' => 'bold']); ?>

        <?php echo Form::number('no_of_offices', null, ['class' => 'form-control', 'placeholder' => 'Ofis Sayısı', 'min' => 1]); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'no_of_offices'); ?>

    </div>

    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'no_of_employees'); ?>">
        <?php echo Form::label('no_of_employees', 'Çalışan Sayısı', ['class' => 'bold']); ?>

        <?php echo Form::number('no_of_employees', null, ['class' => 'form-control', 'placeholder' => 'Çalışan Sayısı', 'min' => 1]); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'no_of_employees'); ?>

    </div>

    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'established_in'); ?>">
        <?php echo Form::label('established_in', 'Kuruluş Yılı', ['class' => 'bold']); ?>

        <?php echo Form::number('established_in', null, ['class' => 'form-control', 'placeholder' => 'Kuruluş Yılı', 'min' => 1900, 'max' => date('Y')]); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'established_in'); ?>

    </div>

    <!-- 
<div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'logo'); ?>">
        <?php echo Form::label('logo', 'Şirket Logosu', ['class' => 'bold']); ?>

        <?php echo Form::file('logo', ['class' => 'form-control', 'accept' => 'image/*']); ?>

        <?php if(isset($company) && !empty($company->logo)): ?>
        <div class="mt-2">
            <img src="<?php echo e(asset('uploads/company_logo/' . $company->logo)); ?>" alt="Logo" style="max-height: 100px;">
        </div>
        <?php endif; ?>
        <?php echo APFrmErrHelp::showErrors($errors, 'logo'); ?>

    </div>
-->

    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'address'); ?>">
        <?php echo Form::label('address', 'Adres', ['class' => 'bold']); ?>

        <?php echo Form::text('address', null, ['class' => 'form-control', 'placeholder' => 'Adres']); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'address'); ?>

    </div>

    <?php if(isset($company) && $company->package_id > 0): ?>
        <div class="form-group">
            <?php echo Form::label('package', 'Paket', ['class' => 'bold']); ?>

            <strong><?php echo e(optional($company->getPackage())->package_title); ?></strong>
        </div>
        <div class="form-group">
            <?php echo Form::label('package_duration', 'Paket Süresi', ['class' => 'bold']); ?>

            <strong><?php echo e(optional($company->package_start_date)->translatedFormat('d F Y')); ?></strong> -
            <strong><?php echo e(optional($company->package_end_date)->translatedFormat('d F Y')); ?></strong>
        </div>
        <div class="form-group">
            <?php echo Form::label('package_quota', 'Kullanılan Kota', ['class' => 'bold']); ?>

            <strong><?php echo e($company->availed_jobs_quota); ?></strong> / <strong><?php echo e($company->jobs_quota); ?></strong>
        </div>
        <hr />
    <?php endif; ?>

    <?php if(isset($company) && $company->cvs_package_id > 0): ?>
        <div class="form-group">
            <?php echo Form::label('cvs_package', 'CV Arama Paketi', ['class' => 'bold']); ?>

            <strong><?php echo e(optional($company->cvs_getPackage())->package_title); ?></strong>
        </div>
        <div class="form-group">
            <?php echo Form::label('cvs_package_duration', 'CV Paket Süresi', ['class' => 'bold']); ?>

            <strong><?php echo e($company->cvs_package_start_date ? \Carbon\Carbon::parse($company->cvs_package_start_date)->translatedFormat('d F Y') : 'N/A'); ?></strong>
            -
            <strong><?php echo e($company->cvs_package_end_date ? \Carbon\Carbon::parse($company->cvs_package_end_date)->translatedFormat('d F Y') : 'N/A'); ?></strong>
        </div>
        <div class="form-group">
            <?php echo Form::label('cvs_quota', 'Mevcut CV Kotası', ['class' => 'bold']); ?>

            <strong><?php echo e($company->availed_cvs_quota ?? 0); ?></strong> /
            <strong><?php echo e($company->cvs_quota ?? 0); ?></strong>
        </div>
    <?php endif; ?>

    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'is_active'); ?>">
        <?php echo Form::label('is_active', 'Durum', ['class' => 'bold']); ?>

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
                <input name="is_active" type="radio" value="1" <?php echo e($is_active_1); ?>> Aktif
            </label>
            <label class="radio-inline">
                <input name="is_active" type="radio" value="0" <?php echo e($is_active_2); ?>> Pasif
            </label>
        </div>
        <?php echo APFrmErrHelp::showErrors($errors, 'is_active'); ?>

    </div>

    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'is_featured'); ?>">
        <?php echo Form::label('is_featured', 'Öne Çıkan', ['class' => 'bold']); ?>

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
                <input name="is_featured" type="radio" value="1" <?php echo e($is_featured_1); ?>> Öne Çıkan
            </label>
            <label class="radio-inline">
                <input name="is_featured" type="radio" value="0" <?php echo e($is_featured_2); ?>> Normal
            </label>
        </div>
        <?php echo APFrmErrHelp::showErrors($errors, 'is_featured'); ?>

    </div>

    <div class="form-actions">
        <?php echo Form::button('Kaydet <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>', array('class' => 'btn btn-large btn-primary', 'type' => 'submit')); ?>

    </div>
</div>
<?php $__env->startPush('scripts'); ?>
    <?php echo $__env->make('admin.shared.tinyMCEFront', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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
                $.post("<?php echo e(route('filter.default.states.dropdown')); ?>", {
                    country_id: country_id,
                    state_id: state_id,
                    _method: 'POST',
                    _token: '<?php echo e(csrf_token()); ?>'
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
                $.post("<?php echo e(route('filter.default.cities.dropdown')); ?>", {
                    state_id: state_id,
                    city_id: city_id,
                    _method: 'POST',
                    _token: '<?php echo e(csrf_token()); ?>'
                })
                    .done(function (response) {
                        $('#default_city_dd').html(response);
                    });
            }
        }
    </script>
<?php $__env->stopPush(); ?>
<?php if(isset($company)): ?>
    <?php echo Form::close(); ?>

<?php else: ?>
    <?php echo Form::close(); ?>

<?php endif; ?><?php /**PATH /home/personelnoktasit/public_html/resources/views/admin/company/forms/form.blade.php ENDPATH**/ ?>