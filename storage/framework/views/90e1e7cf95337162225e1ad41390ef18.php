
<?php $__env->startSection('content'); ?>
<!-- Header start -->
<?php echo $__env->make('includes.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- Header end --> 
<!-- Inner Page Title start -->
<?php echo $__env->make('includes.inner_page_title', ['page_title'=>'Şifre Sıfırlama'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<!-- Inner Page Title end -->
<div class="listpgWraper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="useraccountwrap">
                    <div class="userccount whitebg">
                    
                    <div class="panel-body mt-5">
                        <?php if(session('status')): ?>
                        <div class="alert alert-success">
                            <?php echo e(session('status')); ?>

                        </div>
                        <?php endif; ?>
                        <form class="form-horizontal" method="POST" action="<?php echo e(route('password.email')); ?>">
                            <?php echo e(csrf_field()); ?>

                            <div class="form-group<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                                <label for="email" class="mb-2 control-label"><?php echo e(__('Email Address')); ?></label>
                                
                                    <input id="email" type="email" class="form-control" placeholder="Kayıtlı E-posta Adresinizi Girin" name="email" value="<?php echo e(old('email')); ?>" required>
                                    <?php if($errors->has('email')): ?>
                                    <span class="help-block">
                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                
                            </div>
                            <div class="text-center mt-3">
                                
                                    <button type="submit" class="btn btn-primary">
                                        <?php echo e(__('Send Password Reset Link')); ?>

                                    </button>
                               
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $__env->make('includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/personelnoktasit/public_html/resources/views/auth/passwords/email.blade.php ENDPATH**/ ?>