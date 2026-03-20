<?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('view_users')): ?>
    <li class="nav-item">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="icon-user"></i>
            <span class="title">Kullanıcı Profilleri</span>
            <span class="arrow"></span>
        </a>
        <ul class="sub-menu">
            <li class="nav-item">
                <a href="<?php echo e(route('list.users')); ?>" class="nav-link">
                    <i class="icon-user"></i>
                    <span class="title">Profilleri Listele</span>
                </a>
            </li>
            <?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('create_users')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('create.user')); ?>" class="nav-link">
                        <i class="icon-user"></i>
                        <span class="title">Yeni Profil Ekle</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?><?php /**PATH /home/personelnoktasit/public_html/resources/views/admin/shared/side_bars/site_user.blade.php ENDPATH**/ ?>