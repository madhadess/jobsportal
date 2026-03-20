<!-- BEGIN SIDEBAR -->
<style>
    /* =============================================
   MODERN ADMIN SIDEBAR - 2026
   ============================================= */

    /* Sidebar Container */
    .page-sidebar {
        background: #ffffff !important;
        width: 260px !important;
        min-width: 260px !important;
        border-right: 1px solid #e5e7eb !important;
        box-shadow: 2px 0 8px rgba(0, 0, 0, 0.05) !important;
        position: relative !important;
    }

    /* Sidebar Collapsed State */
    .page-sidebar-closed .page-sidebar {
        width: 70px !important;
        min-width: 70px !important;
    }

    .page-sidebar-closed .page-sidebar-menu>li>a .title,
    .page-sidebar-closed .page-sidebar-menu>li>a .arrow,
    .page-sidebar-closed .page-sidebar-menu .heading h3 {
        display: none !important;
    }

    .page-sidebar-closed .page-sidebar-menu>li>a {
        padding: 16px !important;
        justify-content: center !important;
    }

    .page-sidebar-closed .page-sidebar-menu>li>a i {
        margin-right: 0 !important;
    }

    .page-sidebar-menu {
        padding: 0 !important;
        margin: 0 !important;
    }

    /* Tüm Liste Öğeleri */
    .page-sidebar-menu li {
        list-style: none !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.05) !important;
    }

    .page-sidebar-menu li:last-child {
        border-bottom: none !important;
    }

    /* Ana Menü Linkleri */
    .page-sidebar-menu>li>a {
        display: flex !important;
        align-items: center !important;
        padding: 14px 24px !important;
        color: #111827 !important;
        font-size: 14px !important;
        font-weight: 600 !important;
        text-decoration: none !important;
        border-left: 4px solid transparent !important;
        transition: all 0.3s ease !important;
        background: transparent !important;
        border-radius: 0 !important;
        position: relative !important;
        overflow: hidden !important;
    }

    /* Force dark color for all children elements (titles, icons) */
    .page-sidebar-menu>li>a * {
        color: #111827 !important;
        transition: all 0.3s ease !important;
    }

    .page-sidebar-menu>li>a:hover {
        background: #f8fafc !important;
        color: #000000 !important;
        border-left-color: #3b82f6 !important;
        transform: translateX(2px) !important;
    }

    .page-sidebar-menu>li>a:hover * {
        color: #000000 !important;
    }

    /* Aktif Menü */
    .page-sidebar-menu>li.active>a,
    .page-sidebar-menu>li.active.open>a {
        background: #f1f5f9 !important;
        color: #3b82f6 !important;
        border-left: 4px solid #3b82f6 !important;
        font-weight: 700 !important;
    }

    /* OK İŞARETİ */
    .page-sidebar-menu>li>a .arrow:before,
    .page-sidebar-menu>li>a>.arrow:before {
        color: #94a3b8 !important;
        font-size: 10px !important;
    }

    .page-sidebar-menu>li:hover>a .arrow:before,
    .page-sidebar-menu>li.open>a .arrow:before {
        color: #6b7280 !important;
        opacity: 1 !important;
        transform: translateX(2px) !important;
    }

    .page-sidebar-menu>li.active>a .arrow:before,
    .page-sidebar-menu>li.open>a .arrow:before {
        color: #6b7280 !important;
        opacity: 1 !important;
    }

    /* Bölüm Başlıkları */
    .page-sidebar-menu>li.heading,
    .page-sidebar-menu .heading {
        padding: 24px 24px 12px !important;
        background: #f8fafc !important;
        border-bottom: 1px solid #e5e7eb !important;
        margin: 8px 0 !important;
    }

    .page-sidebar-menu>li.heading h3,
    .page-sidebar-menu .heading h3 {
        font-size: 11px !important;
        font-weight: 700 !important;
        color: #374151 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.1em !important;
        margin: 0 !important;
    }

    /* Alt Menü */
    .page-sidebar-menu .sub-menu,
    .page-sidebar-menu>li>ul.sub-menu {
        background: #ffffff !important;
        margin: 0 !important;
        padding: 0 !important;
        border-radius: 0 !important;
        border: none !important;
        box-shadow: inset 0 4px 6px -1px rgba(0, 0, 0, 0.05) !important;
    }

    .page-sidebar-menu .sub-menu>li {
        background: #ffffff !important;
        border-bottom: 1px solid #f1f5f9 !important;
    }

    .page-sidebar-menu .sub-menu>li:last-child {
        border-bottom: none !important;
    }

    .page-sidebar-menu .sub-menu>li>a {
        display: flex !important;
        align-items: center !important;
        padding: 12px 24px 12px 56px !important;
        font-size: 13px !important;
        color: #374151 !important;
        font-weight: 500 !important;
        text-decoration: none !important;
        transition: all 0.3s ease !important;
        background: #ffffff !important;
        border-radius: 0 !important;
        position: relative !important;
        overflow: hidden !important;
    }

    .page-sidebar-menu .sub-menu>li>a::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(90deg, rgba(59, 130, 246, 0.03) 0%, transparent 100%);
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .page-sidebar-menu .sub-menu>li>a:hover {
        background: #f3f4f6 !important;
        color: #000000 !important;
        transform: translateX(2px) !important;
    }

    .page-sidebar-menu .sub-menu>li>a:hover::before {
        opacity: 1;
    }

    .page-sidebar-menu .sub-menu>li.active>a {
        color: #3b82f6 !important;
        background: #f8fafc !important;
        font-weight: 600 !important;
    }

    .page-sidebar-menu .sub-menu>li>a i,
    .page-sidebar-menu .sub-menu>li>a [class^="icon-"] {
        width: 16px !important;
        min-width: 16px !important;
        font-size: 14px !important;
        margin-right: 12px !important;
        color: #000000 !important;
        opacity: 1 !important;
        visibility: visible !important;
        display: inline-block !important;
        text-align: center !important;
        transition: all 0.3s ease !important;
    }

    .page-sidebar-menu .sub-menu>li>a * {
        color: #374151 !important;
    }

    .page-sidebar-menu .sub-menu>li>a:hover * {
        color: #000000 !important;
    }

    .page-sidebar-menu .sub-menu>li>a:hover i,
    .page-sidebar-menu .sub-menu>li>a:hover [class^="icon-"] {
        color: #000000 !important;
        transform: scale(1.1) !important;
    }

    .page-sidebar-menu .sub-menu>li.active>a i,
    .page-sidebar-menu .sub-menu>li.active>a [class^="icon-"] {
        color: #000000 !important;
        transform: scale(1.1) !important;
    }

    /* Gizle */
    .page-sidebar-menu>li.sidebar-toggler-wrapper,
    .page-sidebar-menu>li.sidebar-search-wrapper {
        display: none !important;
    }

    /* Nav Item Start */
    .page-sidebar-menu>li.nav-item.start.active>a {
        background: rgba(59, 130, 246, 0.3) !important;
        box-shadow: inset 0 0 20px rgba(59, 130, 246, 0.3) !important;
    }

    /* Scrollbar Styling */
    .page-sidebar::-webkit-scrollbar {
        width: 6px !important;
    }

    .page-sidebar::-webkit-scrollbar-track {
        background: #f1f5f9 !important;
    }

    .page-sidebar::-webkit-scrollbar-thumb {
        background: #cbd5e1 !important;
        border-radius: 3px !important;
    }

    .page-sidebar::-webkit-scrollbar-thumb:hover {
        background: #94a3b8 !important;
    }

    /* Responsive için */
    @media (max-width: 768px) {

        /* Sidebar'ı görünür yap */
        .page-sidebar {
            width: 280px !important;
            min-width: 280px !important;
            max-width: 280px !important;
            transform: translateX(-100%) !important;
            transition: transform 0.3s ease !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            height: 100vh !important;
            z-index: 99999 !important;
            box-shadow: 4px 0 25px rgba(0, 0, 0, 0.15) !important;
            background: #ffffff !important;
            overflow-y: auto !important;
            overflow-x: hidden !important;
            display: block !important;
            visibility: visible !important;
            opacity: 1 !important;
            padding: 0 !important;
            margin: 0 !important;
            border: none !important;
            border-radius: 0 16px 16px 0 !important;
        }

        .page-sidebar.open {
            transform: translateX(0) !important;
        }

        /* Page content'i kaydırma - KALDIRILDI */
        .page-content-wrapper {
            transition: none !important;
            transform: none !important;
        }

        .page-content-wrapper.shifted {
            transform: none !important;
        }

        /* Sidebar overlay */
        .page-sidebar-overlay {
            display: none !important;
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            width: 100% !important;
            height: 100% !important;
            background: rgba(0, 0, 0, 0.5) !important;
            z-index: 99998 !important;
        }

        .page-sidebar-overlay.show {
            display: block !important;
        }

        /* Menü içeriği görünür yap - TÜM ELEMENTLER */
        .page-sidebar .page-sidebar-menu {
            display: block !important;
            opacity: 1 !important;
            visibility: visible !important;
            width: 100% !important;
            height: auto !important;
            overflow: visible !important;
            position: relative !important;
        }

        .page-sidebar .page-sidebar-menu>li {
            display: block !important;
            opacity: 1 !important;
            visibility: visible !important;
            width: 100% !important;
            height: auto !important;
            position: relative !important;
        }

        .page-sidebar .page-sidebar-menu>li>a {
            display: flex !important;
            opacity: 1 !important;
            visibility: visible !important;
            width: 100% !important;
            height: auto !important;
            position: relative !important;
            color: #000000 !important;
            font-size: 14px !important;
        }

        .page-sidebar .page-sidebar-menu>li>a .title {
            display: inline !important;
            opacity: 1 !important;
            visibility: visible !important;
            color: inherit !important;
            font-size: inherit !important;
        }

        .page-sidebar .page-sidebar-menu>li>a i {
            display: inline-block !important;
            opacity: 1 !important;
            visibility: visible !important;
            color: #000000 !important;
            font-size: 18px !important;
        }

        .page-sidebar .page-sidebar-menu .heading {
            display: block !important;
            opacity: 1 !important;
            visibility: visible !important;
            width: 100% !important;
            height: auto !important;
            position: relative !important;
        }

        .page-sidebar .page-sidebar-menu .heading h3 {
            display: block !important;
            opacity: 1 !important;
            visibility: visible !important;
            color: #374151 !important;
            font-size: 11px !important;
        }

        .page-sidebar .sub-menu {
            display: block !important;
            opacity: 1 !important;
            visibility: visible !important;
            width: 100% !important;
            height: auto !important;
            position: relative !important;
        }

        .page-sidebar .sub-menu>li {
            display: block !important;
            opacity: 1 !important;
            visibility: visible !important;
            width: 100% !important;
            height: auto !important;
            position: relative !important;
        }

        .page-sidebar .sub-menu>li>a {
            display: flex !important;
            opacity: 1 !important;
            visibility: visible !important;
            width: 100% !important;
            height: auto !important;
            position: relative !important;
            color: #374151 !important;
            font-size: 13px !important;
        }

        .page-sidebar .sub-menu>li>a i {
            display: inline-block !important;
            opacity: 1 !important;
            visibility: visible !important;
            color: #000000 !important;
            font-size: 14px !important;
        }

        /* Tüm gizli elementleri zorla göster */
        .page-sidebar * {
            opacity: 1 !important;
            visibility: visible !important;
            display: block !important;
        }

        .page-sidebar .page-sidebar-menu>li>a,
        .page-sidebar .page-sidebar-menu>li>a *,
        .page-sidebar .sub-menu>li>a,
        .page-sidebar .sub-menu>li>a * {
            display: flex !important;
            opacity: 1 !important;
            visibility: visible !important;
        }
    }
