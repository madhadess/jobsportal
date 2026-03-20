<li class="nav-item  "> <a href="javascript:;" class="nav-link nav-toggle"> <i class="fa fa-file-text-o"
            aria-hidden="true"></i> <span class="title">İçerik Yönetimi</span> <span class="arrow"></span> </a>
    <ul class="sub-menu">
        <?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('view_pages')): ?>
            <li class="nav-item  "> <a href="<?php echo e(route('list.cms')); ?>" class="nav-link "> <span class="title">Sayfaları
                        Listele</span> </a> </li>
        <?php endif; ?>
        <?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('manage_pages')): ?>
            <li class="nav-item  "> <a href="<?php echo e(route('create.cms')); ?>" class="nav-link "> <span class="title">Yeni Sayfa
                        Ekle</span> </a> </li>
        <?php endif; ?>
        <?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('view_pages')): ?>
            <li class="nav-item  "> <a href="<?php echo e(route('list.cmsContent')); ?>" class="nav-link "> <span
                        class="title">Çevrilmiş Sayfalar</span> </a> </li>
        <?php endif; ?>
        <?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('manage_pages')): ?>
            <li class="nav-item  "> <a href="<?php echo e(route('create.cmsContent')); ?>" class="nav-link "> <span class="title">Yeni
                        Çeviri Ekle</span> </a> </li>
        <?php endif; ?>
    </ul>
</li><?php /**PATH /home/personelnoktasit/public_html/resources/views/admin/shared/side_bars/cms.blade.php ENDPATH**/ ?>