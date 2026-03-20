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
                    <li> <span>Üyeler</span> </li>
                </ul>
            </div>
            <!-- END PAGE BAR -->
            <!-- BEGIN PAGE TITLE-->
            <h3 class="page-title">Üye Yönetimi <small>Üyeler</small> </h3>
            <!-- END PAGE TITLE-->
            <!-- END PAGE HEADER-->
            <div class="row">
                <div class="col-md-12">
                    <!-- Begin: life time stats -->
                    <div class="portlet light portlet-fit portlet-datatable bordered">
                        <div class="portlet-title">
                            <div class="caption"> <i class="icon-settings font-dark"></i> <span
                                    class="caption-subject font-dark sbold uppercase">Üyeler</span> </div>
                            <div class="actions">
                                @if(Auth::guard('admin')->user()->hasPermission('create_users'))
                                    <a href="{{ route('create.user') }}" class="btn btn-xs btn-success"><i
                                            class="glyphicon glyphicon-plus"></i> Yeni Üye Ekle</a>
                                @endif
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-container">
                                <form method="post" role="form" id="user-search-form">
                                    <table class="table table-striped table-bordered table-hover" id="user_datatable_ajax">
                                        <thead>
                                            <tr role="row" class="filter">
                                                <td><input type="text" class="form-control" name="id" id="id"
                                                        autocomplete="off" placeholder="ID Ara"></td>
                                                <td><input type="text" class="form-control" name="name" id="name"
                                                        autocomplete="off" placeholder="Ad Soyad Ara"></td>
                                                <td><input type="text" class="form-control" name="email" id="email"
                                                        autocomplete="off" placeholder="E-posta Ara"></td>
                                                <td>
                                                    <select name="user_type" id="user_type" class="form-control"
                                                        autocomplete="off">
                                                        <option value="-1">Tümü (Üye Tipi)</option>
                                                        <option value="candidate">Aday</option>
                                                        <option value="member">Hizmet Alan</option>
                                                        <option value="personnel">Hizmet Personeli</option>
                                                        <option value="caregiver">Bakıcı</option>
                                                    </select>
                                                </td>
                                                <td></td>
                                            </tr>
                                            <tr role="row" class="heading">
                                                <th>ID</th>
                                                <th>Ad</th>
                                                <th>E-posta</th>
                                                <th>Üye Tipi</th>
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
            var oTable = $('#user_datatable_ajax').DataTable({
                processing: true,
                serverSide: true,
                stateSave: true,
                searching: false,
                "order": [[0, "desc"]],
                ajax: {
                    url: '{!! route('fetch.data.users') !!}',
                    data: function (d) {
                        d.id = $('input[name=id]').val();
                        d.name = $('input[name=name]').val();
                        d.email = $('input[name=email]').val();
                        d.user_type = $('#user_type').val();
                    }
                }, columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'email', name: 'email' },
                    { data: 'user_type', name: 'user_type' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
            $('#user-search-form').on('submit', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#id').on('keyup', function (e) {
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
            $('#user_type').on('change', function (e) {
                oTable.draw();
                e.preventDefault();
            });
        });
        function delete_user(id) {
            if (confirm('Emin misiniz? Silmek istiyor musunuz?')) {
                $.post("{{ route('delete.user') }}", { id: id, _method: 'DELETE', _token: '{{ csrf_token() }}' })
                    .done(function (response) {
                        if (response == 'ok') {
                            var table = $('#user_datatable_ajax').DataTable();
                            table.row('user_dt_row_' + id).remove().draw(false);
                        } else {
                            alert('İşlem başarısız!');
                        }
                    });
            }
        }
        function make_active(id) {
            $.post("{{ route('make.active.user') }}", { id: id, _method: 'PUT', _token: '{{ csrf_token() }}' })
                .done(function (response) {
                    if (response == 'ok') {
                        $('#onclick_active_' + id).attr("onclick", "make_not_active(" + id + ")");
                        $('#onclick_active_' + id).html("<i class=\"fa fa-check-square-o\" aria-hidden=\"true\"></i>Pasif Yap");
                    } else {
                        alert('İşlem başarısız!');
                    }
                });
        }
        function make_not_active(id) {
            $.post("{{ route('make.not.active.user') }}", { id: id, _method: 'PUT', _token: '{{ csrf_token() }}' })
                .done(function (response) {
                    if (response == 'ok') {
                        $('#onclick_active_' + id).attr("onclick", "make_active(" + id + ")");
                        $('#onclick_active_' + id).html("<i class=\"fa fa-square-o\" aria-hidden=\"true\"></i>Aktif Yap");
                    } else {
                        alert('İşlem başarısız!');
                    }
                });
        }
        function make_verified(id) {
            $.post("{{ route('make.verified.user') }}", { id: id, _method: 'PUT', _token: '{{ csrf_token() }}' })
                .done(function (response) {
                    if (response == 'ok') {
                        $('#onclick_verified_' + id).attr("onclick", "make_not_verified(" + id + ")");
                        $('#onclick_verified_' + id).html("<i class=\"fa fa-check-square-o\" aria-hidden=\"true\"></i>Doğrulandı");
                    } else {
                        alert('İşlem başarısız!');
                    }
                });
        }
        function make_not_verified(id) {
            $.post("{{ route('make.not.verified.user') }}", { id: id, _method: 'PUT', _token: '{{ csrf_token() }}' })
                .done(function (response) {
                    if (response == 'ok') {
                        $('#onclick_verified_' + id).attr("onclick", "make_verified(" + id + ")");
                        $('#onclick_verified_' + id).html("<i class=\"fa fa-square-o\" aria-hidden=\"true\"></i>Doğrulanmadı");
                    } else {
                        alert('İşlem başarısız!');
                    }
                });
        }
    </script>
@endpush