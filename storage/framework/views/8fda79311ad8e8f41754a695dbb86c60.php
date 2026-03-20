<div class="col-lg-3">
        <div class="usernavwrap">
                <ul class="usernavdash">
                        <li class="<?php echo e(Request::url() == route('company.home') ? 'active' : ''); ?>"><a
                                        href="<?php echo e(route('company.home')); ?>"><i class="fas fa-tachometer"
                                                aria-hidden="true"></i> <?php echo e(__('Panel')); ?></a></li>
                        <li class="<?php echo e(Request::url() == route('company.profile') ? 'active' : ''); ?>"><a
                                        href="<?php echo e(route('company.profile')); ?>"><i class="fas fa-pencil"
                                                aria-hidden="true"></i> <?php echo e(__('Hesap Bilgilerini Düzenle')); ?></a></li>
                        <li><a href="<?php echo e(route('company.detail', Auth::guard('company')->user()->slug)); ?>"><i
                                                class="fas fa-user-alt" aria-hidden="true"></i>
                                        <?php echo e(__('Şirket Genel Profili')); ?></a></li>
                        <li class="<?php echo e(Request::url() == route('post.job') ? 'active' : ''); ?>"><a
                                        href="<?php echo e(route('post.job')); ?>"><i class="fas fa-desktop" aria-hidden="true"></i>
                                        <?php echo e(__('İş İlanı Ver')); ?></a></li>
                        <li class="<?php echo e(Request::url() == route('posted.jobs') ? 'active' : ''); ?>"><a
                                        href="<?php echo e(route('posted.jobs')); ?>"><i class="fab fa-black-tie"></i>
                                        <?php echo e(__('İlanları Yönet')); ?></a></li>

                        <li class="<?php echo e(Request::url() == route('company.packages') ? 'active' : ''); ?>"><a
                                        href="<?php echo e(route('company.packages')); ?>"><i class="fas fa-search"
                                                aria-hidden="true"></i>
                                        <?php echo e(__('CV Arama Paketleri')); ?></a></li>
                        <li class="<?php echo e(Request::url() == route('company.featured_packages') ? 'active' : ''); ?>"><a
                                        href="<?php echo e(route('company.featured_packages')); ?>"><i class="fas fa-bolt"
                                                aria-hidden="true"></i>
                                        <?php echo e(__('Öne Çıkarma Paketleri')); ?></a></li>

                        <li class="<?php echo e(Request::url() == url('/list-payment-history') ? 'active' : ''); ?>"><a
                                        href="<?php echo e(url('/list-payment-history')); ?>"><i class="fas fa-file-invoice"></i>
                                        <?php echo e(__('Ödeme Geçmişi')); ?></a></li>

                        <li class="<?php echo e(Request::url() == route('company.unloced-users') ? 'active' : ''); ?>"><a
                                        href="<?php echo e(route('company.unloced-users')); ?>"><i class="fas fa-user"
                                                aria-hidden="true"></i> <?php echo e(__('Kilit Açık Kullanıcılar')); ?></a></li>

                        <li class="<?php echo e(Request::url() == route('company.messages') ? 'active' : ''); ?>"><a
                                        href="<?php echo e(route('company.messages')); ?>"><i class="fas fa-envelope"
                                                aria-hidden="true"></i> <?php echo e(__('Şirket Mesajları')); ?></a></li>
                        <li class="<?php echo e(Request::url() == route('company.followers') ? 'active' : ''); ?>"><a
                                        href="<?php echo e(route('company.followers')); ?>"><i class="fas fa-users"
                                                aria-hidden="true"></i> <?php echo e(__('Şirket Takipçileri')); ?></a></li>
                        <li><a href="<?php echo e(route('company.logout')); ?>"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                                class="fas fa-sign-out" aria-hidden="true"></i> <?php echo e(__('Çıkış')); ?></a>
                                <form id="logout-form" action="<?php echo e(route('company.logout')); ?>" method="POST"
                                        style="display: none;">
                                        <?php echo e(csrf_field()); ?>

                                </form>
                        </li>
                </ul>
        </div>
        <div class="row">
                <div class="col-md-12"><?php echo $siteSetting->dashboard_page_ad; ?></div>
        </div>
</div><?php /**PATH /home/personelnoktasit/public_html/resources/views/includes/company_dashboard_menu.blade.php ENDPATH**/ ?>