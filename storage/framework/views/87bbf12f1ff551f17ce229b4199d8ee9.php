
<?php $__env->startSection('content'); ?>
    <!-- Header start -->
    <?php echo $__env->make('includes.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Header end -->





    <div class="authpages">
        <div class="container">
            <div class="row justify-content-center align-items-center">



                <div class="col-lg-5">
                    <?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <div class="useraccountwrap">


                        <div class="userccount whitebg mb-0">



                            <div class="tab-content">
                                <div id="candidate" class="formpanel mt-0 tab-pane active">
                                    <h5 class="text-center"><?php echo e(__('Candidate Login')); ?></h5>
                                    <div class="socialLogin">


                                        <a href="<?php echo e(url('login/jobseeker/google')); ?>" class="gp"><i
                                                class="fa-brands fa-google"></i></a>
                                        <a href="<?php echo e(url('login/jobseeker/facebook')); ?>" class="fb"><i class="fab fa-facebook"
                                                aria-hidden="true"></i></a>
                                        <a href="<?php echo e(url('login/jobseeker/twitter')); ?>" class="tw"><svg
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                <path
                                                    d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z">
                                                </path>
                                            </svg></a>
                                    </div>

                                    <div class="divider-text-center"><span><?php echo e(__('Or login with your account')); ?></span></div>


                                    <form class="form-horizontal" method="POST" action="<?php echo e(route('login')); ?>">
                                        <?php echo e(csrf_field()); ?>

                                        <input type="hidden" name="candidate_or_employer" value="candidate" />
                                        <div class="formpanel">
                                            <div class="formrow<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">
                                                <input id="email" type="email" class="form-control" name="email"
                                                    value="<?php echo e(old('email')); ?>" required autofocus
                                                    placeholder="<?php echo e(__('Email Address')); ?>">
                                                <?php if($errors->has('email')): ?>
                                                    <span class="help-block">
                                                        <strong><?php echo e($errors->first('email')); ?></strong>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="formrow<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">
                                                <input id="password" type="password" class="form-control" name="password"
                                                    value="" required placeholder="<?php echo e(__('Password')); ?>">
                                                <?php if($errors->has('password')): ?>
                                                    <span class="help-block">
                                                        <strong><?php echo e($errors->first('password')); ?></strong>
                                                    </span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="mb-3"><i class="fas fa-lock" aria-hidden="true"></i>
                                                <?php echo e(__('Forgot Your Password')); ?>? <a
                                                    href="<?php echo e(route('password.request')); ?>"><?php echo e(__('Click here')); ?></a></div>
                                            <input type="submit" class="btn" value="<?php echo e(__('Login')); ?>">
                                        </div>
                                        <!-- login form  end-->
                                    </form>
                                    <!-- sign up form -->
                                    <div class="newuser"><i class="fa fa-user" aria-hidden="true"></i> <?php echo e(__('New User?')); ?>

                                        <a href="<?php echo e(route('register')); ?>"><?php echo e(__('Register Here')); ?></a></div>

                                    <!-- sign up form end-->
                                </div>

                            </div>
                            <!-- login form -->



                        </div>



                    </div>
                </div>







            </div>




        </div>
    </div>



    <?php echo $__env->make('includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/personelnoktasit/public_html/resources/views/auth/login.blade.php ENDPATH**/ ?>