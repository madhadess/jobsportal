

<?php $__env->startSection('content'); ?> 

<!-- Header start --> 

<?php echo $__env->make('includes.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 

<!-- Header end --> 



<?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('includes.inner_top_search', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



<!-- Inner Page Title end -->

<div class="listpgWraper">

    <div class="container">

        

        <form action="<?php echo e(route('job.list')); ?>" method="get">

            <!-- Search Result and sidebar start -->

            <div class="row"> 

                <?php echo $__env->make('includes.job_list_side_bar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                

                <div class="col-lg-9"> 

                    <!-- Search List -->
                     <h3><?php echo e($jobs->total()); ?> İş İlanı Bulundu</h3>    
                    <div class="topstatinfo mb-0">
                    <?php echo e(__('Showing Jobs')); ?> : <?php echo e($jobs->firstItem()); ?> - <?php echo e($jobs->lastItem()); ?> <?php echo e(__('Total')); ?> <?php echo e($jobs->total()); ?>

                    </div>

                    <ul class="featuredlist row">

                        <!-- job start --> 

                        <?php if(isset($jobs) && count($jobs)): ?> <?php $count_1 = 1; ?> 
                        <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $job): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                        <?php $company = $job->getCompany();
                        ?>

                             <?php if(isset($company))
                            {
                            ?>

                            <?php if($count_1 == 7) {?>

                                <li class="col-lg-12"><div class="jobint text-center"><?php echo $siteSetting->listing_page_horizontal_ad; ?></div></li>

                            <?php }else{ ?>

                          
                                


              <li class="col-lg-4 col-md-6 <?php if($job->is_featured == 1): ?> featured <?php endif; ?>">
                <div class="jobint">
                <?php if($job->is_featured == 1): ?> <span class="promotepof-badge"><i class="fa fa-bolt" title="<?php echo e(__('This Job is Featured')); ?>"></i></span> <?php endif; ?>
                


                    <div class="d-flex">
                        <div class="fticon"><i class="fas fa-briefcase"></i> <?php echo e($job->getJobType('job_type')); ?></div>                        
                    </div>

                    <h4><a href="<?php echo e(route('job.detail', [$job->slug])); ?>" title="<?php echo e($job->title); ?>"><?php echo \Illuminate\Support\Str::limit($job->title, $limit = 20, $end = '...'); ?></a>
                    
                    
                </h4>
                <?php if(!(bool)$job->hide_salary): ?>                    
                    <div class="salary mb-2">Maaş: <strong><?php echo e($job->getSalaryRange()); ?>/<?php echo e($job->getSalaryPeriod('salary_period')); ?></strong></div>
                    <?php endif; ?> 


                    <strong><i class="fas fa-map-marker-alt"></i> <?php echo e($job->getCity('city')); ?></strong> 
                    
                    <div class="jobcompany">
                     <div class="ftjobcomp">
                        <span><?php echo e($job->created_at->translatedFormat('d F Y')); ?></span>
                        <a href="<?php echo e(route('company.detail', $company->slug)); ?>" title="<?php echo e($company->name); ?>"><?php echo e($company->name); ?></a>
                     </div>
                    <a href="<?php echo e(route('company.detail', $company->slug)); ?>" class="company-logo" title="<?php echo e($company->name); ?>"><?php echo e($company->printCompanyImage()); ?> </a>
                    </div>
                </div>
            </li>







						 <?php } ?>

                            <?php $count_1++; ?>

						

						 <?php } ?>

                        <!-- job end --> 

                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>

						

						

						

                           

                       

                            <!-- job end -->

                            

						

						

						

                    </ul>



                    <!-- Pagination Start -->

                    <div class="pagiWrap mt-5">

                        <div class="row">

                            <div class="col-lg-5">

                                <div class="showreslt">

                                    <?php echo e(__('Showing Jobs')); ?> : <?php echo e($jobs->firstItem()); ?> - <?php echo e($jobs->lastItem()); ?> <?php echo e(__('Total')); ?> <?php echo e($jobs->total()); ?>


                                </div>

                            </div>

                            <div class="col-lg-7 text-right">

                                <?php if(isset($jobs) && count($jobs)): ?>

                                <?php echo e($jobs->appends(request()->query())->links()); ?>


                                <?php endif; ?>

                            </div>

                        </div>

                    </div>

                    <!-- Pagination end --> 

                   



                </div>

            </div>

        </form>

    </div>

</div>


<?php if(Request::get('search') != '' || Request::get('functional_area_id') != '' || Request::get('country_id') != ''|| Request::get('state_id') != '' || Request::get('city_id') != ''|| Request::get('city_id') != ''): ?>

<div class="modal fade" id="show_alert" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <form id="submit_alert">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="search" value="<?php echo e(Request::get('search')); ?>">
                <input type="hidden" name="country_id" value="<?php if(isset(Request::get('country_id')[0])): ?> <?php echo e(Request::get('country_id')[0]); ?> <?php endif; ?>">
                <input type="hidden" name="state_id" value="<?php if(isset(Request::get('state_id')[0])): ?><?php echo e(Request::get('state_id')[0]); ?> <?php endif; ?>">
                <input type="hidden" name="city_id" value="<?php if(isset(Request::get('city_id')[0])): ?><?php echo e(Request::get('city_id')[0]); ?> <?php endif; ?>">
                <input type="hidden" name="functional_area_id" value="<?php if(isset(Request::get('functional_area_id')[0])): ?><?php echo e(Request::get('functional_area_id')[0]); ?> <?php endif; ?>">
                <div class="modal-header">
                    <h4 class="modal-title"><?php echo e(__('Job Alert')); ?></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
					<h3><?php echo e(__('Get the latest')); ?> <strong>"<?php echo e(ucfirst(Request::get('search'))); ?>"</strong> <?php echo e(__('jobs sent straight to your inbox')); ?> <?php if(Request::get('location')!=''): ?> in <strong><?php echo e(ucfirst(Request::get('location'))); ?></strong><?php endif; ?></h3>
                    <div class="form-group">
                        <input type="text" class="form-control" name="email" id="email" placeholder="<?php echo e(__('Enter your Email')); ?>" value="<?php if(Auth::check()): ?><?php echo e(Auth::user()->email); ?><?php endif; ?>">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
                    <button type="submit" class="btn btn-primary"><?php echo e(__('Submit')); ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php endif; ?>


<?php echo $__env->make('includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>

<style type="text/css">

    .searchList li .jobimg {

        min-height: 80px;

    }

    .hide_vm_ul{

        height:100px;

        overflow:hidden;

    }

    .hide_vm{

        display:none !important;

    }

    .view_more{

        cursor:pointer;

    }

</style>

<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?> 

<script>
$('.btn-job-alert').on('click', function() {
	<?php if(Auth::user()): ?>
	$('#show_alert').modal('show');
	<?php else: ?>
	swal({
		title: "İş Uyarılarını Kaydet",
		text: "İş Uyarılarını kaydetmek için Kayıtlı ve Giriş Yapmış olmalısınız",
		icon: "error",
		buttons: {
			Login: "Giriş Yap",
			register: "Kayıt Ol",
			hello: "OK",
		},
	});
	<?php endif; ?>

})

$(document).ready(function($) {
	$("#search-job-list").submit(function() {
		$(this).find(":input").filter(function() {
			return !this.value;
		}).attr("disabled", "disabled");
		return true;
	});


	$("#search-job-list").find(":input").prop("disabled", false);

	$(".view_more_ul").each(function () {
    if ($(this).height() > 100) {
        $(this).addClass("hide_vm_ul");
        $(this).next(".view_more").removeClass("hide_vm");
    }
});

// "View More" click event
$(".view_more").on("click", function (e) {
    e.preventDefault();
    $(this).prev(".view_more_ul").removeClass("hide_vm_ul");
    $(this).addClass("hide_vm");
    $(this).next(".view_less").removeClass("hide_vm");
});

// "View Less" click event
$(".view_less").on("click", function (e) {
    e.preventDefault();
    $(this).prev(".view_more").removeClass("hide_vm");
    $(this).prevAll(".view_more_ul").addClass("hide_vm_ul");
    $(this).addClass("hide_vm");
});

});

if ($("#submit_alert").length > 0) {

	$("#submit_alert").validate({
		rules: {
			email: {
				required: true,
				maxlength: 5000,
				email: true
			}
		},

		messages: {
			email: {
				required: "Email is required",
			}
		},

		submitHandler: function(form) {
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});

			$.ajax({
				url: "<?php echo e(route('subscribe.alert')); ?>",
				type: "GET",
				data: $('#submit_alert').serialize(),
				success: function(response) {
					$("#submit_alert").trigger("reset");
					$('#show_alert').modal('hide');
					swal({
						title: "Success",
						text: response["msg"],
						icon: "success",
						button: "OK",
					});
				}
			});
		}
	})
}

$(document).on('click', '.swal-button--Login', function() {
	window.location.href = "<?php echo e(route('login')); ?>";
})
$(document).on('click', '.swal-button--register', function() {
	window.location.href = "<?php echo e(route('register')); ?>";
})

</script>

<?php echo $__env->make('includes.country_state_city_js', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopPush(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/personelnoktasit/public_html/resources/views/job/list.blade.php ENDPATH**/ ?>