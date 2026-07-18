@php $isRtl = app()->getLocale() === 'ar'; @endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isRtl ? 'تسجيل الدخول' : 'Sign In' }} — {{ $isRtl ? 'بوابة الأعضاء' : 'Membership Portal' }}</title>
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
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-blue-600 mb-4 shadow-lg">
                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <h1 class="text-xl font-bold text-slate-900">{{ $isRtl ? 'بوابة الأعضاء' : 'Membership Portal' }}</h1>
            <p class="text-sm text-slate-500 mt-1">{{ $isRtl ? 'سجّل دخولك للمتابعة' : 'Sign in to continue' }}</p>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
            @error('login')
            <div class="mb-4 p-3.5 rounded-xl bg-red-50 border border-red-200">
                <p class="flex items-center gap-2 text-red-700 text-sm font-medium">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ $message }}
                </p>
            </div>
            @enderror

            <form method="POST" action="{{ route('membership.login.post') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="login" class="block text-sm font-medium text-slate-700 mb-1.5">
                        {{ $isRtl ? 'اسم المستخدم أو البريد الإلكتروني' : 'Username or Email' }}
                    </label>
                    <input id="login" name="login" type="text" autocomplete="username" autofocus
                           value="{{ old('login') }}"
                           class="w-full border border-slate-300 rounded-lg px-3.5 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">
                        {{ $isRtl ? 'كلمة المرور' : 'Password' }}
                    </label>
                    <input id="password" name="password" type="password" autocomplete="current-password"
                           class="w-full border border-slate-300 rounded-lg px-3.5 py-2.5 text-sm text-slate-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-colors">
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-4 rounded-lg transition-colors text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    {{ $isRtl ? 'تسجيل الدخول' : 'Sign in' }}
                </button>
            </form>
        </div>

        <div class="mt-6 flex items-center justify-center gap-2 text-xs text-slate-400">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            {{ $isRtl ? 'محمي بالمصادقة الثنائية' : 'Protected by Two-Factor Authentication' }}
        </div>
    </div>

    @include('membership.partials.no-devtools')
</body>
</html>
