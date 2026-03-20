

<?php $__env->startSection('content'); ?>

    <!-- Header start -->

    <?php echo $__env->make('includes.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Header end -->

    <!-- Inner Page Title start -->

    <?php echo $__env->make('includes.inner_page_title', ['page_title' => __('İş Verici Paneline Hoş Geldiniz')], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Inner Page Title end -->

    <div class="listpgWraper">

        <div class="container"><?php echo $__env->make('flash::message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <div class="row"> <?php echo $__env->make('includes.company_dashboard_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php $company = auth()->guard('company')->user(); ?>

                <div class="col-md-9 col-sm-8 company-dashboard-content">
                    <?php
    $hasUnlimitedFreeQuota = method_exists($company, 'hasUnlimitedFreeJobPostingQuota')
        ? $company->hasUnlimitedFreeJobPostingQuota()
        : false;
    if (
        $company->is_active == 1 && (($company->package_end_date === null) ||
            (\Carbon\Carbon::parse($company->package_end_date)->lt(\Carbon\Carbon::now())) ||
            (!$hasUnlimitedFreeQuota && $company->jobs_quota <= $company->availed_jobs_quota))
    ) { ?>

                    <div class="userprofilealert">
                        <h5>
                            <i class="fas fa-check"></i>
                            <?php echo e(__('Hesabınız artık aktif, İş İlanı yayınlamaya başlayın.')); ?>

                        </h5>
                    </div>

                    <?php } elseif ($company->is_active != 1) { ?>
                    <div class="userprofilealert">
                        <h5>
                            <i class="fas fa-times"></i>
                            <?php echo e(__('Hesabınız doğrulama beklediği için şu anda pasif durumda.')); ?>

                        </h5>
                    </div>
                    <?php } ?>




                    <?php echo $__env->make('includes.company_dashboard_stats', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    <?php if(
                        $company->getPackage('package_price') !== null &&
                        (float)$company->getPackage('package_price') <= 0 &&
                        $company->package_end_date !== null &&
                        Carbon\Carbon::parse($company->package_end_date)->gt(Carbon\Carbon::now()) &&
                        ($hasUnlimitedFreeQuota || $company->jobs_quota > $company->availed_jobs_quota)
                    ): ?>
                        <div class="freepackagebox">
                            <div class="frpkgct">
                                <h5><?php echo e(__('Tebrikler! Hesabınız artık aktif')); ?></h5>
                                <p>
                                    <?php if($hasUnlimitedFreeQuota): ?>
                                        <?php echo e(__('Ücretsiz paketiniz aktif. İlan yayınlama limitiniz bulunmuyor.')); ?>

                                    <?php else: ?>
                                        <?php echo e(__('Elde ettiniz')); ?> <?php echo e($company->jobs_quota - $company->availed_jobs_quota); ?>

                                        <?php echo e(__('ücretsiz ilan yayınlama, geçerli')); ?> <?php echo e(__('48 saat. Bitmeden acele edin')); ?>

                                    <?php endif; ?>
                                </p>
                            </div>
                            <a href="<?php echo e(url('/post-job')); ?>"><?php echo e(__('İlan Yayınla')); ?></a>
                        </div>
                    <?php endif; ?>



                    <?php
    if ((bool) config('company.is_company_package_active')) {
        $packages = App\Package::where('package_for', 'like', 'employer')->get();
        $package = Auth::guard('company')->user()->getPackage();
                    ?>



                    <?php    if (null !== $package) { ?>
                    <?php echo $__env->make('includes.company_package_msg', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo $__env->make('includes.company_packages_upgrade', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php    } elseif (null !== $packages) { ?>
                    <?php echo $__env->make('includes.company_packages_new', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php    }
    } ?>



                    <div class="paypackages mt-5">
                        <!---four-plan-->
                        <?php 
                    $company = Auth::guard('company')->user();
    $currentPackage = $company->cvs_getPackage(); 
                ?>
                        <?php if(null !== $currentPackage): ?>
                            <?php if(null !== ($currentPackage) && !empty($currentPackage)): ?>
                                <div class="instoretxt">

                                    <h3><?php echo e(__('Satın Alınan CV Paketi Detayları')); ?></h3>
                                    <div class="table-responsive">
                                        <table class="table table-bordered mb-0">
                                            <thead class="table-dark">
                                                <tr>
                                                    <th scope="col"><?php echo e(__('Paket Adı')); ?></th>
                                                    <th scope="col"><?php echo e(__('Fiyat')); ?></th>
                                                    <th scope="col"><?php echo e(__('Mevcut CV Kotası')); ?></th>
                                                    <th scope="col"><?php echo e(__('Satın Alınma Tarihi')); ?></th>
                                                    <th scope="col"><?php echo e(__('Paket Süresi Doldu')); ?></th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th><?php echo e($currentPackage->package_title); ?></th>
                                                    <td><strong><?php echo e($currentPackage->package_price); ?> ₺</strong></td>
                                                    <td><strong><?php echo e($company->availed_cvs_quota ?? 0); ?></strong> /
                                                        <strong><?php echo e($company->cvs_quota); ?></strong>
                                                    </td>
                                                    <td><strong><?php echo e(Carbon\Carbon::parse($company->cvs_package_start_date)->translatedFormat('d F Y')); ?></strong>
                                                    </td>
                                                    <td><strong><?php echo e(Carbon\Carbon::parse($company->cvs_package_end_date)->translatedFormat('d F Y')); ?></strong>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>





                            <?php endif; ?>
                            <div class="four-plan">
                                <h3><?php echo e(__('CV Arama Paketini Yükselt')); ?></h3>
                                <div class="row">
                                    <?php    $packages = App\Package::get(); ?>
                                    <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($package->package_for == 'cv_search'): ?>
                                            <div class="col-12 col-sm-6 col-lg-4 package-card-col">
                                                <ul class="boxes">
                                                    <li class="plan-name"><?php echo e($package->package_title); ?></li>
                                                    <li>
                                                        <div class="main-plan">
                                                            <div class="plan-price1-2"><?php echo e($package->package_price); ?> ₺</div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </li>
                                                    <li class="plan-pages"><i class="far fa-check-circle"></i>
                                                        <?php echo e(__('Başvuran CV Görüntüleme')); ?> <?php echo e($package->package_num_listings); ?></li>
                                                    <li class="plan-pages"><i class="far fa-check-circle"></i>
                                                        <?php echo e(__('CV Görüntüleme Erişimi')); ?> <?php echo e($package->package_num_days); ?> <?php echo e(__('Gün')); ?>

                                                    </li>
                                                    <li class="plan-pages"><i class="far fa-check-circle"></i>
                                                        <?php echo e(__('Premium Destek 7/24')); ?></li>

                                                    <li class="order paypal"><a href="javascript:void(0)" data-bs-toggle="modal"
                                                            data-bs-target="#buypack<?php echo e($package->id); ?>"
                                                            class="reqbtn"><?php echo e(__('Şimdi Satın Al')); ?> <i
                                                                class="fas fa-arrow-right"></i></a></li>

                                                </ul>
                                            </div>


                                            <div class="modal fade" id="buypack<?php echo e($package->id); ?>" tabindex="-1" role="dialog"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"><?php echo e(__('Şimdi Satın Al')); ?></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <div class="invitereval">
                                                                <h3><?php echo e(__('Ödeme Yönteminizi Seçin')); ?></h3>

                                                                <div class="totalpay"><?php echo e(__('Ödenecek Toplam Tutar')); ?>:
                                                                    <strong><?php echo e($package->package_price); ?> ₺</strong>
                                                                </div>

                                                                <ul class="btn2s">

                                                                    <?php if((bool) $siteSetting->is_paytr_active): ?>
                                                                        <li class="order p-2">
                                                                            <a href="<?php echo e(route('paytr.order.package', ['package_id' => $package->id])); ?>">
                                                                                <i class="fas fa-credit-card" aria-hidden="true"></i>
                                                                                <?php echo e(__('PayTR ile Öde')); ?>

                                                                            </a>
                                                                        </li>
                                                                    <?php endif; ?>
                                                                    <?php if((bool) $siteSetting->is_bank_transfer_active): ?>
                                                                        <li class="order p-2">
                                                                            <a href="<?php echo e(route('bank.transfer.order.package', ['package_id' => $package->id])); ?>">
                                                                                <i class="fas fa-university" aria-hidden="true"></i>
                                                                                <?php echo e(__('Havale/EFT')); ?>

                                                                            </a>
                                                                        </li>
                                                                    <?php endif; ?>

                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="four-plan">
                                <h3><?php echo e(__('CV Arama Paketini Yükselt')); ?></h3>
                                <div class="row">
                                    <?php    $packages = App\Package::get(); ?>
                                    <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($package->package_for == 'cv_search'): ?>
                                            <div class="col-12 col-sm-6 col-lg-4 package-card-col">
                                                <ul class="boxes">
                                                    <li class="plan-name"><?php echo e($package->package_title); ?></li>
                                                    <li>
                                                        <div class="main-plan">
                                                            <div class="plan-price1-2"><?php echo e($package->package_price); ?> ₺</div>
                                                            <div class="clearfix"></div>
                                                        </div>
                                                    </li>
                                                    <li class="plan-pages"><i class="far fa-check-circle"></i>
                                                        <?php echo e(__('Başvuran CV Görüntüleme')); ?> <?php echo e($package->package_num_listings); ?></li>
                                                    <li class="plan-pages"><i class="far fa-check-circle"></i>
                                                        <?php echo e(__('CV Görüntüleme Erişimi')); ?> <?php echo e($package->package_num_days); ?> <?php echo e(__('Gün')); ?>

                                                    </li>
                                                    <li class="plan-pages"><i class="far fa-check-circle"></i>
                                                        <?php echo e(__('Premium Destek 7/24')); ?></li>

                                                    <li class="order paypal"><a href="javascript:void(0)" data-bs-toggle="modal"
                                                            data-bs-target="#buypack<?php echo e($package->id); ?>"
                                                            class="reqbtn"><?php echo e(__('Şimdi Satın Al')); ?> <i
                                                                class="fas fa-arrow-right"></i></a></li>

                                                </ul>
                                            </div>



                                            <div class="modal fade" id="buypack<?php echo e($package->id); ?>" tabindex="-1" role="dialog"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"><?php echo e(__('Şimdi Satın Al')); ?></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <div class="invitereval">
                                                                <h3><?php echo e(__('Ödeme Yönteminizi Seçin')); ?></h3>

                                                                <div class="totalpay"><?php echo e(__('Ödenecek Toplam Tutar')); ?>:
                                                                    <strong><?php echo e($package->package_price); ?> ₺</strong>
                                                                </div>

                                                                <ul class="btn2s">

                                                                    <?php if((bool) $siteSetting->is_paytr_active): ?>
                                                                        <li class="order p-2">
                                                                            <a href="<?php echo e(route('paytr.order.package', ['package_id' => $package->id])); ?>">
                                                                                <i class="fas fa-credit-card" aria-hidden="true"></i>
                                                                                <?php echo e(__('PayTR ile Öde')); ?>

                                                                            </a>
                                                                        </li>
                                                                    <?php endif; ?>
                                                                    <?php if((bool) $siteSetting->is_bank_transfer_active): ?>
                                                                        <li class="order p-2">
                                                                            <a href="<?php echo e(route('bank.transfer.order.package', ['package_id' => $package->id])); ?>">
                                                                                <i class="fas fa-university" aria-hidden="true"></i>
                                                                                <?php echo e(__('Havale/EFT')); ?>

                                                                            </a>
                                                                        </li>
                                                                    <?php endif; ?>

                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        <?php endif; ?>
                        <!---end four-plan-->
                    </div>




                </div>
            </div>
        </div>
    </div>




    <?php echo $__env->make('includes.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php echo $__env->make('includes.immediate_available_btn', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/personelnoktasit/public_html/resources/views/company_home.blade.php ENDPATH**/ ?>