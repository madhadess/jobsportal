
<?php $__env->startSection('content'); ?> 
<!-- Header start --> 
<?php echo $__env->make('includes.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> 
<!-- Header end --> 


<?php echo $__env->make('includes.inner_top_search', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php
$company = $job->getCompany();
?>






<div class="listpgWraper">
    <div class="container"> 
        <?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
       

    <div class="row jobPagetitle">
            <div class="col-lg-8">
                <div class="jobinfo">
                    <h2><?php echo e($job->title); ?></h2>
                    <div class="ptext"><?php echo e(__('Date Posted')); ?>: <?php echo e($job->created_at->translatedFormat('d F Y')); ?></div>
                    
                    <?php if(!(bool)$job->hide_salary): ?>
                    <div class="salary"><?php echo e($job->getSalaryPeriod('salary_period')); ?>: <strong><?php echo e($job->getSalaryRange()); ?></strong></div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-4">

            <div class="jobButtons applybox">
            <?php if($job->isJobExpired()): ?>
                <span class="jbexpire"><i class="fas fa-paper-plane" aria-hidden="true"></i> <?php echo e(__('Job is expired')); ?></span>
                <?php elseif(Auth::check() && Auth::user()->isAppliedOnJob($job->id)): ?>
                    <a href="javascript:;" class="btn apply applied"><i class="fas fa-paper-plane" aria-hidden="true"></i> <?php echo e(__('Already Applied')); ?></a>
                <?php else: ?>
                    <?php if(!Auth::check()): ?>
                        <?php if($job->application_url != ''): ?>
                            <a href="<?php echo e(route('job.apply', $job->slug)); ?>" class="btn apply"><i class="fas fa-paper-plane" aria-hidden="true"></i> <?php echo e(__('Apply Now')); ?></a>
                        <?php else: ?>
                            <a href="<?php echo e(route('apply.job', $job->slug)); ?>" class="btn apply"><i class="fas fa-paper-plane" aria-hidden="true"></i> <?php echo e(__('Apply Now')); ?></a>
                        <?php endif; ?>
                    <?php else: ?>
                        <?php
                            $user = Auth::user();
                            $canApply = $user->canApplyToJob();
                        ?>

                        <?php if(!$canApply): ?>
                            <a href="<?php echo e(route('my.profile')); ?>" class="btn apply"><i class="fas fa-exclamation-circle" aria-hidden="true"></i> <?php echo e(__('Complete your profile to apply')); ?></a>
                        <?php else: ?>
                            <?php if($job->application_url != ''): ?>
                                <a href="<?php echo e(route('job.apply', $job->slug)); ?>" class="btn apply"><i class="fas fa-paper-plane" aria-hidden="true"></i> <?php echo e(__('Apply Now')); ?></a>
                            <?php else: ?>
                                <a href="<?php echo e(route('apply.job', $job->slug)); ?>" class="btn apply"><i class="fas fa-paper-plane" aria-hidden="true"></i> <?php echo e(__('Apply Now')); ?></a>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                <?php endif; ?>

				</div>

            </div>
       </div>




        <!-- Job Detail start -->
        <div class="row">
            <div class="col-lg-7"> 
				
				 <!-- Job Header start -->
        <div class="job-header">
           
			
			<!-- Job Detail start -->
                <div class="jobmainreq">
                    <div class="jobdetail">
                       <h3><i class="fa fa-align-left" aria-hidden="true"></i> <?php echo e(__('Job Detail')); ?></h3>
						
							
                       <ul class="jbdetail row">
                                <li class="col-lg-4 col-md-6 col-6">
                                    <div class="jbitlist">
                                    <span class="material-symbols-outlined">location_on</span>
                                    <div class="jbitdata">
                                        <strong><?php echo e(__('Location')); ?></strong>
                                        <?php if((bool)$job->is_freelance): ?>
                                        <span>Serbest Çalışma</span>
                                        <?php else: ?>
                                        <span><?php echo e($job->getLocation()); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    </div>
                                </li>
                               
                                <li class="col-lg-4 col-md-6 col-6">
                                    <div class="jbitlist"> 
                                    <span class="material-symbols-outlined">desktop_windows</span>                                    
                                    <div class="jbitdata">
                                        <strong><?php echo e(__('Job Type')); ?>:</strong>
                                        <span><?php echo e($job->getJobType('job_type')); ?></span>
                                    </div>
                                    </div>
                                </li>
                                <li class="col-lg-4 col-md-6 col-6">
                                    <div class="jbitlist"> 
                                    <span class="material-symbols-outlined">schedule</span>                                                                          
                                    <div class="jbitdata">
                                        <strong><?php echo e(__('Shift')); ?>:</strong>
                                        <span><?php echo e($job->getJobShift('job_shift')); ?></span>
                                    </div>
                                    </div>
                                </li>
                                <li class="col-lg-4 col-md-6 col-6">
                                    <div class="jbitlist">
                                    <span class="material-symbols-outlined">analytics</span>
                                    <div class="jbitdata">
                                        <strong><?php echo e(__('Career Level')); ?>:</strong>                                        
                                        <span><?php echo e($job->getCareerLevel('career_level')); ?></span>
                                    </div>
                                    </div>
                                </li>
                                <li class="col-lg-4 col-md-6 col-6">
                                    <div class="jbitlist">
                                    <span class="material-symbols-outlined">group</span>
                                    <div class="jbitdata">
                                        <strong><?php echo e(__('Positions')); ?>:</strong>
                                        <span><?php echo e($job->num_of_positions); ?></span>
                                    </div>
                                    </div>
                                </li>
                                <li class="col-lg-4 col-md-6 col-6">
                                    <div class="jbitlist">
                                    <span class="material-symbols-outlined">calendar_view_day</span>
                                    <div class="jbitdata">
                                        <strong><?php echo e(__('Experience')); ?>:</strong>    
                                        <span><?php echo e($job->getJobExperience('job_experience')); ?></span>
                                    </div>
                                    </div>
                                </li>
                                <li class="col-lg-4 col-md-6 col-6">
                                    <div class="jbitlist">
                                    <span class="material-symbols-outlined">male</span>
                                    <div class="jbitdata">
                                        <strong><?php echo e(__('Gender')); ?>:</strong>
                                        <span><?php echo e($job->getGender('gender')); ?></span></div>
                                    </div>
                                </li>
                                <li class="col-lg-4 col-md-6 col-6">
                                    <div class="jbitlist">
                                    <span class="material-symbols-outlined">school</span>
                                    <div class="jbitdata">
                                        <strong><?php echo e(__('Degree')); ?>:</strong>
                                        <span><?php echo e($job->getDegreeLevel('degree_level')); ?></span></div>
                                    </div>
                                </li>
                                <li class="col-lg-4 col-md-6 col-6">
                                    <div class="jbitlist">
                                    <span class="material-symbols-outlined">calendar_month</span>
                                    <div class="jbitdata">
                                        <strong><?php echo e(__('Apply Before')); ?>:</strong>
                                        <span><?php echo e(\Carbon\Carbon::parse($job->expiry_date)->translatedFormat('d F Y')); ?></span></div>
                                    </div>
                                </li> 
                                
                            </ul>
							
							
                       
                    </div>
                </div>
			
			
            <div class="jobButtons">
                <a href="<?php echo e(route('email.to.friend', $job->slug)); ?>" class="btn"><i class="fas fa-envelope" aria-hidden="true"></i> <?php echo e(__('Email to Friend')); ?></a>
                <?php if(Auth::check() && Auth::user()->isFavouriteJob($job->slug)): ?> <a href="<?php echo e(route('remove.from.favourite', $job->slug)); ?>" class="btn"><i class="fas fa-floppy" aria-hidden="true"></i> <?php echo e(__('Remove From Favourite Job')); ?> <i class="fas fa-times"></i></a> <?php else: ?> <a href="<?php echo e(route('add.to.favourite', $job->slug)); ?>" class="btn"><i class="fas fa-floppy"></i> <?php echo e(__('Add to Favourite')); ?></a> <?php endif; ?>
                <a href="<?php echo e(route('report.abuse', $job->slug)); ?>" class="btn report"><i class="fas fa-exclamation-triangle" aria-hidden="true"></i> <?php echo e(__('Report Abuse')); ?></a>
                </div>
            </div>
				
				
				
                <!-- Job Description start -->
                <div class="job-header">
                    <div class="contentbox">
                        <h3><i class="fas fa-file-text" aria-hidden="true"></i> <?php echo e(__('Job Description')); ?></h3>
                        <p><?php echo $job->description; ?></p>                       
                    </div>
                </div>
				
				<?php if(!empty($job->benefits)): ?>
				<div class="job-header benefits">
                    <div class="contentbox">
                        <h3><i class="fa fa-file-text" aria-hidden="true"></i> <?php echo e(__('Benefits')); ?></h3>
                        <p><?php echo $job->benefits; ?></p>                       
                    </div>
                </div>
                <?php endif; ?>
				
				<div class="job-header">
                    <div class="contentbox">                        
                        <h3><i class="fas fa-puzzle-piece" aria-hidden="true"></i> <?php echo e(__('Skills Required')); ?></h3>
                        <ul class="skillslist">
                            <?php echo $job->getJobSkillsList(); ?>

                        </ul>
                    </div>
                </div>
				
				
                <!-- Job Description end --> 

                
            </div>
            <!-- related jobs end -->

            <div class="col-lg-5"> 
				
				
				
				<div class="companyinfo">
					<h3><i class="fas fa-building" aria-hidden="true"></i> <?php echo e(__('Company Overview')); ?></h3>
                            <div class="companylogo"><a href="<?php echo e(route('company.detail',$company->slug)); ?>"><?php echo e($company->printCompanyImage()); ?></a></div>
                            <div class="title"><a href="<?php echo e(route('company.detail',$company->slug)); ?>"><?php echo e($company->name); ?></a></div>
                            <div class="ptext"><?php echo e($company->getLocation()); ?></div>
                            <div class="opening">
                                <a href="<?php echo e(route('company.detail',$company->slug)); ?>">
                                    <?php echo e(App\Company::countNumJobs('company_id', $company->id)); ?> <?php echo e(__('Current Jobs Openings')); ?>

                                </a>
                            </div>
                            <div class="clearfix"></div>
					<hr>
				<div class="companyoverview">
				
					<p><?php echo e(\Illuminate\Support\Str::limit(strip_tags($company->description), 250, '...')); ?> <a href="<?php echo e(route('company.detail',$company->slug)); ?>">Devamını Oku</a></p>
					</div>
                        </div>
				
			<!-- Google Map start -->
            <div class="job-header">
                    <div class="jobdetail">
                        <h3><i class="fas fa-map-marker" aria-hidden="true"></i> <?php echo e(__('Google Map')); ?></h3>
                        <div class="gmap">
                            <iframe src="https://maps.google.it/maps?q=<?php echo e(urlencode(strip_tags($company->map))); ?>&output=embed" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
				
			
            
               
            </div>
        </div>




	<!-- related jobs start -->
    <div class="relatedJobs">
        <h3 class="mb-0"><?php echo e(__('Related Jobs')); ?></h3>
        <ul class="featuredlist row">
            <?php if(isset($relatedJobs) && count($relatedJobs)): ?>
            <?php $__currentLoopData = $relatedJobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedJob): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $relatedJobCompany = $relatedJob->getCompany(); ?>
            <?php if(null !== $relatedJobCompany): ?>
            <!--Job start-->
            <li class="col-lg-3 col-md-6">
                <div class="jobint">

                    <div class="d-flex">
                        <div class="fticon"><i class="fas fa-briefcase"></i> <?php echo e($relatedJob->getJobType('job_type')); ?></div>                        
                    </div>
                    <h4><a href="<?php echo e(route('job.detail', [$relatedJob->slug])); ?>" title="<?php echo e($relatedJob->title); ?>"><?php echo \Illuminate\Support\Str::limit($relatedJob->title, $limit = 20, $end = '...'); ?></a>
                    </h4>
                    <?php if(!(bool)$relatedJob->hide_salary): ?>                    
                    <div class="salary mb-2">Maaş: <strong><?php echo e($relatedJob->getSalaryRange()); ?>/<?php echo e($relatedJob->getSalaryPeriod('salary_period')); ?></strong></div>
                    <?php endif; ?> 
                    <strong><i class="fas fa-map-marker-alt"></i> <?php echo e($relatedJob->getCity('city')); ?></strong>                     
                    <div class="jobcompany">
                     <div class="ftjobcomp">
                        <span><?php echo e($relatedJob->created_at->translatedFormat('d F Y')); ?></span>
                        <a href="<?php echo e(route('company.detail', $relatedJobCompany->slug)); ?>" title="<?php echo e($company->name); ?>"><?php echo e($company->name); ?></a>
                     </div>
                    <a href="<?php echo e(route('company.detail', $relatedJobCompany->slug)); ?>" class="company-logo" title="<?php echo e($company->name); ?>"><?php echo e($company->printCompanyImage()); ?> </a>
                    </div>
                </div>
            </li>
        
            <!--Job end--> 
            <?php endif; ?>
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
<?php echo $__env->make('includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('styles'); ?>
<style type="text/css">
    .view_more{display:none !important;}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?> 
<script>
    $(document).ready(function ($) {
        $("form").submit(function () {
            $(this).find(":input").filter(function () {
                return !this.value;
            }).attr("disabled", "disabled");
            return true;
        });
        $("form").find(":input").prop("disabled", false);

        $(".view_more_ul").each(function () {
            if ($(this).height() > 100)
            {
                $(this).css('height', 100);
                $(this).css('overflow', 'hidden');
                //alert($( this ).next());
                $(this).next().removeClass('view_more');
            }
        });



    });
</script> 
<?php $__env->stopPush(); ?>



<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/personelnoktasit/public_html/resources/views/job/detail.blade.php ENDPATH**/ ?>