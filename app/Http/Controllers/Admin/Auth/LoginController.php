<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
      |--------------------------------------------------------------------------
      | Login Controller
      |--------------------------------------------------------------------------
      |
      | This controller handles authenticating users for the application and
      | redirecting them to your home screen. The controller uses a trait
      | to conveniently provide its functionality to your applications.
      |
     */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('admin.guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        if ($admin) {
            $now = \Carbon\Carbon::now();
            $today = $now->toDateString();

            // Accumulate last status time before logging out
            if ($admin->status_updated_at && $admin->current_status) {
                // Reset daily stats if date changed (rare on logout but for safety)
                if ($admin->today_date != $today) {
                    $admin->today_date = $today;
                    $admin->today_online_seconds = 0;
                    $admin->today_break_seconds = 0;
                    $admin->today_in_call_seconds = 0;
                }

                $diff = $now->diffInSeconds(\Carbon\Carbon::parse($admin->status_updated_at));
                if ($admin->current_status == 'ONLINE') {
                    $admin->today_online_seconds += $diff;
                } elseif ($admin->current_status == 'BREAK') {
                    $admin->today_break_seconds += $diff;
                } elseif ($admin->current_status == 'IN_CALL') {
                    $admin->today_in_call_seconds += $diff;
                }
            }

            // Update Admin status
            $admin->current_status = 'OFFLINE';
            $admin->status_updated_at = $now;
            $admin->save();

            // Update Activity status
            \App\AdminActivity::updateOrCreate(
                ['admin_id' => $admin->id],
                [
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'is_online' => false,
                    'last_activity' => now(),
                ]
            );

            // Log the OFFLINE event
            \App\AdminActivityLog::create([
                'admin_id' => $admin->id,
                'url' => $request->fullUrl(),
                'method' => 'POST',
                'payload' => json_encode(['status' => 'OFFLINE', 'reason' => 'logout']),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent()
            ]);
        }

        $this->guard('admin')->logout();
        $request->session()->invalidate();
        return redirect('/admin/login');
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

}
