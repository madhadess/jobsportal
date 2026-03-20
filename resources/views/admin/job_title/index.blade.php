@extends('admin.layouts.admin_layout')
@section('content')
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
                    <li> <a href="{{ route('admin.home') }}">Ana Sayfa</a> <i class="fa fa-circle"></i> </li>
                    <li> <span>İş Ünvanları</span> </li>
                </ul>
            </div>
            <!-- END PAGE BAR -->
            <!-- BEGIN PAGE TITLE-->
            <h3 class="page-title">İş Ünvanlarını Yönet <small>İş Ünvanları</small> </h3>
            <!-- END PAGE TITLE-->
            <!-- END PAGE HEADER-->
            <div class="row">
                <div class="col-md-12">
                    <!-- Begin: life time stats -->
                    <div class="portlet light portlet-fit portlet-datatable bordered">
                    <div class="portlet-title">
                        <div class="caption"> <i class="icon-settings font-dark"></i> <span class="caption-subject font-dark sbold uppercase">İş Ünvanları</span> </div>
                        <div class="actions"> <a href="{{ route('create.job.title') }}" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i> Yeni İş Ünvanı Ekle</a> </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-container">
                            <form method="post" role="form" id="jobTitle-search-form">
                                <table class="table table-striped table-bordered table-hover"  id="jobTitleDatatableAjax">
                                    <thead>
                                        <tr role="row" class="filter"> 
                                            <td>{!! Form::select('lang', ['' => 'Dil Seçin']+$languages, config('default_lang'), array('id'=>'lang', 'class'=>'form-control')) !!}</td>
                                            <td><input type="text" class="form-control" name="job_title" id="job_title" autocomplete="off" placeholder="İş Ünvanı"></td>
                                            <td><select name="is_active" id="is_active"  class="form-control">
                                                    <option value="-1">Durum</option>
                                                    <option value="1" selected="selected">Aktif</option>
                                                    <option value="0">Pasif</option>
                                                </select></td></tr>
                                        <tr role="row" class="heading">                                            
                                            <th>Dil</th>
                                            <th>İş Ünvanı</th>
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
@endsection
@push('scripts')
    <script>
        $(function () {
            var oTable = $('#jobTitleDatatableAjax').DataTable({
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
                    url: '{!! route('fetch.data.job.titles') !!}',
                    data: function (d) {
                        d.lang = $('#lang').val();
                        d.job_title = $('input[name=job_title]').val();
                        d.is_active = $('#is_active').val();
                    }
                }, columns: [
                    { data: 'lang', name: 'lang' },
                    { data: 'job_title', name: 'job_title' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
            $('#jobTitle-search-form').on('submit', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#lang').on('change', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#job_title').on('keyup', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#is_active').on('change', function (e) {
                oTable.draw();
                e.preventDefault();
            });
        });
        function deleteJobTitle(id, is_default) {
            var msg = 'Emin misiniz?';
            if (is_default == 1) {
                msg = 'Emin misiniz? Varsayılan İş Ünvanını silmek üzeresiniz, diğer tüm ünvanlar da silinecek!';
            }
            if (confirm(msg)) {
                $.post("{{ route('delete.job.title') }}", { id: id, _method: 'DELETE', _token: '{{ csrf_token() }}' })
                    .done(function (response) {
                        if (response == 'ok') {
                            var table = $('#jobTitleDatatableAjax').DataTable();
                            table.row('jobTitleDtRow' + id).remove().draw(false);
                        } else {
                            alert('İstek Başarısız!');
                        }
                    });
            }
        }
        function makeActive(id) {
            $.post("{{ route('make.active.job.title') }}", { id: id, _method: 'PUT', _token: '{{ csrf_token() }}' })
                .done(function (response) {
                    if (response == 'ok') {
                        var table = $('#jobTitleDatatableAjax').DataTable();
                        table.row('jobTitleDtRow' + id).remove().draw(false);
                    } else {
                        alert('İstek Başarısız!');
                    }
                });
        }
        function makeNotActive(id) {
            $.post("{{ route('make.not.active.job.title') }}", { id: id, _method: 'PUT', _token: '{{ csrf_token() }}' })
                .done(function (response) {
                    if (response == 'ok') {
                        var table = $('#jobTitleDatatableAjax').DataTable();
                        table.row('jobTitleDtRow' + id).remove().draw(false);
                    } else {
                        alert('İstek Başarısız!');
                    }
                });
        }
    </script>
@endpush