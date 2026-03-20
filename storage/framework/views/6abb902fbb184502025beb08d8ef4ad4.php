<h5><?php echo e(__('İlan Detayları')); ?></h5>
<?php if(isset($job)): ?>
    <?php echo Form::model($job, array('method' => 'put', 'route' => array('update.front.job', $job->id), 'class' => 'form')); ?>

    <?php echo Form::hidden('id', $job->id); ?>

<?php else: ?>
    <?php echo Form::open(array('method' => 'post', 'route' => array('store.front.job'), 'class' => 'form')); ?>

<?php endif; ?>
<div class="row">
    <div class="col-md-12">
        <div class="formrow <?php echo APFrmErrHelp::hasError($errors, 'title'); ?>">
            <?php echo Form::text('title', null, array('class' => 'form-control', 'id' => 'title', 'placeholder' => __('İlan Başlığı'))); ?>

            <?php echo APFrmErrHelp::showErrors($errors, 'title'); ?>

        </div>
    </div>
    <div class="col-md-12">
        <div class="formrow <?php echo APFrmErrHelp::hasError($errors, 'description'); ?>">
            <label for="">Açıklama</label>
            <?php echo Form::textarea('description', null, array('class' => 'form-control', 'id' => 'description', 'placeholder' => __('İlan Açıklaması'))); ?>

            <?php echo APFrmErrHelp::showErrors($errors, 'description'); ?>

        </div>
    </div>

    <div class="col-md-12">
        <div class="formrow <?php echo APFrmErrHelp::hasError($errors, 'benefits'); ?>">
            <label for="">Yan Haklar</label>
            <?php echo Form::textarea('benefits', null, array('class' => 'form-control', 'id' => 'benefits', 'placeholder' => __('İlan Yan Hakları'))); ?>

            <?php echo APFrmErrHelp::showErrors($errors, 'benefits'); ?>

        </div>
    </div>


    <div class="col-md-12">
        <div class="formrow <?php echo APFrmErrHelp::hasError($errors, 'skills'); ?>">
            <label for="">Yetenekler</label>
            <?php
