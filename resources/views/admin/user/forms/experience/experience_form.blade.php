<div class="modal-body">
    <div class="form-body">
        <div class="form-group" id="div_title">
            <label for="title" class="bold">Deneyim Başlığı / Pozisyon</label>
            <input class="form-control" id="title" placeholder="Pozisyon örneğin: Temizlik Görevlisi" name="title"
                type="text" value="{{(isset($profileExperience) ? $profileExperience->title : '')}}">
            <span class="help-block title-error"></span>
        </div>

        <div class="form-group" id="div_company">
            <label for="company" class="bold">Şirket / Kurum</label>
            <input class="form-control" id="company" placeholder="Şirket Adı" name="company" type="text"
                value="{{(isset($profileExperience) ? $profileExperience->company : '')}}">
            <span class="help-block company-error"></span>
        </div>

        <div class="form-group" id="div_country_id">
            <label for="country_id" class="bold">Ülke</label>
            <?php
$country_id = (isset($profileExperience) ? $profileExperience->country_id : $siteSetting->default_country_id);
            ?>
            {!! Form::select('country_id', ['' => 'Ülke Seçin'] + $countries, $country_id, array('class' => 'form-control', 'id' => 'experience_country_id')) !!}
            <span class="help-block country_id-error"></span>
        </div>

        <div class="form-group" id="div_state_id">
            <label for="state_id" class="bold">Şehir</label>
            <span id="default_state_experience_dd">
                {!! Form::select('state_id', ['' => 'Şehir Seçin'], null, array('class' => 'form-control', 'id' => 'experience_state_id')) !!}
            </span>
            <span class="help-block state_id-error"></span>
        </div>

        <div class="form-group" id="div_city_id">
            <label for="city_id" class="bold">İlçe</label>
            <span id="default_city_experience_dd">
                {!! Form::select('city_id', ['' => 'İlçe Seçin'], null, array('class' => 'form-control', 'id' => 'city_id')) !!}
            </span>
            <span class="help-block city_id-error"></span>
        </div>

        <div class="form-group" id="div_date_start">
            <label for="date_start" class="bold">Başlangıç Tarihi</label>
            <input class="form-control datepicker" autocomplete="off" id="date_start" placeholder="Başlangıç Tarihi"
                name="date_start" type="text"
                value="{{(isset($profileExperience) ? $profileExperience->date_start->format('Y-m-d') : '')}}">
            <span class="help-block date_start-error"></span>
        </div>
        <div class="form-group" id="div_date_end">
            <label for="date_end" class="bold">Bitiş Tarihi</label>
            <input class="form-control datepicker" autocomplete="off" id="date_end" placeholder="Bitiş Tarihi"
                name="date_end" type="text"
                value="{{(isset($profileExperience) ? $profileExperience->date_end->format('Y-m-d') : '')}}">
            <span class="help-block date_end-error"></span>
        </div>
        <div class="form-group" id="div_is_currently_working">
            <label for="is_currently_working" class="bold">Halen Çalışıyor musunuz?</label>
            <div class="radio-list" style="margin-left:22px;">
                <?php
$val_1_checked = '';
$val_2_checked = 'checked="checked"';

if (isset($profileExperience) && $profileExperience->is_currently_working == 1) {
    $val_1_checked = 'checked="checked"';
    $val_2_checked = '';
}
                ?>
                <label class="radio-inline"><input id="currently_working" name="is_currently_working" type="radio"
                        value="1" {{$val_1_checked}}> Evet </label>
                <label class="radio-inline"><input id="not_currently_working" name="is_currently_working" type="radio"
                        value="0" {{$val_2_checked}}> Hayır </label>
            </div>
            <span class="help-block is_currently_working-error"></span>
        </div>
        <div class="form-group" id="div_description">
            <label for="name" class="bold">Deneyim Açıklaması</label>
            <textarea name="description" class="form-control" id="description"
                placeholder="Görev ve sorumluluklarınız">{{(isset($profileExperience) ? $profileExperience->description : '')}}</textarea>
            <span class="help-block description-error"></span>
        </div>
    </div>
</div>