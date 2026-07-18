@php $isRtl = app()->getLocale() === 'ar'; @endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isRtl ? 'المصادقة الثنائية' : 'Two-Factor Authentication' }} — {{ $isRtl ? 'بوابة الأعضاء' : 'Membership Portal' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @if($isRtl)
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Cairo', sans-serif; }</style>
    @else
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
    @endif
</head>
<body class="min-h-screen flex items-center justify-center bg-slate-50 p-6">

    <div class="w-full max-w-sm">

        <div class="text-center mb-8">
            <div class="mx-auto w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center mb-4">
                <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            <h1 class="text-xl font-bold text-slate-900">
                {{ $isRtl ? 'المصادقة الثنائية' : 'Two-Factor Authentication' }}
            </h1>
            <p class="text-slate-500 mt-1.5 text-sm">
                {{ $isRtl ? 'أدخل الرمز المكون من 6 أرقام من تطبيق Google Authenticator' : 'Enter the 6-digit code from Google Authenticator' }}
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <form method="POST" action="{{ route('membership.mfa.verify') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="otp" class="block text-sm font-medium text-slate-700 mb-1.5">
                        {{ $isRtl ? 'رمز التحقق' : 'Verification Code' }}
                    </label>
                    <input type="text" id="otp" name="otp"
                        inputmode="numeric" maxlength="6" autofocus autocomplete="one-time-code"
                        class="w-full border border-slate-300 rounded-lg px-3.5 py-3 text-center text-2xl font-mono tracking-[0.5em] text-slate-900 placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors {{ $errors->has('otp') ? 'border-red-400 bg-red-50' : '' }}"
                        placeholder="000000">
                    @error('otp')
                        <p class="flex items-center gap-1.5 text-red-600 text-xs mt-1.5 font-medium">
                            <svg class="w-3.5 h-3.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-4 rounded-lg transition-colors text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    {{ $isRtl ? 'تحقق' : 'Verify' }}
                </button>
            </form>

            <div class="mt-6 text-center">
                <form method="POST" action="{{ route('membership.mfa.cancel') }}">
                    @csrf
                    <button type="submit" class="text-sm text-slate-500 hover:text-slate-700 transition-colors">
                        {{ $isRtl ? '← العودة لتسجيل الدخول' : '← Back to login' }}
                    </button>
                </form>
            </div>
        </div>

    </div>

    @include('membership.partials.no-devtools')
</body>
</html>
