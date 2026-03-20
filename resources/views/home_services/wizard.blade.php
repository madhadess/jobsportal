@extends('layouts.app')

@section('content')
    <div class="wizard-page-wrapper">
        <div class="wizard-overlay"></div>
        <div class="container wizard-container py-5">
            <div class="wizard-header text-center mb-5">
                <h1 class="wizard-title text-white fw-bold">
                    {{ $type == 'caregiver' ? 'Profesyonel Bakıcı Hizmeti' : 'Profesyonel Hizmet Çözümleri' }}
                </h1>
                <p class="wizard-subtitle text-white-50">Birkaç kolay adımda ihtiyacınız olan profesyonel desteğe ulaşın.
                </p>
            </div>

            <div class="wizard-card shadow-lg">
                <!-- Professional Progress Bar -->
                <div class="wizard-progress-enhanced mb-5">
                    <div class="progress-track"></div>
                    <div class="progress-fill" style="width: 12.5%"></div>
                    <div class="progress-steps-wrapper">
                        <div class="step-item active" data-step="1">
                            <div class="step-circle">1</div>
                            <span class="step-text">Kategori</span>
                        </div>
                        <div class="step-item" data-step="2">
                            <div class="step-circle">2</div>
                            <span class="step-text">Çalışma Şekli</span>
                        </div>
                        <div class="step-item" data-step="3">
                            <div class="step-circle">3</div>
                            <span class="step-text">Nitelikler</span>
                        </div>
                        <div class="step-item" data-step="4">
                            <div class="step-circle">4</div>
                            <span class="step-text">Tamamla</span>
                        </div>
                    </div>
                </div>

                <form id="wizardForm" class="p-md-4">
                    @csrf
                    <input type="hidden" name="type" value="{{ $type }}">
                    <input type="hidden" name="category_id" id="selected_category_id">
                    <input type="hidden" name="service_id" id="selected_service_id">
                    <input type="hidden" name="working_mode_name" id="selected_working_mode">

                    <!-- Step 1: Category Selection -->
                    <div class="wizard-step active" id="step1">
                        <div class="step-header text-center mb-5">
                            <h2 class="fw-bold text-dark">
                                {{ $type == 'caregiver' ? 'Hangi alanda bakıcı arıyorsunuz?' : 'Hangi hizmete ihtiyacınız var?' }}
                            </h2>
                            <div class="divider mx-auto"></div>
                        </div>
                        <div class="row g-4 category-grid justify-content-center">
                            @foreach($categories as $category)
                                <div class="col-lg-3 col-md-4 col-sm-6">
                                    <div class="premium-card category-card" data-id="{{ $category->id }}"
                                        data-name="{{ $category->category_name }}">
                                        <div class="card-icon-wrapper">
                                            <i class="fa fa-{{ $type == 'caregiver' ? 'user-md' : 'home' }}"></i>
                                        </div>
                                        <div class="card-body">
                                            <h4 class="card-title">{{ $category->category_name }}</h4>
                                            <div class="card-selection-indicator"><i class="fa fa-check"></i></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Step 2: Service & Working Mode -->
                    <div class="wizard-step" id="step2">
                        <div class="step-header text-center mb-5">
                            <h2 class="fw-bold text-dark" id="step2Title">Hizmet Detayları</h2>
                            <p class="text-muted">Size en uygun seçenekleri belirleyin.</p>
                            <div class="divider mx-auto"></div>
                        </div>

                        <!-- Services Section (Dynamic) -->
                        <div id="services_section" style="display: none; margin-bottom: 40px;">
                            <h4 class="text-center mb-4" style="color: #1e3c72; font-weight: 600;">Alt Hizmet Seçimi</h4>
                            <div class="row g-4 justify-content-center" id="services_container"></div>
                            <hr class="my-4">
                        </div>

                        <h4 class="text-center mb-4" style="color: #1e3c72; font-weight: 600;">Çalışma Şekli</h4>
                        <div class="row g-4 justify-content-center" id="working_mode_container">
                            <!-- Ajax with options -->
                        </div>
                    </div>

                    <!-- Step 3: Attributes -->
                    <div class="wizard-step" id="step3">
                        <div class="step-header text-center mb-5">
                            <h2 class="fw-bold text-dark">İstediğiniz Özel Nitelikler</h2>
                            <p class="text-muted">Aradığınız personelde olmasını istediğiniz diğer özellikleri işaretleyin.
                            </p>
                            <div class="divider mx-auto"></div>
                        </div>
                        <div class="row g-3" id="attributes_container">
                            <!-- Ajax with options -->
                        </div>
                    </div>

                    <!-- Step 4: Contact & Details -->
                    <div class="wizard-step" id="step4">
                        <div class="step-header text-center mb-5">
                            <h2 class="fw-bold text-dark">İletişim ve Detaylar</h2>
                            <p class="text-muted">Son olarak, size ulaşabilmemiz için iletişim bilgilerinizi girin.</p>
                            <div class="divider mx-auto"></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <div class="form-floating-custom">
                                    <label class="small text-muted mb-1">Tercih Edilen Tarih *</label>
                                    <input type="date" name="preferred_date" class="form-control premium-input shadow-none"
                                        min="{{ date('Y-m-d') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-floating-custom">
                                    <label class="small text-muted mb-1">Tercih Edilen Saat</label>
                                    <input type="time" name="preferred_time" class="form-control premium-input shadow-none">
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-floating-custom">
                                    <label class="small text-muted mb-1">Telefon Numarası *</label>
                                    <input type="text" name="customer_phone" class="form-control premium-input shadow-none"
                                        placeholder="05XX XXX XX XX" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-floating-custom">
                                    <label class="small text-muted mb-1">Şehir *</label>
                                    <select name="customer_city" id="city_select"
                                        class="form-select premium-input shadow-none" required>
                                        <option value="">İl Seçin</option>
                                        @php
                                            $states = App\State::where('country_id', 805)->active()->sorted()->get();
                                        @endphp
                                        @foreach($states as $state)
                                            <option value="{{ $state->state }}" data-id="{{ $state->id }}">{{ $state->state }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-floating-custom">
                                    <label class="small text-muted mb-1">İlçe *</label>
                                    <select name="customer_district" id="district_select"
                                        class="form-select premium-input shadow-none" required>
                                        <option value="">Önce İl Seçin</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-floating-custom">
                                    <label class="small text-muted mb-1">Mahalle *</label>
                                    <input type="text" name="customer_neighborhood"
                                        class="form-control premium-input shadow-none" placeholder="Mahalle adı" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-4">
                                <div class="form-floating-custom">
                                    <label class="small text-muted mb-1">Sokak *</label>
                                    <input type="text" name="customer_street" class="form-control premium-input shadow-none"
                                        placeholder="Sokak adı" required>
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="form-floating-custom">
                                    <label class="small text-muted mb-1">Adres Detayı (Bina No, Daire vb.) *</label>
                                    <textarea name="customer_address" class="form-control premium-input shadow-none"
                                        rows="2" placeholder="Bina no, kat, daire..." required></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 mb-4">
                                <div class="form-floating-custom">
                                    <label class="small text-muted mb-1">Ek Notlar</label>
                                    <textarea name="customer_notes" class="form-control premium-input shadow-none" rows="3"
                                        placeholder="Örn: Bebek 6 aylıktır, evde evcil hayvan vardır vb."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Integration Footer -->
                    <div class="wizard-footer d-flex align-items-center justify-content-between mt-5 pt-4 border-top">
                        <button type="button" class="btn btn-outline-secondary btn-lg px-5 shadow-sm" id="prevBtn"
                            style="display: none; border-radius: 50px;">
                            <i class="fa fa-arrow-left me-2"></i> Geri
                        </button>
                        <div class="ms-auto d-flex align-items-center">
                            <button type="button" class="btn btn-primary btn-lg px-5 shadow" id="nextBtn" disabled
                                style="background: #1e3c72; border: none; border-radius: 50px;">
                                İleri <i class="fa fa-arrow-right ms-2"></i>
                            </button>
                            <button type="submit" class="btn btn-success btn-lg px-5 shadow" id="submitBtn"
                                style="display: none; background: #2e7d32; border: none; border-radius: 50px;">
                                Talebi Tamamla <i class="fa fa-check ms-2"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        @import url('https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css');

        .wizard-page-wrapper {
            position: relative;
            min-height: 100vh;
            background: #1e3c72;
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            overflow-x: hidden;
        }

        .wizard-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://www.transparenttextures.com/patterns/cubes.png');
            opacity: 0.1;
        }

        .wizard-container {
            position: relative;
            z-index: 2;
        }

        .wizard-card {
            background: #ffffff;
            border-radius: 30px;
            overflow: hidden;
            border: none;
        }

        .divider {
            width: 60px;
            height: 4px;
            background: #1e3c72;
            border-radius: 2px;
            margin-top: 15px;
            margin-bottom: 25px;
        }

        /* Enhanced Progress Bar */
        .wizard-progress-enhanced {
            position: relative;
            background: #f8f9fa;
            padding: 30px 60px;
            border-bottom: 1px solid #eee;
        }

        .progress-track {
            position: absolute;
            top: 52px;
            left: 60px;
            right: 60px;
            height: 4px;
            background: #dee2e6;
            z-index: 1;
            border-radius: 2px;
        }

        .progress-fill {
            position: absolute;
            top: 52px;
            left: 60px;
            height: 4px;
            background: #1e3c72;
            z-index: 2;
            transition: width 0.6s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 2px;
        }

        .progress-steps-wrapper {
            display: flex;
            justify-content: space-between;
            position: relative;
            z-index: 3;
        }

        .step-item {
            text-align: center;
            cursor: default;
        }

        .step-circle {
            width: 48px;
            height: 48px;
            background: #fff;
            border: 4px solid #dee2e6;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px;
            font-weight: 700;
            color: #adb5bd;
            transition: all 0.4s;
            font-size: 1.1rem;
        }

        .step-text {
            font-size: 0.85rem;
            font-weight: 600;
            color: #adb5bd;
            transition: all 0.4s;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .step-item.active .step-circle {
            border-color: #1e3c72;
            color: #1e3c72;
            transform: scale(1.15);
            box-shadow: 0 0 15px rgba(30, 60, 114, 0.2);
        }

        .step-item.active .step-text {
            color: #1e3c72;
            font-weight: 700;
        }

        .step-item.completed .step-circle {
            background: #1e3c72;
            border-color: #1e3c72;
            color: #fff;
        }

        .step-item.completed .step-text {
            color: #1e3c72;
        }

        /* Category Cards */
        .premium-card {
            background: #fff;
            border: 2px solid #f1f3f5;
            border-radius: 24px;
            padding: 30px 20px;
            transition: all 0.35s cubic-bezier(0.34, 1.56, 0.64, 1);
            cursor: pointer;
            position: relative;
            height: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .premium-card:hover {
            border-color: #1e3c72;
            box-shadow: 0 20px 40px rgba(30, 60, 114, 0.1);
            transform: translateY(-10px);
        }

        .premium-card.selected {
            border-color: #1e3c72;
            background: #f8fbff;
        }

        .card-icon-wrapper {
            font-size: 3rem;
            color: #1e3c72;
            margin-bottom: 20px;
            height: 80px;
            display: flex;
            align-items: center;
        }

        .card-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #212529;
            margin: 0;
        }

        .card-selection-indicator {
            position: absolute;
            top: 15px;
            right: 15px;
            width: 28px;
            height: 28px;
            background: #1e3c72;
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.8rem;
            opacity: 0;
            transform: scale(0.5);
            transition: all 0.3s;
        }

        .premium-card.selected .card-selection-indicator {
            opacity: 1;
            transform: scale(1);
        }

        /* Working Mode Buttons */
        .mode-option-premium {
            background: #fff;
            border: 2px solid #e9ecef;
            border-radius: 18px;
            padding: 25px;
            transition: all 0.3s;
            cursor: pointer;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .mode-option-premium:hover {
            border-color: #1e3c72;
            background: #f8fbff;
        }

        .mode-option-premium.selected {
            border-color: #1e3c72;
            background: #1e3c72;
            color: #fff;
            transform: scale(1.02);
        }

        .mode-name {
            font-size: 1.25rem;
            font-weight: 700;
            margin: 0;
        }

        /* Attribute Chips */
        .attr-chip {
            display: block;
            padding: 15px 20px;
            background: #fff;
            border: 1px solid #e9ecef;
            border-radius: 15px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .attr-chip:hover {
            background: #f8f9fa;
            border-color: #adb5bd;
        }

        .attr-chip.selected {
            background: #e7f0ff;
            border-color: #1e3c72;
            color: #1e3c72;
            font-weight: 600;
        }

        .attr-chip input {
            display: none;
        }

        .attr-icon {
            width: 20px;
            height: 20px;
            border: 2px solid #adb5bd;
            border-radius: 4px;
            position: relative;
            transition: all 0.2s;
        }

        .attr-chip.selected .attr-icon {
            background: #1e3c72;
            border-color: #1e3c72;
        }

        .attr-chip.selected .attr-icon::after {
            content: '\f00c';
            font-family: 'FontAwesome';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #fff;
            font-size: 10px;
        }

        /* Inputs */
        .premium-input {
            border-radius: 12px;
            padding: 14px 18px;
            border: 1px solid #e9ecef;
            background: #f8f9fa;
            font-size: 1rem;
            transition: all 0.2s;
        }

        .premium-input:focus {
            border-color: #1e3c72;
            background: #fff;
        }

        /* Step Animation */
        .wizard-step {
            display: none;
        }

        .wizard-step.active {
            display: block;
            /* animation: animate__fadeIn animate__faster; */
        }

        @media (max-width: 768px) {
            .wizard-page-wrapper {
                padding: 10px;
            }

            .wizard-container {
                padding-top: 20px !important;
            }

            .wizard-progress-enhanced {
                padding: 15px 10px;
            }

            .progress-track,
            .progress-fill {
                left: 10px;
                right: 10px;
                top: 40px;
            }

            .step-circle {
                width: 32px;
                height: 32px;
                font-size: 0.9rem;
                border-width: 3px;
            }

            .step-text {
                display: none;
            }

            .wizard-card {
                border-radius: 20px;
                padding: 15px !important;
            }

            .wizard-header h1 {
                font-size: 1.5rem !important;
            }

            .wizard-header p {
                font-size: 0.9rem !important;
            }

            .step-header h2 {
                font-size: 1.2rem !important;
            }

            .premium-card {
                padding: 20px 10px;
                border-radius: 18px;
            }

            .card-icon-wrapper {
                font-size: 2rem;
                height: 50px;
                margin-bottom: 10px;
            }

            .card-icon-wrapper img {
                width: 50px;
                height: 50px;
            }

            .card-title {
                font-size: 0.9rem;
            }

            .mode-option-premium {
                padding: 15px;
                border-radius: 12px;
            }

            .mode-name {
                font-size: 1rem;
            }

            .attr-chip {
                padding: 12px;
                font-size: 0.85rem;
            }

            .wizard-footer {
                flex-direction: column-reverse;
                gap: 15px;
            }

            .wizard-footer .btn {
                width: 100%;
                border-radius: 12px !important;
                padding: 12px !important;
            }

            .wizard-footer .ms-auto {
                width: 100%;
                flex-direction: column;
            }

            .question-option-radio,
            .question-option-number {
                transition: all 0.2s;
                border: 2px solid #e9ecef !important;
                color: #495057;
                background: #fff;
            }

            .question-option-radio:hover,
            .question-option-number:hover {
                background-color: #f8f9fa;
                border-color: #adb5bd !important;
            }

            .question-option-radio input:checked+span,
            .question-option-radio.active,
            .question-option-number.active {
                background-color: #1e3c72 !important;
                border-color: #1e3c72 !important;
                color: white !important;
                box-shadow: 0 4px 10px rgba(30, 60, 114, 0.2);
            }

        }
        }
    </style>

    @push('scripts')
        <script>$(document).ready(function () {
                let currentStep = 1;
                const totalSteps = 4;

                // Auto-select category if provided in URL
                const urlParams = new URLSearchParams(window.location.search);
                const preSelectedCategory = urlParams.get('category_id');

                if (preSelectedCategory) {

                    // Wait for page load completely
                    setTimeout(function () {
                        const $targetCard = $(`.category-card[data-id="${preSelectedCategory}"]`);

                        if ($targetCard.length) {
                            $targetCard.trigger('click');

                            // Optional: Auto advance to step 2 after a short delay to let user see selection
                            setTimeout(() => {
                                if ($('#nextBtn').prop('disabled') === false) {
                                    $('#nextBtn').trigger('click');
                                }
                            }

                                , 800);
                        }
                    }

                        , 500);
                }


                function updateStep(step) {
                    $('.wizard-step').removeClass('active');
                    $(`#step${step}`).addClass('active');

                    $('.step-item').removeClass('active completed');
                    $(`.step-item[data-step="${step}"]`).addClass('active');

                    for (let i = 1; i < step; i++) {
                        $(`.step-item[data-step="${i}"]`).addClass('completed');
                    }

                    const progressPercent = ((step - 1) / (totalSteps - 1)) * 100;
                    $('.progress-fill').css('width', (progressPercent == 0 ? 12.5 : progressPercent) + '%');

                    $('#prevBtn').toggle(step > 1);

                    if (step === totalSteps) {
                        $('#nextBtn').hide();
                        $('#submitBtn').show();
                    }

                    else {
                        $('#nextBtn').show();
                        $('#submitBtn').hide();
                    }

                    validateStep(step);

                    window.scrollTo({
                        top: 0, behavior: 'smooth'
                    });
                }

                function validateStep(step) {
                    let isValid = false;
                    if (step === 1) isValid = $('#selected_category_id').val() !== '';

                    else if (step === 2) {
                        const serviceRequired = $('#services_section').is(':visible');
                        const serviceValid = !serviceRequired || $('#selected_service_id').val() !== '';
                        const modeValid = $('#selected_working_mode').val() !== '';
                        isValid = serviceValid && modeValid;
                    }

                    else if (step === 3) {
                        let allValid = true;

                        $('.question-item[data-required="1"]').each(function () {
                            const type = $(this).data('type');
                            const id = $(this).data('id');
                            let answered = false;

                            if (type === 'radio') {
                                if ($(`input[name="question_${id}"]:checked`).length > 0) answered = true;
                            }
                            else if (type === 'number') {
                                // Check if radio is used (options exist) OR input value is filled
                                if ($(`input[name="question_${id}"][type="radio"]`).length > 0) {
                                    if ($(`input[name="question_${id}"]:checked`).length > 0) answered = true;
                                } else {
                                    // Direct input check
                                    if ($(`[name="question_${id}"]`).val().trim() !== '') answered = true;
                                }
                            }
                            else if (type === 'textarea' || type === 'text') {
                                if ($(`[name="question_${id}"]`).val().trim() !== '') answered = true;
                            }

                            if (!answered) allValid = false;
                        });
                        isValid = allValid;
                    }

                    else if (step === 4) isValid = true;

                    $('#nextBtn').prop('disabled', !isValid);
                }

                $('.category-card').on('click', function () {
                    $('.category-card').removeClass('selected');
                    $(this).addClass('selected');
                    const catId = $(this).data('id');
                    $('#selected_category_id').val(catId);

                    // Reset subsequent selections
                    $('#selected_service_id').val('');
                    $('#selected_working_mode').val('');

                    validateStep(1);

                    // Fetch options with Loader
                    $('#working_mode_container').html('<div class="col-12 text-center py-5"><i class="fa fa-spinner fa-spin fa-3x text-primary"></i></div>');
                    $('#services_container').html('');
                    $('#services_section').hide();

                    $.get('{{ route("wizard.get-options") }}', {
                        category_id: catId
                    }

                        , function (data) {

                            // Handle Services
                            if (data.services && data.services.length > 0) {
                                let serviceHtml = '';
                                data.services.forEach(service => {
                                    serviceHtml += `<div class="col-md-4">
                                                                                <div class="mode-option-premium service-option" data-id="${service.id}">
                                                                                    <h4 class="mode-name" style="font-size: 1.1rem;">${service.service_name}</h4>
                                                                                </div>
                                                                            </div>`;
                                });
                                $('#services_container').html(serviceHtml);
                                $('#services_section').show();
                            } else {
                                $('#services_section').hide();
                            }

                            let modeHtml = '';
                            if (data.working_modes && data.working_modes.length > 0) {
                                data.working_modes.forEach(mode => {
                                    modeHtml += `<div class="col-md-4">
                                                                                <div class="mode-option-premium" data-name="${mode.option_name}">
                                                                                    <h4 class="mode-name">${mode.option_name}</h4>
                                                                                </div>
                                                                            </div>`;
                                });
                            } else {
                                modeHtml = '<div class="col-12 text-center text-muted py-5">Bu kategori için özel çalışma şekli tanımlanmamıştır. Geçebiliriz.</div>';
                                $('#selected_working_mode').val('Genel');
                            }
                            $('#working_mode_container').html(modeHtml);

                            let questionsHtml = '';
                            if (data.questions && data.questions.length > 0) {
                                data.questions.forEach(q => {
                                    let requiredStar = q.is_required ? '<span class="text-danger">*</span>' : '';
                                    questionsHtml += `<div class="col-12 mb-4 question-item" data-id="${q.id}" data-type="${q.type}" data-required="${q.is_required}">
                                                                                <h5 class="mb-3 fw-bold text-dark">${q.question} ${requiredStar}</h5>`;

                                    if (q.type === 'radio') {
                                        questionsHtml += `<div class="d-flex flex-wrap gap-2">`;
                                        if (q.options) {
                                            q.options.forEach(opt => {
                                                questionsHtml += `<label class="btn btn-outline-primary rounded-pill px-4 py-2 question-option-radio">
                                                                                            <input type="radio" name="question_${q.id}" value="${opt.option_text}" class="d-none">
                                                                                            ${opt.option_text}
                                                                                        </label>`;
                                            });
                                        }
                                        questionsHtml += `</div>`;
                                    } else if (q.type === 'textarea') {
                                        questionsHtml += `<textarea name="question_${q.id}" class="form-control premium-input" rows="3" placeholder="Cevabınızı buraya yazın..."></textarea>`;
                                    } else if (q.type === 'number') {
                                        questionsHtml += `<div class="d-flex gap-2">`;
                                        if (q.options && q.options.length > 0) {
                                            q.options.forEach(opt => {
                                                questionsHtml += `<label class="btn btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center question-option-number" style="width:50px; height:50px;">
                                                                                            <input type="radio" name="question_${q.id}" value="${opt.option_text}" class="d-none">
                                                                                            ${opt.option_text}
                                                                                        </label>`;
                                            });
                                        } else {
                                            questionsHtml += `<input type="number" name="question_${q.id}" class="form-control premium-input" style="width: 100px;">`;
                                        }
                                        questionsHtml += `</div>`;
                                    }
                                    questionsHtml += `</div>`;
                                });
                            } else {
                                if (data.attributes && data.attributes.length > 0) {
                                    questionsHtml += `<div class="col-12"><div class="d-flex flex-wrap gap-2">`;
                                    data.attributes.forEach(attr => {
                                        questionsHtml += `<label class="attr-chip">
                                                                            <input type="checkbox" name="attributes[]" value="${attr.option_name}">
                                                                            <span class="icon"><i class="fa fa-check"></i></span>
                                                                            <span class="text">${attr.option_name}</span>
                                                                        </label>`;
                                    });
                                    questionsHtml += `</div></div>`;
                                } else {
                                    questionsHtml = '<div class="col-12 text-center text-muted py-5">Ekstra bilgi gerekmiyor. Devam edebilirsiniz.</div>';
                                }
                            }
                            $('#attributes_container').html(questionsHtml);
                        }).fail(function () {
                            $('#working_mode_container').html('<div class="col-12 text-center text-danger">Veriler yüklenirken bir hata oluştu.</div>');
                            $('#services_section').hide();
                        });
                });

                $(document).on('click', '.service-option', function () {
                    $('.service-option').removeClass('selected');
                    $(this).addClass('selected');
                    $('#selected_service_id').val($(this).data('id'));
                    validateStep(2);
                });

                $(document).on('click', '.mode-option-premium:not(.service-option)', function () {
                    $('.mode-option-premium:not(.service-option)').removeClass('selected');
                    $(this).addClass('selected');
                    $('#selected_working_mode').val($(this).data('name'));
                    validateStep(2);
                });

                // Trigger Validation on Input Change/Keyup
                $(document).on('change keyup', '.question-item input, .question-item textarea', function () {
                    validateStep(3);
                });

                $(document).on('change', '.attr-chip input', function () {
                    $(this).closest('.attr-chip').toggleClass('selected', this.checked);
                });

                // Fix: Handle Dynamic Question Radio Click Visuals
                $(document).on('click', '.question-option-radio', function () {
                    const $input = $(this).find('input[type="radio"]');
                    const name = $input.attr('name');

                    // Reset others in same group
                    $(`input[name="${name}"]`).closest('.question-option-radio').removeClass('active btn-primary').addClass('btn-outline-primary');

                    // Activate clicked
                    $(this).removeClass('btn-outline-primary').addClass('active btn-primary');
                    $input.prop('checked', true); // Ensure checked
                });

                // Fix: Handle Dynamic Question Number Click Visuals
                $(document).on('click', '.question-option-number', function () {
                    const $input = $(this).find('input[type="radio"]');
                    const name = $input.attr('name');

                    $(`input[name="${name}"]`).closest('.question-option-number').removeClass('active btn-secondary').addClass('btn-outline-secondary');

                    $(this).removeClass('btn-outline-secondary').addClass('active btn-secondary');
                    $input.prop('checked', true);
                });

                $('#city_select').on('change', function () {
                    const stateId = $(this).find(':selected').data('id');
                    if (!stateId) return;

                    $('#district_select').html('<option value="">Yükleniyor...</option>');

                    $.get('{{ route("home-services.get-cities") }}', {
                        state_id: stateId
                    }

                        , function (data) {
                            let html = '<option value="">İlçe Seçin</option>';
                            data.forEach(city => {
                                html += `<option value="${city.city}">${city.city}</option>`;
                            });
                            $('#district_select').html(html);
                        });
                });

                $('#nextBtn').on('click', function () {
                    if (currentStep < totalSteps) {
                        currentStep++;
                        updateStep(currentStep);
                    }
                });

                $('#prevBtn').on('click', function () {
                    if (currentStep > 1) {
                        currentStep--;
                        updateStep(currentStep);
                    }
                });

                $('#wizardForm').on('submit', function (e) {
                    e.preventDefault();
                    const formData = $(this).serialize();

                    $('#submitBtn').prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-2"></i> Gönderiliyor...');

                    $.post('{{ route("wizard.submit") }}', formData, function (response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Başarılı!',
                                text: response.message,
                                confirmButtonColor: '#1e3c72'
                            }).then(() => {
                                window.location.href = response.redirect;
                            });
                        }
                        // Fix: Handle Guest Submission as Info/Success, not Error
                        else if (response.require_auth) {
                            Swal.fire({
                                icon: 'info',
                                title: 'Bilgilendirme',
                                text: response.message,
                                confirmButtonText: 'Tamam',
                                confirmButtonColor: '#1e3c72'
                            }).then(() => {
                                window.location.href = response.redirect;
                            });
                        }
                        else {
                            Swal.fire('Hata!', response.message || 'Bir hata oluştu.', 'error');
                            $('#submitBtn').prop('disabled', false).html('Talebi Tamamla <i class="fa fa-check ms-2"></i>');
                        }

                    }).fail(function (xhr) {
                        Swal.fire('Hata!', (xhr.responseJSON?.message || 'Sunucu hatası oluştu.'), 'error');
                        $('#submitBtn').prop('disabled', false).html('Talebi Tamamla <i class="fa fa-check ms-2"></i>');
                    });
                });
            });
        </script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>@endpush @endsection