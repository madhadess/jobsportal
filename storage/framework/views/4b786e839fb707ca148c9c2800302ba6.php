

<?php $__env->startPush('css'); ?>
<link rel="stylesheet" href="<?php echo e(asset('public/modules/blogs/css/blogs.css')); ?>">
<link href="<?php echo e(asset('css/bootstrap-multiselect.css')); ?>" rel="stylesheet" type="text/css" />
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>

<div class="content-wrapper">

    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
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
            <!-- BEGIN PAGE HEADER-->
            <!-- BEGIN PAGE BAR -->
            <!-- END PAGE TITLE-->
            <!-- END PAGE HEADER-->
            <div class="row">
                <div class="col-lg-12">
                    <section class="content-header">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-md-9">

                                    <h1>
                                        Blog Yönetimi

                                    </h1>
                                </div>
                            </div>


                            <ul class="breadcrumb">
                                <li class="Aktif"><a href="<?php echo e(URL::asset('/admin/blog')); ?>"><i
                                            class="fa fa-dashboard"></i> Blog
                                        Yönetimi</a></li>
                                <li><a href="<?php echo e(URL::asset('/admin/blog_category')); ?>"><i class="fa fa-file-text-o"></i>
                                        Kategori
                                        Yönetimi</a></li>

                            </ul>

                        </div>


                    </section>


                    <section class="content">

                        <div class="panel-body">
                            <table class="table" id="blogTable">
                                <thead>
                                    <tr>

                                        <th>Başlık</th>
                                        <th>İçerik</th>

                                        <th>Son Güncelleme</th>
                                        <th>İşlemler</th>
                                    </tr>
                                    <?php echo e(csrf_field()); ?>

                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $user; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blog): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="item<?php echo e($blog->id); ?>">

                                        <td><?php echo e($blog->heading); ?></td>
                                        <td>
                                            <?php echo \Illuminate\Support\Str::words($blog->content, 5,'..'); ?>

                                        </td>

                                        <td><?php echo e(\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $blog->updated_at)->diffForHumans()); ?>

                                        </td>
                                        <td>
                                            <a id="popup" class="edit-modal btn btn-success"
                                                href="<?php echo e(route('edit-blog',$blog->id)); ?>"><span
                                                    class="fa fa-pencil"></span>
                                                Düzenle</a>
                                            <button id="popup" class="delete-modal btn btn-danger"
                                                onClick="delete_blog(<?php echo e($blog->id); ?>);"><span class="fa fa-trash"></span>
                                                Sil</button>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- /.panel-body -->
                    </section>
                </div>
            </div><!-- /.panel panel-default -->
            <!-- /.col-md-8 -->
            <div id="addModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form method="POST" files="true" Action="<?php echo e(asset('admin/blog/create')); ?>"
                            enctype="multipart/form-data">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Blog Ekle</h4>
                            </div>
                            <div class="modal-body">

                                <?php echo e(csrf_field()); ?>

                                <?php if($categories!=''): ?>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="title">Kategori Seçin</label>
                                    <div class="col-sm-12">
                                        <select id="cate_id" name="cate_id[]" class="form-control" multiple="multiple">
                                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo $cate->id; ?>"><?php echo $cate->heading; ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <div class="form-group <?php echo e($errors->has('title') ? 'has-error' : ''); ?>">
                                    <label class="control-label col-sm-3" for="title">Başlık</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="title" id="title" autofocus value="<?php echo e(old('title')); ?>">
                                        <span class="text-danger"><?php echo e($errors->first('title')); ?></span>
                                    </div>
                                </div>
                                <div class="form-group <?php echo e($errors->has('slug') ? 'has-error' : ''); ?>">
                                    <label class="control-label col-sm-3" for="Slug">Slug</label>
                                    <div class="col-sm-12">
                                        <input type="text" class="form-control" name="slug" id="slug" value="<?php echo e(old('slug')); ?>">
                                        <span class="text-danger"><?php echo e($errors->first('slug')); ?></span>
                                    </div>
                                </div>
                                <div class="form-group <?php echo e($errors->has('content') ? 'has-error' : ''); ?>">
                                    <label class="control-label col-sm-3" for="content">İçerik</label>
                                    <div class="col-sm-12">
                                        <textarea class="form-control" name="content" id="content" cols="40" rows="5"><?php echo e(old('content')); ?></textarea>
                                        <span class="text-danger"><?php echo e($errors->first('content')); ?></span>
                                    </div>
                                </div>
                                <br /><br /><br /> <br />
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="Upload Image">Öne Çıkan Görsel</label>
                                    <div class="col-sm-12">
                                        <input type="file" class="form-control" name="image" id="image" autofocus>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-sm-3" for="Manage Seo">
                                        <input type="checkbox" id="show_seo_fields" />
                                        SEO Yönetimi
                                    </label>
                                </div>
                                <div style="clear:both"></div>
                                <div id="div_show_seo_fields" style="display: none">
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="title">Meta Başlık</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" name="meta_title" id="meta_title" autofocus value="<?php echo e(old('meta_title')); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="title">Meta Anahtar Kelimeler</label>
                                        <div class="col-sm-12">
                                            <input type="text" class="form-control" name="meta_keywords" id="meta_keywords" autofocus value="<?php echo e(old('meta_keywords')); ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-sm-3" for="title">Meta Açıklama</label>
                                        <div class="col-sm-12">
                                            <textarea class="form-control" name="meta_descriptions" id="meta_descriptions" cols="40" rows="5"><?php echo e(old('meta_description')); ?></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div style="clear:both"></div>
                            <br>
                            <div class="modal-footer">
                                <input type="submit" value="Ekle" class="btn btn-primary">
                                <input type="button" value="Kapat" class="btn btn-warning" data-dismiss="modal">
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div id="viewModal" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">İçerik</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <textarea class="form-control" name="contentview" id="contentview" disabled="" cols="40" rows="5"></textarea>
                                    <p class="errorContent text-center alert alert-danger hidden"></p>
                                </div>
                            </div>
                        </div>

                        <div style="clear:both"></div>
                        <br>
                        <div class="modal-footer">

                            <input type="button" value="Kapat" class="btn btn-warning" data-dismiss="modal">
                        </div>



                    </div>

                </div>

            </div>

            <?php $__env->stopSection(); ?>



            <?php $__env->startPush('scripts'); ?>
            <script type="text/javascript" src="<?php echo e(asset('public/toastr/toastr.min.js')); ?>"></script>
            <script src="<?php echo e(asset('js/bootstrap-multiselect.js')); ?>"></script>
            <script src="<?php echo e(asset('modules/blogs/js/blogs.js')); ?>"></script>




            <script>
                $(function () {
                    $('#blogTable').dataTable();

                    <?php if($errors->has('title') || $errors->has('slug') || $errors->has('content')): ?>
                        $('#addModal').modal('show');
                    <?php endif; ?>
                });
            </script>

            <?php $__env->stopPush(); ?>








<?php echo $__env->make('admin.layouts.admin_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/personelnoktasit/public_html/resources/views/admin/blogs/blogs.blade.php ENDPATH**/ ?>