

<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <div class="page-content-wrapper">
            <div class="page-content">
                <?php if(session()->has('message.added')): ?>
                    <div class="alert alert-success fade in">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <?php echo session('message.content'); ?>

                    </div>
                <?php endif; ?>
                <?php if(session()->has('message.updated')): ?>
                    <div class="alert alert-success fade in">
                        <a href="#" class="close" data-dismiss="alert">&times;</a>
                        <?php echo session('message.content'); ?>

                    </div>
                <?php endif; ?>

                <div class="row">
                    <div class="col-lg-12">
                        <section class="content-header">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-9">
                                        <h1><i class="fa fa-th-list"></i>
                                            <?php echo e($type == 'caregiver' ? 'Bakıcı Kategorileri' : 'Hizmet Kategorileri'); ?></h1>
                                    </div>
                                    <div class="col-md-3 text-right">
                                        <a href="<?php echo e(route('admin.service-categories.create', ['type' => $type])); ?>"
                                            class="btn btn-primary">
                                            <i class="fa fa-plus"></i> Yeni Kategori Ekle
                                        </a>
                                    </div>
                                </div>
                                <ul class="breadcrumb">
                                    <li><a href="<?php echo e(route('admin.home')); ?>"><i class="fa fa-dashboard"></i> Kontrol
                                            Paneli</a></li>
                                    <li class="Aktif"><i class="fa fa-th-list"></i>
                                        <?php echo e($type == 'caregiver' ? 'Bakıcı Kategorileri' : 'Hizmet Kategorileri'); ?></li>
                                </ul>
                            </div>
                        </section>

                        <section class="content">
                            <div class="panel-body">
                                <table class="table table-striped table-bordered" id="categoriesTable">
                                    <thead>
                                        <tr>
                                            <th width="5%">ID</th>
                                            <th width="15%">Görsel</th>
                                            <th width="25%">Kategori Adı</th>
                                            <th width="10%"><?php echo e($type == 'caregiver' ? 'Bakıcı Sayısı' : 'Hizmet Sayısı'); ?>

                                            </th>
                                            <th width="10%">Sıralama</th>
                                            <th width="10%">Durum</th>
                                            <th width="15%">Güncelleme</th>
                                            <th width="10%">İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr id="row-<?php echo e($category->id); ?>">
                                                <td><?php echo e($category->id); ?></td>
                                                <td>
                                                    <?php if($category->category_image): ?>
                                                        <img src="<?php echo e(asset('uploads/service_categories/' . $category->category_image)); ?>"
                                                            alt="<?php echo e($category->category_name); ?>"
                                                            style="max-width: 80px; max-height: 60px;">
                                                    <?php else: ?>
                                                        <span class="text-muted">Görsel yok</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <strong><?php echo e($category->category_name); ?></strong>
                                                    <br><small class="text-muted"><?php echo e($category->category_slug); ?></small>
                                                </td>
                                                <td>
                                                    <span class="badge badge-info"><?php echo e($category->getServicesCount()); ?></span>
                                                </td>
                                                <td><?php echo e($category->sort_order); ?></td>
                                                <td>
                                                    <button
                                                        class="btn btn-sm <?php echo e($category->is_active ? 'btn-success' : 'btn-danger'); ?>"
                                                        onclick="toggleStatus(<?php echo e($category->id); ?>)">
                                                        <?php echo e($category->is_active ? 'Aktif' : 'Pasif'); ?>

                                                    </button>
                                                </td>
                                                <td><?php echo e($category->updated_at ? $category->updated_at->diffForHumans() : '-'); ?>

                                                </td>
                                                <td>
                                                    <a href="<?php echo e(route('admin.service-categories.edit', $category->id)); ?>"
                                                        class="btn btn-sm btn-primary" title="Düzenle">
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                    <a href="<?php echo e(route('admin.service-questions.index', $category->id)); ?>"
                                                        class="btn btn-sm btn-info" title="Soruları Yönet">
                                                        <i class="fa fa-question-circle"></i>
                                                    </a>
                                                    <button class="btn btn-sm btn-danger"
                                                        onclick="deleteCategory(<?php echo e($category->id); ?>)" title="Sil">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).ready(function () {
            $('#categoriesTable').DataTable({
                "Language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Turkish.json"
                },
                "order": [[4, "asc"]]
            });
        });

        function toggleStatus(id) {
            $.ajax({
                url: '<?php echo e(url("admin/service-categories")); ?>/' + id + '/toggle-status',
                type: 'POST',
                data: {
                    _token: '<?php echo e(csrf_token()); ?>'
                },
                success: function (response) {
                    if (response.success) {
                        location.reload();
                    }
                },
                error: function () {
                    alert('Bir hata oluştu!');
                }
            });
        }

        function deleteCategory(id) {
            if (confirm('Bu kategoriyi silmek istediğinizden emin misiniz? Bu işlem geri alınamaz.')) {
                $.ajax({
                    url: '<?php echo e(url("admin/service-categories")); ?>/' + id,
                    type: 'DELETE',
                    data: {
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    success: function (response) {
                        if (response.success) {
                            $('#row-' + id).fadeOut(function () {
                                $(this).remove();
                            });
                        }
                    },
                    error: function () {
                        alert('Bir hata oluştu!');
                    }
                });
            }
        }
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.admin_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/personelnoktasit/public_html/resources/views/admin/service_categories/index.blade.php ENDPATH**/ ?>