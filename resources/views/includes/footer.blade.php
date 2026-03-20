<!-- Modern Footer Start -->
<footer class="modern-footer">
    <!-- Main Footer -->
    <div class="footer-main">
        <div class="container">
            <div class="row">
                
                <!-- Logo & About -->
                <div class="col-lg-4 col-md-6 col-12 footer-col">
                    <div class="footer-brand">
                        <a href="{{ route('index') }}" class="footer-logo">
                            <img src="{{ asset('/') }}sitesetting_images/thumb/{{ $siteSetting->site_logo }}" alt="{{ $siteSetting->site_name }}" />
                        </a>
                        <p class="footer-desc">{{ $siteSetting->site_name }} - {{__('Career and business opportunities meeting point. Thousands of job advertisements and talented candidates are here!')}}</p>
                        
                        <!-- Social Icons -->
                        <div class="footer-social">
                            @include('includes.footer_social')
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6 col-6 footer-col">
                    <h5 class="footer-title">{{__('Quick Links')}}</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('index') }}"><i class="fas fa-chevron-right"></i> {{__('Home')}}</a></li>
                        <li><a href="{{ route('job.list') }}"><i class="fas fa-chevron-right"></i> {{__('Job Listings')}}</a></li>
                        <li><a href="{{ route('company.listing') }}"><i class="fas fa-chevron-right"></i> {{__('Companies')}}</a></li>
                        <li><a href="{{ route('contact.us') }}"><i class="fas fa-chevron-right"></i> {{__('Contact Us')}}</a></li>
                        <li><a href="{{ route('faq') }}"><i class="fas fa-chevron-right"></i> {{__('FAQs')}}</a></li>
                        @foreach($show_in_footer_menu as $footer_menu)
                        @php
                        $cmsContent = App\CmsContent::getContentBySlug($footer_menu->page_slug);
                        @endphp
                        <li><a href="{{ route('cms', $footer_menu->page_slug) }}"><i class="fas fa-chevron-right"></i> {{ $cmsContent->page_title }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <!-- Jobs By Functional Area -->
                <div class="col-lg-3 col-md-6 col-6 footer-col">
                    <h5 class="footer-title">{{__('Jobs By Functional Area')}}</h5>
                    <ul class="footer-links">
                        @php
                        $functionalAreas = App\FunctionalArea::getUsingFunctionalAreas(6);
                        @endphp
                        @foreach($functionalAreas as $functionalArea)
                        <li><a href="{{ route('job.list', ['functional_area_id[]'=>$functionalArea->functional_area_id]) }}"><i class="fas fa-chevron-right"></i> {{$functionalArea->functional_area}}</a></li>
                        @endforeach
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="col-lg-3 col-md-6 col-12 footer-col">
                    <h5 class="footer-title">{{__('Contact Us')}}</h5>
                    <ul class="footer-contact">
                        <li>
                            <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div class="contact-text">{{ $siteSetting->site_street_address }}</div>
                        </li>
                        <li>
                            <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                            <div class="contact-text"><a href="mailto:{{ $siteSetting->mail_to_address }}">{{ $siteSetting->mail_to_address }}</a></div>
                        </li>
                        @if($siteSetting->site_phone_primary)
                        <li>
                            <div class="contact-icon"><i class="fas fa-phone-alt"></i></div>
                            <div class="contact-text"><a href="tel:{{ $siteSetting->site_phone_primary }}">{{ $siteSetting->site_phone_primary }}</a></div>
                        </li>
                        @endif
                    </ul>
                    
                    <!-- Newsletter -->
                    <div class="footer-newsletter">
                        <h6>{{__('Subscribe to Our Newsletter')}}</h6>
                        <form class="newsletter-form">
                            <input type="email" placeholder="{{__('Your email address')}}" />
                            <button type="submit"><i class="fas fa-paper-plane"></i></button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
    <!-- Footer Bottom -->
    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 col-12">
                    <p class="copyright-text">{{__('Copyright')}} &copy; {{date('Y')}} {{ $siteSetting->site_name }}. {{__('All Rights Reserved')}}.</p>
                </div>
                <div class="col-md-6 col-12">
                    <ul class="footer-bottom-links">
                        <li><a href="{{ route('cms', 'gizlilik-politikasi') }}">{{__('Privacy Policy')}}</a></li>
                        <li><a href="{{ route('cms', 'kullanim-kosullari') }}">{{__('Terms of Use')}}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- Modern Footer End -->

<style>
/* Modern Footer Styles */
.modern-footer {
    background: linear-gradient(135deg, #1e3a5f 0%, #0f172a 100%);
    color: #ffffff;
    position: relative;
    overflow: hidden;
}

.modern-footer::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #3b82f6 0%, #8b5cf6 50%, #ec4899 100%);
}

.footer-main {
    padding: 60px 0 40px;
    position: relative;
}

.footer-main::before {
    content: '';
    position: absolute;
    top: 0;
    right: 0;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(59, 130, 246, 0.1) 0%, transparent 70%);
    pointer-events: none;
}

