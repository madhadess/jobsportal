<div class="modal-body">
    <div class="form-body">
        <div class="formrow" id="div_name">
            <input type="hidden" name="image" id="image" value="{{(isset($profileProject)? $profileProject->image:'')}}">
            <input class="form-control" id="name" placeholder="{{__('Project Name')}}" name="name" type="text" value="{{(isset($profileProject)? $profileProject->name:'')}}">
            <span class="help-block name-error"></span> </div>

        <div class="formrow" id="div_url">
            <input class="form-control" id="url" placeholder="{{__('Project URL')}}" name="url" type="text" value="{{(isset($profileProject)? $profileProject->url:'')}}">
            <span class="help-block url-error"></span> </div>

        <div class="formrow" id="div_date_start">
            <input class="form-control datepicker" id="date_start" autocomplete="off" placeholder="{{__('Project Start Date')}}" name="date_start" type="text" value="{{(isset($profileProject)? Carbon\Carbon::parse($profileProject->date_start)->format('Y-m-d'):'')}}">
            <span class="help-block date_start-error"></span> </div>

        <div class="formrow" id="div_date_end">
            <input class="form-control datepicker" id="date_end" autocomplete="off" placeholder="{{__('Project End Date')}}" name="date_end" type="text" value="{{(isset($profileProject)? ($profileProject->date_end?Carbon\Carbon::parse($profileProject->date_end)->format('Y-m-d'):''):'')}}">
            <span class="help-block date_end-error"></span> </div>

        <div class="formrow" id="div_is_on_going">
            <label for="is_on_going" class="bold">{{__('Is Ongoing?')}}</label>
            <div class="radio-list">
                <?php
                $val_1_checked = '';
                $val_2_checked = 'checked="checked"';

                if (isset($profileProject) && $profileProject->is_on_going == 1) {
                    $val_1_checked = 'checked="checked"';
                    $val_2_checked = '';
                }
                ?>
                <label class="radio-inline"><input id="on_going" name="is_on_going" type="radio" value="1" {{$val_1_checked}}> {{__('Yes')}} </label>
                <label class="radio-inline"><input id="not_on_going" name="is_on_going" type="radio" value="0" {{$val_2_checked}}> {{__('No')}} </label>
            </div>
            <span class="help-block is_on_going-error"></span>
        </div>

        <div class="formrow" id="div_description">
            <textarea name="description" class="form-control" id="description" placeholder="{{__('Project Description')}}">{{(isset($profileProject)? $profileProject->description:'')}}</textarea>
            <span class="help-block description-error"></span> </div>


        <div class="formrow">
            <div id="dropzone" class="dropzone"></div>
        </div>


    </div>
</div>