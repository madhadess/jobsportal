@extends('admin.layouts.admin_layout')
@section('content')
<div class="page-content-wrapper"> 
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content"> 
        <!-- BEGIN PAGE HEADER--> 
        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb">
                <li> <a href="{{ route('admin.home') }}">Ana Sayfa</a> <i class="fa fa-circle"></i> </li>
                <li> <a href="{{ route('list.cities') }}">Şehirler</a> <i class="fa fa-circle"></i> </li>
                <li> <span>Şehir Düzenle</span> </li>
            </ul>
        </div>
        <!-- END PAGE BAR -->        
        <!-- END PAGE HEADER-->
        <br />
        @include('flash::message')
        <div class="row">
            <div class="col-md-12">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-red-sunglo"> <i class="icon-settings font-red-sunglo"></i> <span class="caption-subject bold uppercase">Şehir Formu</span> </div>
                    </div>
                    <div class="portlet-body form">          
                        <ul class="nav nav-tabs">              
                            <li class="Aktif"> <a href="#Details" data-toggle="tab" aria-expanded="false"> Detaylar </a> </li>
                        </ul>
                        {!! Form::model($city, array('method' => 'put', 'route' => array('update.city', $city->id), 'class' => 'form', 'files'=>true)) !!}
                        {!! Form::hidden('id', $city->id) !!}            
                        <div class="tab-content">              
                            <div class="tab-pane fade active in" id="Details"> @include('admin.city.forms.form') </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
        <!-- END CONTENT BODY --> 
    </div>
    @endsection