</style>
<div class="page-sidebar navbar-collapse collapse">
    <!-- BEGIN SIDEBAR MENU -->
    <ul class="page-sidebar-menu page-header-fixed" data-keep-expanded="false" data-auto-scroll="true"
        data-slide-speed="200" style="padding-top: 20px">
        <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
        <li class="sidebar-toggler-wrapper hide">
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            <div class="sidebar-toggler"> </div>
            <!-- END SIDEBAR TOGGLER BUTTON -->
        </li>
        <!-- DOC: To remove the search box from the sidebar you just need to completely remove the below "sidebar-search-wrapper" LI element -->
        <li class="sidebar-search-wrapper">
            <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
            <!-- DOC: Apply "sidebar-search-bordered" class the below search form to have bordered search box -->
            <!-- DOC: Apply "sidebar-search-bordered sidebar-search-solid" class the below search form to have bordered & solid search box -->
            <!-- END RESPONSIVE QUICK SEARCH FORM -->
        </li>
        <li class="nav-item start active"> <a href="<?php echo e(route('admin.home')); ?>" class="nav-link"> <i
                    class="icon-home"></i> <span class="title">Kontrol Paneli</span> </a> </li>

        <?php if(!APAuthHelp::check(['SUPER_ADMIN'])): ?>
            <li class="nav-item <?php echo e((request()->is('admin/crm/personnel*')) ? 'active' : ''); ?>">
                <a href="<?php echo e(route('admin.crm.personnel')); ?>" class="nav-link">
                    <i class="icon-notebook"></i> <span class="title">Profilim & Notlarım</span>
                </a>
            </li>
        <?php endif; ?>

        <li class="nav-item <?php echo e((request()->is('admin/messages*')) ? 'active' : ''); ?>">
            <a href="<?php echo e(route('admin.messages.index')); ?>" class="nav-link"
                style="display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center;">
                    <i class="icon-bubble"></i> <span class="title">Mesajlarım</span>
                </div>
                <span class="badge badge-danger" id="sidebar-unread-count"
                    style="display:none; font-weight:bold; margin-right: 15px;">0</span>
            </a>
        </li>
        <?php echo $__env->make('admin/shared/side_bars/admin_user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <li class="heading">
            <h3 class="uppercase">Modüller</h3>
        </li>
        <?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('view_services') || APAuthHelp::hasPermission('view_service_categories') || APAuthHelp::hasPermission('view_service_addons') || APAuthHelp::hasPermission('view_service_requests') || APAuthHelp::hasPermission('view_automation') || APAuthHelp::hasPermission('view_caregivers') || APAuthHelp::hasPermission('view_caregiver_categories') || APAuthHelp::hasPermission('view_caregiver_requests')): ?>
            <?php echo $__env->make('admin/shared/side_bars/home_services', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>

        <?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('view_jobs')): ?>
            <?php echo $__env->make('admin/shared/side_bars/job', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>

        <?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('view_companies') || APAuthHelp::hasPermission('view_orders')): ?>
            <?php echo $__env->make('admin/shared/side_bars/company', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>

        <?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('view_users')): ?>
            <?php echo $__env->make('admin/shared/side_bars/site_user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>

        <?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('view_pages') || APAuthHelp::hasPermission('manage_pages')): ?>
            <?php echo $__env->make('admin/shared/side_bars/cms', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>

        <?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('view_blog') || APAuthHelp::hasPermission('manage_blog')): ?>
            <?php echo $__env->make('admin/shared/side_bars/blogs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>

        <?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('manage_seo')): ?>
            <?php echo $__env->make('admin/shared/side_bars/seo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>

        <?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('manage_faqs')): ?>
            <?php echo $__env->make('admin/shared/side_bars/faq', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>

        <?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('manage_videos')): ?>
            <?php echo $__env->make('admin/shared/side_bars/video', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>

        <?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('manage_testimonials')): ?>
            <?php echo $__env->make('admin/shared/side_bars/testimonial', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>

        <?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('manage_sliders')): ?>
            <?php echo $__env->make('admin/shared/side_bars/slider', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>


        
        <?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('manage_locations')): ?>
            <li class="heading">
                <h3 class="uppercase">Çeviri</h3>
            </li>
            <?php echo $__env->make('admin/shared/side_bars/language', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <li class="heading">
                <h3 class="uppercase">Konum Yönetimi</h3>
            </li>
            <?php echo $__env->make('admin/shared/side_bars/country', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('admin/shared/side_bars/country_detail', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('admin/shared/side_bars/state', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('admin/shared/side_bars/city', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>

        
        <?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('view_packages')): ?>
            <li class="heading">
                <h3 class="uppercase">Kullanıcı Paketleri</h3>
            </li>
            <?php echo $__env->make('admin/shared/side_bars/package', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>

        
        <?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('manage_career_levels')): ?>
            <li class="heading">
                <h3 class="uppercase">İlan Özellikleri</h3>
            </li>
            <?php echo $__env->make('admin/shared/side_bars/language_level', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('admin/shared/side_bars/career_level', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('admin/shared/side_bars/functional_area', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('admin/shared/side_bars/gender', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('admin/shared/side_bars/industry', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('admin/shared/side_bars/job_experience', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('admin/shared/side_bars/job_skill', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('admin/shared/side_bars/job_type', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('admin/shared/side_bars/job_shift', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('admin/shared/side_bars/degree_level', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('admin/shared/side_bars/degree_type', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('admin/shared/side_bars/major_subject', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('admin/shared/side_bars/result_type', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('admin/shared/side_bars/marital_status', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('admin/shared/side_bars/ownership_type', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php echo $__env->make('admin/shared/side_bars/salary_period', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>

        
        <?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('view_reports')): ?>
            <li class="heading">
                <h3 class="uppercase">Raporlar</h3>
            </li>
            <li class="nav-item <?php echo e((request()->is('admin/reports*')) ? 'active' : ''); ?>">
                <a href="<?php echo e(route('admin.reports.index')); ?>" class="nav-link">
                    <i class="icon-bar-chart"></i>
                    <span class="title">Raporlama Merkezi</span>
                </a>
            </li>
        <?php endif; ?>


        
        <?php if(APAuthHelp::check(['SUPER_ADMIN', 'SUB_ADMIN', 'CALL_CENTER'])): ?>
            <li class="heading">
                <h3 class="uppercase">Hizmet İlanları</h3>
            </li>
            <li class="nav-item <?php echo e(request()->is('admin/ilanlar*') ? 'active' : ''); ?>">
                <a href="<?php echo e(route('admin.job-posts.index')); ?>" class="nav-link">
                    <i class="icon-list"></i>
                    <span class="title">İlanlar</span>
                </a>
            </li>
            <li class="nav-item <?php echo e(request()->is('admin/basvurular*') ? 'active' : ''); ?>">
                <a href="<?php echo e(route('admin.applications.index')); ?>" class="nav-link">
                    <i class="icon-paper-plane"></i>
                    <span class="title">Başvurular</span>
                </a>
            </li>
            <?php if(APAuthHelp::check(['SUPER_ADMIN'])): ?>
                <li class="nav-item <?php echo e(request()->is('admin/eslesme-kurallari*') ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.match-rules.index')); ?>" class="nav-link">
                        <i class="icon-settings"></i>
                        <span class="title">Eşleşme Kuralları</span>
                    </a>
                </li>
            <?php endif; ?>
        <?php endif; ?>

        
        <?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('view_settings') || APAuthHelp::hasPermission('manage_admins') || APAuthHelp::hasPermission('manage_roles') || APAuthHelp::hasPermission('view_crm') || APAuthHelp::hasPermission('manage_security') || APAuthHelp::hasPermission('manage_campaigns')): ?>
            <li class="heading">
                <h3 class="uppercase">Yönetim</h3>
            </li>

            <?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('view_settings')): ?>
                <?php echo $__env->make('admin/shared/side_bars/site_setting', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>

            <?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('view_crm')): ?>
                <li class="nav-item <?php echo e((request()->is('admin/crm*')) ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.crm.index')); ?>" class="nav-link">
                        <i class="icon-users"></i>
                        <span class="title">Personel Takip (CRM)</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('manage_security')): ?>
                <li class="nav-item <?php echo e((request()->is('admin/security*')) ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.security.index')); ?>" class="nav-link">
                        <i class="icon-shield"></i>
                        <span class="title">Güvenlik Merkezi</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('manage_campaigns')): ?>
                <li class="nav-item <?php echo e((request()->is('admin/campaigns*')) ? 'active' : ''); ?>">
                    <a href="<?php echo e(route('admin.campaign.index')); ?>" class="nav-link">
                        <i class="icon-envelope"></i>
                        <span class="title">E-posta Kampanyaları</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if(APAuthHelp::check(['SUPER_ADMIN'])): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.clear.cache')); ?>" class="nav-link">
                        <i class="icon-refresh"></i>
                        <span class="title">Cache Temizle</span>
                    </a>
                </li>
            <?php endif; ?>
        <?php endif; ?>



    </ul>
    <!-- END SIDEBAR MENU -->
    <!-- END SIDEBAR MENU -->
</div>
<!-- END SIDEBAR -->

<script>
    // Live Polling for Unread Messages
    function updateUnreadCount() {
        if (typeof $ === 'undefined') return;
        $.get('<?php echo e(route("admin.messages.unreadCount")); ?>', function (data) {
            var count = 0;
            if (data.count !== undefined) {
                count = parseInt(data.count);
            } else if (typeof data === 'number') {
                count = data;
            }

            var badge = $('#sidebar-unread-count');
            if (count > 0) {
                badge.text(count).show();
            } else {
                badge.hide();
            }
        });
    }

    // Poll every 15 seconds
    setInterval(updateUnreadCount, 15000);
    $(document).ready(updateUnreadCount);
</script><?php /**PATH /home/personelnoktasit/public_html/resources/views/admin/shared/sidebar.blade.php ENDPATH**/ ?>