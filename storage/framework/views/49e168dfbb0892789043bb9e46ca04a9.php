

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
                                        <h1><i class="fa fa-plus"></i> Yeni
                                            <?php echo e($type == 'caregiver' ? 'Bakıcı Kategorisi' : 'Hizmet Kategorisi'); ?> Ekle
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
                                    <li class="Aktif">Yeni Ekle</li>
                                </ul>
                            </div>
                        </section>

                        <section class="content">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <form Action="<?php echo e(route('admin.service-categories.store')); ?>" method="POST"
                                        enctype="multipart/form-data">
                                        <?php echo csrf_field(); ?>
                                        <div class="form-group <?php echo e($errors->has('type') ? 'has-error' : ''); ?>">
                                            <label for="type">Kategori Tipi <span class="text-danger">*</span></label>
                                            <select class="form-control" id="type" name="type" required>
                                                <option value="service" <?php echo e(old('type', $type) == 'service' ? 'selected' : ''); ?>>Genel Hizmet</option>
                                                <option value="caregiver" <?php echo e(old('type', $type) == 'caregiver' ? 'selected' : ''); ?>>Bakıcı / Danışan</option>
                                            </select>
                                            <?php if($errors->has('type')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('type')); ?></span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="form-group <?php echo e($errors->has('category_name') ? 'has-error' : ''); ?>">
                                            <label for="category_name">Kategori Adı <span
                                                    class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="category_name" name="category_name"
                                                value="<?php echo e(old('category_name')); ?>" placeholder="Kategori adını girin"
                                                required>
                                            <?php if($errors->has('category_name')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('category_name')); ?></span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="form-group <?php echo e($errors->has('category_desc') ? 'has-error' : ''); ?>">
                                            <label for="category_desc">Kategori Açıklaması</label>
                                            <textarea class="form-control" id="category_desc" name="category_desc" rows="4"
                                                placeholder="Kategori açıklamasını girin"><?php echo e(old('category_desc')); ?></textarea>
                                            <?php if($errors->has('category_desc')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('category_desc')); ?></span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="form-group <?php echo e($errors->has('category_image') ? 'has-error' : ''); ?>">
                                            <label for="category_image">Kategori Görseli</label>
                                            <input type="file" class="form-control" id="category_image"
                                                name="category_image" accept="image/*">
                                            <small class="text-muted">İzin verilen formatlar: jpeg, png, jpg, gif. Maksimum
                                                boyut: 2MB</small>
                                            <?php if($errors->has('category_image')): ?>
                                                <span class="text-danger"><?php echo e($errors->first('category_image')); ?></span>
                                            <?php endif; ?>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group <?php echo e($errors->has('sort_order') ? 'has-error' : ''); ?>">
                                                    <label for="sort_order">Sıralama</label>
                                                    <input type="number" class="form-control" id="sort_order"
                                                        name="sort_order" value="<?php echo e(old('sort_order', 0)); ?>" min="0">
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
                                                        <option value="1" <?php echo e(old('is_active', 1) == 1 ? 'selected' : ''); ?>>
                                                            Aktif</option>
                                                        <option value="0" <?php echo e(old('is_active') == 0 ? 'selected' : ''); ?>>Pasif
                                                        </option>
                                                    </select>
                                                    <?php if($errors->has('is_active')): ?>
                                                        <span class="text-danger"><?php echo e($errors->first('is_active')); ?></span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-save"></i> Kaydet
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
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.admin_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/personelnoktasit/public_html/resources/views/admin/service_categories/create.blade.php ENDPATH**/ ?>