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
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li> <a href="{{ route('admin.home') }}">Ana Sayfa</a> <i class="fa fa-circle"></i> </li>
                    <li> <span>Rol Yönetimi</span> </li>
                </ul>
            </div>
            <h3 class="page-title"> Rol Yönetimi <small>Roller</small> </h3>
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light portlet-fit portlet-datatable bordered">
                        <div class="portlet-title">
                            <div class="caption"> <i class="icon-settings font-dark"></i> <span
                                    class="caption-subject font-dark sbold uppercase">Roller</span> </div>
                            <div class="actions">
                                <a href="{{ route('admin.roles.create') }}" class="btn btn-xs btn-success"><i
                                        class="glyphicon glyphicon-plus"></i> Yeni Rol Ekle</a>
                            </div>
                        </div>
                        <div class="portlet-body">
                            <div class="table-container">
                                <table class="table table-striped table-bordered table-hover" id="roles_datatable_ajax">
                                    <thead>
                                        <tr role="row" class="heading">
                                            <th>Rol Adı</th>
                                            <th>Görünen Ad</th>
                                            <th>Sistem Rolü?</th>
                                            <th>Durum</th>
                                            <th>İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(function () {
            $('#roles_datatable_ajax').DataTable({
                "order": [[0, "asc"]],
                processing: true,
                serverSide: true,
                stateSave: true,
                ajax: '{!! route('admin.roles.fetch') !!}',
                columns: [
                    { data: 'role_name', name: 'role_name' },
                    { data: 'display_name', name: 'display_name' },
                    { data: 'is_system_label', name: 'is_system', orderable: false, searchable: false },
                    { data: 'is_active_label', name: 'is_active', orderable: false, searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
        });
        function deleteRole(id) {
            if (confirm('Emin misiniz? Silmek istiyor musunuz?')) {
                $.post("{{ route('admin.roles.delete') }}", { id: id, _method: 'DELETE', _token: '{{ csrf_token() }}' })
                    .done(function (response) {
                        if (response == 'ok') {
                            var table = $('#roles_datatable_ajax').DataTable();
                            table.row('roleDtRow' + id).remove().draw(false);
                        } else {
                            alert('İşlem başarısız! Sistem rolleri silinemez.');
                        }
                    });
            }
        }
    </script>
@endpush