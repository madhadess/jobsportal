<ul class="row profilestat">
    <li class="col-md-4 col-6">
        <a href="<?php echo e(route('posted.jobs')); ?>" class="inbox"> <i class="fas fa-clock" aria-hidden="true"></i>
            <h6><?php echo e(Auth::guard('company')->user()->countOpenJobs()); ?>

            <strong><?php echo e(__('Aktif İlanlar')); ?></strong>
        </h6>
</a>
    </li>
    <li class="col-md-4 col-6">
        <a href="<?php echo e(route('company.followers')); ?>" class="inbox"> <i class="fas fa-user" aria-hidden="true"></i>
            <h6><?php echo e(Auth::guard('company')->user()->countFollowers()); ?>

            <strong><?php echo e(__('Takipçiler')); ?></strong> 
        </h6>
</a>
    </li>
     <li class="col-md-4 col-6">
        <a href="<?php echo e(route('company.messages')); ?>" class="inbox"> <i class="fas fa-envelope" aria-hidden="true"></i>
            <h6><?php echo e(Auth::guard('company')->user()->countCompanyMessages()); ?>

            <strong><?php echo e(__('Mesajlar')); ?></strong>
        </h6>
</a>
    </li>
</ul>


<?php /**PATH /home/personelnoktasit/public_html/resources/views/includes/company_dashboard_stats.blade.php ENDPATH**/ ?>