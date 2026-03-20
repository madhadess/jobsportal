{!! Form::model($user, array('method' => 'put', 'route' => array('my.profile'), 'class' => 'form', 'files' => true)) !!}

<h5>{{__('Hesap Bilgileri')}}</h5>
<div class="row">
    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'email') !!}">
            <label for="">{{__('Email')}}</label>
            {!! Form::text('email', null, array('class' => 'form-control', 'id' => 'email', 'placeholder' => __('Email'))) !!}
            {!! APFrmErrHelp::showErrors($errors, 'email') !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'password') !!}">
            <label for="">{{__('Password')}}</label>
            {!! Form::password('password', array('class' => 'form-control', 'id' => 'password', 'placeholder' => __('Password'))) !!}
            {!! APFrmErrHelp::showErrors($errors, 'password') !!}
        </div>
    </div>
</div>

<hr>

<h5>{{__('Kişisel Bilgiler')}}</h5>

<div class="row">
    <div class="col-md-6">
        <div class="userimgupbox">
            <div class="imagearea">
                <label>{{__('Profil Resmi')}} <span>*</span></label>
                {{ ImgUploader::print_image("user_images/$user->image", 100, 100) }}
            </div>
            <div class="formrow">
                <div id="thumbnail"></div>
                <label class="btn btn-default"><i class="fas fa-upload"></i> {{__('Profil Resmi Seç')}}
                    <input type="file" name="image" id="image" style="display: none;">
                </label>
                {!! APFrmErrHelp::showErrors($errors, 'image') !!}
            </div>
        </div>


    </div>
    <div class="col-md-6">
        <div class="userimgupbox">
            <div class="imagearea">
                <label>{{__('Kapak Fotoğrafı')}}</label>
                {{ ImgUploader::print_image("user_images/$user->cover_image", 200, 90) }}
            </div>
            <div class="formrow">
                <div id="thumbnail_cover_image"></div>
                <label class="btn btn-default"><i class="fas fa-upload"></i> {{__('Kapak Fotoğrafı Seç')}}
                    <input type="file" name="cover_image" id="cover_image" style="display: none;">
                </label>
                {!! APFrmErrHelp::showErrors($errors, 'cover_image') !!}
            </div>
        </div>
    </div>

</div>




<div class="row">
    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'first_name') !!}">
            <label for="">{{__('Ad')}} <span>*</span></label>
            {!! Form::text('first_name', null, array('class' => 'form-control', 'id' => 'first_name', 'placeholder' => __('Ad'))) !!}
            {!! APFrmErrHelp::showErrors($errors, 'first_name') !!}
        </div>
    </div>

    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'last_name') !!}">
            <label for="">{{__('Soyad')}} <span>*</span></label>
            {!! Form::text('last_name', null, array('class' => 'form-control', 'id' => 'last_name', 'placeholder' => __('Soyad'))) !!}
            {!! APFrmErrHelp::showErrors($errors, 'last_name') !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'middle_name') !!}">
            <label for="">{{__('Takma Ad')}}</label>
            {!! Form::text('middle_name', null, array('class' => 'form-control', 'id' => 'middle_name', 'placeholder' => __('Takma Ad'))) !!}
            {!! APFrmErrHelp::showErrors($errors, 'middle_name') !!}
        </div>
    </div>

    <div class="col-md-4">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'gender_id') !!}">
            <label for="">{{__('Cinsiyet')}} <span>*</span></label>
            {!! Form::select('gender_id', ['' => __('Cinsiyet Seç')] + $genders, null, array('class' => 'form-control', 'id' => 'gender_id')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'gender_id') !!}
        </div>
    </div>
    <div class="col-md-4">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'marital_status_id') !!}">
            <label for="">{{__('Medeni Durum')}} <span>*</span></label>
            {!! Form::select('marital_status_id', ['' => __('Medeni Durum Seç')] + $maritalStatuses, null, array('class' => 'form-control', 'id' => 'marital_status_id')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'marital_status_id') !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'country_id') !!}">
            <label for="">{{__('Ülke')}} <span>*</span></label>
            <?php $country_id = old('country_id', (isset($user) && (int) $user->country_id > 0) ? $user->country_id : $siteSetting->default_country_id); ?>
            {!! Form::select('country_id', ['' => __('Ülke Seç')] + $countries, $country_id, array('class' => 'form-control', 'id' => 'country_id')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'country_id') !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'state_id') !!}">
            <label for="">{{__('Şehir')}} <span>*</span></label>
            <span id="state_dd">
                {!! Form::select('state_id', ['' => __('Şehir Seç')], null, array('class' => 'form-control', 'id' => 'state_id')) !!}
            </span> {!! APFrmErrHelp::showErrors($errors, 'state_id') !!}
        </div>
    </div>
    <div class="col-md-3">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'city_id') !!}">
            <label for="">{{__('İlçe')}} <span>*</span></label>
            <span id="city_dd">
                {!! Form::select('city_id', ['' => __('İlçe Seç')], null, array('class' => 'form-control', 'id' => 'city_id')) !!}
            </span> {!! APFrmErrHelp::showErrors($errors, 'city_id') !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'nationality_id') !!}">
            <label for="">{{__('Uyruk')}} <span>*</span></label>
            {!! Form::select('nationality_id', ['' => __('Uyruk Seç')] + $nationalities, null, array('class' => 'form-control', 'id' => 'nationality_id')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'nationality_id') !!}
        </div>
    </div>
    <div class="col-md-6">


        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'date_of_birth') !!}">
            <?php 

            if (!empty($user->date_of_birth)) {

    $d = $user->date_of_birth;
} else {
    $d = date('Y-m-d', strtotime('-16 years'));
}
$dob = old('date_of_birth') ? date('Y-m-d', strtotime(old('date_of_birth'))) : date('Y-m-d', strtotime($d));


            ?>
            <label for="">{{__('Doğum Tarihi')}} <span>*</span></label>
            {!! Form::date('date_of_birth', $dob, array('class' => 'form-control', 'id' => 'date_of_birth', 'placeholder' => __('Doğum Tarihi'), 'autocomplete' => 'off')) !!}
            {!! APFrmErrHelp::showErrors($errors, 'date_of_birth') !!}
        </div>




    </div>

    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'phone') !!}">
            <label for="">{{__('Telefon')}} <span>*</span></label>
            {!! Form::text('phone', null, array('class' => 'form-control', 'id' => 'phone', 'placeholder' => __('Telefon'))) !!}
            {!! APFrmErrHelp::showErrors($errors, 'phone') !!}
        </div>
    </div>
    <div class="col-md-6">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'mobile_num') !!}">
            <label for="">{{__('Cep Telefonu')}}</label>
            {!! Form::text('mobile_num', null, array('class' => 'form-control', 'id' => 'mobile_num', 'placeholder' => __('Cep Telefonu Numarası'))) !!}
            {!! APFrmErrHelp::showErrors($errors, 'mobile_num') !!}
        </div>
    </div>
    <div class="col-md-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'street_address') !!}">
            <label for="">{{__('Adres')}} <span>*</span></label>
            {!! Form::textarea('street_address', null, array('class' => 'form-control', 'id' => 'street_address', 'placeholder' => __('Adres'))) !!}
            {!! APFrmErrHelp::showErrors($errors, 'street_address') !!}
        </div>
    </div>

</div>

