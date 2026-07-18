@php $isRtl = app()->getLocale() === 'ar'; @endphp
<div id="pwa-install-banner"
     class="hidden fixed bottom-4 inset-x-4 sm:inset-x-auto sm:right-4 sm:left-auto sm:w-96 z-50 bg-surface-container-lowest border border-secondary/20 rounded-xl login-card-shadow p-4">
    <div class="flex items-start gap-3">
        <img src="/icons/icon-192.png" alt="" class="w-11 h-11 rounded-lg flex-shrink-0">
        <div class="flex-1 min-w-0">
            <p class="font-semibold text-sm text-on-background">
                {{ $isRtl ? 'ثبّت تطبيق بوابة الأعضاء' : 'Install the Membership app' }}
            </p>
            <p id="pwa-install-subtext" class="text-xs text-on-surface-variant mt-0.5">
                {{ $isRtl ? 'وصول أسرع من شاشتك الرئيسية.' : 'Faster access from your home screen.' }}
            </p>
            <div id="pwa-install-steps" class="hidden mt-2 text-xs text-on-surface-variant bg-surface-container-low rounded-lg p-2.5 space-y-1"></div>
            <div class="mt-3 flex items-center gap-2">
                <button id="pwa-install-button" type="button"
                        class="h-9 px-4 bg-primary hover:bg-primary-container text-white font-semibold text-xs rounded-lg transition-all active:scale-[0.98] flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-base">download</span>
                    <span id="pwa-install-button-label">{{ $isRtl ? 'تثبيت' : 'Install' }}</span>
                </button>
                <button id="pwa-install-dismiss" type="button"
                        class="h-9 px-3 text-on-surface-variant hover:text-on-background text-xs font-semibold rounded-lg hover:bg-surface-container-high transition-colors">
                    {{ $isRtl ? 'ليس الآن' : 'Not now' }}
                </button>
            </div>
        </div>
        <button id="pwa-install-close" type="button" class="text-on-surface-variant hover:text-on-background flex-shrink-0">
            <span class="material-symbols-outlined text-lg">close</span>
        </button>
    </div>
</div>

<script>
(function () {
    var DISMISS_KEY = 'pwa-install-dismissed-until';
    var DISMISS_DAYS = 7;
    var isRtl = @json($isRtl);

    var t = isRtl ? {
        iosSteps: ['اضغط على أيقونة المشاركة أسفل الشاشة (مربع بسهم لأعلى).', 'مرر لأسفل واضغط على "إضافة إلى الشاشة الرئيسية".', 'اضغط "إضافة" في أعلى الشاشة.'],
        iosButton: 'أرني كيف',
        androidSteps: ['اضغط على قائمة (⋮) في أعلى المتصفح.', 'اختر "إضافة إلى الشاشة الرئيسية" أو "تثبيت التطبيق".'],
        androidButtonFallback: 'إظهار التعليمات',
    } : {
        iosSteps: ['Tap the Share icon at the bottom of the screen (square with an arrow).', 'Scroll down and tap "Add to Home Screen".', 'Tap "Add" at the top.'],
        iosButton: 'Show me how',
        androidSteps: ['Tap the (⋮) menu at the top of the browser.', 'Choose "Add to Home screen" or "Install app".'],
        androidButtonFallback: 'Show instructions',
    };

    function isDismissed() {
        var until = localStorage.getItem(DISMISS_KEY);
        return until && Date.now() < parseInt(until, 10);
    }

    function dismiss() {
        localStorage.setItem(DISMISS_KEY, String(Date.now() + DISMISS_DAYS * 24 * 60 * 60 * 1000));
        hide();
    }

    function hide() {
        var el = document.getElementById('pwa-install-banner');
        if (el) el.classList.add('hidden');
    }

    function show() {
        var el = document.getElementById('pwa-install-banner');
        if (el) el.classList.remove('hidden');
    }

    function showSteps(steps) {
        var box = document.getElementById('pwa-install-steps');
        box.innerHTML = steps.map(function (s, i) {
            return '<div>' + (i + 1) + '. ' + s + '</div>';
        }).join('');
        box.classList.remove('hidden');
    }

    var isStandalone = window.matchMedia('(display-mode: standalone)').matches
        || window.navigator.standalone === true;

    if (isStandalone || isDismissed()) {
        return;
    }

    var isIos = /iphone|ipad|ipod/i.test(window.navigator.userAgent);
    var deferredPrompt = null;

    // Auto-remove after 1 minute if the user never interacts with it.
    var AUTO_HIDE_MS = 60 * 1000;
    var autoHideTimer = setTimeout(hide, AUTO_HIDE_MS);
    function stopAutoHide() {
        clearTimeout(autoHideTimer);
    }

    document.getElementById('pwa-install-close').addEventListener('click', function () {
        stopAutoHide();
        dismiss();
    });
    document.getElementById('pwa-install-dismiss').addEventListener('click', function () {
        stopAutoHide();
        dismiss();
    });

    if (isIos) {
        // iOS Safari has no programmatic install API at all — tapping can only
        // reveal the manual steps, it can never install directly.
        document.getElementById('pwa-install-button-label').textContent = t.iosButton;
        document.getElementById('pwa-install-button').addEventListener('click', function () {
            stopAutoHide();
            showSteps(t.iosSteps);
        });
        show();
        return;
    }

    // Android/Chrome: beforeinstallprompt is unreliable in practice (engagement
    // heuristics, repeat-visit requirements) — if it never fires, tapping Install
    // must still DO something instead of silently no-op'ing.
    window.addEventListener('beforeinstallprompt', function (event) {
        event.preventDefault();
        deferredPrompt = event;
        show();
    });

    document.getElementById('pwa-install-button').addEventListener('click', function () {
        if (deferredPrompt) {
            stopAutoHide();
            deferredPrompt.prompt();
            deferredPrompt.userChoice.finally(function () {
                deferredPrompt = null;
                hide();
            });
            return;
        }

        stopAutoHide();
        document.getElementById('pwa-install-button-label').textContent = t.androidButtonFallback;
        showSteps(t.androidSteps);
    });

    // Show the banner regardless of whether beforeinstallprompt has fired yet,
    // so there's always something to tap rather than nothing appearing at all.
    show();

    window.addEventListener('appinstalled', function () {
        stopAutoHide();
        hide();
    });
})();
</script>
