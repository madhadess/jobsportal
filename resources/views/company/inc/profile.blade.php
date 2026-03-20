<div class="useraccount">
    <div class="formpanel mt0">

        {!! Form::model($company, array('method' => 'put', 'route' => array('update.company.profile'), 'class' => 'form', 'files' => true)) !!}
        <h5>{{__('Account Information')}}</h5>
        <div class="row">
            <div class="col-md-6">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'email') !!}">
                    <label>{{__('E-posta')}}</label>
                    {!! Form::text('email', null, array('class' => 'form-control', 'id' => 'email', 'placeholder' => __('E-posta'))) !!}
                    {!! APFrmErrHelp::showErrors($errors, 'email') !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'password') !!}">
                    <label>{{__('Şifre')}}</label>
                    {!! Form::password('password', array('class' => 'form-control', 'id' => 'password', 'placeholder' => __('Şifre'))) !!}
                    {!! APFrmErrHelp::showErrors($errors, 'password') !!}
                </div>
            </div>
        </div>
        <hr>


        <h5>{{__('Company Information')}}</h5>
        <div class="row">
            <div class="col-md-6">
                <div class="userimgupbox">
                    <div class="imagearea">
                        <label>{{__('Şirket Logosu')}}</label>
                        {{ ImgUploader::print_image("company_logos/$company->logo", 100, 100) }}
                    </div>
                    <div class="formrow">
                        <div id="thumbnail"></div>
                        <label class="btn btn-default"> {{__('Şirket Logosu Seç')}}
                            <input type="file" name="logo" id="logo" style="display: none;">
                        </label>
                        {!! APFrmErrHelp::showErrors($errors, 'logo') !!}
                    </div>
                </div>
            </div>
            <div class="col-md-6">

            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'name') !!}">
                    <label>{{__('Şirket Adı')}} <span>*</span></label>
                    {!! Form::text('name', null, array('class' => 'form-control', 'id' => 'name', 'placeholder' => __('Şirket Adı'))) !!}
                    {!! APFrmErrHelp::showErrors($errors, 'name') !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'industry_id') !!}">
                    <label>{{__('Sektör')}} <span>*</span></label>
                    {!! Form::select('industry_id', ['' => __('Sektör Seç')] + $industries, null, array('class' => 'form-control', 'id' => 'industry_id')) !!}
                    {!! APFrmErrHelp::showErrors($errors, 'industry_id') !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'ownership_type') !!}">
                    <label>{{__('Mülkiyet Tipi')}} <span>*</span></label>
                    {!! Form::select('ownership_type_id', ['' => __('Mülkiyet Tipi Seç')] + $ownershipTypes, null, array('class' => 'form-control', 'id' => 'ownership_type_id')) !!}
                    {!! APFrmErrHelp::showErrors($errors, 'ownership_type_id') !!}
                </div>
            </div>





            <div class="col-md-12">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'description') !!}">
                    <label>{{__('Açıklama')}} <span>*</span></label>
                    {!! Form::textarea('description', null, array('class' => 'form-control', 'id' => 'description', 'placeholder' => __('Şirket detayları'))) !!}
                    {!! APFrmErrHelp::showErrors($errors, 'description') !!}
                </div>
            </div>
            <div class="col-md-12 d-none">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'location') !!}">
                    <label>{{__('Adres')}} <span>*</span></label>
                    {!! Form::text('location', null, array('class' => 'form-control', 'id' => 'location', 'placeholder' => __('Konum'))) !!}
                    {!! APFrmErrHelp::showErrors($errors, 'location') !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'no_of_offices') !!}">
                    <label>{{__('Ofis Sayısı')}} <span>*</span></label>
                    {!! Form::select('no_of_offices', ['' => __('Ofis sayısı seç')] + MiscHelper::getNumOffices(), null, array('class' => 'form-control', 'id' => 'no_of_offices')) !!}
                    {!! APFrmErrHelp::showErrors($errors, 'no_of_offices') !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'no_of_employees') !!}">
                    <label>{{__('Çalışan Sayısı')}} <span>*</span></label>
                    {!! Form::select('no_of_employees', ['' => __('Çalışan sayısı seç')] + MiscHelper::getNumEmployees(), null, array('class' => 'form-control', 'id' => 'no_of_employees')) !!}
                    {!! APFrmErrHelp::showErrors($errors, 'no_of_employees') !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'established_in') !!}">
                    <label>{{__('Kuruluş Yılı')}} <span>*</span></label>
                    {!! Form::select('established_in', ['' => __('Kuruluş yılı seç')] + MiscHelper::getEstablishedIn(), null, array('class' => 'form-control', 'id' => 'established_in')) !!}
                    {!! APFrmErrHelp::showErrors($errors, 'established_in') !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'website') !!}">
                    <label>{{__('Web Sitesi URL')}} <span>*</span></label>
                    {!! Form::text('website', null, array('class' => 'form-control', 'id' => 'website', 'placeholder' => __('Web Sitesi'))) !!}
                    {!! APFrmErrHelp::showErrors($errors, 'website') !!}
                </div>
            </div>



            <div class="col-md-6">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'phone') !!}">
                    <label>{{__('Telefon')}} <span>*</span></label>
                    {!! Form::text('phone', null, array('class' => 'form-control', 'id' => 'phone', 'placeholder' => __('Telefon'))) !!}
                    {!! APFrmErrHelp::showErrors($errors, 'phone') !!}
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="col-md-6">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'facebook') !!}">
                    <label>{{__('Facebook')}}</label>
                    {!! Form::text('facebook', null, array('class' => 'form-control', 'id' => 'facebook', 'placeholder' => __('Facebook'))) !!}
                    {!! APFrmErrHelp::showErrors($errors, 'facebook') !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'twitter') !!}">
                    <label>{{__('Twitter')}}</label>
                    {!! Form::text('twitter', null, array('class' => 'form-control', 'id' => 'twitter', 'placeholder' => __('Twitter'))) !!}
                    {!! APFrmErrHelp::showErrors($errors, 'twitter') !!}
                </div>
            </div>
            <div class="col-md-6">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'linkedin') !!}">
                    <label>{{__('LinkedIn')}}</label>
                    {!! Form::text('linkedin', null, array('class' => 'form-control', 'id' => 'linkedin', 'placeholder' => __('Linkedin'))) !!}
                    {!! APFrmErrHelp::showErrors($errors, 'linkedin') !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'pinterest') !!}">
                    <label>{{__('Pinterest')}}</label>
                    {!! Form::text('pinterest', null, array('class' => 'form-control', 'id' => 'pinterest', 'placeholder' => __('Pinterest'))) !!}
                    {!! APFrmErrHelp::showErrors($errors, 'pinterest') !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'country_id') !!}">
                    <label>{{__('Ülke')}} <span>*</span></label>
                    {!! Form::select('country_id', ['' => __('Ülke Seç')] + $countries, old('country_id', (isset($company)) ? $company->country_id : $siteSetting->default_country_id), array('class' => 'form-control', 'id' => 'country_id')) !!}
                    {!! APFrmErrHelp::showErrors($errors, 'country_id') !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'state_id') !!}">
                    <label>{{__('İl')}} <span>*</span></label>
                    <span id="default_state_dd">
                        {!! Form::select('state_id', ['' => __('İl Seç')], null, array('class' => 'form-control', 'id' => 'state_id')) !!}
                    </span> {!! APFrmErrHelp::showErrors($errors, 'state_id') !!}
                </div>
            </div>
            <div class="col-md-4">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'city_id') !!}">
                    <label>{{__('Şehir')}} <span>*</span></label>
                    <span id="default_city_dd">
                        {!! Form::select('city_id', ['' => __('Şehir Seç')], null, array('class' => 'form-control', 'id' => 'city_id')) !!}
                    </span> {!! APFrmErrHelp::showErrors($errors, 'city_id') !!}
                </div>
            </div>
            <div class="col-md-12">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'map') !!}">
                    <label>{{__('Şirket Adresi')}} <span>*</span></label>
                    {!! Form::text('map', null, array('class' => 'form-control', 'id' => 'map', 'placeholder' => __('Şirket Adresi'))) !!}
                    {!! APFrmErrHelp::showErrors($errors, 'map') !!}
                </div>
            </div>

            <div class="col-md-12 mt-3">
                <h3>{{__('İK Yetkilisi Bilgileri')}}</h3>
            </div>

            <div class="col-md-6">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'contact_name') !!}">
                    <label>{{__('Ad')}} <span>*</span></label>
                    {!! Form::text('contact_name', null, array('class' => 'form-control', 'id' => 'contact_name', 'placeholder' => __('Örn: Kadir Sarıdağ'))) !!}
                    {!! APFrmErrHelp::showErrors($errors, 'contact_name') !!}
                </div>
            </div>

            <div class="col-md-6">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'contact_email') !!}">
                    <label>{{__('E-posta')}} <span>*</span></label>
                    {!! Form::email('contact_email', null, array('class' => 'form-control', 'id' => 'contact_email', 'placeholder' => __('E-posta'))) !!}
                    {!! APFrmErrHelp::showErrors($errors, 'contact_email') !!}
                </div>
            </div>


            <div class="col-md-6">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'ceo') !!}">
                    <label>{{__('Pozisyon / Unvan')}} </label>
                    {!! Form::text('ceo', null, array('class' => 'form-control', 'id' => 'ceo', 'placeholder' => __('Örn: CEO'))) !!}
                    {!! APFrmErrHelp::showErrors($errors, 'ceo') !!}
                </div>
            </div>



            <div class="col-md-6">
                <div class="formrow {!! APFrmErrHelp::hasError($errors, 'registration_number') !!}">
                    <label>{{__('Şirket Sicil Numarası')}} </label>
                    {!! Form::text('registration_number', null, array('class' => 'form-control', 'id' => 'registration_number', 'placeholder' => __('Sicil Numarası'))) !!}
                    {!! APFrmErrHelp::showErrors($errors, 'registration_number') !!}
                </div>
            </div>










            <div class="col-md-12">
                <div class="formrow">
                    <button type="submit" class="btn">{{__('Profili Güncelle ve Kaydet')}} <i
                            class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>
                </div>
            </div>
        </div>
        <input type="file" name="image" id="image" style="display:none;" accept="image/*" />
        {!! Form::close() !!}
    </div>
