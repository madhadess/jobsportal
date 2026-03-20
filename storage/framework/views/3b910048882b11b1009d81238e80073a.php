

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


                        <div class="userccount whitebg">


                            <div class="tab-content">
                                <div id="employer" class="formpanel mt-0 tab-pane fade active">
                                    <h3><?php echo e(__('Register as an Employer')); ?></h3>
                                    <form class="form-horizontal mt-3" method="POST"
                                        action="<?php echo e(route('company.register')); ?>">

                                        <?php echo e(csrf_field()); ?>


                                        <input type="hidden" name="candidate_or_employer" value="employer" />

                                        <div class="formrow<?php echo e($errors->has('name') ? ' has-error' : ''); ?>">

                                            <input type="text" name="name" class="form-control" required="required"
                                                placeholder="<?php echo e(__('Name')); ?>" value="<?php echo e(old('name')); ?>">

                                            <?php if($errors->has('name')): ?> <span class="help-block">
                                            <strong><?php echo e($errors->first('name')); ?></strong> </span> <?php endif; ?>
                                        </div>

                                        <div class="formrow<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">

                                            <input type="email" name="email" class="form-control" required="required"
                                                placeholder="<?php echo e(__('Email')); ?>" value="<?php echo e(old('email')); ?>">

                                            <?php if($errors->has('email')): ?> <span class="help-block">
                                            <strong><?php echo e($errors->first('email')); ?></strong> </span> <?php endif; ?>
                                        </div>

                                        <div class="formrow<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">

                                            <input type="password" name="password" class="form-control" required="required"
                                                placeholder="<?php echo e(__('Password')); ?>" value="">

                                            <?php if($errors->has('password')): ?> <span class="help-block">
                                            <strong><?php echo e($errors->first('password')); ?></strong> </span> <?php endif; ?>
                                        </div>

                                        <div class="formrow<?php echo e($errors->has('password_confirmation') ? ' has-error' : ''); ?>">

                                            <input type="password" name="password_confirmation" class="form-control"
                                                required="required" placeholder="<?php echo e(__('Password Confirmation')); ?>" value="">

                                            <?php if($errors->has('password_confirmation')): ?> <span class="help-block">
                                                <strong><?php echo e($errors->first('password_confirmation')); ?></strong> </span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="formrow<?php echo e($errors->has('is_subscribed') ? ' has-error' : ''); ?>">

                                            <?php

    $is_checked = '';

    if (old('is_subscribed', 1)) {

        $is_checked = 'checked="checked"';

    }

    ?>



                                            <input type="checkbox" value="1" name="is_subscribed" <?php echo e($is_checked); ?> />
                                            <?php echo e(__('Subscribe to Newsletter')); ?>


                                            <?php if($errors->has('is_subscribed')): ?> <span class="help-block">
                                            <strong><?php echo e($errors->first('is_subscribed')); ?></strong> </span> <?php endif; ?>
                                        </div>




                                        <div class="formrow<?php echo e($errors->has('terms_of_use') ? ' has-error' : ''); ?>">

                                            <input type="checkbox" value="1" name="terms_of_use" />

                                            <a href="<?php echo e(url('cms/kullanim-kosullari')); ?>"
                                                target="_blank"><?php echo e(__('Kullanım Şartlarını kabul ediyorum')); ?></a>



                                            <?php if($errors->has('terms_of_use')): ?> <span class="help-block">
                                            <strong><?php echo e($errors->first('terms_of_use')); ?></strong> </span> <?php endif; ?>
                                        </div>

                                        <div
                                            class="form-group col-12 col-sm-12 col-md-10 text-center mx-auto mobile-padding-no mb-3 <?php echo e($errors->has('g-recaptcha-response') ? ' has-error' : ''); ?>">
                                            <?php echo app('captcha')->display(); ?>

                                            <?php if($errors->has('g-recaptcha-response')): ?> <span class="help-block">
                                            <strong><?php echo e($errors->first('g-recaptcha-response')); ?></strong> </span> <?php endif; ?>
                                        </div>

                                        <input type="submit" class="btn" value="<?php echo e(__('Register')); ?>">

                                    </form>

                                </div>

                            </div>

                            <!-- sign up form -->

                            <div class="newuser"><i class="fas fa-user" aria-hidden="true"></i> Hesabınız var mı? <a
                                    href="<?php echo e(url('company-login')); ?>">Giriş Yap</a></div>

                            <!-- sign up form end-->



                        </div>

                    </div>
                </div>


            </div>



        </div>

    </div>

    <?php echo $__env->make('includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/personelnoktasit/public_html/resources/views/auth/company-register.blade.php ENDPATH**/ ?>