const CACHE_NAME = 'beans-pwa-v1';
const URLS_TO_CACHE = [
  '/',                     // if you want to cache root
  '/pages/scan.php',       // start_url
  '/static/css/custom.css',
  '/static/js/app.js',     // your main JS
  '/static/img/pixel-coffee-robot.png',
  '/static/img/coffee-farm-pixel.png',
  // add any other assets, fonts, icons...
];

self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => cache.addAll(URLS_TO_CACHE))
      .then(() => self.skipWaiting())
  );
});

self.addEventListener('activate', event => {
  // clean up old caches
  event.waitUntil(
    caches.keys().then(keys =>
      Promise.all(
        keys
          .filter(key => key !== CACHE_NAME)
          .map(key => caches.delete(key))
      )
    )
  );
});

self.addEventListener('fetch', event => {
  event.respondWith(
    caches.match(event.request)
      .then(cached => {
        if (cached) return cached;
        return fetch(event.request)
          .then(response => {
            // optionally cache new resources
            return caches.open(CACHE_NAME).then(cache => {
              cache.put(event.request, response.clone());
              return response;
            });
          });
      })
      .catch(() => {
        // optionally return offline fallback for navigation
        if (event.request.mode === 'navigate') {
          return caches.match('/offline.html');
        }
      })
  );
});
