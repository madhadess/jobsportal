
<?php $__env->startSection('content'); ?>
<!-- Header start -->
<?php echo $__env->make('includes.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- Header end --> 
<!-- Inner Page Title start -->
<?php echo $__env->make('includes.inner_page_title', ['page_title'=>__('Frequently asked questions')], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- Inner Page Title end -->
<!-- Page Title End -->
<div class="listpgWraper">
    <div class="container"> 
        <!--Question-->
        <div class="faqs">
            <div class="accordion" id="accordion">
                <h3>&nbsp;</h3>
                <?php if(isset($faqs) && count($faqs)): ?>
                <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?php echo e($faq->id); ?>" aria-expanded="true" aria-controls="collapseOne">
                    <?php echo $faq->faq_question; ?>

                    </button>
                </h2>

                <div id="collapse<?php echo e($faq->id); ?>" class="accordion-collapse collapse show" data-bs-parent="#accordionExample">
                <div class="accordion-body">
                <?php echo $faq->faq_answer; ?>

                </div>
                </div>

                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3"></div>
            <div class="col-md-6"><?php echo $siteSetting->cms_page_ad; ?></div>
            <div class="col-md-3"></div>
        </div>
    </div>
</div>

<?php echo $__env->make('includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/personelnoktasit/public_html/resources/views/faq/list_faq.blade.php ENDPATH**/ ?>