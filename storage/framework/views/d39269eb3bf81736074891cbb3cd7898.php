
<?php $__env->startSection('content'); ?>
<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content"> 
        <!-- BEGIN PAGE HEADER--> 
        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li> <a href="<?php echo e(route('admin.home')); ?>">Ana Sayfa</a> <i class="fa fa-circle"></i> </li>
                <li> <a href="<?php echo e(route('list.packages')); ?>">Paketler</a> <i class="fa fa-circle"></i> </li>
                <li> <span>Paket Düzenle</span> </li>
            </ul>
        </div>
        <!-- END PAGE BAR --> 
        <!-- END PAGE HEADER--> 
        <br />
        <?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-red-sunglo"> <i class="icon-settings font-red-sunglo"></i> <span class="caption-subject bold uppercase">Paket Formu</span> </div>
                    </div>
                    <div class="portlet-body form">
                        <ul class="nav nav-tabs">
                            <li class="Aktif"> <a href="#Details" data-toggle="tab" aria-expanded="false"> Detaylar </a> </li>
                        </ul>
                        <?php echo Form::model($package, array('method' => 'put', 'route' => array('update.package', $package->id), 'class' => 'form', 'files'=>true)); ?>

                        <?php echo Form::hidden('id', $package->id); ?>

                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="Details"> <?php echo $__env->make('admin.package.forms.form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> </div>
                        </div>
                        <?php echo Form::close(); ?> </div>
                </div>
            </div>
        </div>
        <!-- END CONTENT BODY --> 
    </div>
    <?php $__env->stopSection(); ?>








<?php echo $__env->make('admin.layouts.admin_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/personelnoktasit/public_html/resources/views/admin/package/edit.blade.php ENDPATH**/ ?>