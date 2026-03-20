<?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('view_services') || APAuthHelp::hasPermission('view_service_categories') || APAuthHelp::hasPermission('view_service_addons') || APAuthHelp::hasPermission('view_service_requests') || APAuthHelp::hasPermission('view_automation')): ?>
    <!-- Hizmet Yönetimi -->
    <li class="nav-item">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="icon-home"></i>
            <span class="title">Hizmet Yönetimi</span>
            <span class="arrow"></span>
        </a>
        <ul class="sub-menu">
            <?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('view_service_categories')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.service-categories.index', ['type' => 'service'])); ?>" class="nav-link">
                        <i class="icon-list"></i>
                        <span class="title">Hizmet Kategorileri</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('view_services')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.services.index', ['type' => 'service'])); ?>" class="nav-link">
                        <i class="icon-settings"></i>
                        <span class="title">Hizmetler</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('view_service_addons')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.service-addons.index')); ?>" class="nav-link">
                        <i class="icon-plus"></i>
                        <span class="title">Ek Hizmetler</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('view_service_requests')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.service-requests.index', ['type' => 'service'])); ?>" class="nav-link">
                        <i class="icon-envelope"></i>
                        <span class="title">Hizmet Talepleri</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('view_automation')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.automation.index')); ?>" class="nav-link">
                        <i class="icon-rocket"></i>
                        <span class="title">Otomatik Eşleştirme</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?>

<?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('view_caregivers') || APAuthHelp::hasPermission('view_caregiver_categories') || APAuthHelp::hasPermission('view_caregiver_requests')): ?>
    <!-- Bakıcı Yönetimi -->
    <li class="nav-item">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="icon-users"></i>
            <span class="title">Bakıcı Yönetimi</span>
            <span class="arrow"></span>
        </a>
        <ul class="sub-menu">
            <?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('view_caregiver_categories')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.service-categories.index', ['type' => 'caregiver'])); ?>" class="nav-link">
                        <i class="icon-list"></i>
                        <span class="title">Bakıcı Türleri</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('view_caregivers')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.services.index', ['type' => 'caregiver'])); ?>" class="nav-link">
                        <i class="icon-user"></i>
                        <span class="title">Bakıcılar / Uzmanlar</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('view_caregiver_requests')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('admin.service-requests.index', ['type' => 'caregiver'])); ?>" class="nav-link">
                        <i class="icon-envelope"></i>
                        <span class="title">Bakıcı Talepleri</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?><?php /**PATH /home/personelnoktasit/public_html/resources/views/admin/shared/side_bars/home_services.blade.php ENDPATH**/ ?>