<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use App\Models\Permission;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RoleController extends Controller
{
    public function index()
    {
        return view('admin.role.index');
    }

    public function create()
    {
        $permissions = Permission::active()->get()->groupBy('group');
        return view('admin.role.add', compact('permissions'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'role_name' => 'required|unique:roles,role_name',
            'display_name' => 'required',
        ]);

        $role = new Role();
        $role->role_name = $request->input('role_name');
        $role->display_name = $request->input('display_name');
        $role->description = $request->input('description');
        $role->is_active = $request->input('is_active', 1);
        $role->is_system = 0;
        $role->save();

        if ($request->has('permissions')) {
            $role->permissions()->sync($request->input('permissions'));
        }

        flash(__('Rol başarıyla eklendi!'))->success();
        return redirect()->route('admin.roles.edit', $role->id);
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        $permissions = Permission::active()->get()->groupBy('group');
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        return view('admin.role.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $this->validate($request, [
            'role_name' => 'required|unique:roles,role_name,' . $id,
            'display_name' => 'required',
        ]);

        $role->role_name = $request->input('role_name');
        $role->display_name = $request->input('display_name');
        $role->description = $request->input('description');
        $role->is_active = $request->input('is_active', 1);
        $role->save();

        $role->permissions()->sync($request->input('permissions', []));

        flash(__('Rol başarıyla güncellendi!'))->success();
        return redirect()->route('admin.roles.edit', $role->id);
    }

    public function destroy(Request $request)
    {
        $id = $request->input('id');
        try {
            $role = Role::findOrFail($id);
            // System roles cannot be deleted
            if ($role->is_system) {
                return 'notok';
            }
            // Check if any admins are assigned to this role
            if ($role->admins()->count() > 0) {
                return 'notok';
            }
            $role->permissions()->detach(); // Remove all permission assignments first
            $role->delete();
            return 'ok';
        } catch (ModelNotFoundException $e) {
            return 'notok';
        }
    }

    public function fetchRolesData(Request $request)
    {
        $roles = Role::select(['id', 'role_name', 'display_name', 'is_active', 'is_system']);

        return Datatables::of($roles)
            ->addColumn('is_system_label', function ($role) {
                return $role->is_system
                    ? '<span class="label label-danger">EVET</span>'
                    : '<span class="label label-success">HAYIR</span>';
            })
            ->addColumn('is_active_label', function ($role) {
                return $role->is_active
                    ? '<span class="label label-success">AKTİF</span>'
                    : '<span class="label label-danger">PASİF</span>';
            })
            ->addColumn('action', function ($role) {
                $editBtn = '<li>
                    <a href="' . route('admin.roles.edit', ['id' => $role->id]) . '">
                    <i class="fa fa-pencil" aria-hidden="true"></i> Düzenle</a>
                </li>';

                $deleteBtn = '';
                if (!$role->is_system) {
                    $deleteBtn = '<li>
                        <a href="javascript:void(0);" onclick="deleteRole(' . $role->id . ');">
                        <i class="fa fa-trash-o" aria-hidden="true"></i> Sil</a>
                    </li>';
                }

                return '<div class="btn-group">
                    <button class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false">İŞLEMLER
                        <i class="fa fa-angle-down"></i>
                    </button>
                    <ul class="dropdown-menu">' . $editBtn . $deleteBtn . '</ul>
                </div>';
            })
            ->rawColumns(['action', 'is_system_label', 'is_active_label'])
            ->setRowId(function ($role) {
                return 'roleDtRow' . $role->id;
            })
            ->make(true);
    }
}
