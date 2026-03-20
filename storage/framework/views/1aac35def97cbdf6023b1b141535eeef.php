
<?php $__env->startSection('content'); ?>
<!-- Header start -->
<?php echo $__env->make('includes.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- Header end --> 
<!-- Inner Page Title start -->
<?php echo $__env->make('includes.inner_page_title', ['page_title'=>__('Manage Jobs')], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- Inner Page Title end -->
<div class="listpgWraper">
    <div class="container">
        <div class="row">
            <?php echo $__env->make('includes.company_dashboard_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <div class="col-lg-9"> 
                <div class="myads">

                    <?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 

                    <h3><?php echo e(__('Manage Jobs')); ?></h3>
                    
                    <!-- Tabs start -->
                    <ul class="nav nav-tabs mt-4" id="jobTabs">
                        <li class="nav-item">
                            <a class="nav-link active" id="active-tab" data-toggle="tab" href="#active-jobs"><?php echo e(__('Active Jobs')); ?></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="expired-tab" data-toggle="tab" href="#expired-jobs"><?php echo e(__('Expired Jobs')); ?></a>
                        </li>
                    </ul>
                    <!-- Tabs end -->

                    <div class="tab-content">
                        <!-- active Jobs start -->
                        <div class="tab-pane fade show active" id="active-jobs">
                            <ul class="featuredlist row">
                                <?php if(isset($jobs) && count($jobs)): ?>
                                    <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php 
                                            $company = $job->getCompany(); 
                                            $appliedUsersCount = $job->appliedUsers->count();
                                        ?>
                                        <?php if(null !== $company && $job->expiry_date >= now()): ?>

                                        <li class="col-lg-6 col-md-6" id="job_li_<?php echo e($job->id); ?>">
                                            <div class="jobint">

                                                <div class="d-flex">
                                                    <div class="fticon"><i class="fas fa-briefcase"></i> <?php echo e($job->getJobType('job_type')); ?></div>                        
                                                </div>
                                                <h4><a href="<?php echo e(route('job.detail', [$job->slug])); ?>" title="<?php echo e($job->title); ?>"><?php echo \Illuminate\Support\Str::limit($job->title, $limit = 20, $end = '...'); ?></a>
                                                </h4>
                                                <?php if(!(bool)$job->hide_salary): ?>                    
                                                <div class="salary mb-2"><?php echo e(__('Salary')); ?>: <strong><?php echo e($job->getSalaryRange()); ?>/<?php echo e($job->getSalaryPeriod('salary_period')); ?></strong></div>
                                                <?php endif; ?> 
                                                <strong><i class="fas fa-map-marker-alt"></i> <?php echo e($job->getCity('city')); ?></strong>    
                                                <span><?php echo e($job->created_at->translatedFormat('d F Y')); ?></span>
                                                <div class="d-flex mt-3 compjobslinks">
                                                    <a class="btn btn-primary me-2" href="<?php echo e(route('list.applied.users', [$job->id])); ?>"><?php echo e(__('Candidates')); ?>

                                                        <?php if($appliedUsersCount > 0): ?>
                                                            <span class="badge bg-white text-dark"><?php echo e($appliedUsersCount); ?></span>
                                                        <?php else: ?>
                                                            <span class="badge bg-white text-dark">0</span>
                                                        <?php endif; ?>
                                                    </a>
                                                    <a class="btn btn-warning me-2" href="<?php echo e(route('edit.front.job', [$job->id])); ?>"><i class="fas fa-edit"></i></a>
                                                    <?php if($job->is_featured == 1): ?>
                                                        <button class="btn btn-success me-2" disabled><i class="fas fa-check-circle"></i> <?php echo e(__('Öne Çıkarıldı')); ?></button>
                                                    <?php else: ?>
                                                        <a class="btn btn-info me-2" href="javascript:;" onclick="makeFeatured(<?php echo e($job->id); ?>);" id="featured_btn_<?php echo e($job->id); ?>"><i class="fas fa-arrow-up"></i> <?php echo e(__('Öne Çıkar')); ?></a>
                                                    <?php endif; ?>
                                                    <a class="btn btn-danger me-2" href="javascript:;" onclick="deleteJob(<?php echo e($job->id); ?>);"><i class="fas fa-trash"></i></a>                                    
                                                </div>
                                            </div>
                                        </li>

                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <p><?php echo e(__('No active Jobs')); ?></p>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <!-- active Jobs end -->

                        <!-- Expired Jobs start -->
                        <div class="tab-pane fade" id="expired-jobs">
                            <ul class="featuredlist row">
                                <?php if(isset($jobs) && count($jobs)): ?>
                                    <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php 
                                            $company = $job->getCompany(); 
                                            $appliedUsersCount = $job->appliedUsers->count();
                                        ?>
                                        <?php if(null !== $company && $job->expiry_date < now()): ?>
                                           
                                            <li class="col-lg-6 col-md-6" id="job_li_<?php echo e($job->id); ?>">
                                            <div class="jobint">

                                                <div class="d-flex">
                                                    <div class="fticon"><i class="fas fa-briefcase"></i> <?php echo e($job->getJobType('job_type')); ?></div>                        
                                                </div>
                                                <h4><a href="<?php echo e(route('job.detail', [$job->slug])); ?>" title="<?php echo e($job->title); ?>"><?php echo \Illuminate\Support\Str::limit($job->title, $limit = 20, $end = '...'); ?></a>
                                                </h4>
                                                <?php if(!(bool)$job->hide_salary): ?>                    
                                                <div class="salary mb-2"><?php echo e(__('Salary')); ?>: <strong><?php echo e($job->getSalaryRange()); ?>/<?php echo e($job->getSalaryPeriod('salary_period')); ?></strong></div>
                                                <?php endif; ?> 
                                                <strong><i class="fas fa-map-marker-alt"></i> <?php echo e($job->getCity('city')); ?></strong>    
                                                <span><?php echo e($job->created_at->translatedFormat('d F Y')); ?></span>
                                                <div class="d-flex mt-3 compjobslinks">
                                                <a class="btn btn-primary me-2" href="<?php echo e(route('list.applied.users', [$job->id])); ?>"><?php echo e(__('Candidates')); ?>

                                                                <?php if($appliedUsersCount > 0): ?>
                                                                    <span class="badge bg-white text-dark"><?php echo e($appliedUsersCount); ?></span>
                                                                <?php else: ?>
                                                                    <span class="badge bg-white text-dark">0</span>
                                                                <?php endif; ?>
                                                            </a>
                                                            <a class="btn btn-warning me-2" href="<?php echo e(route('edit.front.job', [$job->id])); ?>"><?php echo e(__('Repost')); ?></a>
                                                            <a class="btn btn-danger me-2" href="javascript:;" onclick="deleteJob(<?php echo e($job->id); ?>);"><i class="fas fa-trash"></i></a>                                       
                                                </div>
                                            </div>
                                        </li>







                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <p><?php echo e(__('No Expired Jobs')); ?></p>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <!-- Expired Jobs end -->
                    </div>

                    <!-- Pagination Start -->
                    <div class="pagiWrap mt-4">
                        <div class="row">
                            <div class="col-md-5">
                                <div class="showreslt">
                                    <?php echo e(__('Showing Jobs')); ?> : <?php echo e($jobs->firstItem()); ?> - <?php echo e($jobs->lastItem()); ?> <?php echo e(__('Total')); ?> <?php echo e($jobs->total()); ?>

                                </div>
                            </div>
                            <div class="col-md-7 text-right">
                                <?php if(isset($jobs) && count($jobs)): ?>
                                    <?php echo e($jobs->appends(request()->query())->links()); ?>

                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <!-- Pagination end -->

                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $__env->make('includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script type="text/javascript">
    function deleteJob(id) {
        var msg = "<?php echo e(__('Are you sure?')); ?>";
        if (confirm(msg)) {
            $.post("<?php echo e(route('delete.front.job')); ?>", {id: id, _method: 'DELETE', _token: '<?php echo e(csrf_token()); ?>'})
                .done(function (response) {
                    if (response == 'ok') {
                        $('#job_li_' + id).remove();
                    } else {
                        alert("<?php echo e(__('Request Failed!')); ?>");
                    }
                });
        }
    }

    function makeFeatured(id) {
        var msg = "<?php echo e(__('Bu ilanı öne çıkarmak istediğinize emin misiniz? Bu işlem 1 öne çıkarma kredinizi kullanacaktır.')); ?>";
        if (confirm(msg)) {
            $.post("<?php echo e(route('make.job.featured')); ?>", {job_id: id, _token: '<?php echo e(csrf_token()); ?>'})
                .done(function (response) {
                    if (response.status == 'success') {
                        $('#featured_btn_' + id).removeClass('btn-info').addClass('btn-success').attr('disabled', true).html('<i class="fas fa-check-circle"></i> <?php echo e(__("Öne Çıkarıldı")); ?>').removeAttr('onclick');
                        alert(response.message);
                    } else {
                        alert(response.message);
                    }
                });
        }
    }

    $(document).ready(function() {
        // Initialize the tab functionality
        $('#jobTabs a').on('click', function (e) {
            e.preventDefault();
            $(this).tab('show');
        });
    });
</script>
<?php $__env->stopPush(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/personelnoktasit/public_html/resources/views/job/company_posted_jobs.blade.php ENDPATH**/ ?>