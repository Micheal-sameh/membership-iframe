@php $isRtl = app()->getLocale() === 'ar'; @endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}" x-data="{ copied: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isRtl ? 'تفعيل المصادقة الثنائية' : 'Enable Two-Factor Authentication' }} — {{ $isRtl ? 'بوابة الأعضاء' : 'Membership Portal' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @if($isRtl)
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Cairo', sans-serif; }</style>
    @else
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
    @endif
</head>
<body class="min-h-screen flex items-center justify-center bg-slate-50 p-6">

    <div class="w-full max-w-3xl">

        <div class="text-center mb-6">
            <h1 class="text-xl font-bold text-slate-900">
                {{ $isRtl ? 'إعداد المصادقة الثنائية' : 'Set Up Two-Factor Authentication' }}
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                {{ $isRtl ? 'مطلوب لمتابعة الدخول إلى بوابة الأعضاء' : 'Required to continue into the membership portal' }}
            </p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            <div class="grid md:grid-cols-2 gap-8">

                <div class="space-y-6">
                    <div class="space-y-4">
                        <div class="flex gap-3">
                            <div class="w-7 h-7 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">1</div>
                            <div>
                                <h3 class="text-sm font-semibold text-slate-900">{{ $isRtl ? 'ثبّت التطبيق' : 'Install the App' }}</h3>
                                <p class="text-sm text-slate-500 mt-0.5">{{ $isRtl ? 'حمّل تطبيق Google Authenticator من متجر التطبيقات على هاتفك.' : "Download Google Authenticator from your phone's app store." }}</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="w-7 h-7 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">2</div>
                            <div>
                                <h3 class="text-sm font-semibold text-slate-900">{{ $isRtl ? 'امسح رمز QR' : 'Scan the QR Code' }}</h3>
                                <p class="text-sm text-slate-500 mt-0.5">{{ $isRtl ? 'افتح التطبيق واضغط على علامة + ثم امسح رمز QR المعروض.' : 'Open the app, tap the + button, and scan the QR code shown here.' }}</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="w-7 h-7 rounded-full bg-blue-600 text-white flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">3</div>
                            <div>
                                <h3 class="text-sm font-semibold text-slate-900">{{ $isRtl ? 'أدخل الرمز' : 'Enter the Code' }}</h3>
                                <p class="text-sm text-slate-500 mt-0.5">{{ $isRtl ? 'أدخل الرمز المكون من 6 أرقام الذي يظهر في التطبيق أدناه.' : 'Enter the 6-digit code shown in the app below.' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 rounded-lg p-4 border border-slate-200">
                        <p class="text-xs font-medium text-slate-500 mb-2">
                            {{ $isRtl ? 'لا تستطيع مسح الرمز؟ أدخل هذا المفتاح يدوياً:' : "Can't scan? Enter this key manually:" }}
                        </p>
                        <div class="flex items-center gap-2">
                            <code class="flex-1 text-sm font-mono font-semibold text-slate-900 tracking-wider break-all select-all">{{ $secret }}</code>
                            <button type="button"
                                x-on:click="navigator.clipboard.writeText('{{ $secret }}'); copied = true; setTimeout(() => copied = false, 2000)"
                                class="flex-shrink-0 p-2 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 transition-colors"
                                :title="copied ? '{{ $isRtl ? 'تم النسخ!' : 'Copied!' }}' : '{{ $isRtl ? 'نسخ' : 'Copy' }}'">
                                <svg x-show="!copied" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                <svg x-show="copied" x-cloak class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="space-y-5">
                    <div class="flex justify-center">
                        <div class="bg-white p-4 rounded-xl border-2 border-slate-200 inline-block">
                            {!! $qrCodeSvg !!}
                        </div>
                    </div>

                    <form method="POST" action="{{ route('membership.mfa.setup.confirm') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label for="otp" class="block text-sm font-medium text-slate-700 mb-1.5">
                                {{ $isRtl ? 'رمز التحقق' : 'Verification Code' }}
                            </label>
                            <input type="text" id="otp" name="otp"
                                inputmode="numeric" maxlength="6" autocomplete="one-time-code"
                                class="w-full border border-slate-300 rounded-lg px-3.5 py-3 text-center text-xl font-mono tracking-[0.4em] text-slate-900 placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors {{ $errors->has('otp') ? 'border-red-400 bg-red-50' : '' }}"
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
                            {{ $isRtl ? 'تفعيل المصادقة الثنائية' : 'Enable MFA' }}
                        </button>
                    </form>

                    <div class="text-center">
                        <form method="POST" action="{{ route('membership.mfa.cancel') }}">
                            @csrf
                            <button type="submit" class="text-sm text-slate-500 hover:text-slate-700 transition-colors">
                                {{ $isRtl ? '← العودة لتسجيل الدخول' : '← Back to login' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('membership.partials.no-devtools')
</body>
</html>
