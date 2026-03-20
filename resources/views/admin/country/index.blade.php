@extends('admin.layouts.admin_layout')
@section('content')
<style type="text/css">
    .table td, .table th {
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
                <li> <span>Ülkeler</span> </li>
            </ul>
        </div>
        <!-- END PAGE BAR --> 
        <!-- BEGIN PAGE TITLE-->
        <h3 class="page-title">Ülke Yönetimi <small>Ülkeler</small> </h3>
        <!-- END PAGE TITLE--> 
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-12"> 
                <!-- Begin: life time stats -->
                <div class="portlet light portlet-fit portlet-datatable bordered">
                    <div class="portlet-title">
                        <div class="caption"> <i class="icon-settings font-dark"></i> <span class="caption-subject font-dark sbold uppercase">Ülkeler</span> </div>
                        <div class="actions"> <a href="{{ route('create.country') }}" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i> Yeni Ülke Ekle</a> </div>
                    </div>
                    <div class="portlet-body">
                        <div class="table-container">
                            <form method="post" role="form" id="country-search-form">
                                <table class="table table-striped table-bordered table-hover"  id="countryDatatableAjax">
                                    <thead>
                                        <tr role="row" class="filter"> 
                                            <td>{!! Form::select('lang', ['' => 'Language Seçin']+$languages, config('default_lang'), array('id'=>'lang', 'class'=>'form-control')) !!}</td>
                                            <td><input type="text" class="form-control" name="country" id="country" autocomplete="off" placeholder="Ülke"></td>                      
                                            <td><select name="is_active" id="is_active"  class="form-control">
                                                    <option value="-1">Durum?</option>
                                                    <option value="1" selected="selected">active</option>
                                                    <option value="0">Pasif</option>
                                                </select></td></tr>
                                        <tr role="row" class="heading">                                            
                                            <th>Language</th>
                                            <th>Ülke</th>
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
        var oTable = $('#countryDatatableAjax').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            searching: false,
            ajax: {
                url: '{!! route('fetch.data.countries') !!}',
                data: function (d) {
                    d.lang = $('#lang').val();
                    d.country = $('input[name=country]').val();
                    d.is_active = $('#is_active').val();
                }
            }, columns: [
                {data: 'lang', name: 'lang'},
                {data: 'country', name: 'country'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
        $('#country-search-form').on('submit', function (e) {
            oTable.draw();
            e.preventDefault();
        });
        $('#lang').on('change', function (e) {
            oTable.draw();
            e.preventDefault();
        });
        $('#country').on('keyup', function (e) {
            oTable.draw();
            e.preventDefault();
        });
        $('#is_active').on('change', function (e) {
            oTable.draw();
            e.preventDefault();
        });
    });
    function deleteCountry(id, is_default) {
        var msg = 'Emin misiniz?';
        if (is_default == 1) {
            msg = 'Emin misiniz? Varsayılan ülkeyi siliyorsunuz. Varsayılan olmayan diğer ülkeler de silinecek!';
        }
        if (confirm(msg)) {
            $.post("{{ route('delete.country') }}", {id: id, _method: 'DELETE', _token: '{{ csrf_token() }}'})
                    .done(function (response) {
                        if (response == 'ok')
                        {
                            var table = $('#countryDatatableAjax').DataTable();
                            table.row('countryDtRow' + id).remove().draw(false);
                        } else
                        {
                            alert('İşlem başarısız!');
                        }
                    });
        }
    }
    function makeActive(id) {
        $.post("{{ route('make.active.country') }}", {id: id, _method: 'PUT', _token: '{{ csrf_token() }}'})
                .done(function (response) {
                    if (response == 'ok')
                    {
                        var table = $('#countryDatatableAjax').DataTable();
                        table.row('countryDtRow' + id).remove().draw(false);
                    } else
                    {
                        alert('İşlem başarısız!');
                    }
                });
    }
    function makeNotActive(id) {
        $.post("{{ route('make.not.active.country') }}", {id: id, _method: 'PUT', _token: '{{ csrf_token() }}'})
                .done(function (response) {
                    if (response == 'ok')
                    {
                        var table = $('#countryDatatableAjax').DataTable();
                        table.row('countryDtRow' + id).remove().draw(false);
                    } else
                    {
                        alert('İşlem başarısız!');
                    }
                });
    }
</script> 
@endpush











