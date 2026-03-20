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
                        <li> <span>Ülke Detayları</span> </li>
                    </ul>
                </div>
                <!-- END PAGE BAR -->
                <!-- BEGIN PAGE TITLE-->
                <h3 class="page-title">Ülke Detaylarını Yönet <small>Ülke Detayları</small> </h3>
                <!-- END PAGE TITLE-->
                <!-- END PAGE HEADER-->
                <div class="row">
                    <div class="col-md-12">
                        <!-- Begin: life time stats -->
                        <div class="portlet light portlet-fit portlet-datatable bordered">
                            <div class="portlet-title">
                                <div class="caption"> <i class="icon-settings font-dark"></i> <span
                                        class="caption-subject font-dark sbold uppercase">Ülke Detayları</span> </div>
                            </div>
                            <div class="portlet-body">
                                <div class="table-container">
                                    <form method="post" role="form" id="countryDetail-search-form">
                                        <table class="table table-striped table-bordered table-hover"
                                            id="countryDetailDatatableAjax">
                                            <thead>
                                                <tr role="row" class="heading">
                                                    <th>Ülke</th>
                                                    <th>Sıralama Adı</th>
                                                    <th>Telefon Kodu</th>
                                                    <th>Para Birimi</th>
                                                    <th>Kod</th>
                                                    <th>Sembol</th>
                                                    <th>Binlik<br />Ayırıcı</th>
                                                    <th>Ondalık<br />Ayırıcı</th>
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
            var oTable = $('#countryDetailDatatableAjax').DataTable({
                processing: true,
                serverSide: true,
                stateSave: true,
                searching: true,
                /*		
                 "order": [[1, "asc"]],            
                 paging: true,
                 info: true,
                 */
                ajax: {
                    url: '{!! route('fetch.data.country.details') !!}'
                },
                columns: [
                    { data: 'country_id', name: 'country_id' },
                    { data: 'sort_name', name: 'sort_name' },
                    { data: 'phone_code', name: 'phone_code' },
                    { data: 'currency', name: 'currency' },
                    { data: 'code', name: 'code' },
                    { data: 'symbol', name: 'symbol' },
                    { data: 'thousand_separator', name: 'thousand_separator' },
                    { data: 'decimal_separator', name: 'decimal_separator' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }