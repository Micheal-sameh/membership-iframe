@php $isRtl = app()->getLocale() === 'ar'; @endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isRtl ? 'بوابة الأعضاء' : 'Membership Portal' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @if($isRtl)
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Cairo', sans-serif; }</style>
    @else
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
    @endif
    <style>html, body { height: 100%; margin: 0; }</style>
</head>
<body class="flex flex-col bg-slate-50 text-slate-900 antialiased">

    <header class="bg-white border-b border-slate-200 flex-shrink-0">
        <div class="px-4 sm:px-6 h-14 flex items-center gap-3">
            <div class="flex items-center gap-2.5 flex-1 min-w-0">
                <div class="w-7 h-7 rounded-lg bg-blue-600 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                </div>
                <span class="text-sm font-semibold text-slate-900 truncate">{{ $isRtl ? 'بوابة الأعضاء' : 'Membership Portal' }}</span>
            </div>

            <div class="flex items-center gap-2">
                <span class="text-xs text-slate-500 hidden sm:inline truncate max-w-[200px]">{{ Auth::user()->login }}</span>
                <form method="POST" action="{{ route('membership.logout') }}" class="m-0">
                    @csrf
                    <button type="submit"
                            class="text-xs text-slate-500 hover:text-red-500 transition-colors px-2 py-1 rounded-md hover:bg-slate-100">
                        {{ $isRtl ? 'تسجيل الخروج' : 'Sign Out' }}
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="flex-1 min-h-0">
        @if($iframeUrl)
            <iframe src="{{ $iframeUrl }}" class="w-full h-full border-0" allowfullscreen></iframe>
        @else
            <div class="h-full flex items-center justify-center p-6">
                <div class="text-center max-w-sm">
                    <div class="mx-auto w-14 h-14 rounded-2xl bg-slate-100 flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 17.25v1.007a3 3 0 01-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0115 18.257V17.25m6-12V15a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 15V5.25m18 0A2.25 2.25 0 0018.75 3H5.25A2.25 2.25 0 003 5.25m18 0V12a2.25 2.25 0 01-2.25 2.25H5.25A2.25 2.25 0 013 12V5.25"/>
                        </svg>
                    </div>
                    <h2 class="text-lg font-semibold text-slate-800">{{ $isRtl ? 'لم يتم إعداد الرابط بعد' : 'No content URL configured yet' }}</h2>
                    <p class="text-sm text-slate-500 mt-1">{{ $isRtl ? 'يرجى ضبط MEMBERSHIP_IFRAME_URL في إعدادات النظام.' : 'Set MEMBERSHIP_IFRAME_URL in the environment configuration.' }}</p>
                </div>
            </div>
        @endif
    </main>

    @include('membership.partials.no-devtools')
</body>
</html>
