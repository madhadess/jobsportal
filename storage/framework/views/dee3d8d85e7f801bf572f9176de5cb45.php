

<?php $__env->startSection('content'); ?>

<!-- Header start -->

<?php echo $__env->make('includes.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<!-- Header end -->



<div class="listpgWraper mt-5">

    <div class="container">

        <?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <!-- Job Header start -->
         <div class="row">
            <div class="col-lg-7">
            
         

        <div class="job-header">
            <div class="jobinfo">
                        <!-- Candidate Info -->

                        <div class="candidateinfo">

                            <div class="userPic"><a href="<?php echo e(route('company.detail',$company->slug)); ?>"><?php echo e($company->printCompanyImage()); ?></a>

                            </div>

                            <div class="title"><?php echo e($company->name); ?></div>

                            <div class="desi"><?php echo e($company->getIndustry('industry')); ?></div>

                            <div class="loctext"><i class="fa fa-history" aria-hidden="true"></i>

                                <?php echo e(__('Member Since')); ?>, <?php echo e($company->created_at->translatedFormat('d F Y')); ?></div>

                            <div class="loctext"><i class="fa fa-map-marker" aria-hidden="true"></i>

                                <?php echo e($company->location); ?></div>

                            <div class="clearfix"></div>

                        </div>


            </div>

            <!-- Buttons -->
            <div class="jobButtons"> 
            <?php if(Auth::guard('web')->check() && Auth::guard('web')->user()->isFavouriteCompany($company->slug)): ?>
    <a href="<?php echo e(route('remove.from.favourite.company', $company->slug)); ?>" class="btn">
        <i class="fa fa-floppy-o" aria-hidden="true"></i> <?php echo e(__('Remove from Favourite')); ?>

    </a>
<?php else: ?>
    <a href="<?php echo e(route('add.to.favourite.company', $company->slug)); ?>" class="btn">
        <i class="fa fa-floppy-o" aria-hidden="true"></i> <?php echo e(__('Add to Favourite')); ?>

    </a>
<?php endif; ?>

                <a href="<?php echo e(route('report.abuse.company', $company->slug)); ?>" class="btn report">
                    <i class="fa fa-exclamation-triangle" aria-hidden="true"></i> <?php echo e(__('Report Abuse')); ?>

                </a> 
    
            </div>
        </div>

        <!-- About Employee start -->

        <div class="job-header">

            <div class="contentbox">

                <h3><?php echo e(__('About Company')); ?></h3>

                <p><?php echo $company->description; ?></p>

            </div>

        </div>


        </div>

        <div class="col-lg-5">
         <!-- Company Detail start -->

         <div class="job-header">

            <div class="jobdetail">
                <h3><?php echo e(__('Company Detail')); ?></h3>
                    <ul class="jbdetail row">
                                <li class="col-lg-4 col-md-6 col-6">
                                    <div class="jbitlist">
                                    <span class="material-symbols-outlined">verified</span>
                                    <div class="jbitdata">
                                        <strong><?php echo e(__('Verified')); ?></strong>
                                        <span><?php echo e(((bool)$company->verified)? 'Yes':'No'); ?></span>
                                    </div>
                                    </div>
                                </li>
                                <li class="col-lg-4 col-md-6 col-6">
                                    <div class="jbitlist">
                                    <span class="material-symbols-outlined">group</span>
                                    <div class="jbitdata">
                                        <strong><?php echo e(__('Company Size')); ?></strong>
                                        <span><?php echo e($company->no_of_employees); ?></span>
                                    </div>
                                    </div>
                                </li>
                                <li class="col-lg-4 col-md-6 col-6">
                                    <div class="jbitlist">
                                    <span class="material-symbols-outlined">cake</span>
                                    <div class="jbitdata">
                                        <strong><?php echo e(__('Founded In')); ?></strong>
                                        <span><?php echo e($company->established_in); ?></span>
                                    </div>
                                    </div>
                                </li>
                                <li class="col-lg-4 col-md-6 col-6">
                                    <div class="jbitlist">
                                    <span class="material-symbols-outlined">corporate_fare</span>
                                    <div class="jbitdata">
                                        <strong><?php echo e(__('Organization Type')); ?></strong>
                                        <span><?php echo e($company->getOwnershipType('ownership_type')); ?></span>
                                    </div>
                                    </div>
                                </li>
                                <li class="col-lg-4 col-md-6 col-6">
                                    <div class="jbitlist">
                                    <span class="material-symbols-outlined">corporate_fare</span>
                                    <div class="jbitdata">
                                        <strong><?php echo e(__('Total Offices')); ?></strong>
                                        <span><?php echo e($company->no_of_offices); ?></span>
                                    </div>
                                    </div>
                                </li>
                                <li class="col-lg-4 col-md-6 col-6">
                                    <div class="jbitlist">
                                    <span class="material-symbols-outlined">cases</span>
                                    <div class="jbitdata">
                                        <strong><?php echo e(__('Open Jobs')); ?></strong>
                                        <span><?php echo e($company->countNumJobs('company_id',$company->id)); ?></span>
                                    </div>
                                    </div>
                                </li>


                            
                    </ul>
            </div>

         </div>


         <div class="job-header">

                    <div class="jobdetail">
                        <iframe src="https://maps.google.it/maps?q=<?php echo e(urlencode(strip_tags($company->map))); ?>&output=embed" allowfullscreen></iframe>
                    </div>

                </div>


        </div>

        </div>









  <!-- Opening Jobs start -->

  <div class="relatedJobs">

<h3><?php echo e(__('Current Openings')); ?></h3>

<ul class="featuredlist row">

    <?php if(isset($company->jobs) && count($company->jobs)): ?>

    <?php $__currentLoopData = $company->jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $companyJob): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

    <!--Job start-->
    <li class="col-lg-3 col-md-6">
                <div class="jobint">

                    <div class="d-flex">
                        <div class="fticon"><i class="fas fa-briefcase"></i> <?php echo e($companyJob->getJobType('job_type')); ?></div>                        
                    </div>

                    <h4><a href="<?php echo e(route('job.detail', [$companyJob->slug])); ?>" title="<?php echo e($companyJob->title); ?>"><?php echo \Illuminate\Support\Str::limit($companyJob->title, $limit = 20, $end = '...'); ?></a>
                    
                    
                </h4>
                <?php if(!(bool)$companyJob->hide_salary): ?>                    
                    <div class="salary mb-2"><?php echo e(__('Salary')); ?>: <strong><?php echo e(number_format($companyJob->salary_from, 0, ',', '.')); ?> <?php echo e($companyJob->salary_currency == 'TL' ? '₺' : $companyJob->salary_currency); ?> - <?php echo e(number_format($companyJob->salary_to, 0, ',', '.')); ?> <?php echo e($companyJob->salary_currency == 'TL' ? '₺' : $companyJob->salary_currency); ?>/<?php echo e($companyJob->getSalaryPeriod('salary_period')); ?></strong></div>
                    <?php endif; ?> 


                    <strong><i class="fas fa-map-marker-alt"></i> <?php echo e($companyJob->getCity('city')); ?></strong> 
                    
                    <div class="jobcompany">
                     <div class="ftjobcomp">
                        <span><?php echo e($companyJob->created_at->translatedFormat('d F Y')); ?></span>
                        <a href="<?php echo e(route('company.detail', $company->slug)); ?>" title="<?php echo e($company->name); ?>"><?php echo e($company->name); ?></a>
                     </div>
                    <a href="<?php echo e(route('company.detail', $company->slug)); ?>" class="company-logo" title="<?php echo e($company->name); ?>"><?php echo e($company->printCompanyImage()); ?> </a>
                    </div>
                </div>
            </li>

    <!--Job end-->

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php else: ?>
    <div class="nodatabox">
    <h4><?php echo e(__('There are currently no open positions available.')); ?></h4>
    <div class="viewallbtn mt-2"><a href="<?php echo e(route('job.list')); ?>"><?php echo e(__('Search Jobs')); ?></a></div>
</div>

    <?php endif; ?>



    <!-- Job end -->

</ul>

</div>









    </div>

</div>

<!-- Modal -->

<div class="modal fade" id="sendmessage" role="dialog">

    <div class="modal-dialog">



        <!-- Modal content-->

        <div class="modal-content">

            <form action="" id="send-form">

                <?php echo csrf_field(); ?>

                <input type="hidden" name="company_id" id="company_id" value="<?php echo e($company->id); ?>">

                <div class="modal-header">                    

                    <h4 class="modal-title"><?php echo e(__('Send Message')); ?></h4>

					<button type="button" class="close" data-bs-dismiss="modal">&times;</button>

                </div>

                <div class="modal-body">

                    <div class="form-group">

                        <textarea class="form-control" name="message" id="message" cols="10" rows="7"></textarea>

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

<script type="text/javascript">

$(document).ready(function() {

    $(document).on('click', '#send_company_message', function() {

        var postData = $('#send-company-message-form').serialize();

        $.ajax({

            type: 'POST',

            url: "<?php echo e(route('contact.company.message.send')); ?>",

            data: postData,

            //dataType: 'json',

            success: function(data) {

                response = JSON.parse(data);

                var res = response.success;

                if (res == 'success') {

                    var errorString = '<div role="alert" class="alert alert-success popmessage">' +

                        response.message + '</div>';

                    $('#alert_messages').html(errorString);

                    $('#send-company-message-form').hide('slow');

                    $(document).scrollTo('.alert', 2000);

                } else {

                    var errorString = '<div class="alert alert-danger" role="alert"><ul>';

                    response = JSON.parse(data);

                    $.each(response, function(index, value) {

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



function send_message() {

    const el = document.createElement('div')

    el.innerHTML =

        "Please <a class='btn' href='<?php echo e(route('login')); ?>' onclick='set_session()'>log in</a> as a Canidate and try again."

    <?php if(Auth::check()): ?>

    $('#sendmessage').modal('show');

    <?php else: ?>

    swal({

        title: "You are not Loged in",

        content: el,

        icon: "error",

        button: "OK",

    });

    <?php endif; ?>

}

if ($("#send-form").length > 0) {

    $("#send-form").validate({

        validateHiddenInputs: true,

        ignore: "",



        rules: {

            message: {

                required: true,

                maxlength: 5000

            },

        },

        messages: {



            message: {

                required: "Message is required",

            }



        },

        submitHandler: function(form) {

            $.ajaxSetup({

                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

                }

            });

            <?php if(null !== (Auth::user())): ?>

            $.ajax({

                url: "<?php echo e(route('submit-message')); ?>",

                type: "POST",

                data: $('#send-form').serialize(),

                success: function(response) {

                    $("#send-form").trigger("reset");

                    $('#sendmessage').modal('hide');

                    swal({

                        title: "Success",

                        text: response["msg"],

                        icon: "success",

                        button: "OK",

                    });

                }

            });

            <?php endif; ?>

        }

    })

}

</script>

<?php $__env->stopPush(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/personelnoktasit/public_html/resources/views/company/detail.blade.php ENDPATH**/ ?>