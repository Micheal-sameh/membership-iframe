<script>
(function () {
    document.addEventListener('contextmenu', function (e) { e.preventDefault(); });

    document.addEventListener('keydown', function (e) {
        var key = (e.key || '').toLowerCase();
        var blocked =
            key === 'f12' ||
            (e.ctrlKey && e.shiftKey && ['i', 'j', 'c'].includes(key)) ||
            (e.metaKey && e.altKey && ['i', 'j', 'c'].includes(key)) ||
            (e.ctrlKey && ['u', 's'].includes(key));

        if (blocked) {
            e.preventDefault();
            e.stopPropagation();
        }
    });

    function lockOut() {
        var isRtl = document.documentElement.dir === 'rtl';
        document.documentElement.innerHTML =
            '<head><meta charset="UTF-8"></head>' +
            '<body style="margin:0;min-height:100vh;display:flex;align-items:center;justify-content:center;' +
            'background:#f8fafc;font-family:' + (isRtl ? "'Cairo'" : "'Inter'") + ',sans-serif;">' +
            '<div style="text-align:center;max-width:22rem;padding:1.5rem;">' +
            '<div style="width:3.5rem;height:3.5rem;border-radius:1rem;background:#fee2e2;' +
            'display:flex;align-items:center;justify-content:center;margin:0 auto 1rem;">' +
            '<svg width="28" height="28" fill="none" stroke="#dc2626" viewBox="0 0 24 24">' +
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-8.99 3.75h.008v.008h-.008v-.008z"/></svg></div>' +
            '<h1 style="font-size:1.1rem;font-weight:700;color:#0f172a;margin:0 0 .25rem;">' +
            (isRtl ? 'تم تقييد الوصول' : 'Access Restricted') + '</h1>' +
            '<p style="font-size:.875rem;color:#64748b;margin:0;">' +
            (isRtl ? 'أدوات المطور غير مسموح بها في هذه البوابة.' : 'Developer tools are not permitted on this portal.') +
            '</p></div></body>';
    }

    var threshold = 160;
    var triggered = false;
    setInterval(function () {
        var widthDiff = window.outerWidth - window.innerWidth > threshold;
        var heightDiff = window.outerHeight - window.innerHeight > threshold;
        if ((widthDiff || heightDiff) && !triggered) {
            triggered = true;
            lockOut();
        }
    }, 500);
})();
</script>
