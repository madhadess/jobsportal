<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="utf-8" />
    <title><?php echo e($siteSetting->site_name); ?> | Admin Giriş</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="<?php echo e(asset('/')); ?>admin_assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('/')); ?>admin_assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="<?php echo e(asset('/')); ?>favicon.ico" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
            overflow: hidden;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 50%);
            animation: pulse 15s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
        
        .login-wrapper {
            display: flex;
            width: 100%;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }
        
        .login-left {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 60px;
            color: #fff;
        }
        
        .login-left h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 28px;
            text-shadow: 0 4px 20px rgba(0,0,0,0.3);
            letter-spacing: -0.5px;
        }
        
        .login-left p {
            font-size: 1.4rem;
            opacity: 1;
            max-width: 480px;
            text-align: center;
            line-height: 1.9;
            font-weight: 400;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        
        .login-left .features {
            margin-top: 50px;
            display: flex;
            gap: 30px;
        }
        
        .login-left .feature-item {
            text-align: center;
        }
        
        .login-left .feature-item i {
            font-size: 2.8rem;
            margin-bottom: 14px;
            display: block;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        
        .login-left .feature-item span {
            font-size: 1.2rem;
            opacity: 1;
            font-weight: 500;
            text-shadow: 0 1px 5px rgba(0,0,0,0.2);
        }
        
        .login-right {
            width: 500px;
            min-height: 100vh;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px;
            box-shadow: -20px 0 60px rgba(0,0,0,0.1);
        }
        
        .login-logo {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .login-logo img {
            max-height: 60px;
            width: auto;
        }
        
        .login-title {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .login-title h2 {
            font-size: 2.4rem;
            font-weight: 700;
            color: #111827;
            margin-bottom: 14px;
            letter-spacing: -0.3px;
        }
        
        .login-title p {
            color: #6b7280;
            font-size: 1.2rem;
            font-weight: 400;
        }
        
        .form-group {
            margin-bottom: 28px;
        }
        
        .form-group label {
            display: block;
            font-size: 1.1rem;
            font-weight: 600;
            color: #1f2937;
            margin-bottom: 12px;
        }
        
        .form-control {
            width: 100%;
            padding: 18px 22px;
            font-size: 1.1rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            transition: all 0.3s ease;
            background: #f9fafb;
            color: #111827;
        }
        
        .form-control:focus {
            outline: none;
            border-color: #667eea;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }
        
        .form-control::placeholder {
            color: #9ca3af;
        }
        
        .input-icon {
            position: relative;
        }
        
        .input-icon i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #9ca3af;
            font-size: 1.1rem;
        }
        
        .input-icon .form-control {
            padding-left: 50px;
        }
        
        .btn-login {
            width: 100%;
            padding: 20px;
            font-size: 1.2rem;
            font-weight: 600;
            color: #fff;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
            letter-spacing: 0.3px;
        }
        
        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
        }
        
        .btn-login:active {
            transform: translateY(0);
        }
        
        .form-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 1.05rem;
            color: #4b5563;
            cursor: pointer;
            font-weight: 500;
        }
        
        .remember-me input[type="checkbox"] {
            width: 20px;
            height: 20px;
            accent-color: #667eea;
        }
        
        .forgot-password {
            font-size: 1.05rem;
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }
        
        .forgot-password:hover {
            text-decoration: underline;
        }
        
        .alert {
            padding: 14px 18px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
        
        .alert-danger {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
        }
        
        .copyright {
            text-align: center;
            margin-top: 40px;
            color: #9ca3af;
            font-size: 0.85rem;
        }
        
        @media (max-width: 992px) {
            .login-left {
                display: none;
            }
            .login-right {
                width: 100%;
                max-width: 100%;
            }
        }
        
        @media (max-width: 576px) {
            .login-right {
                padding: 40px 24px;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-left">
            <h1><?php echo e($siteSetting->site_name); ?></h1>
            <p>Yönetim panelinize hoş geldiniz. Güvenli ve modern arayüz ile sisteminizi kolayca yönetin.</p>
            <div class="features">
                <div class="feature-item">
                    <i class="fa fa-shield"></i>
                    <span>Güvenli</span>
                </div>
                <div class="feature-item">
                    <i class="fa fa-bolt"></i>
                    <span>Hızlı</span>
                </div>
                <div class="feature-item">
                    <i class="fa fa-cogs"></i>
                    <span>Kolay</span>
                </div>
            </div>
        </div>
        <div class="login-right">
            <div class="login-logo">
                <img src="<?php echo e(asset('/')); ?>sitesetting_images/mid/<?php echo e($siteSetting->site_logo); ?>" alt="<?php echo e($siteSetting->site_name); ?>" />
            </div>
            <?php echo $__env->yieldContent('content'); ?>
            <div class="copyright"><?php echo e(date('Y')); ?> © <?php echo e($siteSetting->site_name); ?>. Tüm hakları saklıdır.</div>
        </div>
    </div>
    
    <script src="<?php echo e(asset('/')); ?>admin_assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo e(asset('/')); ?>admin_assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo e(asset('/')); ?>admin_assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
</body>
</html>







<?php /**PATH /home/personelnoktasit/public_html/resources/views/admin/layouts/login_layout.blade.php ENDPATH**/ ?>