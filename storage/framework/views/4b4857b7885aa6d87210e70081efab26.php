
<?php $__env->startSection('content'); ?>
<div class="login-title">
    <h2>Hoş Geldiniz</h2>
    <p>Devam etmek için giriş yapın</p>
</div>

<?php if($errors->has('email')): ?>
<div class="alert alert-danger">
    <i class="fa fa-exclamation-circle"></i> <?php echo e($errors->first('email')); ?>

</div>
<?php endif; ?>

<?php if($errors->has('password')): ?>
<div class="alert alert-danger">
    <i class="fa fa-exclamation-circle"></i> <?php echo e($errors->first('password')); ?>

</div>
<?php endif; ?>

<form method="POST" action="<?php echo e(route('admin.login')); ?>">
    <?php echo e(csrf_field()); ?>

    
    <div class="form-group">
        <label for="email">E-Posta Adresi</label>
        <div class="input-icon">
            <i class="fa fa-envelope"></i>
            <input type="email" class="form-control" id="email" name="email" placeholder="ornek@email.com" value="<?php echo e(old('email')); ?>" required autofocus>
        </div>
    </div>
    
    <div class="form-group">
        <label for="password">Şifre</label>
        <div class="input-icon">
            <i class="fa fa-lock"></i>
            <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
        </div>
    </div>
    
    <button type="submit" class="btn-login">
        <i class="fa fa-sign-in"></i> Giriş Yap
    </button>
    
    <div class="form-footer">
        <label class="remember-me">
            <input type="checkbox" name="remember"> Beni Hatırla
        </label>
        <a href="<?php echo e(route('admin.password.request')); ?>" class="forgot-password">Şifremi Unuttum?</a>
    </div>
</form>
<?php $__env->stopSection(); ?>








<?php echo $__env->make('admin.layouts.login_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/personelnoktasit/public_html/resources/views/admin/auth/login.blade.php ENDPATH**/ ?>