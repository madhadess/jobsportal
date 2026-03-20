

<?php $__env->startSection('content'); ?>
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li><a href="<?php echo e(route('admin.home')); ?>">Ana Sayfa</a><i class="fa fa-circle"></i></li>
                    <li><a href="<?php echo e(route('admin.job-posts.index')); ?>">İlanlar</a><i class="fa fa-circle"></i></li>
                    <li><span>Tüm Başvurular</span></li>
                </ul>
            </div>

            
            <div class="row" style="margin-bottom:20px;">
                <div class="col-md-3 col-sm-6">
                    <div class="dashboard-stat dashboard-stat-v2 blue">
                        <div class="visual"><i class="fa fa-paper-plane"></i></div>
                        <div class="details">
                            <div class="number"><?php echo e($stats['total']); ?></div>
                            <div class="desc">Toplam Başvuru</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="dashboard-stat dashboard-stat-v2 green">
                        <div class="visual"><i class="fa fa-check"></i></div>
                        <div class="details">
                            <div class="number"><?php echo e($stats['accepted']); ?></div>
                            <div class="desc">Kabul Edildi</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="dashboard-stat dashboard-stat-v2 red">
                        <div class="visual"><i class="fa fa-times"></i></div>
                        <div class="details">
                            <div class="number"><?php echo e($stats['rejected']); ?></div>
                            <div class="desc">Reddedildi</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="dashboard-stat dashboard-stat-v2 yellow">
                        <div class="visual"><i class="fa fa-star"></i></div>
                        <div class="details">
                            <div class="number"><?php echo e($stats['avg_score']); ?>%</div>
                            <div class="desc">Ort. Uygunluk Skoru</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="portlet light bordered">
                <div class="portlet-title">
                    <div class="caption font-dark">
                        <i class="fa fa-paper-plane font-dark"></i>
                        <span class="caption-subject bold uppercase">Başvurular</span>
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
                        <input type="number" name="min_score" class="form-control input-sm" placeholder="Min. Skor %"
                            value="<?php echo e(request('min_score')); ?>" style="width:120px; margin-right:6px;">
                        <button type="submit" class="btn btn-sm btn-default"><i class="fa fa-filter"></i></button>
                        <a href="<?php echo e(route('admin.applications.index')); ?>" class="btn btn-sm btn-default"
                            style="margin-left:5px;">Temizle</a>
                    </form>

                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Başvuran</th>
                                <th>İlan</th>
                                <th>Uygunluk Skoru</th>
                                <th>Durum</th>
                                <th>Tarih</th>
                                <th>İşlem</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__empty_1 = true; $__currentLoopData = $applications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($app->id); ?></td>
                                    <td>
                                        <strong><?php echo e($app->applicant?->getName()); ?></strong><br>
                                        <small class="text-muted"><?php echo e($app->applicant?->email); ?></small>
                                    </td>
                                    <td>
                                        <a href="<?php echo e(route('admin.job-posts.show', $app->job_post_id)); ?>">
                                            <?php echo e(\Illuminate\Support\Str::limit($app->jobPost?->title, 35)); ?>

                                        </a>
                                    </td>
                                    <td>
                                        <?php $score = (float) $app->match_score; ?>
                                        <span
                                            class="<?php echo e($score >= 70 ? 'text-success' : ($score >= 40 ? 'text-warning' : 'text-danger')); ?>"
                                            style="font-weight:700;">
                                            %<?php echo e(number_format($score, 0)); ?>

                                        </span>
                                        <div
                                            style="background:#f3f4f6; border-radius:4px; height:5px; margin-top:3px; overflow:hidden;">
                                            <div
                                                style="width:<?php echo e(min($score, 100)); ?>%; height:100%; background:<?php echo e($score >= 70 ? '#10b981' : ($score >= 40 ? '#f59e0b' : '#ef4444')); ?>;">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="label label-<?php echo e($statusColors[$app->status] ?? 'default'); ?>">
                                            <?php echo e($statusLabels[$app->status] ?? $app->status); ?>

                                        </span>
                                    </td>
                                    <td><?php echo e($app->created_at->format('d.m.Y')); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('admin.applications.show', $app->id)); ?>" class="btn btn-xs blue">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted">Başvuru bulunamadı.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <?php echo e($applications->appends(request()->query())->links()); ?>

                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.admin_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/personelnoktasit/public_html/resources/views/admin/applications/index.blade.php ENDPATH**/ ?>