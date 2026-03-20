
<?php $__env->startSection('content'); ?>
    <style type="text/css">
        .table td,
        .table th {
            font-size: 12px;
            line-height: 2.42857 !important;
        }
    </style>
    <div class="page-content-wrapper">
        <!-- BEGIN CONTENT BODY -->
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <!-- BEGIN PAGE BAR -->
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li> <a href="<?php echo e(route('admin.home')); ?>">Ana Sayfa</a> <i class="fa fa-circle"></i> </li>
                    <li> <span>Cinsiyetler</span> </li>
                </ul>
            </div>
            <!-- END PAGE BAR -->
            <!-- BEGIN PAGE TITLE-->
            <h3 class="page-title">Cinsiyetleri Yönet <small>Cinsiyetler</small> </h3>
            <!-- END PAGE TITLE-->
            <!-- END PAGE HEADER-->
            <div class="row">
                <div class="col-md-12">
                    <!-- Begin: life time stats -->
                    <div class="portlet light portlet-fit portlet-datatable bordered">
                        <div class="portlet-title">
                            <div class="caption"> <i class="icon-settings font-dark"></i> <span
                                    class="caption-subject font-dark sbold uppercase">Cinsiyetler</span> </div>
                            <div class="actions"> <a href="<?php echo e(route('create.gender')); ?>" class="btn btn-xs btn-success"><i
                                        class="glyphicon glyphicon-plus"></i> Yeni Cinsiyet Ekle</a> </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-container">
                                <form method="post" role="form" id="gender-search-form">
                                    <table class="table table-striped table-bordered table-hover" id="genderDatatableAjax">
                                        <thead>
                                            <tr role="row" class="filter">
                                                <td><?php echo Form::select('lang', ['' => 'Dil Seçin']+$languages, config('default_lang'), array('id'=>'lang', 'class'=>'form-control')); ?></td>
                                                <td><input type="text" class="form-control" name="gender" id="gender" autocomplete="off" placeholder="Cinsiyet"></td>
                                                <td><select name="is_active" id="is_active"  class="form-control">
                                                        <option value="-1">Durum</option>
                                                        <option value="1" selected="selected">Aktif</option>
                                                        <option value="0">Pasif</option>
                                                    </select></td>
                                                <td>
                                                    <div class="margin-bottom-5">
                                                        <button type="submit" class="btn btn-sm btn-success filter-submit margin-bottom-5"><i class="fa fa-search"></i> Ara</button>
                                                    </div>
                                                    <button type="button" class="btn btn-sm btn-icon dark filter-cancel"><i class="fa fa-times"></i> Sıfırla</button>
                                                </td>
                                            </tr>
                                            <tr role="row" class="heading">
                                                <th>Dil</th>
                                                <th>Cinsiyet</th>
                                                <th>Durum</th>
                                                <th>İşlemler</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END CONTENT BODY -->
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <script>
        $(function () {
            var oTable = $('#genderDatatableAjax').DataTable({
                processing: true,
                serverSide: true,
                stateSave: true,
                searching: false,
                /*		
                 "order": [[1, "asc"]],            
                 paging: true,
                 info: true,
                 */
                ajax: {
                    url: '<?php echo route('fetch.data.genders'); ?>',
                    data: function (d) {
                        d.lang = $('#lang').val();
                        d.gender = $('input[name=gender]').val();
                        d.is_active = $('#is_active').val();
                    }
                }, columns: [
                    { data: 'lang', name: 'lang' },
                    { data: 'gender', name: 'gender' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
            $('#gender-search-form').on('submit', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#lang').on('change', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#gender').on('keyup', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#is_active').on('change', function (e) {
                oTable.draw();
                e.preventDefault();
            });
        });
        function deleteGender(id, is_default) {
            var msg = 'Emin misiniz?';
            if (is_default == 1) {
                msg = 'Emin misiniz? Varsayılan Cinsiyeti silmek üzeresiniz, diğer tüm cinsiyetler de silinecek!';
            }
            if (confirm(msg)) {
                $.post("<?php echo e(route('delete.gender')); ?>", { id: id, _method: 'DELETE', _token: '<?php echo e(csrf_token()); ?>' })
                    .done(function (response) {
                        if (response == 'ok') {
                            var table = $('#genderDatatableAjax').DataTable();
                            table.row('genderDtRow' + id).remove().draw(false);
                        } else {
                            alert('İstek Başarısız!');
                        }
                    });
            }
        }
        function makeActive(id) {
            $.post("<?php echo e(route('make.active.gender')); ?>", { id: id, _method: 'PUT', _token: '<?php echo e(csrf_token()); ?>' })
                .done(function (response) {
                    if (response == 'ok') {
                        var table = $('#genderDatatableAjax').DataTable();
                        table.row('genderDtRow' + id).remove().draw(false);
                    } else {
                        alert('İstek Başarısız!');
                    }
                });
        }
        function makeNotActive(id) {
            $.post("<?php echo e(route('make.not.active.gender')); ?>", { id: id, _method: 'PUT', _token: '<?php echo e(csrf_token()); ?>' })
                .done(function (response) {
                    if (response == 'ok') {
                        var table = $('#genderDatatableAjax').DataTable();
                        table.row('genderDtRow' + id).remove().draw(false);
                    } else {
                        alert('İstek Başarısız!');
                    }
                });
        }
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.admin_layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/personelnoktasit/public_html/resources/views/admin/gender/index.blade.php ENDPATH**/ ?>