{{-- Kariyer Bilgileri & Video — Sadece personel/bakıcı/iş arayan --}}
@if(!auth()->user()->isMember())
    <hr>
    <h5>{{__('Kariyer Bilgileri')}}</h5>
    <div class="row">
        <div class="col-md-6">
            <div class="formrow {!! APFrmErrHelp::hasError($errors, 'career_level_id') !!}">
                <label for="">{{__('Kariyer Seviyesi')}}</label>
                {!! Form::select('career_level_id', ['' => __('Kariyer Seviyesi Seç')] + $careerLevels, null, array('class' => 'form-control', 'id' => 'career_level_id')) !!}
                {!! APFrmErrHelp::showErrors($errors, 'career_level_id') !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="formrow {!! APFrmErrHelp::hasError($errors, 'job_experience_id') !!}">
                <label for="">{{__('İş Deneyimi')}}</label>
                {!! Form::select('job_experience_id', ['' => __('İş Deneyimi Seç')] + $jobExperiences, null, array('class' => 'form-control', 'id' => 'job_experience_id')) !!}
                {!! APFrmErrHelp::showErrors($errors, 'job_experience_id') !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="formrow {!! APFrmErrHelp::hasError($errors, 'industry_id') !!}">
                <label for="">{{__('Sektör')}}</label>
                {!! Form::select('industry_id', ['' => __('Sektör Seç')] + $industries, null, array('class' => 'form-control', 'id' => 'industry_id')) !!}
                {!! APFrmErrHelp::showErrors($errors, 'industry_id') !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="formrow {!! APFrmErrHelp::hasError($errors, 'functional_area_id') !!}">
                <label for="">{{__('İş Alanı')}}</label>
                {!! Form::select('functional_area_id', ['' => __('İş Alanı Seç')] + $functionalAreas, null, array('class' => 'form-control', 'id' => 'functional_area_id')) !!}
                {!! APFrmErrHelp::showErrors($errors, 'functional_area_id') !!}
            </div>
        </div>

        <div class="col-md-6">
            <div class="formrow {!! APFrmErrHelp::hasError($errors, 'expected_salary') !!}">
                <label for="">{{__('Beklenen Maaş')}} (₺)</label>
                {!! Form::text('expected_salary', null, array('class' => 'form-control', 'id' => 'expected_salary', 'placeholder' => __('Beklenen Maaş'))) !!}
                {!! APFrmErrHelp::showErrors($errors, 'expected_salary') !!}
            </div>
        </div>
    </div>

    <hr>
    <h5>{{__('Video Profili')}} <small class="text-muted">({{__('İsteğe Bağlı')}})</small></h5>
    <div class="row">
        <div class="col-md-6">
            <div class="formrow {!! APFrmErrHelp::hasError($errors, 'video_link') !!}">
                <label for="">{{__('YouTube Video Linki')}}</label>
                {!! Form::text('video_link', null, array('class' => 'form-control', 'id' => 'video_link', 'placeholder' => 'https://www.youtube.com/embed/...')) !!}
                {!! APFrmErrHelp::showErrors($errors, 'video_link') !!}
            </div>
        </div>
        <div class="col-md-6">
            <div class="formrow">
                <label for="">{{__('veya Video Dosyası Yükle')}}</label>
                {!! Form::file('video', array('class' => 'form-control', 'id' => 'video')) !!}
                <span class="help-block text-muted">{{__('MP4, max 20MB')}}</span>
            </div>
        </div>
    </div>

    <hr>
    <h5>{{__('Adli Sicil Kaydı')}} <small class="text-muted">({{__('PDF, JPG, PNG')}})</small></h5>
    <div class="row">
        <div class="col-md-6">
            <div class="formrow">
                <label for="">{{__('Adli Sicil Belgesi Yükle')}}</label>
                {!! Form::file('criminal_record_file', array('class' => 'form-control', 'id' => 'criminal_record_file', 'accept' => '.pdf,.jpg,.jpeg,.png')) !!}
                <span class="help-block text-muted">{{__('PDF, JPG veya PNG, max 5MB')}}</span>
                @if(isset($user) && $user->criminal_record_file)
                    <div class="mt-2">
                        <i class="fas fa-check-circle text-success"></i>
                        <a href="{{ asset('uploads/criminal_records/' . $user->criminal_record_file) }}" target="_blank">
                            {{ __('Mevcut belgeyi görüntüle') }}
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endif



<div class="row">

    <div class="col-md-12">
        <div class="formrow {!! APFrmErrHelp::hasError($errors, 'is_subscribed') !!}">
            <?php
$is_checked = 'checked="checked"';
if (old('is_subscribed', ((isset($user)) ? $user->is_subscribed : 1)) == 0) {
    $is_checked = '';
}
	?>
            <input type="checkbox" value="1" name="is_subscribed" {{$is_checked}} />
            {{__('Bültene Abone Ol')}}
            {!! APFrmErrHelp::showErrors($errors, 'is_subscribed') !!}
        </div>
    </div>
    <div class="col-md-12">
        <div class="formrow"><button type="submit" class="btn">{{__('Profili Güncelle ve Kaydet')}} <i
                    class="fa fa-arrow-circle-right" aria-hidden="true"></i></button></div>
    </div>
</div>


{!! Form::close() !!}


@push('styles')
    <style type="text/css">
        .datepicker>div {
            display: block;
        }
    </style>
@endpush
@push('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            try {
                initdatepicker();
            } catch (e) {
                console.error("initdatepicker error:", e);
            }

            if ($.fn.typeahead) {
                $('#salary_currency').typeahead({
                    source: function (query, process) {
                        return $.get("{{ route('typeahead.currency_codes') }}", { query: query }, function (data) {
                            console.log(data);
                            data = $.parseJSON(data);
                            return process(data);
                        });
                    }
                });
            } else {
                console.warn("Typeahead plugin not loaded");
            }

            $('#country_id').on('change', function (e) {
                e.preventDefault();
                filterStates(0);
            });
            $(document).on('change', '#state_id', function (e) {
                e.preventDefault();
                filterCities(0);
            });
            filterStates(<?php echo old('state_id', $user->state_id); ?>);

            /*******************************/
            var fileInput = document.getElementById("image");
            fileInput.addEventListener("change", function (e) {
                var files = this.files
                showThumbnail(files)
            }, false)

            var fileInput_cover_image = document.getElementById("cover_image");

            fileInput_cover_image.addEventListener("change", function (e) {

                var files_cover_image = this.files

                showThumbnail_cover_image(files_cover_image)

            }, false)


            function showThumbnail(files) {
                $('#thumbnail').html('');
                for (var i = 0; i < files.length; i++) {
                    var file = files[i]
                    var imageType = /image.*/
                    if (!file.type.match(imageType)) {
                        console.log("Not an Image");
                        continue;
                    }
                    var reader = new FileReader()
                    reader.onload = (function (theFile) {
                        return function (e) {
                            $('#thumbnail').append('<div class="fileattached"><img height="100px" src="' + e.target.result + '" > <div>' + theFile.name + '</div><div class="clearfix"></div></div>');
                        };
                    }(file))
                    var ret = reader.readAsDataURL(file);
                }
            }


            function showThumbnail_cover_image(files) {

                $('#thumbnail_cover_image').html('');

                for (var i = 0; i < files.length; i++) {

                    var file = files[i]

                    var imageType = /image.*/

                    if (!file.type.match(imageType)) {

                        console.log("Not an Image");

                        continue;

                    }

                    var reader = new FileReader()

                    reader.onload = (function (theFile) {

                        return function (e) {

                            $('#thumbnail_cover_image').append('<div class="fileattached"><img height="100px" src="' + e.target.result + '" > <div>' + theFile.name + '</div><div class="clearfix"></div></div>');

                        };

                    }(file))

                    var ret = reader.readAsDataURL(file);

                }

            }


        });

        function filterStates(state_id) {
            var country_id = $('#country_id').val();
            // console.log("filterStates called with country_id:", country_id, "state_id:", state_id);
            if (country_id != '') {
                $.post("{{ route('filter.lang.states.dropdown') }}", { country_id: country_id, state_id: state_id, _method: 'POST', _token: '{{ csrf_token() }}' })
                    .done(function (response) {
                        console.log("filterStates response received length:", response.length);
                        $('#state_dd').html(response);
                        filterCities(<?php echo old('city_id', $user->city_id); ?>);
                    })
                    .fail(function (xhr, status, error) {
                        console.error("filterStates error:", error);
                    });
            }
        }
        function filterCities(city_id) {
            var state_id = $('#state_id').val();
            console.log("filterCities called with state_id:", state_id, "city_id:", city_id);
            if (state_id != '') {
                $.post("{{ route('filter.lang.cities.dropdown') }}", { state_id: state_id, city_id: city_id, _method: 'POST', _token: '{{ csrf_token() }}' })
                    .done(function (response) {
                        console.log("filterCities response received length:", response.length);
                        $('#city_dd').html(response);
                    })
                    .fail(function (xhr, status, error) {
                        console.error("filterCities error:", error);
                    });
            }
        }
        function initdatepicker() {
            if ($.fn.bootstrapDatepicker) {
                $(".datepicker").bootstrapDatepicker({
                    autoclose: true,
                    format: 'yyyy-m-d'
                });
            } else if ($.fn.datepicker) {
                $(".datepicker").datepicker({
                    autoclose: true,
                    format: 'yyyy-m-d'
                });
            }
            $('.select2-multiple').select2({
                placeholder: "Uzmanlık Alanı Seçin",
                allowClear: true
            });
        }
    </script>
@endpush