@php $isRtl = app()->getLocale() === 'ar'; @endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}" x-data="{ copied: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isRtl ? 'تفعيل المصادقة الثنائية' : 'Enable Two-Factor Authentication' }} — {{ $isRtl ? 'أبو رواش' : 'Ava Rewase' }}</title>
    {{-- PWA disabled for now — re-enable by uncommenting this block
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#04162e">
    <link rel="apple-touch-icon" href="/icons/apple-touch-icon.png">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Membership">
    --}}
    <link rel="icon" type="image/png" href="/favicon.png">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @if($isRtl)
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    @else
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Source+Serif+4:ital,opsz,wght@0,8..60,400..700;1,8..60,400..700&display=swap" rel="stylesheet">
    @endif
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet">
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
        .login-card-shadow {
            box-shadow: 0 20px 50px -12px rgba(4, 22, 46, 0.15);
        }
        body { font-family: {{ $isRtl ? "'Cairo', sans-serif" : "'Plus Jakarta Sans', sans-serif" }}; }
        .font-headline { font-family: {{ $isRtl ? "'Cairo', sans-serif" : "'Source Serif 4', serif" }}; }
    </style>
    <script id="tailwind-config">
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#04162e',
                        'primary-container': '#1a2b44',
                        secondary: '#735c00',
                        'secondary-container': '#fed65b',
                        background: '#fbf9f4',
                        'on-background': '#1b1c19',
                        'on-surface-variant': '#44474d',
                        'surface-container-low': '#f5f3ee',
                        'surface-container-lowest': '#ffffff',
                        'surface-container-high': '#eae8e3',
                        'outline-variant': '#c5c6ce',
                    },
                },
            },
        }
    </script>
    {{-- PWA disabled for now — re-enable by uncommenting this block
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').catch(() => {});
            });
        }
    </script>
    --}}
