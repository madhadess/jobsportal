@extends('admin.layouts.admin_layout')
@section('content')
    <style type="text/css">
        .table td,
        .table th {
            font-size: 12px;
            line-height: 2.42857 !important;
            vertical-align: middle !important;
        }

        .table td:last-child {
            text-align: center !important;
        }

        .table td:last-child .btn-group,
        .table td:last-child .btn {
            display: inline-block !important;
            float: none !important;
            margin: 0 auto !important;
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
                    <li> <span>Eğitim Seviyeleri</span> </li>
                </ul>
            </div>
            <!-- END PAGE BAR -->
            <!-- BEGIN PAGE TITLE-->
            <h3 class="page-title">Eğitim Seviyelerini Yönet <small>Eğitim Seviyeleri</small> </h3>
            <!-- END PAGE TITLE-->
            <!-- END PAGE HEADER-->
            <div class="row">
                <div class="col-md-12">
                    <!-- Begin: life time stats -->
                    <div class="portlet light portlet-fit portlet-datatable bordered">
                        <div class="portlet-title">
                            <div class="caption"> <i class="icon-settings font-dark"></i> <span
                                    class="caption-subject font-dark sbold uppercase">Eğitim Seviyeleri</span> </div>
                            <div class="actions"> <a href="{{ route('create.degree.level') }}"
                                    class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i> Yeni Eğitim
                                    Seviyesi Ekle</a> </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-container">
                                <form method="post" role="form" id="degreeLevel-search-form">
                                    <table class="table table-striped table-bordered table-hover"
                                        id="degreeLevelDatatableAjax">
                                        <thead>
                                            <tr role="row" class="filter">
                                                <td>{!! Form::select('lang', ['' => 'Dil Seçin'] + $languages, config('default_lang'), array('id' => 'lang', 'class' => 'form-control')) !!}
                                                </td>
                                                <td><input type="text" class="form-control" name="degree_level"
                                                        id="degree_level" autocomplete="off" placeholder="Eğitim Seviyesi">
                                                </td>
                                                <td><select name="is_active" id="is_active" class="form-control">
                                                        <option value="-1">Durum</option>
                                                        <option value="1" selected="selected">Aktif</option>
                                                        <option value="0">Pasif</option>
                                                    </select></td>
                                            </tr>
                                            <tr role="row" class="heading">
                                                <th>Dil</th>
                                                <th>Eğitim Seviyesi</th>
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
            var oTable = initModernDataTable('#degreeLevelDatatableAjax', {
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: '{!! route('fetch.data.degree.levels') !!}',
                    data: function (d) {
                        d.lang = $('#lang').val();
                        d.degree_level = $('#degree_level').val();
                        d.is_active = $('#is_active').val();
                    }
                }, columns: [
                    { data: 'lang', name: 'lang' }, { data: 'degree_level', name: 'degree_level' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
            $('#degreeLevel-search-form').on('submit', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#lang').on('change', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#degree_level').on('keyup', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#is_active').on('change', function (e) {
                oTable.draw();
                e.preventDefault();
            });
        });
        function deleteDegreeLevel(id, is_default) {
            var msg = 'Emin misiniz?';
            if (is_default == 1) {
                msg = 'Emin misiniz? Varsayılan Eğitim Seviyesini silmek üzeresiniz, diğer tüm seviyeler de silinecek!';
            }
            if (confirm(msg)) {
                $.post("{{ route('delete.degree.level') }}", { id: id, _method: 'DELETE', _token: '{{ csrf_token() }}' }, null, 'text')
                    .done(function (response) {
                        if (response == 'ok') {
                            var table = $('#degreeLevelDatatableAjax').DataTable();
                            table.row('degreeLevelDtRow' + id).remove().draw(false);
                        } else {
                            alert('İstek Başarısız!');
                        }
                    });
            }
        }
        function makeActive(id) {
            $.post("{{ route('make.active.degree.level') }}", { id: id, _method: 'PUT', _token: '{{ csrf_token() }}' })
                .done(function (response) {
                    if (response == 'ok') {
                        var table = $('#degreeLevelDatatableAjax').DataTable();
                        table.row('degreeLevelDtRow' + id).remove().draw(false);
                    } else {
                        alert('İstek Başarısız!');
                    }
                });
        }
        function makeNotActive(id) {
            $.post("{{ route('make.not.active.degree.level') }}", { id: id, _method: 'PUT', _token: '{{ csrf_token() }}' })
                .done(function (response) {
                    if (response == 'ok') {
                        var table = $('#degreeLevelDatatableAjax').DataTable();
                        table.row('degreeLevelDtRow' + id).remove().draw(false);
                    } else {
                        alert('İstek Başarısız!');
                    }
                });
        }
    </script>
@endpush