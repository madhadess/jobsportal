<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemConfig;
use Illuminate\Http\Request;

class SecurityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('checkAdminRoles:SUPER_ADMIN');
    }

    public function index()
    {
        $configs = SystemConfig::where('group', 'security')->get();
        return view('admin.security.index', compact('configs'));
    }

    public function update(Request $request)
    {
        $data = $request->except('_token');

        foreach ($data as $key => $value) {
            SystemConfig::updateOrCreate(
                ['key' => $key, 'group' => 'security'],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('success', 'Güvenlik ayarları başarıyla güncellendi.');
    }
}
