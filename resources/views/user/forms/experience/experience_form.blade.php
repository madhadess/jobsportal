<div class="modal-body">
    <div class="form-body">
        <div class="formrow" id="div_title">
            <input class="form-control" id="title" placeholder="{{__('Deneyim Başlığı')}}" name="title" type="text"
                value="{{(isset($profileExperience) ? $profileExperience->title : '')}}">
            <span class="help-block title-error"></span>
        </div>

        <div class="formrow" id="div_company">
            <input class="form-control" id="company" placeholder="{{__('Şirket')}}" name="company" type="text"
                value="{{(isset($profileExperience) ? $profileExperience->company : '')}}">
            <span class="help-block company-error"></span>
        </div>

        <div class="formrow" id="div_country_id">
            <?php
$country_id = (isset($profileExperience) ? $profileExperience->country_id : $siteSetting->default_country_id);
            ?>
            {!! Form::select('country_id', ['' => __('Ülke Seç')] + $countries, $country_id, array('class' => 'form-control', 'id' => 'experience_country_id')) !!}
            <span class="help-block country_id-error"></span>
        </div>

        <div class="formrow" id="div_state_id">
            <span id="default_state_experience_dd">
                {!! Form::select('state_id', ['' => __('Eyalet Seç')], null, array('class' => 'form-control', 'id' => 'experience_state_id')) !!}
            </span>
            <span class="help-block state_id-error"></span>
        </div>

        <div class="formrow" id="div_city_id">
            <span id="default_city_experience_dd">
                {!! Form::select('city_id', ['' => __('Şehir Seç')], null, array('class' => 'form-control', 'id' => 'city_id')) !!}
            </span>
            <span class="help-block city_id-error"></span>
        </div>

        <div class="formrow" id="div_date_start">
            <input class="form-control datepicker" autocomplete="off" id="date_start"
                placeholder="{{__('Deneyim Başlangıç Tarihi')}}" name="date_start" type="text"
                value="{{(isset($profileExperience) ? Carbon\Carbon::parse($profileExperience->date_start)->format('Y-m-d') : '')}}">
            <span class="help-block date_start-error"></span>
        </div>
        <div class="formrow" id="div_date_end">
            <input class="form-control datepicker" autocomplete="off" id="date_end"
                placeholder="{{__('Deneyim Bitiş Tarihi')}}" name="date_end" type="text"
                value="{{(isset($profileExperience) && $profileExperience->date_end ? Carbon\Carbon::parse($profileExperience->date_end)->format('Y-m-d') : '')}}">
            <span class="help-block date_end-error"></span>
        </div>
        <div class="formrow" id="div_is_currently_working">
            <label for="is_currently_working" class="bold">{{__('Şu anda çalışıyor musunuz?')}}</label>
            <div class="radio-list">
                <?php
$val_1_checked = '';
$val_2_checked = 'checked="checked"';

if (isset($profileExperience) && $profileExperience->is_currently_working == 1) {
    $val_1_checked = 'checked="checked"';
    $val_2_checked = '';
}
                ?>
                <label class="radio-inline"><input id="currently_working" name="is_currently_working" type="radio"
                        value="1" {{$val_1_checked}}> {{__('Evet')}} </label>
                <label class="radio-inline"><input id="not_currently_working" name="is_currently_working" type="radio"
                        value="0" {{$val_2_checked}}> {{__('Hayır')}} </label>
            </div>
            <span class="help-block is_currently_working-error"></span>
        </div>
        <div class="formrow" id="div_description">
            <textarea name="description" class="form-control" id="description"
                placeholder="{{__('Deneyim Açıklaması')}}">{{(isset($profileExperience) ? $profileExperience->description : '')}}</textarea>
            <span class="help-block description-error"></span>
        </div>
    </div>
</div>