const CACHE_NAME = 'lajupesan-cache-v1';

// Install event
self.addEventListener('install', function(event) {
  self.skipWaiting();
});

// Activate event
self.addEventListener('activate', function(event) {
  event.waitUntil(
    caches.keys().then(function(cacheNames) {
      return Promise.all(
        cacheNames.filter(function(cacheName) {
          return cacheName !== CACHE_NAME;
        }).map(function(cacheName) {
          return caches.delete(cacheName);
        })
      );
    })
  );
});

// Fetch event - Network first, fallback to cache
self.addEventListener('fetch', function(event) {
  event.respondWith(
    fetch(event.request)
      .then(function(response) {
        return response;
      })
      .catch(function() {
        return caches.match(event.request);
      })
  );
});
