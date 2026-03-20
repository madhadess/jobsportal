@extends('admin.layouts.admin_layout')
@section('content')
    <style type="text/css">
        #jobDatatableAjax th,
        #jobDatatableAjax td {
            vertical-align: middle;
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
                    <li> <span>İlanlar</span> </li>
                </ul>
            </div>
            <!-- END PAGE BAR -->
            <!-- BEGIN PAGE TITLE-->
            <h3 class="page-title">İlan Yönetimi <small>İlanlar</small> </h3>
            <!-- END PAGE TITLE-->
            <!-- END PAGE HEADER-->
            <div class="row">
                <div class="col-md-12">
                    <!-- Begin: life time stats -->
                    <div class="portlet light portlet-fit portlet-datatable bordered">
                        <div class="portlet-title">
                            <div class="caption"> <i class="icon-settings font-dark"></i> <span
                                    class="caption-subject font-dark sbold uppercase">İlanlar</span> </div>
                            <div class="actions">
                                @if(Auth::guard('admin')->user()->hasPermission('create_jobs'))
                                    <a href="{{ route('create.job') }}" class="btn btn-xs btn-success"><i
                                            class="glyphicon glyphicon-plus"></i> Yeni İlan Ekle</a>
                                @endif
                            </div>
                        </div>
                        <div class="portlet-body">
                            <!-- Filtre Alanı - Ayrı -->
                            <div class="portlet-body" style="padding: 16px 20px !important;">
                                <form method="post" role="form" id="job-search-form">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label class="control-label">Şirket</label>
                                            {!! Form::select('company_id', ['' => 'Şirket'] + $companies, null, array('id' => 'company_id', 'class' => 'form-control')) !!}
                                        </div>
                                        <div class="col-md-3">
                                            <label class="control-label">Başlık</label>
                                            <input type="text" class="form-control" name="title" id="title"
                                                autocomplete="off" placeholder="Başlık">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="control-label">Açıklama</label>
                                            <input type="text" class="form-control" name="description" id="description"
                                                autocomplete="off" placeholder="Açıklama">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="control-label">Lokasyon</label>
                                            <?php $default_country_id = Request::query('country_id', $siteSetting->default_country_id); ?>
                                            {!! Form::select('country_id', ['' => 'Ülke'] + $countries, $default_country_id, array('id' => 'country_id', 'class' => 'form-control')) !!}
                                            <span id="default_state_dd">
                                                {!! Form::select('state_id', ['' => 'Eyalet'], null, array('id' => 'state_id', 'class' => 'form-control')) !!}
                                            </span>
                                            <span id="default_city_dd">
                                                {!! Form::select('city_id', ['' => 'Şehir'], null, array('id' => 'city_id', 'class' => 'form-control')) !!}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-2">
                                            <label class="control-label">Durum</label>
                                            <select name="is_active" id="is_active" class="form-control">
                                                <option value="-1">Durum</option>
                                                <option value="1">Aktif</option>
                                                <option value="0">Pasif</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="control-label">Öne Çıkan</label>
                                            <select name="is_featured" id="is_featured" class="form-control">
                                                <option value="-1">Öne Çıkan</option>
                                                <option value="1">Evet</option>
                                                <option value="0">Hayır</option>
                                            </select>
                                        </div>
                                        <div class="col-md-8">
                                            <label class="control-label">&nbsp;</label><br>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-search"></i> Filtrele
                                            </button>
                                            <button type="button" class="btn btn-default" onclick="resetFilters()">
                                                <i class="fa fa-refresh"></i> Sıfırla
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Tablo Alanı -->
                            <div class="portlet-body" style="padding: 0 !important;">
                                <div class="table-container">
                                    <table class="table table-striped table-bordered table-hover" id="jobDatatableAjax">
                                        <thead>
                                            <tr role="row" class="heading">
                                                <th>Şirket</th>
                                                <th>Başlık</th>
                                                <th>Açıklama</th>
                                                <th>Lokasyon</th>
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
        <!-- END CONTENT BODY -->
    </div>







