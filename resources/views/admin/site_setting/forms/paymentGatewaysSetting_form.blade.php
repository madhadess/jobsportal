{!! APFrmErrHelp::showErrorsNotice($errors) !!}

@include('flash::message')

<div class="form-body">

    <div class="row">
        <div class="col-lg-4">
            <div class="paymentboxstabs">
                <ul class="nav nav-tabs">
                    <li class="Aktif"> <a href="#packagesfor" data-toggle="tab" aria-expanded="false"><i
                                class="fa fa-users" aria-hidden="true"></i> Paketler Kimin İçin </a> </li>
                    <li class=""> <a href="#paytrtab" data-toggle="tab" aria-expanded="false"><i
                                class="fa fa-credit-card" aria-hidden="true"></i> PayTR iFrame </a> </li>
                    <li class=""> <a href="#banktransfertab" data-toggle="tab" aria-expanded="false"><i
                                class="fa fa-bank" aria-hidden="true"></i> Havale / EFT </a> </li>
                </ul>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="tab-content">
                <!-- Packages -->
                <div class="tab-pane fade active in" id="packagesfor">
                    <fieldset>
                        <legend>Paketler:</legend>
                        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_jobseeker_package_active') !!}">
                            {!! Form::label('is_jobseeker_package_active', 'İş Arayan İçin Paket Aktif mi?', ['class' => 'bold']) !!}
                            <div class="radio-list">
                                <label
                                    class="radio-inline">{!! Form::radio('is_jobseeker_package_active', 1, null, ['id' => 'is_jobseeker_package_active_yes']) !!}
                                    Evet </label>
                                <label
                                    class="radio-inline">{!! Form::radio('is_jobseeker_package_active', 0, true, ['id' => 'is_jobseeker_package_active_no']) !!}
                                    Hayır </label>
                            </div>
                            {!! APFrmErrHelp::showErrors($errors, 'is_jobseeker_package_active') !!}
                        </div>

                        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_company_package_active') !!}">
                            {!! Form::label('is_company_package_active', 'Şirket İçin Paket Aktif mi?', ['class' => 'bold']) !!}
                            <div class="radio-list">
                                <label
                                    class="radio-inline">{!! Form::radio('is_company_package_active', 1, true, ['id' => 'is_company_package_active_yes']) !!}
                                    Evet </label>
                                <label
                                    class="radio-inline">{!! Form::radio('is_company_package_active', 0, null, ['id' => 'is_company_package_active_no']) !!}
                                    Hayır </label>
                            </div>

                            {!! APFrmErrHelp::showErrors($errors, 'is_company_package_active') !!}
                        </div>

                        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'payment_bypass') !!}">
                            {!! Form::label('payment_bypass', 'Bypass Payments (Tüm Paketleri Ücretsiz Yap)', ['class' => 'bold', 'style' => 'color: red;']) !!}
                            <div class="radio-list">
                                <label class="radio-inline">
                                    {!! Form::radio('payment_bypass', 1, null, ['id' => 'payment_bypass_yes']) !!} Evet
                                </label>
                                <label class="radio-inline">
                                    {!! Form::radio('payment_bypass', 0, true, ['id' => 'payment_bypass_no']) !!} Hayır
                                </label>
                            </div>
                            <span class="help-block" style="color:red; font-size:12px;">DİKKAT: Bu seçenek "Evet"
                                olduğunda, sitedeki tüm paketlerin fiyatları her yerde "0" (Ücretsiz) olarak görünür ve
                                satın alma işlemleri doğrudan başarılı sayılarak kullanıcılara atanır. POS entegrasyonu
                                bitene kadar geçici olarak kullanılması önerilir.</span>
                            {!! APFrmErrHelp::showErrors($errors, 'payment_bypass') !!}
                        </div>

                    </fieldset>
                </div>

                <!-- PayTR -->
                <div class="tab-pane fade" id="paytrtab">
                    <fieldset>
                        <legend>PayTR iFrame:</legend>
                        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'paytr_merchant_id') !!}">
                            {!! Form::label('paytr_merchant_id', 'Merchant ID', ['class' => 'bold']) !!}
                            {!! Form::text('paytr_merchant_id', null, array('class' => 'form-control', 'id' => 'paytr_merchant_id', 'placeholder' => 'Merchant ID')) !!}
                            {!! APFrmErrHelp::showErrors($errors, 'paytr_merchant_id') !!}
                        </div>
                        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'paytr_merchant_key') !!}">
                            {!! Form::label('paytr_merchant_key', 'Merchant Key', ['class' => 'bold']) !!}
                            {!! Form::text('paytr_merchant_key', null, array('class' => 'form-control', 'id' => 'paytr_merchant_key', 'placeholder' => 'Merchant Key')) !!}
                            {!! APFrmErrHelp::showErrors($errors, 'paytr_merchant_key') !!}
                        </div>
                        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'paytr_merchant_salt') !!}">
                            {!! Form::label('paytr_merchant_salt', 'Merchant Salt', ['class' => 'bold']) !!}
                            {!! Form::text('paytr_merchant_salt', null, array('class' => 'form-control', 'id' => 'paytr_merchant_salt', 'placeholder' => 'Merchant Salt')) !!}
                            {!! APFrmErrHelp::showErrors($errors, 'paytr_merchant_salt') !!}
                        </div>
                        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_paytr_active') !!}">
                            {!! Form::label('is_paytr_active', 'PayTR Aktif mi?', ['class' => 'bold']) !!}
                            <div class="radio-list">
                                <label
                                    class="radio-inline">{!! Form::radio('is_paytr_active', 1, null, ['id' => 'is_paytr_active_yes']) !!}
                                    Evet </label>
                                <label
                                    class="radio-inline">{!! Form::radio('is_paytr_active', 0, true, ['id' => 'is_paytr_active_no']) !!}
                                    Hayır </label>
                            </div>
                            {!! APFrmErrHelp::showErrors($errors, 'is_paytr_active') !!}
                        </div>
                    </fieldset>
                </div>

                <!-- Bank Transfer -->
                <div class="tab-pane fade" id="banktransfertab">
                    <fieldset>
                        <legend>Havale / EFT:</legend>
                        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'bank_details') !!}">
                            {!! Form::label('bank_details', 'Banka Hesap Bilgileri', ['class' => 'bold']) !!}
                            {!! Form::textarea('bank_details', null, array('class' => 'form-control', 'id' => 'bank_details', 'placeholder' => 'Banka adı, IBAN, Alıcı adı vb.')) !!}
                            {!! APFrmErrHelp::showErrors($errors, 'bank_details') !!}
                        </div>
                        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_bank_transfer_active') !!}">
                            {!! Form::label('is_bank_transfer_active', 'Havale / EFT Aktif mi?', ['class' => 'bold']) !!}
                            <div class="radio-list">
                                <label
                                    class="radio-inline">{!! Form::radio('is_bank_transfer_active', 1, null, ['id' => 'is_bank_transfer_active_yes']) !!}
                                    Evet </label>
                                <label
                                    class="radio-inline">{!! Form::radio('is_bank_transfer_active', 0, true, ['id' => 'is_bank_transfer_active_no']) !!}
                                    Hayır </label>
                            </div>
                            {!! APFrmErrHelp::showErrors($errors, 'is_bank_transfer_active') !!}
                        </div>
                    </fieldset>
                </div>

                <!-- PayU -->
                <div class="tab-pane fade" id="payutab">

                    <fieldset>

                        <legend>PayU Money:</legend>
                        <?php 
        $mode = array(
    'test' => 'TEST MODE',
    'live' => 'LIVE MODE',
);
         ?>

                        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'payu_money_mode') !!}">

                            {!! Form::label('payu_money_mode', 'PayU Modu', ['class' => 'bold']) !!}
                            {!! Form::select('payu_money_mode', $mode, null, array('class' => 'form-control', 'id' => 'payu_money_mode')) !!}

                            {!! APFrmErrHelp::showErrors($errors, 'payu_money_mode') !!}

                        </div>

                        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'payu_money_key') !!}">

                            {!! Form::label('payu_money_key', 'PayU Anahtarı', ['class' => 'bold']) !!}

                            {!! Form::text('payu_money_key', null, array('class' => 'form-control', 'id' => 'payu_money_key', 'placeholder' => 'PayU Anahtarı')) !!}

                            {!! APFrmErrHelp::showErrors($errors, 'payu_money_key') !!}

                        </div>

                        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'salt') !!}">

                            {!! Form::label('salt', 'PayU Salt', ['class' => 'bold']) !!}

                            {!! Form::text('salt', null, array('class' => 'form-control', 'id' => 'salt', 'placeholder' => 'PayU Salt')) !!}

                            {!! APFrmErrHelp::showErrors($errors, 'salt') !!}

                        </div>



                        <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_payu_active') !!}">

                            {!! Form::label('is_payu_active', 'PayU Aktif mi?', ['class' => 'bold']) !!}

                            <div class="radio-list">

                                <label
                                    class="radio-inline">{!! Form::radio('is_payu_active', 1, true, ['id' => 'is_payu_active_yes']) !!}
                                    Evet </label>

                                <label
                                    class="radio-inline">{!! Form::radio('is_payu_active', 0, null, ['id' => 'is_payu_active_no']) !!}
                                    Hayır </label>

                            </div>

                            {!! APFrmErrHelp::showErrors($errors, 'is_payu_active') !!}

                        </div>

                    </fieldset>

                </div>
            </div>
        </div>
    </div>










</div>