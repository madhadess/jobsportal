<?php echo APFrmErrHelp::showErrorsNotice($errors); ?>

<?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div class="form-body">
    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'index_page_below_top_employes_ad'); ?>">
        <?php echo Form::label('index_page_below_top_employes_ad', 'Ana Sayfa En İyi İşverenler Altı', ['class' => 'bold']); ?>

        <?php echo Form::textarea('index_page_below_top_employes_ad', null, array('class' => 'form-control', 'id' => 'index_page_below_top_employes_ad', 'placeholder' => 'Ana Sayfa En İyi İşverenler Altı')); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'index_page_below_top_employes_ad'); ?>

    </div>
    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'above_footer_ad'); ?>">
        <?php echo Form::label('above_footer_ad', 'Ana Sayfa Şehirler Altı', ['class' => 'bold']); ?>

        <?php echo Form::textarea('above_footer_ad', null, array('class' => 'form-control', 'id' => 'above_footer_ad', 'placeholder' => 'Ana Sayfa Şehirler Altı')); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'above_footer_ad'); ?>

    </div>
    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'dashboard_page_ad'); ?>">
        <?php echo Form::label('dashboard_page_ad', 'Panel Menü Altı Dikey Reklam', ['class' => 'bold']); ?>

        <?php echo Form::textarea('dashboard_page_ad', null, array('class' => 'form-control', 'id' => 'dashboard_page_ad', 'placeholder' => 'Panel Menü Altı Dikey Reklam')); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'dashboard_page_ad'); ?>

    </div>
    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'cms_page_ad'); ?>">
        <?php echo Form::label('cms_page_ad', 'CMS Sayfa İçerik Altı Reklam', ['class' => 'bold']); ?>

        <?php echo Form::textarea('cms_page_ad', null, array('class' => 'form-control', 'id' => 'cms_page_ad', 'placeholder' => 'CMS Sayfa İçerik Altı Reklam')); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'cms_page_ad'); ?>

    </div>
    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'listing_page_vertical_ad'); ?>">
        <?php echo Form::label('listing_page_vertical_ad', 'Listeleme Sayfası Yan Panel Dikey Reklam', ['class' => 'bold']); ?>

        <?php echo Form::textarea('listing_page_vertical_ad', null, array('class' => 'form-control', 'id' => 'listing_page_vertical_ad', 'placeholder' => 'Listeleme Sayfası Yan Panel Dikey Reklam')); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'listing_page_vertical_ad'); ?>

    </div>
    <div class="form-group <?php echo APFrmErrHelp::hasError($errors, 'listing_page_horizontal_ad'); ?>">
        <?php echo Form::label('listing_page_horizontal_ad', 'Listeleme Sayfası İlanların Altı Yatay Reklam', ['class' => 'bold']); ?>

        <?php echo Form::textarea('listing_page_horizontal_ad', null, array('class' => 'form-control', 'id' => 'listing_page_horizontal_ad', 'placeholder' => 'Listeleme Sayfası İlanların Altı Yatay Reklam')); ?>

        <?php echo APFrmErrHelp::showErrors($errors, 'listing_page_horizontal_ad'); ?>

    </div>
</div><?php /**PATH /home/personelnoktasit/public_html/resources/views/admin/site_setting/forms/siteAds_form.blade.php ENDPATH**/ ?>