</div>






@push('styles')
    <style type="text/css">
        .datepicker>div {
            display: block;
        }
    </style>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table thead th {
            background-color: #000;
            color: #fff;
            padding: 12px;
            text-align: left;
        }

        table tbody td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
        }

        table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .btn {
            display: inline-block;
            padding: 8px 16px;
            margin: 5px;
            border: none;
            border-radius: 4px;
            color: #fff;
            background-color: #007bff;
            text-decoration: none;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }



        .text-success {
            color: #28a745;
        }

        .text-danger {
            color: #dc3545;
        }
    </style>
@endpush
@push('scripts')
    @include('includes.tinyMCEFront')
    <script type="text/javascript">
        $(document).ready(function () {
            $('#country_id').on('change', function (e) {
                e.preventDefault();
                filterLangStates(0);
            });
            $(document).on('change', '#state_id', function (e) {
                e.preventDefault();
                filterLangCities(0);
            });
            filterLangStates(<?php echo old('state_id', (isset($company)) ? $company->state_id : 0); ?>);

            /*******************************/
            var fileInput = document.getElementById("logo");
            fileInput.addEventListener("change", function (e) {
                var files = this.files
                showThumbnail(files)
            }, false)
        });

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


        function filterLangStates(state_id) {
            var country_id = $('#country_id').val();
            if (country_id != '') {
                $.post("{{ route('filter.lang.states.dropdown') }}", { country_id: country_id, state_id: state_id, _method: 'POST', _token: '{{ csrf_token() }}' })
                    .done(function (response) {
                        $('#default_state_dd').html(response);
                        filterLangCities(<?php echo old('city_id', (isset($company)) ? $company->city_id : 0); ?>);
                    });
            }
        }
        function filterLangCities(city_id) {
            var state_id = $('#state_id').val();
            if (state_id != '') {
                $.post("{{ route('filter.lang.cities.dropdown') }}", { state_id: state_id, city_id: city_id, _method: 'POST', _token: '{{ csrf_token() }}' })
                    .done(function (response) {
                        $('#default_city_dd').html(response);
                    });
            }
        }
    </script>
@endpush