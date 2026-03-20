@extends('admin.layouts.admin_layout')
@section('content')
    <div class="page-content-wrapper">
        <div class="page-content">
            <div class="page-bar">
                <ul class="page-breadcrumb">
                    <li> <a href="{{ route('admin.home') }}">Ana Sayfa</a> <i class="fa fa-circle"></i> </li>
                    <li> <a href="{{ route('admin.roles.index') }}">Roller</a> <i class="fa fa-circle"></i> </li>
                    <li> <span>Yeni Rol Ekle</span> </li>
                </ul>
            </div>
            <br />
            @include('flash::message')
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo"> <i class="icon-settings font-red-sunglo"></i> <span
                                    class="caption-subject bold uppercase">Rol Formu</span> </div>
                        </div>
                        <div class="portlet-body form">
                            <ul class="nav nav-tabs">
                                <li class="active"> <a href="#Details" data-toggle="tab" aria-expanded="false"> Detaylar ve
                                        Yetkiler </a> </li>
                            </ul>
                            {!! Form::open(array('method' => 'post', 'route' => 'admin.roles.store', 'class' => 'form')) !!}
                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="Details"> @include('admin.role.forms.form') </div>
                            </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection