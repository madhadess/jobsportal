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
                <li> <span>Yeni Yönetici Kullanıcı Ekle</span> </li>
            </ul>
        </div>
        <!-- END PAGE BAR --> 
        <!-- BEGIN PAGE TITLE-->
        <h3 class="page-title"> Yeni Yönetici Kullanıcı Ekle <small>Yönetici Kullanıcılar</small> </h3>
        <!-- END PAGE TITLE--> 
        <!-- END PAGE HEADER-->
        <div class="row">
            <div class="col-md-6">
                <div class="portlet light bordered">
                    <div class="portlet-title">
                        <div class="caption font-red-sunglo"> <i class="icon-settings font-red-sunglo"></i> <span class="caption-subject bold uppercase">Yeni Yönetici Kullanıcı Formu</span> </div>
                    </div>
                    <div class="portlet-body form">
                        {!! Form::open(array('route' => 'store.admin.user', 'class' => 'form', 'novalidate' => 'novalidate')) !!}            
                        @include('admin.admin.add_edit_form')
                        <div class="form-Actionler">
                            {!! Form::submit('Yeni Yönetici Kullanıcı Oluştur!', array('class'=>'btn blue')) !!}
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END CONTENT BODY --> 
</div>
@endsection







