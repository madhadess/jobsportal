<?php $widget = widget(6); ?>
<section class="how-it-works-modern py-5">
    <div class="container">
        <!-- Section Header -->
        <div class="text-center mb-5">
            <h2 class="section-title-modern fw-bold mb-2">{{__('How It Works')}}</h2>
            <div class="title-underline mx-auto"></div>
        </div>

        <div class="row gy-4 how-it-row position-relative">
            <!-- Decorative Connector Line (Desktop Only) -->
            <div class="connector-line d-none d-lg-block"></div>

            <!-- Step 1 -->
            <div class="col-lg-4 col-md-6">
                <div class="step-card-modern text-center p-4 h-100 transition-all">
                    <div class="step-number">1</div>
                    <div class="step-icon-wrap shadow-sm mb-4 mx-auto d-flex align-items-center justify-content-center">
                        <span class="material-symbols-outlined fs-2 text-primary">person_add</span>
                    </div>
                    <h4 class="fw-bold mb-3">{{ __($widget['extra_field_1'] ?? '') }}</h4>
                    <p class="text-muted mb-0">{{ __($widget['extra_field_2'] ?? '') }}.</p>
                </div>
            </div>

            <!-- Step 2 -->
            <div class="col-lg-4 col-md-6">
                <div class="step-card-modern text-center p-4 h-100 transition-all">
                    <div class="step-number">2</div>
                    <div class="step-icon-wrap shadow-sm mb-4 mx-auto d-flex align-items-center justify-content-center">
                        <span class="material-symbols-outlined fs-2 text-primary">fact_check</span>
                    </div>
                    <h4 class="fw-bold mb-3">{{ __($widget['extra_field_3'] ?? '') }}</h4>
                    <p class="text-muted mb-0">{{ __($widget['extra_field_4'] ?? '') }}.</p>
                </div>
            </div>

            <!-- Step 3 -->
            <div class="col-lg-4 col-md-6 offset-md-3 offset-lg-0">
                <div class="step-card-modern text-center p-4 h-100 transition-all">
                    <div class="step-number">3</div>
                    <div class="step-icon-wrap shadow-sm mb-4 mx-auto d-flex align-items-center justify-content-center">
                        <span class="material-symbols-outlined fs-2 text-primary">touchpad_mouse</span>
                    </div>
                    <h4 class="fw-bold mb-3">{{ __($widget['extra_field_5'] ?? '') }}</h4>
                    <p class="text-muted mb-0">{{ __($widget['extra_field_6'] ?? '') }}.</p>
                </div>
            </div>
        </div>
    </div>
</section>