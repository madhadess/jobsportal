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
                    <li> <span>Sonuç Türleri</span> </li>
                </ul>
            </div>
            <!-- END PAGE BAR -->
            <!-- BEGIN PAGE TITLE-->
            <h3 class="page-title">Sonuç Türü Yönetimi <small>Sonuç Türleri</small> </h3>
            <!-- END PAGE TITLE-->
            <!-- END PAGE HEADER-->
            <div class="row">
                <div class="col-md-12">
                    <!-- Begin: life time stats -->
                    <div class="portlet light portlet-fit portlet-datatable bordered">
                        <div class="portlet-title">
                            <div class="caption"> <i class="icon-settings font-dark"></i> <span
                                    class="caption-subject font-dark sbold uppercase">Sonuç Türleri</span> </div>
                            <div class="actions"> <a href="{{ route('create.result.type') }}"
                                    class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i> Yeni Sonuç Türü
                                    Ekle</a> </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-container">
                                <form method="post" role="form" id="resultType-search-form">
                                    <table class="table table-striped table-bordered table-hover"
                                        id="resultTypeDatatableAjax">
                                        <thead>
                                            <tr role="row" class="filter">
                                                <td>{!! Form::select('lang', ['' => 'Dil Seçin'] + $languages, config('default_lang'), array('id' => 'lang', 'class' => 'form-control')) !!}
                                                </td>
                                                <td><input type="text" class="form-control" name="result_type"
                                                        id="result_type" autocomplete="off" placeholder="Sonuç Türü"></td>
                                                <td><select name="is_active" id="is_active" class="form-control">
                                                        <option value="-1">Aktif mi?</option>
                                                        <option value="1" selected="selected">Aktif</option>
                                                        <option value="0">Pasif</option>
                                                    </select></td>
                                            </tr>
                                            <tr role="row" class="heading">
                                                <th>Dil</th>
                                                <th>Sonuç Türü</th>
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
            var oTable = $('#resultTypeDatatableAjax').DataTable({
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
                    url: '{!! route('fetch.data.result.types') !!}',
                    data: function (d) {
                        d.lang = $('#lang').val();
                        d.result_type = $('#result_type').val();
                        d.is_active = $('#is_active').val();
                    }
                }, columns: [
                    { data: 'lang', name: 'lang' },
                    { data: 'result_type', name: 'result_type' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
            $('#resultType-search-form').on('submit', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#lang').on('change', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#result_type').on('keyup', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#is_active').on('change', function (e) {
                oTable.draw();
                e.preventDefault();
            });
        });
        function deleteResultType(id, is_default) {
            var msg = 'Emin misiniz?';
            if (is_default == 1) {
                msg = 'Emin misiniz? Varsayılan sonuç türünü siliyorsunuz, diğer tüm varsayılan olmayan sonuç türleri de silinecek!';
            }
            if (confirm(msg)) {
                $.post("{{ route('delete.result.type') }}", { id: id, _method: 'DELETE', _token: '{{ csrf_token() }}' })
                    .done(function (response) {
                        if (response == 'ok') {
                            var table = $('#resultTypeDatatableAjax').DataTable();
                            table.row('resultTypeDtRow' + id).remove().draw(false);
                        } else {
                            alert('İşlem Başarısız!');
                        }
                    });
            }
        }
        function makeActive(id) {
            $.post("{{ route('make.active.result.type') }}", { id: id, _method: 'PUT', _token: '{{ csrf_token() }}' })
                .done(function (response) {
                    if (response == 'ok') {
                        var table = $('#resultTypeDatatableAjax').DataTable();
                        table.row('resultTypeDtRow' + id).remove().draw(false);
                    } else {
                        alert('İşlem Başarısız!');
                    }
                });
        }
        function makeNotActive(id) {
            $.post("{{ route('make.not.active.result.type') }}", { id: id, _method: 'PUT', _token: '{{ csrf_token() }}' })
                .done(function (response) {
                    if (response == 'ok') {
                        var table = $('#resultTypeDatatableAjax').DataTable();
                        table.row('resultTypeDtRow' + id).remove().draw(false);
                    } else {
                        alert('İşlem Başarısız!');
                    }
                });
        }
    </script>
@endpush