// Minimal service worker for installability. This app is almost entirely
// dynamic/authenticated (login, MFA, live SSRS report iframe), so we
// deliberately do NOT cache page HTML or API-like responses — that would
// risk serving stale CSRF tokens, stale auth state, or stale report data.
// We only cache the static app-shell assets needed offline, and fall back
// to offline.html for failed page navigations.
const CACHE_NAME = 'membership-shell-v1';
const PRECACHE_URLS = [
    '/manifest.json',
    '/icons/icon-192.png',
    '/icons/icon-512.png',
    '/offline.html',
];

self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME).then((cache) => cache.addAll(PRECACHE_URLS))
    );
    self.skipWaiting();
});

self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((keys) =>
            Promise.all(keys.filter((key) => key !== CACHE_NAME).map((key) => caches.delete(key)))
        )
    );
    self.clients.claim();
});

self.addEventListener('fetch', (event) => {
    const { request } = event;

    if (request.method !== 'GET') {
        return; // never intercept POST/PUT (forms, CSRF-sensitive actions)
    }

    // Page navigations: network-first, offline fallback on failure only.
    if (request.mode === 'navigate') {
        event.respondWith(
            fetch(request).catch(() => caches.match('/offline.html'))
        );
        return;
    }

    // Static app-shell assets we explicitly precached: cache-first.
    const url = new URL(request.url);
    if (PRECACHE_URLS.includes(url.pathname)) {
        event.respondWith(
            caches.match(request).then((cached) => cached || fetch(request))
        );
        return;
    }

    // Everything else (report iframe content, CSS/JS from CDNs, API-like
    // paths) passes straight through to the network, untouched.
});