@endsection
@push('scripts')
    <script>
        $(function () {
            var oTable = initModernDataTable('#jobDatatableAjax', {
                processing: true,
                serverSide: true,
                searching: false,
                ajax: {
                    url: '{!! route('fetch.data.jobs') !!}',
                    data: function (d) {
                        d.company_id = $('#company_id').val();
                        d.title = $('#title').val();
                        d.description = $('#description').val();
                        d.country_id = $('#country_id').val();
                        d.state_id = $('#state_id').val();
                        d.city_id = $('#city_id').val();
                        d.is_active = $('#is_active').val();
                        d.is_featured = $('#is_featured').val();
                    }
                },
                columns: [
                    { data: 'company_id', name: 'company_id' },
                    { data: 'title', name: 'title' },
                    { data: 'description', name: 'description' },
                    { data: 'city_id', name: 'city_id' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });


            $('#job-search-form').on('submit', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#company_id').on('change', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#title').on('keyup', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#description').on('keyup', function (e) {
                oTable.draw();
                e.preventDefault();
            });
            $('#country_id').on('change', function (e) {
                oTable.draw();
                e.preventDefault();
                filterDefaultStates(0);
            });
            $(document).on('change', '#state_id', function (e) {
                oTable.draw();
                e.preventDefault();
                filterDefaultCities(0);
            });
            $(document).on('change', '#city_id', function (e) {
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
            filterDefaultStates(0);
        });

        // Filtreleri sıfırla fonksiyonu
        function resetFilters() {
            $('#company_id').val('');
            $('#title').val('');
            $('#description').val('');
            $('#country_id').val('');
            $('#state_id').val('');
            $('#city_id').val('');
            $('#is_active').val('-1');
            $('#is_featured').val('-1');
            $('#jobDatatableAjax').DataTable().draw();
        }


        function deleteJob(id, is_default) {
            var msg = 'Emin misiniz?';
            if (confirm(msg)) {
                $.post("{{ route('delete.job') }}", { id: id, _method: 'DELETE', _token: '{{ csrf_token() }}' })
                    .done(function (response) {
                        if (response == 'ok') {
                            var table = $('#jobDatatableAjax').DataTable();
                            table.row('jobDtRow' + id).remove().draw(false);
                        } else {
                            alert('Talep başarısız!');
                        }
                    });
            }
        }
        function makeActive(id) {
            $.post("{{ route('make.active.job') }}", { id: id, _method: 'PUT', _token: '{{ csrf_token() }}' })
                .done(function (response) {
                    if (response == 'ok') {
                        var table = $('#jobDatatableAjax').DataTable();
                        table.row('jobDtRow' + id).remove().draw(false);
                    } else {
                        alert('Talep başarısız!');
                    }
                });
        }
        function makeNotActive(id) {
            $.post("{{ route('make.not.active.job') }}", { id: id, _method: 'PUT', _token: '{{ csrf_token() }}' })
                .done(function (response) {
                    if (response == 'ok') {
                        var table = $('#jobDatatableAjax').DataTable();
                        table.row('jobDtRow' + id).remove().draw(false);
                    } else {
                        alert('Talep başarısız!');
                    }
                });
        }
        function makeFeatured(id) {
            $.post("{{ route('make.featured.job') }}", { id: id, _method: 'PUT', _token: '{{ csrf_token() }}' })
                .done(function (response) {
                    if (response == 'ok') {
                        var table = $('#jobDatatableAjax').DataTable();
                        table.row('jobDtRow' + id).remove().draw(false);
                    } else {
                        alert('Talep başarısız!');
                    }
                });
        }
        function makeNotFeatured(id) {
            $.post("{{ route('make.not.featured.job') }}", { id: id, _method: 'PUT', _token: '{{ csrf_token() }}' })
                .done(function (response) {
                    if (response == 'ok') {
                        var table = $('#jobDatatableAjax').DataTable();
                        table.row('jobDtRow' + id).remove().draw(false);
                    } else {
                        alert('Talep başarısız!');
                    }
                });
        }
        function filterDefaultStates(state_id) {
            var country_id = $('#country_id').val();
            if (country_id != '') {
                $.post("{{ route('filter.default.states.dropdown') }}", { country_id: country_id, state_id: state_id, _method: 'POST', _token: '{{ csrf_token() }}' })
                    .done(function (response) {
                        $('#default_state_dd').html(response);
                    });
            }
        }
        function filterDefaultCities(city_id) {
            var state_id = $('#state_id').val();
            if (state_id != '') {
                $.post("{{ route('filter.default.cities.dropdown') }}", { state_id: state_id, city_id: city_id, _method: 'POST', _token: '{{ csrf_token() }}' })
                    .done(function (response) {
                        $('#default_city_dd').html(response);
                    });
            }
        }
    </script>
@endpush