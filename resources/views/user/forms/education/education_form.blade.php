<div class="modal-body">
    <div class="form-body">
        <div class="formrow" id="div_degree_level_id">
            <?php
$degree_level_id = (isset($profileEducation) ? $profileEducation->degree_level_id : null);
            ?>
            {!! Form::select('degree_level_id', ['' => __('Select Degree Level')] + $degreeLevels, $degree_level_id, array('class' => 'form-control', 'id' => 'degree_level_id')) !!}
            <span class="help-block degree_level_id-error"></span>
        </div>

        <div class="formrow" id="div_degree_title">
            <input class="form-control" id="degree_title" placeholder="{{__('Degree Title')}}" name="degree_title"
                type="text" value="{{(isset($profileEducation) ? $profileEducation->degree_title : '')}}">
            <span class="help-block degree_title-error"></span>
        </div>

        <div class="formrow" id="div_major_subjects">
            <?php
$profileEducationMajorSubjectIds = old('major_subjects', (isset($profileEducationMajorSubjectIds) ? $profileEducationMajorSubjectIds : []));
            ?>
            {!! Form::select('major_subjects[]', $majorSubjects, $profileEducationMajorSubjectIds, array('class' => 'form-control', 'id' => 'major_subjects', 'multiple' => 'multiple', 'size' => '4')) !!}
            <span class="help-block major_subjects-error"></span>
        </div>

        <div class="formrow" id="div_country_id">
            <?php
$country_id = (isset($profileEducation) ? $profileEducation->country_id : (isset($siteSetting) ? $siteSetting->default_country_id : null));
            ?>
            {!! Form::select('country_id', ['' => __('Select Country')] + $countries, $country_id, array('class' => 'form-control', 'id' => 'education_country_id')) !!}
            <span class="help-block country_id-error"></span>
        </div>

        <div class="formrow" id="div_state_id">
            <span id="default_state_education_dd">
                {!! Form::select('state_id', ['' => __('Select State')], (isset($profileEducation) ? $profileEducation->state_id : null), array('class' => 'form-control', 'id' => 'education_state_id')) !!}
            </span>
            <span class="help-block state_id-error"></span>
        </div>

        <div class="formrow" id="div_institution">
            <input class="form-control" id="institution" placeholder="{{__('Institution')}}" name="institution"
                type="text" value="{{(isset($profileEducation) ? $profileEducation->institution : '')}}">
            <span class="help-block institution-error"></span>
        </div>

        <div class="formrow" id="div_date_completion">
            <?php
$date_completion = (isset($profileEducation) ? $profileEducation->date_completion : null);
            ?>
            {!! Form::select('date_completion', ['' => __('Select Year')] + MiscHelper::getEstablishedIn(), $date_completion, array('class' => 'form-control', 'id' => 'date_completion')) !!}
            <span class="help-block date_completion-error"></span>
        </div>

    </div>
</div>