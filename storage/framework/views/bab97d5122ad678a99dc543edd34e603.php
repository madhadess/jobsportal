
<?php $__env->startSection('content'); ?> 
<!-- Header start --> 
<?php echo $__env->make('includes.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
<!-- Header end --> 
<!-- Inner Page Title start --> 
<?php echo $__env->make('includes.inner_page_title', ['page_title'=>__('İlan Detayları')], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
<!-- Inner Page Title end -->
<div class="listpgWraper">
    <div class="container">
        <div class="row">
            <?php echo $__env->make('includes.company_dashboard_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <div class="col-md-9 col-sm-8"> 
                <div class="row">
                    <div class="col-md-12">
                        <div class="userccount">
                            <div class="formpanel mt-0"> <?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
                                <!-- Personal Information -->
                                <?php echo $__env->make('job.inc.job', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $__env->make('includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('styles'); ?>
<style type="text/css">
    .userccount p{ text-align:left !important;}
    
    /* Form stilleri */
    .formpanel {
        background-color: #fff;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
    }
    
    .formrow {
        margin-bottom: 15px;
    }
    
    .formrow label {
        display: block;
        font-weight: 600;
        margin-bottom: 5px;
        color: #333;
    }
    
    .form-control {
        display: block;
        width: 100%;
        padding: 10px 12px;
        font-size: 14px;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ced4da;
        border-radius: 4px;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    
    .form-control:focus {
        border-color: #80bdff;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }
    
    .radio-list {
        padding: 10px 0;
    }
    
    .radio-inline {
        display: inline-block;
        margin-right: 15px;
        margin-bottom: 0;
        vertical-align: middle;
        cursor: pointer;
    }
    
    .radio-inline input[type="radio"] {
        margin-right: 5px;
    }
    
    .btn {
        display: inline-block;
        padding: 12px 24px;
        margin-bottom: 0;
        font-size: 14px;
        font-weight: 600;
        line-height: 1.5;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        cursor: pointer;
        border: 1px solid transparent;
        border-radius: 4px;
        text-decoration: none;
        transition: all 0.3s ease;
    }
    
    .btn-primary {
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
    }
    
    .btn-primary:hover {
        color: #fff;
        background-color: #0056b3;
        border-color: #004085;
    }
    
    .select2-multiple {
        min-height: 38px;
    }
    
    .datepicker {
        position: relative;
    }
    
    @media (max-width: 768px) {
        .formpanel {
            padding: 15px;
        }
        
        .form-control {
            padding: 8px 10px;
            font-size: 13px;
        }
        
        .btn {
            padding: 10px 20px;
            font-size: 13px;
        }
    }
</style>
<?php $__env->stopPush(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/personelnoktasit/public_html/resources/views/job/add_edit_job.blade.php ENDPATH**/ ?>