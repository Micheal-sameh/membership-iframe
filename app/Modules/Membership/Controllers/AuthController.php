<?php

declare(strict_types=1);

namespace App\Modules\Membership\Controllers;

use App\Http\Controllers\Controller;
use App\Services\MfaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(
        private MfaService $mfa,
    ) {}

    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('membership.portal');
        }

        return view('membership.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login'    => ['required', 'string'],
            'password' => ['required', 'string'],
        ]);

        if (! Auth::attempt(['email' => $credentials['login'], 'password' => $credentials['password']])) {
            $message = app()->getLocale() === 'ar'
                ? 'بيانات الدخول غير صحيحة.'
                : 'The provided credentials do not match our records.';

            return back()
                ->withErrors(['login' => $message])
                ->withInput($request->only('login'));
        }

        $user = Auth::user();

        if (! $user->is_active) {
            Auth::logout();

            $message = app()->getLocale() === 'ar'
                ? 'تم تعطيل هذا الحساب. يرجى التواصل مع المسؤول.'
                : 'This account has been deactivated. Please contact an administrator.';

            return back()
                ->withErrors(['login' => $message])
                ->withInput($request->only('login'));
        }

        // Credentials are valid, but the real session only starts once MFA passes.
        Auth::logout();

        session(['membership_mfa_pending_user' => [
            'id'    => $user->id,
            'email' => $user->email,
        ]]);

        if ($this->mfa->isEnabled($user->id)) {
            return redirect()->route('membership.mfa.challenge');
        }

        return redirect()->route('membership.mfa.setup');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('membership.login');
    }
}
