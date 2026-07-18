<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MembershipAuthenticated
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! Auth::check()) {
            return redirect()->route('membership.login');
        }

        if (! Auth::user()->is_active) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('membership.login')->withErrors([
                'login' => app()->getLocale() === 'ar'
                    ? 'تم تعطيل هذا الحساب. يرجى التواصل مع المسؤول.'
                    : 'This account has been deactivated. Please contact an administrator.',
            ]);
        }

        return $next($request);
    }
}
