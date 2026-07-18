<?php

declare(strict_types=1);

namespace App\Modules\Membership\Controllers;

use App\Http\Controllers\Controller;
use App\Services\MfaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MfaController extends Controller
{
    public function __construct(
        private MfaService $mfa,
    ) {}

    private function invalidOtpMessage(): string
    {
        return app()->getLocale() === 'ar'
            ? 'رمز التحقق غير صحيح. حاول مرة أخرى.'
            : 'Invalid verification code. Please try again.';
    }

    public function challenge()
    {
        if (! session()->has('membership_mfa_pending_user')) {
            return redirect()->route('membership.login');
        }

        return view('membership.mfa-challenge');
    }

    public function verify(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $pendingUser = session('membership_mfa_pending_user');

        if (! $pendingUser) {
            return redirect()->route('membership.login');
        }

        $secret = $this->mfa->getSecret($pendingUser['id']);

        if (! $secret || ! $this->mfa->verify($secret, $request->otp)) {
            return back()->withErrors([
                'otp' => $this->invalidOtpMessage(),
            ]);
        }

        session()->forget('membership_mfa_pending_user');

        Auth::loginUsingId($pendingUser['id']);
        $request->session()->regenerate();

        return redirect()->route('membership.portal');
    }

    public function setup()
    {
        $pendingUser = session('membership_mfa_pending_user');

        if (! $pendingUser) {
            return redirect()->route('membership.login');
        }

        // Already enrolled (e.g. enabled elsewhere) — go straight to the challenge instead.
        if ($this->mfa->isEnabled($pendingUser['id'])) {
            return redirect()->route('membership.mfa.challenge');
        }

        $secret = session('membership_mfa_setup_secret');

        if (! $secret) {
            $secret = $this->mfa->generateSecret();
            session(['membership_mfa_setup_secret' => $secret]);
        }

        $appName = config('app.name', 'Membership Portal');
        $qrCodeSvg = $this->mfa->getQrCodeSvg($appName, $pendingUser['login'], $secret);

        return view('membership.mfa-setup', [
            'qrCodeSvg' => $qrCodeSvg,
            'secret'    => $secret,
        ]);
    }

    public function confirmSetup(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $pendingUser = session('membership_mfa_pending_user');
        $secret = session('membership_mfa_setup_secret');

        if (! $pendingUser || ! $secret) {
            return redirect()->route('membership.login');
        }

        if (! $this->mfa->verify($secret, $request->otp)) {
            return back()->withErrors([
                'otp' => $this->invalidOtpMessage(),
            ]);
        }

        $this->mfa->enable($pendingUser['id'], $secret);

        session()->forget(['membership_mfa_setup_secret', 'membership_mfa_pending_user']);

        Auth::loginUsingId($pendingUser['id']);
        $request->session()->regenerate();

        return redirect()->route('membership.portal');
    }

    public function cancel(Request $request)
    {
        session()->forget(['membership_mfa_pending_user', 'membership_mfa_setup_secret']);
        $request->session()->regenerateToken();

        return redirect()->route('membership.login');
    }
}
