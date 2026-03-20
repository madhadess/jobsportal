<?php
$lang = config('default_lang');
$direction = MiscHelper::getLangDirection($lang);
?>

<?php $__env->startSection('content'); ?>
<div class="page-content-wrapper"> 
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content"> 
        <!-- BEGIN PAGE HEADER--> 
        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li> <a href="<?php echo e(route('admin.home')); ?>">Ana Sayfa</a> <i class="fa fa-circle"></i> </li>        
                <li> <span>Site Ayarlarını Düzenle</span> </li>
            </ul>
        </div>
        <!-- END PAGE BAR --> 
        <!-- BEGIN PAGE TITLE-->
        <!--<h3 class="page-title">Edit User <small>Users</small> </h3>-->
        <!-- END PAGE TITLE--> 
        <!-- END PAGE HEADER-->
        <br />
        <?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-red-sunglo"> <i class="icon-settings font-red-sunglo"></i> <span class="caption-subject bold uppercase">Site Ayarları Formu</span> </div>
                    </div>
                    <div class="portlet-body form">          
                        <ul class="nav nav-tabs">              
                            <li class="Aktif"> <a href="#site" data-toggle="tab" aria-expanded="false"> Site </a> </li>              
                            <li class=""> <a href="#email" data-toggle="tab" aria-expanded="false"> E-posta </a> </li>
                            <li class=""> <a href="#social" data-toggle="tab" aria-expanded="false"> Sosyal Ağlar </a> </li>
                            <li class=""> <a href="#ads" data-toggle="tab" aria-expanded="false"> Reklam Yönetimi </a> </li>
                            <li class=""> <a href="#captcha" data-toggle="tab" aria-expanded="false"> Captcha </a> </li>
                            <li class=""> <a href="#socialMediaLogin" data-toggle="tab" aria-expanded="false"> Sosyal Medya Girişi </a> </li>
                            <li class=""> <a href="#paymentGateways" data-toggle="tab" aria-expanded="false"> Ödeme Sistemleri </a> </li>
                            <li class=""> <a href="#homePageSlider" data-toggle="tab" aria-expanded="false"> Ana Sayfa Slider </a> </li>
                            <li class=""> <a href="#googleAnalytics" data-toggle="tab" aria-expanded="false"> Google Analytics </a> </li>  
                        </ul>
                        <?php echo Form::model($siteSetting, array('method' => 'put', 'route' => array('update.site.setting'), 'class' => 'form', 'files'=>true)); ?>

                        <div class="tab-content">              
                            <div class="tab-pane fade active in" id="site"> <?php echo $__env->make('admin.site_setting.forms.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </div>
                            <div class="tab-pane fade" id="email"> <?php echo $__env->make('admin.site_setting.forms.siteEmailSetting_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </div>
                            <div class="tab-pane fade" id="social"> <?php echo $__env->make('admin.site_setting.forms.siteSocialSetting_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </div>
                            <div class="tab-pane fade" id="ads"> <?php echo $__env->make('admin.site_setting.forms.siteAds_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </div>
                            <div class="tab-pane fade" id="captcha"> <?php echo $__env->make('admin.site_setting.forms.captchaSetting_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </div>
                            <div class="tab-pane fade" id="socialMediaLogin"> <?php echo $__env->make('admin.site_setting.forms.socialMediaLoginSetting_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </div>
                            <div class="tab-pane fade" id="paymentGateways"> <?php echo $__env->make('admin.site_setting.forms.paymentGatewaysSetting_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </div>
                            <div class="tab-pane fade" id="homePageSlider"> <?php echo $__env->make('admin.site_setting.forms.homePageSliderSetting_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </div>
                            <div class="tab-pane fade" id="googleAnalytics"> <?php echo $__env->make('admin.site_setting.forms.googleAnalytics_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </div>
                        </div>
                        <div class="form-Actionler">
                            <?php echo Form::button('Güncelle <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>', array('class'=>'btn btn-large btn-primary', 'type'=>'submit')); ?>

                        </div>
                        <?php echo Form::close(); ?>

                    </div>
                </div>
            </div>
        </div>
        <!-- END CONTENT BODY --> 
    </div>
    <?php $__env->stopSection(); ?>
    <?php $__env->startPush('scripts'); ?>
    <?php echo $__env->make('admin.shared.tinyMCE', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php $__env->stopPush(); ?>








<?php echo $__env->make('admin.layouts.admin_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/personelnoktasit/public_html/resources/views/admin/site_setting/edit.blade.php ENDPATH**/ ?>