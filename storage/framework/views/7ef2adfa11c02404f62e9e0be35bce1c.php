

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

                                <div id="candidate" class="formpanel mt-0 tab-pane active">
                                    <h3 class="text-center"><?php echo e(__('İş Arayan / Personel Olarak Kaydol')); ?></h3>



                                    <form class="form-horizontal mt-3" method="POST" action="<?php echo e(route('register')); ?>"
                                        enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?>

                                        <input type="hidden" name="candidate_or_employer" value="candidate" />

                                        <div class="formrow<?php echo e($errors->has('user_type') ? ' has-error' : ''); ?>">
                                            <select name="user_type" id="user_type" class="form-control" required="required"
                                                onchange="toggleOccupationGroup(this.value)">
                                                <option value=""><?php echo e(__('Üyelik Amacınızı Seçin')); ?></option>
                                                <option value="candidate" <?php echo e(old('user_type') == 'candidate' ? 'selected' : ''); ?>><?php echo e(__('İş Arıyorum (İlanlara Başvurmak İçin)')); ?></option>
                                                <option value="personnel" <?php echo e(old('user_type') == 'personnel' ? 'selected' : ''); ?>><?php echo e(__('Hizmet Personeliyim (Temizlik, Montaj vb.)')); ?></option>
                                                <option value="caregiver" <?php echo e(old('user_type') == 'caregiver' ? 'selected' : ''); ?>><?php echo e(__('Bakıcıyım (Çocuk, Yaşlı, Hasta vb.)')); ?></option>
                                            </select>
                                            <?php if($errors->has('user_type')): ?> <span class="help-block">
                                            <strong><?php echo e($errors->first('user_type')); ?></strong> </span> <?php endif; ?>
                                        </div>

                                        <div id="occupation_group_wrap"
                                            class="formrow<?php echo e($errors->has('parent_occupation_id') ? ' has-error' : ''); ?>"
                                            style="display: <?php echo e(in_array(old('user_type'), ['personnel', 'caregiver']) ? 'block' : 'none'); ?>;">

                                            
                                            <select name="parent_occupation_id" id="parent_occupation_id"
                                                class="form-control mb-2">
                                                <option value=""><?php echo e(__('Meslek Alanınızı Seçin')); ?></option>
                                            </select>
                                            <?php if($errors->has('parent_occupation_id')): ?>
                                                <span class="help-block">
                                                    <strong><?php echo e($errors->first('parent_occupation_id')); ?></strong>
                                                </span>
                                            <?php endif; ?>

                                        </div>

                                        <div class="formrow<?php echo e($errors->has('first_name') ? ' has-error' : ''); ?>">

                                            <input type="text" name="first_name" class="form-control" required="required"
                                                placeholder="<?php echo e(__('Adınız')); ?>" value="<?php echo e(old('first_name')); ?>">

                                            <?php if($errors->has('first_name')): ?> <span class="help-block">
                                            <strong><?php echo e($errors->first('first_name')); ?></strong> </span> <?php endif; ?>
                                        </div>



                                        <div class="formrow<?php echo e($errors->has('last_name') ? ' has-error' : ''); ?>">

                                            <input type="text" name="last_name" class="form-control" required="required"
                                                placeholder="<?php echo e(__('Soyadınız')); ?>" value="<?php echo e(old('last_name')); ?>">

                                            <?php if($errors->has('last_name')): ?> <span class="help-block">
                                            <strong><?php echo e($errors->first('last_name')); ?></strong> </span> <?php endif; ?>
                                        </div>

                                        <div class="formrow<?php echo e($errors->has('email') ? ' has-error' : ''); ?>">

                                            <input type="email" name="email" class="form-control" required="required"
                                                placeholder="<?php echo e(__('E-posta Adresiniz')); ?>" value="<?php echo e(old('email')); ?>">

                                            <?php if($errors->has('email')): ?> <span class="help-block">
                                            <strong><?php echo e($errors->first('email')); ?></strong> </span> <?php endif; ?>
                                        </div>

                                        <div class="formrow<?php echo e($errors->has('password') ? ' has-error' : ''); ?>">

                                            <input type="password" name="password" class="form-control" required="required"
                                                placeholder="<?php echo e(__('Şifre')); ?>" value="">

                                            <?php if($errors->has('password')): ?> <span class="help-block">
                                            <strong><?php echo e($errors->first('password')); ?></strong> </span> <?php endif; ?>
                                        </div>

                                        <div class="formrow<?php echo e($errors->has('password_confirmation') ? ' has-error' : ''); ?>">

                                            <input type="password" name="password_confirmation" class="form-control"
                                                required="required" placeholder="<?php echo e(__('Şifre Onayı')); ?>" value="">

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
                                            <?php echo e(__('Bültene Abone Ol')); ?>


                                            <?php if($errors->has('is_subscribed')): ?> <span class="help-block">
                                            <strong><?php echo e($errors->first('is_subscribed')); ?></strong> </span> <?php endif; ?>
                                        </div>





                                        <div class="formrow<?php echo e($errors->has('terms_of_use') ? ' has-error' : ''); ?>">

                                            <input type="checkbox" value="1" name="terms_of_use" id="terms_of_use"
                                                required />
                                            <label for="terms_of_use"><a href="<?php echo e(url('cms/kullanim-kosullari')); ?>"
                                                    target="_blank"><?php echo e(__('Kullanım Koşullarını')); ?></a>
                                                <?php echo e(__('ve')); ?>

                                                <a href="<?php echo e(url('cms/kvkk-aydinlatma-metni')); ?>"
                                                    target="_blank"><?php echo e(__('KVKK Aydınlatma Metni\'ni')); ?></a>
                                                <?php echo e(__('kabul ediyorum')); ?>

                                            </label>



                                            <?php if($errors->has('terms_of_use')): ?> <span class="help-block">
                                            <strong><?php echo e($errors->first('terms_of_use')); ?></strong> </span> <?php endif; ?>
                                        </div>

                                        

                                        <div
                                            class="form-group mb-3 <?php echo e($errors->has('g-recaptcha-response') ? ' has-error' : ''); ?>">
                                            <?php echo app('captcha')->display(); ?>

                                            <?php if($errors->has('g-recaptcha-response')): ?> <span class="help-block">
                                            <strong><?php echo e($errors->first('g-recaptcha-response')); ?></strong> </span> <?php endif; ?>
                                        </div>






                                        <input type="submit" class="btn" value="<?php echo e(__('Kayıt Ol')); ?>">

                                    </form>

                                </div>



                            </div>

                            <!-- sign up form -->

                            <div class="newuser"><i class="fas fa-user" aria-hidden="true"></i>
                                <?php echo e(__('Zaten hesabınız var mı?')); ?> <a href="<?php echo e(route('login')); ?>"><?php echo e(__('Giriş Yap')); ?></a></div>

                            <!-- sign up form end-->



                        </div>

                    </div>
                </div>





            </div>



        </div>

    </div>

    <?php echo $__env->make('includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php $__env->startPush('scripts'); ?>
        <script>
            // Parent groups mapped by type
            var parentGroupsByType = {
                'personnel': <?php echo \App\Models\OccupationGroup::whereNull('parent_id')->where('is_active', 1)->where('type', 'service')->get(['id', 'name'])->toJson(); ?>,
                'caregiver': <?php echo \App\Models\OccupationGroup::whereNull('parent_id')->where('is_active', 1)->where('type', 'caregiver')->get(['id', 'name'])->toJson(); ?>

            };

            // Sub occupations mapped by parent_id
            var occupationMap = <?php echo \App\Models\OccupationGroup::whereNotNull('parent_id')->get()->groupBy('parent_id')->toJson(); ?>;

            function toggleOccupationGroup(val) {
                var parentSelect = $('#parent_occupation_id');

                if (val == 'personnel' || val == 'caregiver') {
                    $('#occupation_group_wrap').show();
                    $('#parent_occupation_id').attr('required', 'required');

                    // Populate parent options based on type
                    parentSelect.empty();
                    parentSelect.append('<option value="">' + <?php echo json_encode(__('Meslek Alanınızı Seçin'), 15, 512) ?> + '</option>');
                    var groups = parentGroupsByType[val] || [];
                    groups.forEach(function (item) {
                        parentSelect.append('<option value="' + item.id + '">' + item.name + '</option>');
                    });

                } else {
                    $('#occupation_group_wrap').hide();
                    $('#parent_occupation_id').removeAttr('required');
                    parentSelect.empty();
                }
            }

            $(document).ready(function () {
                toggleOccupationGroup($('#user_type').val());

                var oldParentId = <?php echo json_encode(old('parent_occupation_id'), 15, 512) ?>;
                if (oldParentId) {
                    $('#parent_occupation_id').val(String(oldParentId));
                }
            });
        </script>
    <?php $__env->stopPush(); ?>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/personelnoktasit/public_html/resources/views/auth/register.blade.php ENDPATH**/ ?>