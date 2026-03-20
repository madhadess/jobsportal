<?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('view_jobs')): ?>
    <li class="nav-item">
        <a href="javascript:;" class="nav-link nav-toggle">
            <i class="icon-briefcase"></i>
            <span class="title">İş İlanları</span>
            <span class="arrow"></span>
        </a>
        <ul class="sub-menu">
            <li class="nav-item">
                <a href="<?php echo e(route('list.jobs')); ?>" class="nav-link">
                    <span class="title">İlanları Listele</span>
                </a>
            </li>
            <?php if(APAuthHelp::check(['SUPER_ADMIN']) || APAuthHelp::hasPermission('create_jobs')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('create.job')); ?>" class="nav-link">
                        <span class="title">Yeni İlan Ekle</span>
                    </a>
                </li>
            <?php endif; ?>
            <?php if(APAuthHelp::check(['SUPER_ADMIN'])): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('list.jobsB')); ?>" class="nav-link">
                        <span class="title">İlanları İçe Aktar</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>
    </li>
<?php endif; ?><?php /**PATH /home/personelnoktasit/public_html/resources/views/admin/shared/side_bars/job.blade.php ENDPATH**/ ?>