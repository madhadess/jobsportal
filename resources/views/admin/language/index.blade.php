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
                    <li> <span>Languageler</span> </li>
                </ul>
            </div>
            <!-- END PAGE BAR -->
            <!-- BEGIN PAGE TITLE-->
            <h3 class="page-title">Language Yönetimi <small>Languageler</small> </h3>
            <!-- END PAGE TITLE-->
            <!-- END PAGE HEADER-->
            <div class="row">
                <div class="col-md-12">
                    <!-- Begin: life time stats -->
                    <div class="portlet light portlet-fit portlet-datatable bordered">
                        <div class="portlet-title">
                            <div class="caption"> <i class="icon-settings font-dark"></i> <span
                                    class="caption-subject font-dark sbold uppercase">Languageler</span> </div>
                            <div class="actionss"> <a href="{{ route('create.language') }}"
                                    class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i> Yeni Language
                                    Ekle</a> </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-container">
                                <form method="post" role="form" id="Language-search-form">
                                    <table class="table table-striped table-bordered table-hover"
                                        id="languageDatatableAjax">
                                        <thead>
                                            <tr role="row" class="filter">
                                                <td><input type="text" class="form-control" name="lang" id="lang"
                                                        autocomplete="off" placeholder="Dil"></td>
                                                <td><input type="text" class="form-control" name="native" id="native"
                                                        autocomplete="off" placeholder="Yerel Ad"></td>
                                                <td><input type="text" class="form-control" name="iso_code" id="iso_code"
                                                        autocomplete="off" placeholder="ISO Kodu"></td>
                                                <td><select name="is_rtl" id="is_rtl">
                                                        <option value="-1">RTL mi?</option>
                                                        <option value="1">RTL</option>
                                                        <option value="0">LTR</option>
                                                    </select></td>
                                                <td><select name="is_default" id="is_default">
                                                        <option value="-1">Varsayılan mı?</option>
                                                        <option value="1">Varsayılan</option>
                                                        <option value="0">Varsayılan Değil</option>
                                                    </select></td>
                                                <td><select name="is_active" id="is_active" class="form-control">
                                                        <option value="-1">Durum</option>
                                                        <option value="1" selected="selected">Aktif</option>
                                                        <option value="0">Pasif</option>
                                                    </select></td>
                                            </tr>
                                            <tr role="row" class="heading">
                                                <th>Dil</th>
                                                <th>Yerel Ad</th>
                                                <th>ISO Kodu</th>
                                                <th>RTL</th>
                                                <th>Varsayılan</th>
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
            var oTable = $('#languageDatatableAjax').DataTable({
                processing: true,
                serverSide: true,
                stateSave: true,
                searching: false,
                ajax: {
                    url: '{!! route('fetch.data.languages') !!}',
                    data: function (d) {
                        d.lang = $('#lang').val();
                        d.native = $('#native').val();
                        d.iso_code = $('#iso_code').val();
                        d.is_rtl = $('#is_rtl').val();
                        d.is_default = $('#is_default').val();
                        d.is_active = $('#is_active').val();
                    }
                }, columns: [
                    { data: 'lang', name: 'lang' },
                    { data: 'native', name: 'native' },
                    { data: 'iso_code', name: 'iso_code' },
                    { data: 'is_rtl', name: 'is_rtl' },
                    { data: 'is_default', name: 'is_default' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
            $('#Language-search-form').on('submit', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#lang').on('keyup', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#native').on('keyup', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#iso_code').on('keyup', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#is_default').on('change', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#is_active').on('change', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#is_rtl').on('change', function (e) {
                oTable.draw();
                e.preventDefault();
            });
        });
        function deleteLanguage(id, is_default) {
            var msg = 'Emin misiniz?';
            if (is_default != 1) {
                if (confirm(msg)) {
                    $.post("{{ route('delete.language') }}", { id: id, _method: 'DELETE', _token: '{{ csrf_token() }}' })
                        .done(function (response) {
                            if (response == 'ok') {
                                var table = $('#languageDatatableAjax').DataTable();
                                table.row('languageDtRow' + id).remove().draw(false);
                            } else {
                                alert('İşlem başarısız!');
                            }
                        });
                }
            } else {
                alert('Varsayılan Dili silemezsiniz');
            }
        }
        function makeDefaultLanguage(id) {
            $.post("{{ route('make.default.language') }}", { id: id, _method: 'PUT', _token: '{{ csrf_token() }}' })
                .done(function (response) {
                    if (response == 'ok') {
                        var table = $('#languageDatatableAjax').DataTable();
                        table.draw(false);
                    } else {
                        alert('İşlem başarısız!');
                    }
                });
        }
        function makeActive(id) {
            $.post("{{ route('make.active.language') }}", { id: id, _method: 'PUT', _token: '{{ csrf_token() }}' })
                .done(function (response) {
                    if (response == 'ok') {
                        var table = $('#languageDatatableAjax').DataTable();
                        table.row('languageDtRow' + id).remove().draw(false);
                    } else {
                        alert('İşlem başarısız!');
                    }
                });
        }
        function makeNotActive(id) {
            $.post("{{ route('make.not.active.language') }}", { id: id, _method: 'PUT', _token: '{{ csrf_token() }}' })
                .done(function (response) {
                    if (response == 'ok') {
                        var table = $('#languageDatatableAjax').DataTable();
                        table.row('languageDtRow' + id).remove().draw(false);
                    } else {
                        alert('İşlem başarısız!');
                    }
                });
        }
    </script>
@endpush