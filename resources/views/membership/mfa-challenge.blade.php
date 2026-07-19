@php $isRtl = app()->getLocale() === 'ar'; @endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isRtl ? 'المصادقة الثنائية' : 'Two-Factor Authentication' }} — {{ $isRtl ? 'أبو رواش' : 'Ava Rewase' }}</title>
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

    <div class="w-full max-w-sm">

        <div class="text-center mb-8">
            <div class="mx-auto w-14 h-14 rounded-2xl bg-secondary-container/30 flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-secondary text-3xl">shield_lock</span>
            </div>
            <h1 class="font-headline text-xl font-semibold text-primary">
                {{ $isRtl ? 'المصادقة الثنائية' : 'Two-Factor Authentication' }}
            </h1>
            <p class="text-on-surface-variant mt-1.5 text-sm">
                {{ $isRtl ? 'أدخل الرمز المكون من 6 أرقام من تطبيق Google Authenticator' : 'Enter the 6-digit code from Google Authenticator' }}
            </p>
        </div>

        <div class="bg-surface-container-lowest rounded-xl login-card-shadow border border-secondary/10 p-6">
            <form method="POST" action="{{ route('membership.mfa.verify') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="otp" class="block text-sm font-semibold text-on-surface-variant mb-1.5">
                        {{ $isRtl ? 'رمز التحقق' : 'Verification Code' }}
                    </label>
                    <input type="text" id="otp" name="otp"
                        inputmode="numeric" maxlength="6" autofocus autocomplete="one-time-code"
                        class="w-full border border-outline-variant rounded-lg px-3.5 py-3 text-center text-2xl font-mono tracking-[0.5em] text-on-background placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-secondary/30 focus:border-secondary transition-colors {{ $errors->has('otp') ? 'border-red-400 bg-red-50' : 'bg-white' }}"
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
                    {{ $isRtl ? 'تحقق' : 'Verify' }}
                </button>
            </form>

            <div class="mt-6 text-center">
                <form method="POST" action="{{ route('membership.mfa.cancel') }}">
                    @csrf
                    <button type="submit" class="text-sm text-on-surface-variant hover:text-primary transition-colors">
                        {{ $isRtl ? '← العودة لتسجيل الدخول' : '← Back to login' }}
                    </button>
                </form>
            </div>
        </div>

    </div>

    {{-- @include('membership.partials.no-devtools') --}}
</body>
</html>
