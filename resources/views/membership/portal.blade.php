@php $isRtl = app()->getLocale() === 'ar'; @endphp
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $isRtl ? 'بوابة الأعضاء' : 'Membership Portal' }} — {{ $isRtl ? 'أبو رواش' : 'Ava Rewase' }}</title>
    @include('membership.partials.head-assets')
    <style>html, body { height: 100%; margin: 0; }</style>
</head>
<body class="flex flex-col bg-surface-container-low text-on-background antialiased">

    @include('membership.partials.nav')

    <main class="flex-1 min-h-0">
        @if($iframeUrl)
            <iframe src="{{ $iframeUrl }}" class="w-full h-full border-0" allowfullscreen></iframe>
        @else
            <div class="h-full flex items-center justify-center p-6">
                <div class="text-center max-w-sm">
                    <div class="mx-auto w-14 h-14 rounded-2xl bg-secondary-container/30 flex items-center justify-center mb-4">
                        <span class="material-symbols-outlined text-secondary text-3xl">folder_off</span>
                    </div>
                    <h2 class="font-headline text-lg font-semibold text-primary">{{ $isRtl ? 'لم يتم إعداد الرابط بعد' : 'No content URL configured yet' }}</h2>
                    <p class="text-sm text-on-surface-variant mt-1">{{ $isRtl ? 'يرجى ضبط MEMBERSHIP_IFRAME_URL في إعدادات النظام.' : 'Set MEMBERSHIP_IFRAME_URL in the environment configuration.' }}</p>
                </div>
            </div>
        @endif
    </main>

    {{-- @include('membership.partials.no-devtools') --}}
    @include('membership.partials.install-prompt')
</body>
</html>
