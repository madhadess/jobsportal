
<?php $__env->startSection('content'); ?> 
<!-- Header start --> 
<?php echo $__env->make('includes.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
<!-- Header end --> 



<div class="pageSearch text-center">
            <h3><?php echo e(__('En yüksek puanlı şirketlerde işe alının')); ?>.</h3>
            </div>




<div class="listpgWraper">
<div class="container">

    <div class="row">
        <div class="col-lg-3">



      
                
                <form id="top-search" method="GET" action="<?php echo e(route('company.listing')); ?>">    
                                  
                <div class="compnysidebarserch">           
                    <h4><?php echo e(__('Arama Filtresi')); ?></h4>
                    <div class="mb-3">                        
                    <input type="text" name="search" value="<?php echo e(Request::get('search', '')); ?>" class="form-control" placeholder="<?php echo e(__('keywords e.g. "Google"')); ?>" />  
                    </div>
                    <div class="mb-3">
                        <label for=""><?php echo e(__('Ülke')); ?></label>
                        <?php echo Form::select('country_id[]', ['' => __('Select Country')]+$countries, Request::get('country_id', $siteSetting->default_country_id), array('class'=>'form-control', 'id'=>'country_id')); ?>

                    </div>
                    <div class="mb-3">
                        <label for=""><?php echo e(__('Şehir')); ?></label>
                        <span id="state_dd">
                <?php echo Form::select('state_id[]', ['' => __('Select State')], Request::get('state_id', null), array('class'=>'form-control', 'id'=>'state_id')); ?>

                </span>
                    </div>
                    <div class="mb-3">
                        <label for=""><?php echo e(__('İlçe')); ?></label>
                        <span id="city_dd">
                    <?php echo Form::select('city_id[]', ['' => __('Select City')], Request::get('city_id', null), array('class'=>'form-control', 'id'=>'city_id')); ?>

                </span>
                    </div>

                    <div class="mb-3">
                    <label for=""><?php echo e(__('Sektör')); ?></label>
                    <ul class="optionlist">
                        <?php $__currentLoopData = $industries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $industry): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <input type="checkbox" name="industry_id[]" id="industry_id_<?php echo e($key); ?>" value="<?php echo e($key); ?>" <?php echo e(in_array($key, (array)old('industry_id', $industry_id)) ? 'checked' : ''); ?>>
                                <label for="industry_id_<?php echo e($key); ?>"></label>
                                <?php echo e($industry['name']); ?> <span><?php echo e($industry['count']); ?></span>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    </div>

                    <div class="comfilter">
                    <button type="submit" id="submit-form-top" class="btn"><i class="fa fa-search" aria-hidden="true"></i> <?php echo e(__('Search Company')); ?></button>
                    </div>

                </div>
                
                
                </form>
         



        </div>
        <div class="col-lg-9">



            <h3><?php echo e($companies->total()); ?> <?php echo e(__('İşveren Bulundu')); ?></h3>
            <div class="showreslt mb-4">
                        <?php echo e(__('Showing Companies')); ?> : <?php echo e($companies->firstItem()); ?> - <?php echo e($companies->lastItem()); ?> <?php echo e(__('Total')); ?> <?php echo e($companies->total()); ?>

                    </div>

        <ul class="row compnaieslist">
            <?php if($companies->isEmpty()): ?>
                <p><?php echo e(__('Aktif ve doğrulanmış şirket bulunamadı.')); ?></p>
            <?php else: ?>
            <?php $__currentLoopData = $companies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>   
            <li class="col-lg-4 col-md-6">                
                        <div class="empint">
                        <a href="<?php echo e(route('company.detail', $company->slug)); ?>" title="<?php echo e($company->name); ?>">
                            <div class="emptbox">
                            <div class="comimg"><?php echo e($company->printCompanyImage()); ?></div>
                                <div class="text-info-right">
                                <h4><?php echo e($company->name); ?></h4>	
                                <?php if($company->getIndustry('industry')): ?>
                                    <div class="indst">                           
                                        <?php echo e($company->getIndustry('industry')); ?>                         
                                    </div>
                                <?php endif; ?>
                                <div class="emloc"><i class="fas fa-map-marker-alt"></i> <?php echo e($company->getCity('city')); ?></div>
                                </div>	                                        
                            

                            <div class="cm-info-bottom"><span><i class="fas fa-briefcase"></i> <?php echo e($company->countNumJobs('company_id',$company->id)); ?> <?php echo e(__('Open Jobs')); ?></span></div>	
                            </div>
                        </a>					
                        </div>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>

        </ul>
	    <div class="pagiWrap">
            <div class="row">
                <div class="col-md-5">
                    <div class="showreslt">
                        <?php echo e(__('Showing Companies')); ?> : <?php echo e($companies->firstItem()); ?> - <?php echo e($companies->lastItem()); ?> <?php echo e(__('Total')); ?> <?php echo e($companies->total()); ?>

                    </div>
                </div>
                <div class="col-md-7 text-right">
                    <?php if(isset($companies) && count($companies)): ?>
                    <?php echo e($companies->appends(request()->query())->links()); ?>

                    <?php endif; ?>
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
    .formrow iframe {
        height: 78px;
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?> 

<?php echo $__env->make('includes.country_state_city_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('click', '#send_company_message', function () {
            var postData = $('#send-company-message-form').serialize();
            $.ajax({
                type: 'POST',
                url: "<?php echo e(route('contact.company.message.send')); ?>",
                data: postData,
                //dataType: 'json',
                success: function (data)
                {
                    response = JSON.parse(data);
                    var res = response.success;
                    if (res == 'success')
                    {
                        var errorString = '<div role="alert" class="alert alert-success">' + response.message + '</div>';
                        $('#alert_messages').html(errorString);
                        $('#send-company-message-form').hide('slow');
                        $(document).scrollTo('.alert', 2000);
                    } else
                    {
                        var errorString = '<div class="alert alert-danger" role="alert"><ul>';
                        response = JSON.parse(data);
                        $.each(response, function (index, value)
                        {
                            errorString += '<li>' + value + '</li>';
                        });
                        errorString += '</ul></div>';
                        $('#alert_messages').html(errorString);
                        $(document).scrollTo('.alert', 2000);
                    }
                },
            });
        });
    });
</script> 
<?php $__env->stopPush(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/personelnoktasit/public_html/resources/views/company/listing.blade.php ENDPATH**/ ?>