$skills = old('skills', $jobSkillIds);
            ?>
            <?php echo Form::select('skills[]', $jobSkills, $skills, array('class' => 'form-control select2-multiple', 'id' => 'skills', 'multiple' => 'multiple')); ?>

            <?php echo APFrmErrHelp::showErrors($errors, 'skills'); ?>

        </div>
    </div>
    <div class="col-md-4">
        <div class="formrow <?php echo APFrmErrHelp::hasError($errors, 'country_id'); ?>" id="country_id_div">
            <?php echo Form::select('country_id', ['' => __('Ülke Seç')] + $countries, old('country_id', (isset($job)) ? $job->country_id : $siteSetting->default_country_id), array('class' => 'form-control', 'id' => 'country_id')); ?>

            <?php echo APFrmErrHelp::showErrors($errors, 'country_id'); ?>

        </div>
    </div>
    <div class="col-md-4">
        <div class="formrow <?php echo APFrmErrHelp::hasError($errors, 'state_id'); ?>" id="state_id_div"> <span
                id="default_state_dd">
                <?php echo Form::select('state_id', ['' => __('Eyalet Seç')], null, array('class' => 'form-control', 'id' => 'state_id')); ?>

            </span> <?php echo APFrmErrHelp::showErrors($errors, 'state_id'); ?> </div>
    </div>
    <div class="col-md-4">
        <div class="formrow <?php echo APFrmErrHelp::hasError($errors, 'city_id'); ?>" id="city_id_div"> <span
                id="default_city_dd">
                <?php echo Form::select('city_id', ['' => __('Şehir Seç')], null, array('class' => 'form-control', 'id' => 'city_id')); ?>

            </span> <?php echo APFrmErrHelp::showErrors($errors, 'city_id'); ?> </div>
    </div>
    <div class="col-md-6">
        <div class="formrow <?php echo APFrmErrHelp::hasError($errors, 'salary_from'); ?>" id="salary_from_div">
            <?php echo Form::number('salary_from', null, array('class' => 'form-control', 'id' => 'salary_from', 'placeholder' => __('Maaş Başlangıç'))); ?>

            <?php echo APFrmErrHelp::showErrors($errors, 'salary_from'); ?>

        </div>
    </div>
    <div class="col-md-6">
        <div class="formrow <?php echo APFrmErrHelp::hasError($errors, 'salary_to'); ?>" id="salary_to_div">
            <?php echo Form::number('salary_to', null, array('class' => 'form-control', 'id' => 'salary_to', 'placeholder' => __('Maaş Bitiş'))); ?>

            <?php echo APFrmErrHelp::showErrors($errors, 'salary_to'); ?>

        </div>
    </div>
    <div class="col-md-4">
        <div class="formrow <?php echo APFrmErrHelp::hasError($errors, 'salary_currency'); ?>" id="salary_currency_div">
            <?php
                $salary_currency = Request::get('salary_currency', (isset($job)) ? $job->salary_currency : $siteSetting->default_currency_code);
            ?>

            <?php echo Form::select('salary_currency', ['' => __('Maaş Para Birimi Seç')] + $currencies, $salary_currency, array('class' => 'form-control', 'id' => 'salary_currency')); ?>

            <?php echo APFrmErrHelp::showErrors($errors, 'salary_currency'); ?>

        </div>
    </div>
    <div class="col-md-4">
        <div class="formrow <?php echo APFrmErrHelp::hasError($errors, 'salary_period_id'); ?>" id="salary_period_id_div">
            <?php echo Form::select('salary_period_id', ['' => __('Maaş Dönemi Seç')] + $salaryPeriods, null, array('class' => 'form-control', 'id' => 'salary_period_id')); ?>

            <?php echo APFrmErrHelp::showErrors($errors, 'salary_period_id'); ?>

        </div>
    </div>
    <div class="col-md-4">
        <div class="formrow <?php echo APFrmErrHelp::hasError($errors, 'hide_salary'); ?>">
            <?php echo Form::label('hide_salary', __('Maaşı Gizle?'), ['class' => 'bold']); ?>

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
                    <input id="hide_salary_yes" name="hide_salary" type="radio" value="1" <?php echo e($hide_salary_1); ?>>
                    <?php echo e(__('Evet')); ?> </label>
                <label class="radio-inline">
                    <input id="hide_salary_no" name="hide_salary" type="radio" value="0" <?php echo e($hide_salary_2); ?>>
                    <?php echo e(__('Hayır')); ?> </label>
            </div>
            <?php echo APFrmErrHelp::showErrors($errors, 'hide_salary'); ?>

        </div>
    </div>
    <div class="col-md-6">
        <div class="formrow <?php echo APFrmErrHelp::hasError($errors, 'career_level_id'); ?>" id="career_level_id_div">
            <?php echo Form::select('career_level_id', ['' => __('Kariyer Seviyesi Seç')] + $careerLevels, null, array('class' => 'form-control', 'id' => 'career_level_id')); ?>

            <?php echo APFrmErrHelp::showErrors($errors, 'career_level_id'); ?>

        </div>
    </div>

    <div class="col-md-6">
        <div class="formrow <?php echo APFrmErrHelp::hasError($errors, 'functional_area_id'); ?>" id="functional_area_id_div">
            <?php echo Form::select('functional_area_id', ['' => __('Fonksiyonel Alan Seç')] + $functionalAreas, null, array('class' => 'form-control', 'id' => 'functional_area_id')); ?>

            <?php echo APFrmErrHelp::showErrors($errors, 'functional_area_id'); ?>

        </div>
    </div>
    <div class="col-md-6">
        <div class="formrow <?php echo APFrmErrHelp::hasError($errors, 'job_type_id'); ?>" id="job_type_id_div">
            <?php echo Form::select('job_type_id', ['' => __('İş Tipi Seç')] + $jobTypes, null, array('class' => 'form-control', 'id' => 'job_type_id')); ?>

            <?php echo APFrmErrHelp::showErrors($errors, 'job_type_id'); ?>

        </div>
    </div>
    <div class="col-md-6">
        <div class="formrow <?php echo APFrmErrHelp::hasError($errors, 'job_shift_id'); ?>" id="job_shift_id_div">
            <?php echo Form::select('job_shift_id', ['' => __('İş Vardiyası Seç')] + $jobShifts, null, array('class' => 'form-control', 'id' => 'job_shift_id')); ?>

            <?php echo APFrmErrHelp::showErrors($errors, 'job_shift_id'); ?>

        </div>
    </div>
    <div class="col-md-6">
        <div class="formrow <?php echo APFrmErrHelp::hasError($errors, 'num_of_positions'); ?>" id="num_of_positions_div">
            <?php echo Form::select('num_of_positions', ['' => __('Pozisyon Sayısı Seç')] + MiscHelper::getNumPositions(), null, array('class' => 'form-control', 'id' => 'num_of_positions')); ?>

            <?php echo APFrmErrHelp::showErrors($errors, 'num_of_positions'); ?>

        </div>
    </div>
    <div class="col-md-6">
        <div class="formrow <?php echo APFrmErrHelp::hasError($errors, 'gender_id'); ?>" id="gender_id_div">
            <?php echo Form::select('gender_id', ['' => __('Tercih Yok')] + $genders, null, array('class' => 'form-control', 'id' => 'gender_id')); ?>

            <?php echo APFrmErrHelp::showErrors($errors, 'gender_id'); ?>

        </div>
    </div>
    <div class="col-md-6">
        <div class="formrow <?php echo APFrmErrHelp::hasError($errors, 'expiry_date'); ?>">
            <div class="input-group">
                <?php echo Form::text('expiry_date', (isset($job) && $job->expiry_date) ? date('d-m-Y', strtotime($job->expiry_date)) : null, array('class' => 'form-control', 'id' => 'expiry_date', 'placeholder' => __('İlan Bitiş Tarihi'), 'autocomplete' => 'off', 'data-date-format' => 'dd-mm-yyyy')); ?>

                <span class="input-group-text calendar-icon-trigger" id="expiry_date_icon"
                    style="cursor: pointer; background-color: #f8faff; border-left: none;">
                    <i class="fa fa-calendar-alt text-primary"></i>
                </span>
            </div>
            <small class="text-muted" style="display: block; margin-top: 5px;">
                <i class="fa fa-info-circle me-1"></i>
                <?php echo e(__('Lütfen GG-AA-YYYY formatında giriniz veya takvimden seçiniz.')); ?>

            </small>
            <?php echo APFrmErrHelp::showErrors($errors, 'expiry_date'); ?>

        </div>
    </div>
    <div class="col-md-6">
        <div class="formrow <?php echo APFrmErrHelp::hasError($errors, 'degree_level_id'); ?>" id="degree_level_id_div">
            <?php echo Form::select('degree_level_id', ['' => __('Gerekli Eğitim Seviyesi Seç')] + $degreeLevels, null, array('class' => 'form-control', 'id' => 'degree_level_id')); ?>

            <?php echo APFrmErrHelp::showErrors($errors, 'degree_level_id'); ?>

        </div>
    </div>
    <div class="col-md-6">
        <div class="formrow <?php echo APFrmErrHelp::hasError($errors, 'job_experience_id'); ?>" id="job_experience_id_div">
            <?php echo Form::select('job_experience_id', ['' => __('Gerekli İş Tecrübesi Seç')] + $jobExperiences, null, array('class' => 'form-control', 'id' => 'job_experience_id')); ?>

            <?php echo APFrmErrHelp::showErrors($errors, 'job_experience_id'); ?>

        </div>
    </div>
    <div class="col-md-6">
        <div class="formrow <?php echo APFrmErrHelp::hasError($errors, 'is_freelance'); ?>">
            <?php echo Form::label('is_freelance', __('Freelance mı?'), ['class' => 'bold']); ?>

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
                    <input id="is_freelance_yes" name="is_freelance" type="radio" value="1" <?php echo e($is_freelance_1); ?>>
                    <?php echo e(__('Evet')); ?> </label>
                <label class="radio-inline">
                    <input id="is_freelance_no" name="is_freelance" type="radio" value="0" <?php echo e($is_freelance_2); ?>>
                    <?php echo e(__('Hayır')); ?> </label>
            </div>
            <?php echo APFrmErrHelp::showErrors($errors, 'is_freelance'); ?>

        </div>
    </div>

    <div class="col-md-12">
        <div class="formrow">
            <button type="submit" class="btn"><?php echo e(__('İlanı Gönder')); ?> <i class="fa fa-arrow-circle-right"
                    aria-hidden="true"></i></button>
        </div>
    </div>
