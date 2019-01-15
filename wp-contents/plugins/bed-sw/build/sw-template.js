/**
 * Based from the reacticon service worker
 *
 * @date 15/01/2019
 * @see http://reacticon.org/serviceworker.js
 */
const CACHE_NAME = /* BEDSW--VAR{cacheName} */;
const OFFLINE_FILES_URL = '/wp-json/bed-sw/offlinefiles';

importScripts('serviceworker-cache-polyfill.js');

self.addEventListener('install', event => {
    event.waitUntil (
        caches.open(CACHE_NAME)
            .then(cache => {
                fetch(OFFLINE_FILES_URL)
                    .then(response => response.json())
                    .then(cachableFiles => cache.addAll(cachableFiles))
                    .catch(error => console.log(error))
            })
            .then(() => self.skipWaiting())
    )
});

self.addEventListener('activate', event => {
    event.waitUntil(self.clients.claim());
});

self.addEventListener('fetch', event => {
    /* BEDSW--IF{isDisabled} */
    return false;
    /* BEDSW--ENDIF{isDisabled} */
    event.respondWith(
        caches.match(event.request, {ignoreSearch: true})
            .then(response => fetch(event.request).catch(error => response))
            .catch(error => caches.match('/'))
    );
});