<?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('view_packages')): ?>
    <li class="nav-item">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="fa fa-money" aria-hidden="true"></i>
            <span class="title">Paketler</span>
            <span class="arrow"></span>
        </a>
        <ul class="sub-menu">
            <li class="nav-item">
                <a href="<?php echo e(route('list.packages')); ?>" class="nav-link">
                    <span class="title">Paketleri Listele</span>
                </a>
            </li>
            <?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('create_packages')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('create.package')); ?>" class="nav-link">
                        <span class="title">Yeni Paket Ekle</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?><?php /**PATH /home/personelnoktasit/public_html/resources/views/admin/shared/side_bars/package.blade.php ENDPATH**/ ?>