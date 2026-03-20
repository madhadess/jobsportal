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
                    <li> <span>Maaş Dönemleri</span> </li>
                </ul>
            </div>
            <!-- END PAGE BAR -->
            <!-- BEGIN PAGE TITLE-->
            <h3 class="page-title">Maaş Dönemi Yönetimi <small>Maaş Dönemleri</small> </h3>
            <!-- END PAGE TITLE-->
            <!-- END PAGE HEADER-->
            <div class="row">
                <div class="col-md-12">
                    <!-- Begin: life time stats -->
                    <div class="portlet light portlet-fit portlet-datatable bordered">
                        <div class="portlet-title">
                            <div class="caption"> <i class="icon-settings font-dark"></i> <span
                                    class="caption-subject font-dark sbold uppercase">Maaş Dönemleri</span> </div>
                            <div class="actions"> <a href="{{ route('create.salary.period') }}"
                                    class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i> Yeni Maaş Dönemi
                                    Ekle</a> </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-container">
                                <form method="post" role="form" id="salaryPeriod-search-form">
                                    <table class="table table-striped table-bordered table-hover"
                                        id="salaryPeriodDatatableAjax">
                                        <thead>
                                            <tr role="row" class="filter">
                                                <td>{!! Form::select('lang', ['' => 'Dil Seçin'] + $languages, config('default_lang'), array('id' => 'lang', 'class' => 'form-control')) !!}
                                                </td>
                                                <td><input type="text" class="form-control" name="salary_period"
                                                        id="salary_period" autocomplete="off" placeholder="Maaş Dönemi">
                                                </td>
                                                <td><select name="is_active" id="is_active" class="form-control">
                                                        <option value="-1">Aktif mi?</option>
                                                        <option value="1" selected="selected">Aktif</option>
                                                        <option value="0">Pasif</option>
                                                    </select></td>
                                            </tr>
                                            <tr role="row" class="heading">
                                                <th>Dil</th>
                                                <th>Maaş Dönemi</th>
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
            var oTable = $('#salaryPeriodDatatableAjax').DataTable({
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
                    url: '{!! route('fetch.data.salary.periods') !!}',
                    data: function (d) {
                        d.lang = $('#lang').val();
                        d.salary_period = $('input[name=salary_period]').val();
                        d.is_active = $('#is_active').val();
                    }
                }, columns: [
                    { data: 'lang', name: 'lang' },
                    { data: 'salary_period', name: 'salary_period' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
            $('#salaryPeriod-search-form').on('submit', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#lang').on('change', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#salary_period').on('keyup', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#is_active').on('change', function (e) {
                oTable.draw();
                e.preventDefault();
            });
        });
        function deleteSalaryPeriod(id, is_default) {
            var msg = 'Emin misiniz?';
            if (is_default == 1) {
                msg = 'Emin misiniz? Varsayılan maaş dönemini siliyorsunuz, diğer tüm varsayılan olmayan maaş dönemleri de silinecek!';
            }
            if (confirm(msg)) {
                $.post("{{ route('delete.salary.period') }}", { id: id, _method: 'DELETE', _token: '{{ csrf_token() }}' })
                    .done(function (response) {
                        if (response == 'ok') {
                            var table = $('#salaryPeriodDatatableAjax').DataTable();
                            table.row('salaryPeriodDtRow' + id).remove().draw(false);
                        } else {
                            alert('İşlem Başarısız!');
                        }
                    });
            }
        }
        function makeActive(id) {
            $.post("{{ route('make.active.salary.period') }}", { id: id, _method: 'PUT', _token: '{{ csrf_token() }}' })
                .done(function (response) {
                    if (response == 'ok') {
                        var table = $('#salaryPeriodDatatableAjax').DataTable();
                        table.row('salaryPeriodDtRow' + id).remove().draw(false);
                    } else {
                        alert('Request Failed!');
                    }
                });
        }
        function makeNotActive(id) {
            $.post("{{ route('make.not.active.salary.period') }}", { id: id, _method: 'PUT', _token: '{{ csrf_token() }}' })
                .done(function (response) {
                    if (response == 'ok') {
                        var table = $('#salaryPeriodDatatableAjax').DataTable();
                        table.row('salaryPeriodDtRow' + id).remove().draw(false);
                    } else {
                        alert('Request Failed!');
                    }
                });
        }
    </script>
@endpush