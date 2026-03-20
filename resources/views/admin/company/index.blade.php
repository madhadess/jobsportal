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
                    <li> <span>Şirketler</span> </li>
                </ul>
            </div>
            <!-- END PAGE BAR -->
            <!-- BEGIN PAGE TITLE-->
            <h3 class="page-title">Şirket Yönetimi <small>Şirketler</small> </h3>
            <!-- END PAGE TITLE-->
            <!-- END PAGE HEADER-->
            <div class="row">
                <div class="col-md-12">
                    <!-- Begin: life time stats -->
                    <div class="portlet light portlet-fit portlet-datatable bordered">
                        <div class="portlet-title">
                            <div class="caption"> <i class="icon-settings font-dark"></i> <span
                                    class="caption-subject font-dark sbold uppercase">Şirketler</span> </div>
                            <div class="actions">
                                @if(Auth::guard('admin')->user()->hasPermission('create_companies'))
                                    <a href="{{ route('create.company') }}" class="btn btn-xs btn-success"><i
                                            class="glyphicon glyphicon-plus"></i> Yeni Şirket Ekle</a>
                                @endif
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-container">
                                <form method="post" role="form" id="datatable-search-form">
                                    <table class="table table-striped table-bordered table-hover" id="companyDatatableAjax">
                                        <thead>
                                            <tr role="row" class="filter">
                                                <td><input type="text" class="form-control" name="name" id="name"
                                                        autocomplete="off" placeholder="Şirket Adı"></td>
                                                <td><input type="text" class="form-control" name="email" id="email"
                                                        autocomplete="off" placeholder="Şirket E-postası"></td>
                                                <td><select name="is_active" id="is_active" class="form-control">
                                                        <option value="-1">Durum</option>
                                                        <option value="1" selected="selected">Aktif</option>
                                                        <option value="0">Pasif</option>
                                                    </select></td>
                                                <td><select name="is_featured" id="is_featured" class="form-control">
                                                        <option value="-1">Öne Çıkan</option>
                                                        <option value="1">Öne Çıkan</option>
                                                        <option value="0">Normal</option>
                                                    </select></td>
                                                <td></td>
                                            </tr>
                                            <tr role="row" class="heading">
                                                <th>Ad</th>
                                                <th>E-posta</th>
                                                <th>Durum</th>
                                                <th>Öne Çıkan</th>
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
            var oTable = $('#companyDatatableAjax').DataTable({
                processing: true,
                serverSide: true,
                stateSave: true,
                searching: false,
                ajax: {
                    url: '{!! route('fetch.data.companies') !!}',
                    data: function (d) {
                        d.name = $('#name').val();
                        d.email = $('#email').val();
                        d.is_active = $('#is_active').val();
                        d.is_featured = $('#is_featured').val();
                    }
                }, columns: [
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'is_active', name: 'is_active' },
                    { data: 'is_featured', name: 'is_featured' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
            $('#datatable-search-form').on('submit', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#name').on('keyup', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#email').on('keyup', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#is_active').on('change', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#is_featured').on('change', function (e) {
                oTable.draw();
                e.preventDefault();
            });
        });
        function deleteCompany(id) {
            var msg = 'Emin misiniz?';
            if (confirm(msg)) {
                $.post("{{ route('delete.company') }}", { id: id, _method: 'DELETE', _token: '{{ csrf_token() }}' })
                    .done(function (response) {
                        if (response == 'ok') {
                            var table = $('#companyDatatableAjax').DataTable();
                            table.row('companyDtRow' + id).remove().draw(false);
                        } else {
                            alert('İşlem başarısız!');
                        }
                    });
            }
        }
        function makeActive(id) {
            $.post("{{ route('make.active.company') }}", { id: id, _method: 'PUT', _token: '{{ csrf_token() }}' })
                .done(function (response) {
                    if (response == 'ok') {
                        var table = $('#companyDatatableAjax').DataTable();
                        table.row('companyDtRow' + id).remove().draw(false);
                    } else {
                        alert('Talep başarısız!');
                    }
                });
        }
        function makeNotActive(id) {
            $.post("{{ route('make.not.active.company') }}", { id: id, _method: 'PUT', _token: '{{ csrf_token() }}' })
                .done(function (response) {
                    if (response == 'ok') {
                        var table = $('#companyDatatableAjax').DataTable();
                        table.row('companyDtRow' + id).remove().draw(false);
                    } else {
                        alert('Talep başarısız!');
                    }
                });
        }
        function makeFeatured(id) {
            $.post("{{ route('make.featured.company') }}", { id: id, _method: 'PUT', _token: '{{ csrf_token() }}' })
                .done(function (response) {
                    if (response == 'ok') {
                        var table = $('#companyDatatableAjax').DataTable();
                        table.row('companyDtRow' + id).remove().draw(false);
                    } else {
                        alert('Talep başarısız!');
                    }
                });
        }
        function makeNotFeatured(id) {
            $.post("{{ route('make.not.featured.company') }}", { id: id, _method: 'PUT', _token: '{{ csrf_token() }}' })
                .done(function (response) {
                    if (response == 'ok') {
                        var table = $('#companyDatatableAjax').DataTable();
                        table.row('companyDtRow' + id).remove().draw(false);
                    } else {
                        alert('Talep başarısız!');
                    }
                });
        }
    </script>
@endpush