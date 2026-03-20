
<?php $__env->startSection('content'); ?>
<div class="page-content-wrapper"> 
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content"> 
        <!-- BEGIN PAGE HEADER--> 
        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li> <a href="<?php echo e(route('admin.home')); ?>">Ana Sayfa</a> <i class="fa fa-circle"></i> </li>
                <li> <a href="<?php echo e(route('list.cms')); ?>">CMS</a> <i class="fa fa-circle"></i> </li>
                <li> <span>CMS Sayfasını Düzenle</span> </li>
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
                        <div class="caption font-red-sunglo"> <i class="icon-settings font-red-sunglo"></i> <span class="caption-subject bold uppercase">CMS Formu</span> </div>
                    </div>
                    <div class="portlet-body form">          
                        <ul class="nav nav-tabs">              
                            <li class="Aktif"> <a href="#Details" data-toggle="tab" aria-expanded="false"> Detaylar </a> </li>
                            <li class=""> <a href="#seo" data-toggle="tab" aria-expanded="false"> S.E.O </a> </li>
                        </ul>
                        <?php echo Form::model($cms, array('method' => 'put', 'route' => array('update.cms', $cms->id), 'class' => 'form', 'files'=>true)); ?>

                        <?php echo Form::hidden('id', $cms->id); ?>            
                        <div class="tab-content">              
                            <div class="tab-pane fade active in" id="Details"> <?php echo $__env->make('admin.cms.forms.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </div>
                            <div class="tab-pane fade" id="seo"> <?php echo $__env->make('admin.cms.forms.seo_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </div>
                        </div>
                        <div class="form-Actionler">
                            <?php echo Form::button('Update <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>', array('class'=>'btn btn-large btn-primary', 'type'=>'submit')); ?>

                        </div>
                        <?php echo Form::close(); ?>

                    </div>
                </div>
            </div>
        </div>
        <!-- END CONTENT BODY --> 
    </div>
    <?php $__env->stopSection(); ?>








<?php echo $__env->make('admin.layouts.admin_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/personelnoktasit/public_html/resources/views/admin/cms/edit.blade.php ENDPATH**/ ?>