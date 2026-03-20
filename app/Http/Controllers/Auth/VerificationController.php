<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Verified;

use Jrean\UserVerification\Facades\UserVerification;

class VerificationController extends Controller
{
    public function show()
    {
        return view('auth.verify');
    }

    public function verify(Request $request)
    {
        // This is likely unused if register controller handles it, likely needs removal or redirect
        return redirect()->route('login');
    }


    public function resend(Request $request)
    {
        if ($request->user() && $request->user()->verified == 0) {
            UserVerification::generate($request->user());
            UserVerification::send($request->user(), 'E-posta Doğrulama', config('mail.recieve_to.address'), config('mail.recieve_to.name'));
            return back()->with('resent', true);
        }

        return back()->with('resent', true);
    }



}