</div>
<input type="file" name="image" id="image" style="display:none;" accept="image/*" />
<?php echo Form::close(); ?>

<hr>
<?php $__env->startPush('styles'); ?>
    <link href="<?php echo e(asset('/')); ?>css/jquery-ui.min.css" rel="stylesheet" type="text/css" />
    <style type="text/css">
        .datepicker-dropdown {
            z-index: 999999 !important;
        }

        .datepicker {
            z-index: 999999 !important;
        }

        /* jQuery UI Datepicker Z-Index Fix */
        #ui-datepicker-div {
            z-index: 999999 !important;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
    <?php echo $__env->make('includes.tinyMCEFront', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script type="text/javascript">
        $(document).ready(function () {
            if ($.fn.select2) {
                $('.select2-multiple').select2({
                    placeholder: "<?php echo e(__('Gerekli Yetenekleri Seç')); ?>",
                    allowClear: true
                });
            }

            var $expiryDate = $("#expiry_date");

            // jQuery UI Options
            var datepickerOptions = {
                dateFormat: 'dd-mm-yy',
                changeMonth: true,
                changeYear: true,
                minDate: 0,
                closeText: "Kapat",
                prevText: "&#x3C;geri",
                nextText: "ileri&#x3e;",
                currentText: "Bugün",
                monthNames: ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran",
                    "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"],
                monthNamesShort: ["Oca", "Şub", "Mar", "Nis", "May", "Haz",
                    "Tem", "Ağu", "Eyl", "Eki", "Kas", "Ara"],
                dayNames: ["Pazar", "Pazartesi", "Salı", "Çarşamba", "Perşembe", "Cuma", "Cumartesi"],
                dayNamesShort: ["Pz", "Pt", "Sa", "Ça", "Pe", "Cu", "Ct"],
                dayNamesMin: ["Pz", "Pt", "Sa", "Ça", "Pe", "Cu", "Ct"],
                weekHeader: "Hf",
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ""
            };

            function safeInit() {
                try {
                    // Try jQuery UI Datepicker
                    if ($.fn.datepicker) {
                        console.log("Using: jQuery UI Datepicker");
                        $expiryDate.datepicker(datepickerOptions);
                    } else {
                        console.error("jQuery UI Datepicker not found!");
                    }
                } catch (e) {
                    console.error("Takvim başlatma hatası:", e);
                }
            }

            safeInit();

            // Takvim ikonuna tıklanınca input'a odaklan
            $(document).on('click', '#expiry_date_icon', function (e) {
                e.preventDefault();
                console.log("Takvim ikonuna tıklandı -> Focus tetikleniyor.");
                $expiryDate.focus();
            });

            // Input odaklanınca log
            $(document).on('focus', '#expiry_date', function () {
                console.log("Input odaklandı.");
            });

            $('#country_id').on('change', function (e) {
                e.preventDefault();
                filterLangStates(0);
            });
            $(document).on('change', '#state_id', function (e) {
                e.preventDefault();
                filterLangCities(0);
            });
            filterLangStates(<?php echo old('state_id', (isset($job)) ? $job->state_id : 0); ?>);
        });

        function filterLangStates(state_id) {
            var country_id = $('#country_id').val();
            if (country_id != '') {
                $.post("<?php echo e(route('filter.lang.states.dropdown')); ?>", { country_id: country_id, state_id: state_id, _method: 'POST', _token: '<?php echo e(csrf_token()); ?>' })
                    .done(function (response) {
                        $('#default_state_dd').html(response);
                        filterLangCities(<?php echo old('city_id', (isset($job)) ? $job->city_id : 0); ?>);
                    });
            }
        }
        function filterLangCities(city_id) {
            var state_id = $('#state_id').val();
            if (state_id != '') {
                $.post("<?php echo e(route('filter.lang.cities.dropdown')); ?>", { state_id: state_id, city_id: city_id, _method: 'POST', _token: '<?php echo e(csrf_token()); ?>' })
                    .done(function (response) {
                        $('#default_city_dd').html(response);
                    });
            }
        }
    </script>
<?php $__env->stopPush(); ?><?php /**PATH /home/personelnoktasit/public_html/resources/views/job/inc/job.blade.php ENDPATH**/ ?>