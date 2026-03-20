
<?php $__env->startSection('content'); ?> 
<!-- Header start -->
<?php echo $__env->make('includes.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- Header end --> 
<!-- Inner Page Title start -->
<?php echo $__env->make('includes.inner_page_title', ['page_title'=>__('Email to Friend')], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- Inner Page Title end -->
<!-- Page Title End -->
<div class="listpgWraper">
    <div class="container">
        <?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="userccount">
                    <?php echo Form::open(array('method' => 'post', 'route' => ['email.to.friend', $slug])); ?>

                    <div class="formpanel"> 
                        <!-- Ad Information -->
                        <h5>Email to Friend</h5>            
                        <div class="row">
                            <div class="col-md-12">
                                <div class="formrow<?php echo e($errors->has('job_url') ? ' has-error' : ''); ?>">
                                    <?php echo Form::text('job_url', route('job.detail', $slug), array('class'=>'form-control', 'id'=>'job_url', 'placeholder'=>__('URL'), 'required'=>'required', 'readonly'=>'readonly')); ?>                
                                    <?php if($errors->has('job_url')): ?> <span class="help-block"> <strong><?php echo e($errors->first('job_url')); ?></strong> </span> <?php endif; ?> </div>
                            </div>                            
                            <div class="col-md-12">
                                <div class="formrow<?php echo e($errors->has('friend_name') ? ' has-error' : ''); ?>">
                                    <?php echo Form::text('friend_name', null, array('class'=>'form-control', 'id'=>'friend_name', 'placeholder'=>__('Friends Name'), 'required'=>'required', 'autofocus'=>'autofocus')); ?>                
                                    <?php if($errors->has('friend_name')): ?> <span class="help-block"> <strong><?php echo e($errors->first('friend_name')); ?></strong> </span> <?php endif; ?> </div>
                            </div>                                                                    
                            <div class="col-md-12">
                                <div class="formrow<?php echo e($errors->has('friend_email') ? ' has-error' : ''); ?>">
                                    <?php echo Form::text('friend_email', null, array('class'=>'form-control', 'id'=>'friend_email', 'placeholder'=>__('Friends Email'), 'required'=>'required')); ?>                
                                    <?php if($errors->has('friend_email')): ?> <span class="help-block"> <strong><?php echo e($errors->first('friend_email')); ?></strong> </span> <?php endif; ?> </div>
                            </div>
                            <div class="col-md-12">
                                <div class="formrow<?php echo e($errors->has('your_name') ? ' has-error' : ''); ?>">
                                    <?php
                                    $your_name = (Auth::check()) ? Auth::user()->name : '';
                                    ?>
                                    <?php echo Form::text('your_name', $your_name, array('class'=>'form-control', 'id'=>'your_name', 'placeholder'=>__('Your Name'), 'required'=>'required')); ?>                
                                    <?php if($errors->has('your_name')): ?> <span class="help-block"> <strong><?php echo e($errors->first('your_name')); ?></strong> </span> <?php endif; ?> </div>
                            </div>
                            <div class="col-md-12">
                                <div class="formrow<?php echo e($errors->has('your_email') ? ' has-error' : ''); ?>">
                                    <?php
                                    $your_email = (Auth::check()) ? Auth::user()->email : '';
                                    ?>
                                    <?php echo Form::text('your_email', $your_email, array('class'=>'form-control', 'id'=>'your_email', 'placeholder'=>__('Your Email'), 'required'=>'required')); ?>                
                                    <?php if($errors->has('your_email')): ?> <span class="help-block"> <strong><?php echo e($errors->first('your_email')); ?></strong> </span> <?php endif; ?> </div>
                            </div>
                            <div class="col-md-12">
                                <div class="formrow<?php echo e($errors->has('g-recaptcha-response') ? ' has-error' : ''); ?>">
                                    <?php echo app('captcha')->display(); ?>

                                    <?php if($errors->has('g-recaptcha-response')): ?> <span class="help-block"> <strong><?php echo e($errors->first('g-recaptcha-response')); ?></strong> </span> <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <br>
                        <input type="submit" id="post_ad_btn" class="btn" value="<?php echo e(__('Send to friend')); ?>">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $__env->make('includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/personelnoktasit/public_html/resources/views/contact/email_to_friend_page.blade.php ENDPATH**/ ?>