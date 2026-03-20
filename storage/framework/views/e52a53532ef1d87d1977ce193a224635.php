<?php if($packages->count()): ?>

	<div class="paypackages">

		<!---four-paln-->

		<div class="four-plan">

			<h3><?php echo e(__('İş Paketlerini Yükselt')); ?></h3>

			<div class="row"> <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<div class="col-md-4 col-sm-6 col-xs-12">

						<ul class="boxes">

							<li class="plan-name"><?php echo e($package->package_title); ?></li>

							<li>

								<div class="main-plan">


									<div class="plan-price1-2">
										<?php echo e($package->package_price == 0 ? 'ÜCRETSİZ' : $package->package_price . ' ₺'); ?></div>

									<div class="clearfix"></div>

								</div>

							</li>

							<li class="plan-pages"><i class="far fa-check-circle"></i> <?php echo e(__('İş İlanı')); ?>

								<?php echo e($package->package_num_listings); ?>

							</li>
							<li class="plan-pages"><i class="far fa-check-circle"></i> <?php echo e(__('İş İlanı Süresi')); ?>

								<?php echo e($package->package_num_days); ?> <?php echo e(__('Gün')); ?>

							</li>

							<?php if($package->package_price == 10): ?>
								<li class="plan-pages noadded"><i class="far fa-times-circle"></i> <?php echo e(__('Öne Çıkan İlanlar')); ?></li>
								<li class="plan-pages <?php if($package->package_price == 0): ?> disabled <?php endif; ?>"><i
										class="far fa-times-circle"></i> <?php echo e(__('Premium Destek 24/7')); ?></li>
							<?php else: ?>
								<li class="plan-pages"><i class="far fa-check-circle"></i> <?php echo e(__('İstek üzerine öne çıkan işler')); ?>

								</li>
								<li class="plan-pages <?php if($package->package_price == 0): ?> disabled <?php endif; ?>"><i
										class="far fa-check-circle"></i> <?php echo e(__('Premium Destek 24/7')); ?></li>

							<?php endif; ?>



							<li class="order paypal"><a href="javascript:void(0)" data-bs-toggle="modal"
									data-bs-target="#buypack<?php echo e($package->id); ?>" class="reqbtn"><?php echo e(__('Şimdi Satın Al')); ?> <i
										class="fas fa-arrow-right"></i></a></li>

						</ul>


						<div class="modal fade" id="buypack<?php echo e($package->id); ?>" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title"><?php echo e(__('Şimdi Satın Al')); ?></h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal"
											aria-label="Close"></button>
									</div>

									<div class="modal-body">

										<div class="invitereval">
											<h3>Lütfen Ödeme Yöntemini Seçin</h3>

											<div class="totalpay"><?php echo e(__('Ödenecek Toplam Tutar')); ?>:
												<strong><?php echo e($package->package_price); ?> ₺</strong>
											</div>

											<ul class="btn2s">
												<?php if($package->package_price > 0): ?>
													<li class="order paypal p-2"><a
															href="<?php echo e(route('order.upgrade.package', $package->id)); ?>"><i
																class="fas fa-credit-card" aria-hidden="true"></i>
															<?php echo e(__('Ödeme Yap')); ?></a></li>
												<?php else: ?>
													<li class="order paypal p-2"><a
															href="<?php echo e(route('order.free.package', $package->id)); ?>">
															<?php echo e(__('Ücretsiz Pakete Yükselt')); ?></a></li>
												<?php endif; ?>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>


					</div>
				</div>
			<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
		</div>

	</div>

	<!---end four-paln-->

	</div>

<?php endif; ?><?php /**PATH /home/personelnoktasit/public_html/resources/views/includes/company_packages_upgrade.blade.php ENDPATH**/ ?>