</head>
<body class="min-h-screen flex items-center justify-center bg-background text-on-background p-6">

    <div class="w-full max-w-3xl">

        <div class="text-center mb-6">
            <h1 class="font-headline text-xl font-semibold text-primary">
                {{ $isRtl ? 'إعداد المصادقة الثنائية' : 'Set Up Two-Factor Authentication' }}
            </h1>
            <p class="text-sm text-on-surface-variant mt-1">
                {{ $isRtl ? 'مطلوب لمتابعة الدخول إلى بوابة الأعضاء' : 'Required to continue into the membership portal' }}
            </p>
        </div>

        <div class="bg-surface-container-lowest rounded-xl login-card-shadow border border-secondary/10 p-6">
            <div class="grid md:grid-cols-2 gap-8">

                <div class="space-y-6">
                    <div class="space-y-4">
                        <div class="flex gap-3">
                            <div class="w-7 h-7 rounded-full bg-primary text-white flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">1</div>
                            <div>
                                <h3 class="text-sm font-semibold text-on-background">{{ $isRtl ? 'ثبّت التطبيق' : 'Install the App' }}</h3>
                                <p class="text-sm text-on-surface-variant mt-0.5">{{ $isRtl ? 'حمّل تطبيق Google Authenticator من متجر التطبيقات على هاتفك.' : "Download Google Authenticator from your phone's app store." }}</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="w-7 h-7 rounded-full bg-primary text-white flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">2</div>
                            <div>
                                <h3 class="text-sm font-semibold text-on-background">{{ $isRtl ? 'امسح رمز QR' : 'Scan the QR Code' }}</h3>
                                <p class="text-sm text-on-surface-variant mt-0.5">{{ $isRtl ? 'افتح التطبيق واضغط على علامة + ثم امسح رمز QR المعروض.' : 'Open the app, tap the + button, and scan the QR code shown here.' }}</p>
                            </div>
                        </div>
                        <div class="flex gap-3">
                            <div class="w-7 h-7 rounded-full bg-primary text-white flex items-center justify-center text-xs font-bold flex-shrink-0 mt-0.5">3</div>
                            <div>
                                <h3 class="text-sm font-semibold text-on-background">{{ $isRtl ? 'أدخل الرمز' : 'Enter the Code' }}</h3>
                                <p class="text-sm text-on-surface-variant mt-0.5">{{ $isRtl ? 'أدخل الرمز المكون من 6 أرقام الذي يظهر في التطبيق أدناه.' : 'Enter the 6-digit code shown in the app below.' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-surface-container-low rounded-lg p-4 border border-outline-variant">
                        <p class="text-xs font-medium text-on-surface-variant mb-2">
                            {{ $isRtl ? 'لا تستطيع مسح الرمز؟ أدخل هذا المفتاح يدوياً:' : "Can't scan? Enter this key manually:" }}
                        </p>
                        <div class="flex items-center gap-2">
                            <code class="flex-1 text-sm font-mono font-semibold text-on-background tracking-wider break-all select-all">{{ $secret }}</code>
                            <button type="button"
                                x-on:click="
                                    (navigator.clipboard && window.isSecureContext
                                        ? navigator.clipboard.writeText('{{ $secret }}')
                                        : (() => {
                                            const ta = document.createElement('textarea');
                                            ta.value = '{{ $secret }}';
                                            ta.style.position = 'fixed';
                                            ta.style.opacity = '0';
                                            document.body.appendChild(ta);
                                            ta.select();
                                            document.execCommand('copy');
                                            document.body.removeChild(ta);
                                        })()
                                    );
                                    copied = true; setTimeout(() => copied = false, 2000)
                                "
                                class="flex-shrink-0 p-2 rounded-lg text-on-surface-variant hover:text-secondary hover:bg-secondary-container/20 transition-colors"
                                :title="copied ? '{{ $isRtl ? 'تم النسخ!' : 'Copied!' }}' : '{{ $isRtl ? 'نسخ' : 'Copy' }}'">
                                <span x-show="!copied" class="material-symbols-outlined text-lg">content_copy</span>
                                <span x-show="copied" x-cloak class="material-symbols-outlined text-lg text-green-600">check</span>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="space-y-5">
                    <div class="flex justify-center">
                        <div class="bg-white p-4 rounded-xl border-2 border-secondary/20 inline-block">
                            {!! $qrCodeSvg !!}
                        </div>
                    </div>

                    <form method="POST" action="{{ route('membership.mfa.setup.confirm') }}" class="space-y-4">
                        @csrf
                        <div>
                            <label for="otp" class="block text-sm font-semibold text-on-surface-variant mb-1.5">
                                {{ $isRtl ? 'رمز التحقق' : 'Verification Code' }}
                            </label>
                            <input type="text" id="otp" name="otp"
                                inputmode="numeric" maxlength="6" autocomplete="one-time-code"
                                class="w-full border border-outline-variant rounded-lg px-3.5 py-3 text-center text-xl font-mono tracking-[0.4em] text-on-background placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-secondary/30 focus:border-secondary transition-colors {{ $errors->has('otp') ? 'border-red-400 bg-red-50' : 'bg-white' }}"
                                placeholder="000000">
                            @error('otp')
                                <p class="flex items-center gap-1.5 text-red-600 text-xs mt-1.5 font-medium">
                                    <span class="material-symbols-outlined text-sm">error</span>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="w-full h-12 bg-primary hover:bg-primary-container text-white font-semibold rounded-lg transition-all active:scale-[0.98] text-sm flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-lg">verified_user</span>
                            {{ $isRtl ? 'تفعيل المصادقة الثنائية' : 'Enable MFA' }}
                        </button>
                    </form>

                    <div class="text-center">
                        <form method="POST" action="{{ route('membership.mfa.cancel') }}">
                            @csrf
                            <button type="submit" class="text-sm text-on-surface-variant hover:text-primary transition-colors">
                                {{ $isRtl ? '← العودة لتسجيل الدخول' : '← Back to login' }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- @include('membership.partials.no-devtools') --}}
</body>
</html>
