<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class VerifiedMiddleware
{
    public function handle($request, Closure $next)
    {
        $user = $request->user();

        if ($user instanceof MustVerifyEmail && !$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice');
        }
        if ($user->verified == 0) {
            return redirect()->route('not-verified');
        }

        return $next($request);
    }
}

