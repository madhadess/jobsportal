

<?php $__env->startSection('content'); ?>
    <div class="content-wrapper">
        <div class="page-content-wrapper">
            <div class="page-content">
                <div class="row">
                    <div class="col-lg-12">
                        <section class="content-header">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-9">
                                        <h1><i class="fa fa-pencil"></i>
                                            <?php echo e($type == 'caregiver' ? 'Bakıcı Kategorisi' : 'Hizmet Kategorisi'); ?> Düzenle
                                        </h1>
                                    </div>
                                    <div class="col-md-3 text-right">
                                        <a href="<?php echo e(route('admin.service-categories.index', ['type' => $type])); ?>"
                                            class="btn btn-default">
                                            <i class="fa fa-arrow-left"></i> Geri Dön
                                        </a>
                                    </div>
                                </div>
                                <ul class="breadcrumb">
                                    <li><a href="<?php echo e(route('admin.home')); ?>"><i class="fa fa-dashboard"></i> Kontrol
                                            Paneli</a></li>
                                    <li><a href="<?php echo e(route('admin.service-categories.index', ['type' => $type])); ?>"><i
                                                class="fa fa-th-list"></i>
                                            <?php echo e($type == 'caregiver' ? 'Bakıcı Kategorileri' : 'Hizmet Kategorileri'); ?></a>
                                    </li>
                                    <li class="Aktif">Düzenle</li>
                                </ul>
                            </div>
                        </section>

                        <section class="content">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <form Action="<?php echo e(route('admin.service-categories.update', $category->id)); ?>"
                                        method="POST" enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('PUT'); ?>
                                        <input type="hidden" name="type" value="<?php echo e($type); ?>">

                                        <div class="form-group <?php echo e($errors->has('category_name') ? 'has-error' : ''); ?>">
                                            <label for="category_name">Kategori Adı <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="category_name" name="category_name"
                                                value="<?php echo e(old('category_name', $category->category_name)); ?>"
                                                placeholder="Kategori adını girin" required>
                                            <?php if($errors->has('category_name')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('category_name')); ?></span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="form-group <?php echo e($errors->has('category_desc') ? 'has-error' : ''); ?>">
                                            <label for="category_desc">Kategori Açıklaması</label>
                                            <textarea class="form-control" id="category_desc" name="category_desc" rows="4"
                                                placeholder="Kategori açıklamasını girin"><?php echo e(old('category_desc', $category->category_desc)); ?></textarea>
                                            <?php if($errors->has('category_desc')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('category_desc')); ?></span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="form-group <?php echo e($errors->has('category_image') ? 'has-error' : ''); ?>">
                                            <label for="category_image">Kategori Görseli</label>
                                            <?php if($category->category_image): ?>
                                                <div class="mb-2">
                                                    <img src="<?php echo e(asset('uploads/service_categories/' . $category->category_image)); ?>"
                                                        alt="<?php echo e($category->category_name); ?>"
                                                        style="max-width: 200px; max-height: 150px;">
                                                    <br><small class="text-muted">Mevcut görsel</small>
                                                </div>
                                            <?php endif; ?>
                                            <input type="file" class="form-control" id="category_image"
                                                name="category_image" accept="image/*">
                                            <small class="text-muted">Yeni görsel yüklerseniz mevcut görsel değiştirilir.
                                                İzin verilen formatlar: jpeg, png, jpg, gif. Maksimum boyut: 2MB</small>
                                            <?php if($errors->has('category_image')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('category_image')); ?></span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group <?php echo e($errors->has('sort_order') ? 'has-error' : ''); ?>">
                                                    <label for="sort_order">Sıralama</label>
                                                    <input type="number" class="form-control" id="sort_order"
                                                        name="sort_order"
                                                        value="<?php echo e(old('sort_order', $category->sort_order)); ?>" min="0">
                                                    <small class="text-muted">Düşük sayılar önce gösterilir</small>
                                                    <?php if($errors->has('sort_order')): ?>
                                                        <span class="text-danger"><?php echo e($errors->first('sort_order')); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group <?php echo e($errors->has('is_active') ? 'has-error' : ''); ?>">
                                                    <label for="is_active">Durum <span class="text-danger">*</span></label>
                                                    <select class="form-control" id="is_active" name="is_active" required>
                                                        <option value="1" <?php echo e(old('is_active', $category->is_active) == 1 ? 'selected' : ''); ?>>Aktif</option>
                                                        <option value="0" <?php echo e(old('is_active', $category->is_active) == 0 ? 'selected' : ''); ?>>Pasif</option>
                                                    </select>
                                                    <?php if($errors->has('is_active')): ?>
                                                        <span class="text-danger"><?php echo e($errors->first('is_active')); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-save"></i> Güncelle
                                            </button>
                                            <a href="<?php echo e(route('admin.service-categories.index', ['type' => $type])); ?>"
                                                class="btn btn-default">
                                                <i class="fa fa-times"></i> İptal
                                            </a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </section>

                        <section class="content">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h3 class="panel-title">
                                        <?php echo e($type == 'caregiver' ? 'Sihirbaz Adımları (Bakıcı Türü Seçenekleri)' : 'Sihirbaz Adımları (Hizmet Seçenekleri)'); ?>

                                    </h3>
                                </div>
                                <div class="panel-body">
                                    <form action="<?php echo e(route('admin.service-categories.update-options', $category->id)); ?>"
                                        method="POST" id="optionsForm">
                                        <?php echo csrf_field(); ?>
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="optionsTable">
                                                <thead>
                                                    <tr>
                                                        <th>Tür</th>
                                                        <th>Seçenek Adı (Örn: Gündüzlü, Yatılı, Yemek Yapar)</th>
                                                        <th>Sıra</th>
                                                        <th>Durum</th>
                                                        <th>İşlem</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $__empty_1 = true; $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                        <tr>
                                                            <td>
                                                                <input type="hidden" name="options[<?php echo e($index); ?>][id]"
                                                                    value="<?php echo e($option->id); ?>">
                                                                <select name="options[<?php echo e($index); ?>][option_type]"
                                                                    class="form-control" required>
                                                                    <option value="working_mode" <?php echo e($option->option_type == 'working_mode' ? 'selected' : ''); ?>>Çalışma Şekli</option>
                                                                    <option value="attribute" <?php echo e($option->option_type == 'attribute' ? 'selected' : ''); ?>>
                                                                        Nitelik/Özellik</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <input type="text" name="options[<?php echo e($index); ?>][option_name]"
                                                                    class="form-control" value="<?php echo e($option->option_name); ?>"
                                                                    placeholder="Seçenek adı" required>
                                                            </td>
                                                            <td>
                                                                <input type="number" name="options[<?php echo e($index); ?>][sort_order]"
                                                                    class="form-control" value="<?php echo e($option->sort_order); ?>"
                                                                    min="0">
                                                            </td>
                                                            <td>
                                                                <select name="options[<?php echo e($index); ?>][is_active]"
                                                                    class="form-control">
                                                                    <option value="1" <?php echo e($option->is_active == 1 ? 'selected' : ''); ?>>Aktif</option>
                                                                    <option value="0" <?php echo e($option->is_active == 0 ? 'selected' : ''); ?>>Pasif</option>
                                                                </select>
                                                            </td>
                                                            <td>
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm remove-option"
                                                                    data-id="<?php echo e($option->id); ?>">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                        <tr class="no-options">
                                                            <td colspan="5" class="text-center">Henüz bir seçenek eklenmemiş.
                                                            </td>
                                                        </tr>
                                                    <?php endif; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="text-right">
                                            <button type="button" class="btn btn-success" id="addOptionBtn">
                                                <i class="fa fa-plus"></i> Yeni Seçenek Ekle
                                            </button>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-save"></i> Seçenekleri Kaydet
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </section>

                        <?php $__env->startPush('scripts'); ?>
                            <script>
                                $(document).ready(function () {
                                    let optionIndex = <?php echo e(count($options)); ?>;

                                    $('#addOptionBtn').on('click', function () {
                                        $('.no-options').remove();

                                        let html = `
                                                <tr>
                                                    <td>
                                                        <select name="options[${optionIndex}][option_type]" class="form-control" required>
                                                            <option value="working_mode">Çalışma Şekli</option>
                                                            <option value="attribute" selected>Nitelik/Özellik</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" name="options[${optionIndex}][option_name]" class="form-control" placeholder="Seçenek adı" required>
                                                    </td>
                                                    <td>
                                                        <input type="number" name="options[${optionIndex}][sort_order]" class="form-control" value="${optionIndex}" min="0">
                                                    </td>
                                                    <td>
                                                        <select name="options[${optionIndex}][is_active]" class="form-control">
                                                            <option value="1">Aktif</option>
                                                            <option value="0">Pasif</option>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-sm remove-new-row">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            `;

                                        $('#optionsTable tbody').append(html);
                                        optionIndex++;
                                    });

                                    $(document).on('click', '.remove-new-row', function () {
                                        $(this).closest('tr').remove();
                                        if ($('#optionsTable tbody tr').length === 0) {
                                            $('#optionsTable tbody').append('<tr class="no-options"><td colspan="5" class="text-center">Henüz bir seçenek eklenmemiş.</td></tr>');
                                        }
                                    });

                                    $(document).on('click', '.remove-option', function () {
                                        let id = $(this).data('id');
                                        let row = $(this).closest('tr');

                                        if (confirm('Bu seçeneği silmek istediğinize emin misiniz?')) {
                                            $.ajax({
                                                url: '<?php echo e(url("admin/service-categories/delete-option")); ?>/' + id,
                                                type: 'DELETE',
                                                data: {
                                                    _token: '<?php echo e(csrf_token()); ?>'
                                                },
                                                success: function (response) {
                                                    if (response.success) {
                                                        row.remove();
                                                        if ($('#optionsTable tbody tr').length === 0) {
                                                            $('#optionsTable tbody').append('<tr class="no-options"><td colspan="5" class="text-center">Henüz bir seçenek eklenmemiş.</td></tr>');
                                                        }
                                                    }
                                                }
                                            });
                                        }
                                    });
                                });
                            </script>
                        <?php $__env->stopPush(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.admin_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/personelnoktasit/public_html/resources/views/admin/service_categories/edit.blade.php ENDPATH**/ ?>