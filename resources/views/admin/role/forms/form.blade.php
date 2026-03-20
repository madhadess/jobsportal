<div class="form-body">
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'role_name') !!}">
        {!! Form::label('role_name', 'Rol Adı (Kod)', ['class' => 'bold']) !!}
        {!! Form::text('role_name', null, array('class' => 'form-control', 'id' => 'role_name', 'placeholder' => 'Örn: moderator')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'role_name') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'display_name') !!}">
        {!! Form::label('display_name', 'Görünen Ad', ['class' => 'bold']) !!}
        {!! Form::text('display_name', null, array('class' => 'form-control', 'id' => 'display_name', 'placeholder' => 'Örn: Moderatör')) !!}
        {!! APFrmErrHelp::showErrors($errors, 'display_name') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'description') !!}">
        {!! Form::label('description', 'Açıklama', ['class' => 'bold']) !!}
        {!! Form::textarea('description', null, array('class' => 'form-control', 'id' => 'description', 'placeholder' => 'Rol açıklaması...', 'rows' => 3)) !!}
        {!! APFrmErrHelp::showErrors($errors, 'description') !!}
    </div>
    <div class="form-group {!! APFrmErrHelp::hasError($errors, 'is_active') !!}">
        {!! Form::label('is_active', 'Durum', ['class' => 'bold']) !!}
        <div class="radio-list">
            <label class="radio-inline">{!! Form::radio('is_active', 1, true, ['id' => 'active']) !!} Aktif </label>
            <label class="radio-inline">{!! Form::radio('is_active', 0, false, ['id' => 'inactive']) !!} Pasif </label>
        </div>
        {!! APFrmErrHelp::showErrors($errors, 'is_active') !!}
    </div>

    <hr />
    <div class="clearfix" style="margin-bottom: 10px;">
        <h4 class="bold pull-left" style="margin: 0; line-height: 34px;">Yetkiler</h4>
        <div class="pull-right">
            <button type="button" class="btn btn-xs btn-success" onclick="toggleAllPermissions(true)"><i
                    class="fa fa-check-square-o"></i> Tümünü Seç</button>
            <button type="button" class="btn btn-xs btn-danger" onclick="toggleAllPermissions(false)"><i
                    class="fa fa-square-o"></i> Tümünü Kaldır</button>
        </div>
    </div>
    <div class="row">
        @foreach($permissions as $group => $groupPermissions)
            <div class="col-md-12" style="margin-bottom: 15px;">
                <div
                    style="background: #f5f5f5; padding: 8px 12px; border-left: 3px solid #337ab7; display: flex; justify-content: space-between; align-items: center;">
                    <h5 class="bold" style="margin: 0;">{{ $group }}</h5>
                    <div>
                        <a href="javascript:void(0);" onclick="toggleGroupPermissions('{{ \Illuminate\Support\Str::slug($group) }}', true)"
                            style="font-size: 11px; margin-right: 8px;"><i class="fa fa-check-square-o"></i> Seç</a>
                        <a href="javascript:void(0);" onclick="toggleGroupPermissions('{{ \Illuminate\Support\Str::slug($group) }}', false)"
                            style="font-size: 11px;"><i class="fa fa-square-o"></i> Kaldır</a>
                    </div>
                </div>
            </div>
            @foreach($groupPermissions as $permission)
                <div class="col-md-3">
                    <label class="mt-checkbox mt-checkbox-outline">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                            class="perm-checkbox perm-group-{{ \Illuminate\Support\Str::slug($group) }}" {{ isset($rolePermissions) && in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                        {{ $permission->display_name }}
                        <span></span>
                    </label>
                </div>
            @endforeach
        @endforeach
    </div>
</div>
<div class="form-actions">
    {!! Form::button('Kaydet <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>', array('class' => 'btn btn-large btn-primary', 'type' => 'submit')) !!}
</div>

<script>
    function toggleAllPermissions(checked) {
        document.querySelectorAll('.perm-checkbox').forEach(function (cb) { cb.checked = checked; });
    }
    function toggleGroupPermissions(group, checked) {
        document.querySelectorAll('.perm-group-' + group).forEach(function (cb) { cb.checked = checked; });
    }
</script>