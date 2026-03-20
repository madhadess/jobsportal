@extends('layouts.app')

@section('content')

    <!-- Header start -->

    @include('includes.header')

    <!-- Header end -->



    <div class="authpages">

        <div class="container">

            <div class="row justify-content-center align-items-center">
                <div class="col-lg-5">

                    @include('flash::message')

                    <div class="useraccountwrap">


                        <div class="userccount whitebg">


                            <div class="tab-content">

                                <div id="candidate" class="formpanel mt-0 tab-pane active">
                                    <h3 class="text-center">{{__('İş Arayan / Personel Olarak Kaydol')}}</h3>



                                    <form class="form-horizontal mt-3" method="POST" action="{{ route('register') }}"
                                        enctype="multipart/form-data">
                                        @csrf

                                        <input type="hidden" name="candidate_or_employer" value="candidate" />

                                        <div class="formrow{{ $errors->has('user_type') ? ' has-error' : '' }}">
                                            <select name="user_type" id="user_type" class="form-control" required="required"
                                                onchange="toggleOccupationGroup(this.value)">
                                                <option value="">{{__('Üyelik Amacınızı Seçin')}}</option>
                                                <option value="candidate" {{old('user_type') == 'candidate' ? 'selected' : ''}}>{{__('İş Arıyorum (İlanlara Başvurmak İçin)')}}</option>
                                                <option value="personnel" {{old('user_type') == 'personnel' ? 'selected' : ''}}>{{__('Hizmet Personeliyim (Temizlik, Montaj vb.)')}}</option>
                                                <option value="caregiver" {{old('user_type') == 'caregiver' ? 'selected' : ''}}>{{__('Bakıcıyım (Çocuk, Yaşlı, Hasta vb.)')}}</option>
                                            </select>
                                            @if ($errors->has('user_type')) <span class="help-block">
                                            <strong>{{ $errors->first('user_type') }}</strong> </span> @endif
                                        </div>

                                        <div id="occupation_group_wrap"
                                            class="formrow{{ $errors->has('parent_occupation_id') ? ' has-error' : '' }}"
                                            style="display: {{ in_array(old('user_type'), ['personnel', 'caregiver']) ? 'block' : 'none' }};">

                                            {{-- Parent Category (populated by JavaScript based on user_type) --}}
                                            <select name="parent_occupation_id" id="parent_occupation_id"
                                                class="form-control mb-2">
                                                <option value="">{{__('Meslek Alanınızı Seçin')}}</option>
                                            </select>
                                            @if ($errors->has('parent_occupation_id'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('parent_occupation_id') }}</strong>
                                                </span>
                                            @endif

                                        </div>

                                        <div class="formrow{{ $errors->has('first_name') ? ' has-error' : '' }}">

                                            <input type="text" name="first_name" class="form-control" required="required"
                                                placeholder="{{__('Adınız')}}" value="{{old('first_name')}}">

                                            @if ($errors->has('first_name')) <span class="help-block">
                                            <strong>{{ $errors->first('first_name') }}</strong> </span> @endif
                                        </div>



                                        <div class="formrow{{ $errors->has('last_name') ? ' has-error' : '' }}">

                                            <input type="text" name="last_name" class="form-control" required="required"
                                                placeholder="{{__('Soyadınız')}}" value="{{old('last_name')}}">

                                            @if ($errors->has('last_name')) <span class="help-block">
                                            <strong>{{ $errors->first('last_name') }}</strong> </span> @endif
                                        </div>

                                        <div class="formrow{{ $errors->has('email') ? ' has-error' : '' }}">

                                            <input type="email" name="email" class="form-control" required="required"
                                                placeholder="{{__('E-posta Adresiniz')}}" value="{{old('email')}}">

                                            @if ($errors->has('email')) <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong> </span> @endif
                                        </div>

                                        <div class="formrow{{ $errors->has('password') ? ' has-error' : '' }}">

                                            <input type="password" name="password" class="form-control" required="required"
                                                placeholder="{{__('Şifre')}}" value="">

                                            @if ($errors->has('password')) <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong> </span> @endif
                                        </div>

                                        <div class="formrow{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">

                                            <input type="password" name="password_confirmation" class="form-control"
                                                required="required" placeholder="{{__('Şifre Onayı')}}" value="">

                                            @if ($errors->has('password_confirmation')) <span class="help-block">
                                                <strong>{{ $errors->first('password_confirmation') }}</strong> </span>
                                            @endif
                                        </div>



                                        <div class="formrow{{ $errors->has('is_subscribed') ? ' has-error' : '' }}">

                                            <?php

    $is_checked = '';

    if (old('is_subscribed', 1)) {

        $is_checked = 'checked="checked"';

    }

                                                                                ?>



                                            <input type="checkbox" value="1" name="is_subscribed" {{$is_checked}} />
                                            {{__('Bültene Abone Ol')}}

                                            @if ($errors->has('is_subscribed')) <span class="help-block">
                                            <strong>{{ $errors->first('is_subscribed') }}</strong> </span> @endif
                                        </div>





                                        <div class="formrow{{ $errors->has('terms_of_use') ? ' has-error' : '' }}">

                                            <input type="checkbox" value="1" name="terms_of_use" id="terms_of_use"
                                                required />
                                            <label for="terms_of_use"><a href="{{url('cms/kullanim-kosullari')}}"
                                                    target="_blank">{{__('Kullanım Koşullarını')}}</a>
                                                {{__('ve')}}
                                                <a href="{{url('cms/kvkk-aydinlatma-metni')}}"
                                                    target="_blank">{{__('KVKK Aydınlatma Metni\'ni')}}</a>
                                                {{__('kabul ediyorum')}}
                                            </label>



                                            @if ($errors->has('terms_of_use')) <span class="help-block">
                                            <strong>{{ $errors->first('terms_of_use') }}</strong> </span> @endif
                                        </div>

                                        {{-- CV Upload --}}

                                        <div
                                            class="form-group mb-3 {{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                                            {!! app('captcha')->display() !!}
                                            @if ($errors->has('g-recaptcha-response')) <span class="help-block">
                                            <strong>{{ $errors->first('g-recaptcha-response') }}</strong> </span> @endif
                                        </div>






                                        <input type="submit" class="btn" value="{{__('Kayıt Ol')}}">

                                    </form>

                                </div>



                            </div>

                            <!-- sign up form -->

                            <div class="newuser"><i class="fas fa-user" aria-hidden="true"></i>
                                {{__('Zaten hesabınız var mı?')}} <a href="{{route('login')}}">{{__('Giriş Yap')}}</a></div>

                            <!-- sign up form end-->



                        </div>

                    </div>
                </div>





            </div>



        </div>

    </div>

    @include('includes.footer')

    @push('scripts')
        <script>
            // Parent groups mapped by type
            var parentGroupsByType = {
                'personnel': {!! \App\Models\OccupationGroup::whereNull('parent_id')->where('is_active', 1)->where('type', 'service')->get(['id', 'name'])->toJson() !!},
                'caregiver': {!! \App\Models\OccupationGroup::whereNull('parent_id')->where('is_active', 1)->where('type', 'caregiver')->get(['id', 'name'])->toJson() !!}
            };

            // Sub occupations mapped by parent_id
            var occupationMap = {!! \App\Models\OccupationGroup::whereNotNull('parent_id')->get()->groupBy('parent_id')->toJson() !!};

            function toggleOccupationGroup(val) {
                var parentSelect = $('#parent_occupation_id');

                if (val == 'personnel' || val == 'caregiver') {
                    $('#occupation_group_wrap').show();
                    $('#parent_occupation_id').attr('required', 'required');

                    // Populate parent options based on type
                    parentSelect.empty();
                    parentSelect.append('<option value="">' + @json(__('Meslek Alanınızı Seçin')) + '</option>');
                    var groups = parentGroupsByType[val] || [];
                    groups.forEach(function (item) {
                        parentSelect.append('<option value="' + item.id + '">' + item.name + '</option>');
                    });

                } else {
                    $('#occupation_group_wrap').hide();
                    $('#parent_occupation_id').removeAttr('required');
                    parentSelect.empty();
                }
            }

            $(document).ready(function () {
                toggleOccupationGroup($('#user_type').val());

                var oldParentId = @json(old('parent_occupation_id'));
                if (oldParentId) {
                    $('#parent_occupation_id').val(String(oldParentId));
                }
            });
        </script>
    @endpush

@endsection