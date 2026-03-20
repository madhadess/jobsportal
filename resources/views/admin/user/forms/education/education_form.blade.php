<div class="modal-body">
    <div class="form-body">
        <div class="form-group" id="div_degree_level_id">
            <label for="degree_level_id" class="bold">Eğitim Seviyesi</label>
            <?php
$degree_level_id = (isset($profileEducation) ? $profileEducation->degree_level_id : null);
            ?>
            {!! Form::select('degree_level_id', ['' => 'Eğitim Seviyesi Seçin'] + $degreeLevels, $degree_level_id, array('class' => 'form-control', 'id' => 'degree_level_id')) !!}
            <span class="help-block degree_level_id-error"></span>
        </div>

        <div class="form-group" id="div_degree_title">
            <label for="degree_title" class="bold">Diploma/Derece Başlığı</label>
            <input class="form-control" id="degree_title" placeholder="Diploma Başlığı" name="degree_title" type="text"
                value="{{(isset($profileEducation) ? $profileEducation->degree_title : '')}}">
            <span class="help-block degree_title-error"></span>
        </div>

        <div class="form-group" id="div_major_subjects">
            <label for="major_subjects" class="bold">Bölüm / Uzmanlık Alanları</label>
            <?php
$profileEducationMajorSubjectIds = old('major_subjects', (isset($profileEducationMajorSubjectIds) ? $profileEducationMajorSubjectIds : []));
            ?>
            {!! Form::select('major_subjects[]', $majorSubjects, $profileEducationMajorSubjectIds, array('class' => 'form-control select2-multiple', 'id' => 'major_subjects', 'multiple' => 'multiple')) !!}
            <span class="help-block major_subjects-error"></span>
        </div>

        <div class="form-group" id="div_country_id">
            <label for="country_id" class="bold">Ülke</label>
            <?php
$country_id = (isset($profileEducation) ? $profileEducation->country_id : (isset($siteSetting) ? $siteSetting->default_country_id : null));
            ?>
            {!! Form::select('country_id', ['' => 'Ülke Seçin'] + $countries, $country_id, array('class' => 'form-control', 'id' => 'education_country_id')) !!}
            <span class="help-block country_id-error"></span>
        </div>

        <div class="form-group" id="div_state_id">
            <label for="state_id" class="bold">Şehir</label>
            <span id="default_state_education_dd">
                {!! Form::select('state_id', ['' => 'Şehir Seçin'], (isset($profileEducation) ? $profileEducation->state_id : null), array('class' => 'form-control', 'id' => 'education_state_id')) !!}
            </span>
            <span class="help-block state_id-error"></span>
        </div>

        <div class="form-group" id="div_institution">
            <label for="institution" class="bold">Kurum / Okul</label>
            <input class="form-control" id="institution" placeholder="Kurum Adı" name="institution" type="text"
                value="{{(isset($profileEducation) ? $profileEducation->institution : '')}}">
            <span class="help-block institution-error"></span>
        </div>

        <div class="form-group" id="div_date_completion">
            <label for="date_completion" class="bold">Mezuniyet Yılı</label>
            <?php
$date_completion = (isset($profileEducation) ? $profileEducation->date_completion : null);
            ?>
            {!! Form::select('date_completion', ['' => 'Yıl Seçin'] + MiscHelper::getEstablishedIn(), $date_completion, array('class' => 'form-control', 'id' => 'date_completion')) !!}
            <span class="help-block date_completion-error"></span>
        </div>

    </div>
</div>