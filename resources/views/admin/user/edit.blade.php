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
                    <li> <a href="{{ route('list.users') }}">Kullanıcılar</a> <i class="fa fa-circle"></i> </li>
                    <li> <span>Kullanıcıyı Düzenle</span> </li>
                </ul>
            </div>
            <!-- END PAGE BAR -->
            <!-- BEGIN PAGE TITLE-->
            <!--<h3 class="page-title">Kullanıcıyı Düzenle <small>Kullanıcılar</small> </h3>-->
            <!-- END PAGE TITLE-->
            <!-- END PAGE HEADER-->
            <br />
            @include('flash::message')
            <div class="row">
                <div class="col-md-12">
                    <div class="portlet light bordered">
                        <div class="portlet-title">
                            <div class="caption font-red-sunglo"> <i class="icon-settings font-red-sunglo"></i> <span
                                    class="caption-subject bold uppercase">Kullanıcı Formu</span> </div>
                        </div>
                        <div class="portlet-body form">
                            <ul class="nav nav-tabs">
                                <li class="Aktif"> <a href="#Details" data-toggle="tab" aria-expanded="false"> Detaylar </a>
                                </li>
                                <li><a href="#Summary" data-toggle="tab" aria-expanded="false">Özet</a></li>
                                <li><a href="#Video" data-toggle="tab" aria-expanded="false">Tanıtım Videosu</a></li>
                                <li><a href="#CV" data-toggle="tab" aria-expanded="false">Özgeçmiş</a></li>
                                <li><a href="#Projects" data-toggle="tab" aria-expanded="false">Projeler</a></li>
                                <li><a href="#Experience" data-toggle="tab" aria-expanded="false">Deneyim</a></li>
                                <li><a href="#Education" data-toggle="tab" aria-expanded="false">Eğitim</a></li>
                                <li><a href="#Skills" data-toggle="tab" aria-expanded="false">Yetenekler</a></li>
                                <li><a href="#Languages" data-toggle="tab" aria-expanded="false">Diller</a></li>
                            </ul>

                            <div class="tab-content">
                                <div class="tab-pane fade active in" id="Details"> @include('admin.user.forms.form') </div>
                                <div class="tab-pane fade" id="Summary"> @include('admin.user.forms.summary') </div>
                                <div class="tab-pane fade" id="Video">
                                    <div class="row">
                                        <div class="col-md-12">
                                            @if($user->video_link)
                                                <div class="portlet-title">
                                                    <div class="caption font-red-sunglo"> <i
                                                            class="fa fa-video-camera font-red-sunglo"></i> <span
                                                            class="caption-subject bold uppercase">Tanıtım Videosu</span> </div>
                                                </div>
                                                <div class="portlet-body form">
                                                    <video width="640" height="480" controls>
                                                        <source src="{{ asset('uploads/videos/' . $user->video_link) }}"
                                                            type="video/mp4">
                                                        Tarayıcınız video etiketini desteklemiyor.
                                                    </video>
                                                    <div class="mt-2">
                                                        <form action="{{ route('delete.user.video', $user->id) }}" method="POST"
                                                            onsubmit="return confirm('Videoyu silmek istediğinize emin misiniz?');">
                                                            {{ csrf_field() }}
                                                            {{ method_field('DELETE') }}
                                                            <button type="submit" class="btn btn-danger btn-sm"><i
                                                                    class="fa fa-trash"></i> Videoyu Sil</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="alert alert-warning">Kullanıcı henüz bir video yüklememiş.</div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="CV"> @include('admin.user.forms.cv.cvs') </div>
                                <div class="tab-pane fade" id="Projects"> @include('admin.user.forms.project.projects')
                                </div>
                                <div class="tab-pane fade" id="Experience">
                                    @include('admin.user.forms.experience.experience') </div>
                                <div class="tab-pane fade" id="Education"> @include('admin.user.forms.education.education')
                                </div>
                                <div class="tab-pane fade" id="Skills"> @include('admin.user.forms.skill.skills') </div>
                                <div class="tab-pane fade" id="Languages"> @include('admin.user.forms.language.languages')
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <!-- END CONTENT BODY -->
            <div class="modal fade bs-modal-lg" id="add_cv_modal" tabindex="-1" role="dialog" aria-hidden="true"></div>
            <div class="modal fade bs-modal-lg" id="add_project_modal" tabindex="-1" role="dialog" aria-hidden="true"></div>
            <div class="modal fade bs-modal-lg" id="add_experience_modal" tabindex="-1" role="dialog" aria-hidden="true">
            </div>
            <div class="modal fade bs-modal-lg" id="add_education_modal" tabindex="-1" role="dialog" aria-hidden="true">
            </div>
            <div class="modal fade bs-modal-lg" id="add_skill_modal" tabindex="-1" role="dialog" aria-hidden="true"></div>
            <div class="modal fade bs-modal-lg" id="add_language_modal" tabindex="-1" role="dialog" aria-hidden="true">
            </div>
        </div>
@endsection