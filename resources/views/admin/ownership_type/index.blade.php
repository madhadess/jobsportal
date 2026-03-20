@extends('admin.layouts.admin_layout')
@section('content')
<style type="text/css">
    .table td, .table th {
        font-size: 12px;
        line-height: 2.42857 !important;
    }	
</style>

<div class="page-content-wrapper"> 
    <div class="page-content"> 

        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li>
                    <a href="{{ route('admin.home') }}">Ana Sayfa</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Sahiplik Türleri</span>
                </li>
            </ul>
        </div>

        <h3 class="page-title">
            Sahiplik Türlerini Yönet
            <small>Sahiplik Türleri</small>
        </h3>

        <div class="row">
            <div class="col-md-12">

                <div class="portlet light portlet-fit portlet-datatable bordered">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="icon-settings font-dark"></i>
                            <span class="caption-subject font-dark sbold uppercase">
                                Sahiplik Türleri
                            </span>
                        </div>
                        <div class="actions">
                            <a href="{{ route('create.ownership.type') }}" class="btn btn-xs btn-success">
                                <i class="glyphicon glyphicon-plus"></i>
                                Yeni Sahiplik Türü Ekle
                            </a>
                        </div>
                    </div>

                    <div class="portlet-body">
                        <div class="table-container">
                            <form method="post" role="form" id="ownershipType-search-form">
                                <table class="table table-striped table-bordered table-hover" id="ownershipTypeDatatableAjax">
                                    <thead>
                                        <tr role="row" class="filter">
                                            <td>
                                                {!! Form::select(
                                                    'lang',
                                                    ['' => 'Dil Seçiniz'] + $languages,
                                                    config('default_lang'),
                                                    ['id'=>'lang', 'class'=>'form-control']
                                                ) !!}
                                            </td>
                                            <td>
                                                <input type="text"
                                                       class="form-control"
                                                       name="ownership_type"
                                                       id="ownership_type"
                                                       autocomplete="off"
                                                       placeholder="Sahiplik Türü">
                                            </td>
                                            <td>
                                                <select name="is_active" id="is_active" class="form-control">
                                                    <option value="-1">Aktif mi?</option>
                                                    <option value="1" selected="selected">Aktif</option>
                                                    <option value="0">Pasif</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr role="row" class="heading">
                                            <th>Dil</th>
                                            <th>Sahiplik Türü</th>
                                            <th>İşlemler</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </form>
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

    var oTable = $('#ownershipTypeDatatableAjax').DataTable({
        processing: true,
        serverSide: true,
        stateSave: true,
        searching: false,

        ajax: {
            url: '{!! route('fetch.data.ownership.types') !!}',
            data: function (d) {
                d.lang = $('#lang').val();
                d.ownership_type = $('#ownership_type').val();
                d.is_active = $('#is_active').val();
            }
        },
        columns: [
            {data: 'lang', name: 'lang'},
            {data: 'ownership_type', name: 'ownership_type'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });

    $('#ownershipType-search-form').on('submit', function (e) {
        oTable.draw();
        e.preventDefault();
    });

    $('#lang, #is_active').on('change', function () {
        oTable.draw();
    });

    $('#ownership_type').on('keyup', function () {
        oTable.draw();
    });

});

function deleteOwnershipType(id, is_default) {
    var msg = 'Silmek istediğinize emin misiniz?';

    if (is_default == 1) {
        msg = 'Varsayılan sahiplik türünü siliyorsunuz. Diğer tüm varsayılan olmayan sahiplik türleri de silinecektir. Emin misiniz?';
    }

    if (confirm(msg)) {
        $.post("{{ route('delete.ownership.type') }}", {
            id: id,
            _method: 'DELETE',
            _token: '{{ csrf_token() }}'
        }).done(function (response) {
            if (response == 'ok') {
                var table = $('#ownershipTypeDatatableAjax').DataTable();
                table.row('ownershipTypeDtRow' + id).remove().draw(false);
            } else {
                alert('İşlem başarısız!');
            }
        });
    }
}

function makeActive(id) {
    $.post("{{ route('make.active.ownership.type') }}", {
        id: id,
        _method: 'PUT',
        _token: '{{ csrf_token() }}'
    }).done(function (response) {
        if (response == 'ok') {
            var table = $('#ownershipTypeDatatableAjax').DataTable();
            table.row('ownershipTypeDtRow' + id).remove().draw(false);
        } else {
            alert('İşlem başarısız!');
        }
    });
}

function makeNotActive(id) {
    $.post("{{ route('make.not.active.ownership.type') }}", {
        id: id,
        _method: 'PUT',
        _token: '{{ csrf_token() }}'
    }).done(function (response) {
        if (response == 'ok') {
            var table = $('#ownershipTypeDatatableAjax').DataTable();
            table.row('ownershipTypeDtRow' + id).remove().draw(false);
        } else {
            alert('İşlem başarısız!');
        }
    });
}
</script>
@endpush
