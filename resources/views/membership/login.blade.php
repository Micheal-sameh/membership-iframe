@php $isRtl = app()->getLocale() === 'ar'; @endphp
<!DOCTYPE html>
<html class="scroll-smooth" lang="{{ app()->getLocale() }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isRtl ? 'تسجيل الدخول' : 'Login' }} — {{ $isRtl ? 'أبو رواش' : 'Ava Rewase' }}</title>
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#04162e">
    <link rel="icon" type="image/png" href="/favicon.png">
    <link rel="apple-touch-icon" href="/icons/apple-touch-icon.png">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Membership">
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
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
        .warm-overlay {
            background: linear-gradient(to right, rgba(4, 22, 46, 0.4), rgba(4, 22, 46, 0.1));
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
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').catch(() => {});
            });
        }
    </script>
</head>
<body class="bg-background text-on-background h-screen overflow-hidden flex flex-col">

    <main class="flex-1 min-h-0 flex flex-col md:flex-row">
        {{-- Split screen: image side --}}
        <div class="hidden md:block md:w-1/2 relative overflow-hidden">
            <div class="absolute inset-0 warm-overlay z-10"></div>
            <img alt="Interior of St. Mary and St. Reweis Church"
                 class="w-full h-full object-cover"
                 src="https://lh3.googleusercontent.com/aida-public/AB6AXuDArCfU658E5mLURr9CuXJLGuIc5ewREyTesFEUUJUP_CjwFF31wA3mxS6ErYKx__E16ImB0px20TeKqAYMK-jRzQGLkqpu_9BBV0ygrAPbTiiUjJ20uGT4_HpN8Exe3nI0COoh6sVJAWGuWkeoA_q3zt8Yzn310qAvSik7wnr6t9sPQzF9dRXoS0WAn4FNrJeT08dADnVdaykMr_vrl1umKHebWKTaXyyj5mOBENuFAVwuTNITuDSyE6-mjeOdyENOzQg">
            <div class="absolute {{ $isRtl ? 'bottom-12 right-12' : 'bottom-12 left-12' }} z-20 max-w-md">
                <h1 class="font-headline text-white text-3xl lg:text-4xl font-semibold leading-tight mb-3">
                    {{ $isRtl ? 'عضوية أبو رواش' : 'Ava Rewase Membership' }}
                </h1>
                <p class="text-white/90 text-base">
                    {{ $isRtl ? 'مرحبًا بك في البيت الرقمي لكنيسة السيدة العذراء والشهيد أبو رويس. انضم إلى مجتمعنا وابقَ على تواصل.' : 'Welcome to the digital home of St. Mary & St. Reweis Church. Join our community and stay connected.' }}
                </p>
            </div>
        </div>

        {{-- Split screen: login form --}}
        <div class="w-full md:w-1/2 flex items-center justify-center p-4 sm:p-6 lg:p-10 bg-surface-container-low min-h-0">
            <div class="w-full max-w-md bg-surface-container-lowest p-6 sm:p-8 rounded-xl login-card-shadow border border-secondary/10 max-h-full overflow-y-auto">
                <div class="mb-6">
                    <h2 class="font-headline text-2xl font-medium text-primary mb-1">
                        {{ $isRtl ? 'أهلاً بعودتك' : 'Welcome Home' }}
                    </h2>
                    <p class="text-on-surface-variant text-sm">
                        {{ $isRtl ? 'سجّل دخولك إلى حساب العضوية الخاص بك.' : 'Sign in to your member account.' }}
                    </p>
                </div>

                @error('login')
                <div class="mb-4 p-3 rounded-lg bg-red-50 border border-red-200">
                    <p class="flex items-center gap-2 text-red-700 text-sm font-medium">
                        <span class="material-symbols-outlined text-base">error</span>
                        {{ $message }}
                    </p>
                </div>
                @enderror

                <form method="POST" action="{{ route('membership.login.post') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block font-semibold text-sm text-on-surface-variant mb-1.5" for="login">
                            {{ $isRtl ? 'البريد الإلكتروني' : 'Email Address' }}
                        </label>
                        <input id="login" name="login" type="email" autocomplete="username" autofocus
                               value="{{ old('login') }}"
                               placeholder="name@example.com"
                               class="w-full h-11 px-4 bg-white border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all outline-none">
                    </div>

                    <div>
                        <label class="block font-semibold text-sm text-on-surface-variant mb-1.5" for="password">
                            {{ $isRtl ? 'كلمة المرور' : 'Password' }}
                        </label>
                        <input id="password" name="password" type="password" autocomplete="current-password"
                               placeholder="••••••••"
                               class="w-full h-11 px-4 bg-white border border-outline-variant rounded-lg focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all outline-none">
                    </div>

                    <button type="submit"
                            class="w-full h-12 bg-primary text-white font-semibold text-base rounded-lg hover:bg-primary-container active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                        {{ $isRtl ? 'تسجيل الدخول' : 'Sign In' }}
                        <span class="material-symbols-outlined">login</span>
                    </button>
                </form>

                <div class="mt-6 pt-4 border-t border-surface-container-high text-center">
                    <p class="text-on-surface-variant text-xs inline-flex items-center gap-2 justify-center">
                        <span class="material-symbols-outlined text-sm">shield_lock</span>
                        {{ $isRtl ? 'محمي بالمصادقة الثنائية' : 'Protected by Two-Factor Authentication' }}
                    </p>
                </div>
            </div>
        </div>
    </main>

    {{-- @include('membership.partials.no-devtools') --}}
</body>
</html>