.footer-col {
    margin-bottom: 30px;
}

/* Footer Brand */
.footer-brand {
    padding-right: 30px;
}

.footer-logo {
    display: inline-block;
    margin-bottom: 20px;
}

.footer-logo img {
    max-width: 180px;
    max-height: 50px;
    filter: brightness(0) invert(1);
    transition: all 0.3s ease;
}

.footer-logo:hover img {
    opacity: 0.8;
}

.footer-desc {
    color: rgba(255, 255, 255, 0.7);
    font-size: 14px;
    line-height: 1.7;
    margin-bottom: 24px;
}

/* Footer Social */
.footer-social {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.footer-social a {
    width: 38px;
    height: 38px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.1);
    border-radius: 8px;
    color: #ffffff !important;
    font-size: 16px;
    transition: all 0.3s ease;
    text-decoration: none;
}

.footer-social a i {
    color: #ffffff !important;
    font-size: 16px;
}

.footer-social a svg {
    width: 16px;
    height: 16px;
    fill: #ffffff;
}

.footer-social a:hover {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
}

.footer-social a:hover i,
.footer-social a:hover svg {
    color: #ffffff !important;
    fill: #ffffff;
}

/* Footer Title */
.footer-title {
    color: #ffffff;
    font-size: 18px;
    font-weight: 700;
    margin-bottom: 24px;
    position: relative;
    padding-bottom: 12px;
}

.footer-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 40px;
    height: 3px;
    background: linear-gradient(90deg, #3b82f6 0%, #8b5cf6 100%);
    border-radius: 2px;
}

/* Footer Links */
.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li {
    margin-bottom: 12px;
}

.footer-links li a {
    color: rgba(255, 255, 255, 0.7);
    font-size: 14px;
    text-decoration: none;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
}

.footer-links li a i {
    font-size: 10px;
    color: #3b82f6;
    transition: transform 0.3s ease;
}

.footer-links li a:hover {
    color: #ffffff;
    padding-left: 5px;
}

.footer-links li a:hover i {
    transform: translateX(3px);
}

/* Footer Contact */
.footer-contact {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-contact li {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 16px;
}

.contact-icon {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(59, 130, 246, 0.2);
    border-radius: 8px;
    color: #3b82f6;
    font-size: 14px;
    flex-shrink: 0;
}

.contact-text {
    color: rgba(255, 255, 255, 0.7);
    font-size: 14px;
    line-height: 1.5;
}

.contact-text a {
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    transition: color 0.3s ease;
}

.contact-text a:hover {
    color: #3b82f6;
}

/* Newsletter */
.footer-newsletter {
    margin-top: 24px;
    padding-top: 24px;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.footer-newsletter h6 {
    color: #ffffff;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 12px;
}

.newsletter-form {
    display: flex;
    gap: 8px;
}

.newsletter-form input {
    flex: 1;
    padding: 10px 14px;
    background: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 8px;
    color: #ffffff;
    font-size: 13px;
    outline: none;
    transition: all 0.3s ease;
}

.newsletter-form input::placeholder {
    color: rgba(255, 255, 255, 0.5);
}

.newsletter-form input:focus {
    border-color: #3b82f6;
    background: rgba(255, 255, 255, 0.15);
}

.newsletter-form button {
    width: 44px;
    height: 44px;
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    border: none;
    border-radius: 8px;
    color: #ffffff;
    font-size: 14px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.newsletter-form button:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4);
}

/* Footer Bottom */
.footer-bottom {
    background: rgba(0, 0, 0, 0.2);
    padding: 20px 0;
}

.copyright-text {
    color: rgba(255, 255, 255, 0.6);
    font-size: 13px;
    margin: 0;
}

.footer-bottom-links {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    justify-content: flex-end;
    gap: 24px;
}

.footer-bottom-links li a {
    color: rgba(255, 255, 255, 0.6);
    font-size: 13px;
    text-decoration: none;
    transition: color 0.3s ease;
}

.footer-bottom-links li a:hover {
    color: #3b82f6;
}

/* Responsive */
@media (max-width: 991px) {
    .footer-main {
        padding: 40px 0 20px;
    }
    
    .footer-brand {
        padding-right: 0;
        text-align: center;
    }
    
    .footer-social {
        justify-content: center;
    }
    
    .footer-title::after {
        left: 50%;
        transform: translateX(-50%);
    }
}

@media (max-width: 767px) {
    .footer-col {
        text-align: center;
    }
    
    .footer-links li a {
        justify-content: center;
    }
    
    .footer-contact li {
        justify-content: center;
    }
    
    .footer-bottom-links {
        justify-content: center;
        margin-top: 10px;
    }
    
    .copyright-text {
        text-align: center;
    }
    
    .newsletter-form {
        max-width: 300px;
        margin: 0 auto;
    }
}
</style>

