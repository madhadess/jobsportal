

<?php $__env->startSection('content'); ?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li><a href="<?php echo e(route('admin.home')); ?>">Ana Sayfa</a><i class="fa fa-circle"></i></li>
                    <li><span>Hizmet İlanları</span></li>
                </ul>
            </div>

            
            <div class="row" style="margin-bottom:20px;">
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a class="dashboard-stat dashboard-stat-v2 blue" href="#">
                        <div class="visual"><i class="fa fa-globe"></i></div>
                        <div class="details">
                            <div class="number"><span><?php echo e($stats['open']); ?></span></div>
                            <div class="desc">Yayında</div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a class="dashboard-stat dashboard-stat-v2 green" href="#">
                        <div class="visual"><i class="fa fa-handshake-o"></i></div>
                        <div class="details">
                            <div class="number"><span><?php echo e($stats['matched']); ?></span></div>
                            <div class="desc">Eşleşti</div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a class="dashboard-stat dashboard-stat-v2 yellow" href="#">
                        <div class="visual"><i class="fa fa-star"></i></div>
                        <div class="details">
                            <div class="number"><span><?php echo e($stats['avg_score']); ?>%</span></div>
                            <div class="desc">Ort. Eşleşme Skoru</div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                    <a class="dashboard-stat dashboard-stat-v2 purple" href="#">
                        <div class="visual"><i class="fa fa-check-circle"></i></div>
                        <div class="details">
                            <div class="number"><span>%<?php echo e($stats['accept_rate']); ?></span></div>
                            <div class="desc">Kabul Oranı</div>
                        </div>
                    </a>
                </div>
            </div>

            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-list-alt font-dark"></i>
                        <span class="caption-subject bold uppercase">Hizmet İlanları</span>
                    </div>
                    <div class="actions">
                        <a href="<?php echo e(route('admin.match-rules.index')); ?>" class="btn btn-xs blue">
                            <i class="fa fa-sliders"></i> Eşleşme Kuralları
                        </a>
                    </div>
                </div>
                <div class="portlet-body">
                    
                    <form method="GET" class="form-inline" style="margin-bottom:15px;">
                        <select name="status" class="form-control input-sm" style="margin-right:6px;"
                            onchange="this.form.submit()">
                            <option value="">Tüm Durumlar</option>
                            <?php $__currentLoopData = $statusLabels; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($key); ?>" <?php echo e(request('status') == $key ? 'selected' : ''); ?>><?php echo e($label); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <select name="category_type" class="form-control input-sm" style="margin-right:6px;"
                            onchange="this.form.submit()">
                            <option value="">Tüm Türler</option>
                            <option value="service" <?php echo e(request('category_type') == 'service' ? 'selected' : ''); ?>>Hizmet
                                Personeli</option>
                            <option value="caregiver" <?php echo e(request('category_type') == 'caregiver' ? 'selected' : ''); ?>>Bakıcı
                            </option>
                        </select>
                        <input type="text" name="search" class="form-control input-sm" placeholder="İlan ara..."
                            value="<?php echo e(request('search')); ?>" style="margin-right:6px;">
                        <button type="submit" class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                        <a href="<?php echo e(route('admin.job-posts.index')); ?>" class="btn btn-sm btn-default"
                            style="margin-left:5px;">Temizle</a>
                    </form>

                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Başlık</th>
                                <th>İlan Sahibi</th>
                                <th>Tür</th>
                                <th>Durum</th>
                                <th>Başvuru</th>
                                <th>Ort. Skor</th>
                                <th>Tarih</th>
                                <th>İşlem</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $jobPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($post->id); ?></td>
                                    <td>
                                        <a
                                            href="<?php echo e(route('admin.job-posts.show', $post->id)); ?>"><strong><?php echo e(Str::limit($post->title, 40)); ?></strong></a>
                                    </td>
                                    <td><?php echo e($post->owner?->getName()); ?></td>
                                    <td><?php echo e($post->category_type === 'caregiver' ? '🧑‍⚕️ Bakıcı' : '🔧 Hizmet'); ?></td>
                                    <td>
                                        <span
                                            class="label label-<?php echo e($post->status === 'published' ? 'success' : ($post->status === 'matched' ? 'info' : ($post->status === 'draft' ? 'default' : 'danger'))); ?>">
                                            <?php echo e($statusLabels[$post->status] ?? $post->status); ?>

                                        </span>
                                    </td>
                                    <td class="text-center"><?php echo e($post->applications_count); ?></td>
                                    <td>
                                        <?php
                                            $avgScore = $post->applications->avg('match_score') ?? 0;
                                        ?>
                                        <span
                                            class="<?php echo e($avgScore >= 70 ? 'text-success' : ($avgScore >= 40 ? 'text-warning' : 'text-danger')); ?>">
                                            %<?php echo e(round($avgScore)); ?>

                                        </span>
                                    </td>
                                    <td><?php echo e($post->created_at->format('d.m.Y')); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('admin.job-posts.show', $post->id)); ?>" class="btn btn-xs blue"><i
                                                class="fa fa-eye"></i></a>
                                        <?php if($post->status === 'published'): ?>
                                            <form action="<?php echo e(route('admin.job-posts.close', $post->id)); ?>" method="POST"
                                                style="display:inline;">
                                                <?php echo csrf_field(); ?> <button class="btn btn-xs red" title="Kapat"><i
                                                        class="fa fa-lock"></i></button>
                                            </form>
                                        <?php elseif(in_array($post->status, ['closed', 'cancelled'])): ?>
                                            <form action="<?php echo e(route('admin.job-posts.publish', $post->id)); ?>" method="POST"
                                                style="display:inline;">
                                                <?php echo csrf_field(); ?> <button class="btn btn-xs green" title="Yayınla"><i
                                                        class="fa fa-globe"></i></button>
                                            </form>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="9" class="text-center text-muted">İlan bulunamadı.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <div class="pagination-wrapper"><?php echo e($jobPosts->appends(request()->query())->links()); ?></div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.admin_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/personelnoktasit/public_html/resources/views/admin/job_listings/index.blade.php ENDPATH**/ ?>