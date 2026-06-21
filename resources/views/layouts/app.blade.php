<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($store) ? $store->name : 'LajuPesan' }}</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('output.css') }}">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#2563eb">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="apple-touch-icon" href="{{ asset('assets/images/icons/icon-192x192.png') }}">

    @vite('resources/js/app.js')
</head>

<body>

    <!-- Toast Notification -->
    <div id="toast-notification" class="toast-notification">
        <div class="toast-content">
            <svg class="toast-icon" viewBox="0 0 24 24" fill="none">
                <circle cx="12" cy="12" r="10" fill="#22C55E" />
                <path d="M8 12.5L11 15.5L16 9.5" stroke="white" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
            </svg>
            <span id="toast-message">Berhasil ditambahkan ke keranjang!</span>
        </div>
    </div>

    <style>
        .toast-notification {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%) translateY(-100px);
            z-index: 9999;
            opacity: 0;
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
            pointer-events: none;
        }

        .toast-notification.show {
            transform: translateX(-50%) translateY(0);
            opacity: 1;
        }

        .toast-content {
            display: flex;
            align-items: center;
            gap: 10px;
            background: white;
            padding: 14px 24px;
            border-radius: 50px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
            border: 1px solid #f0f0f0;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            font-weight: 500;
            color: #353535;
            white-space: nowrap;
        }

        .toast-icon {
            width: 22px;
            height: 22px;
            flex-shrink: 0;
        }
    </style>


    <div id="Content-Container"
        class="relative flex flex-col w-full max-w-[640px] min-h-screen mx-auto overflow-x-hidden pb-32">
        @yield('content')
    </div>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="{{ asset('assets/js/index.js') }}"></script>
    @yield('script')
    <!-- Register Service Worker -->
    <script>
      if ('serviceWorker' in navigator) {
        window.addEventListener('load', function() {
          navigator.serviceWorker.register('/sw.js')
            .then(function(registration) {
              console.log('ServiceWorker registered: ', registration.scope);
            })
            .catch(function(error) {
              console.log('ServiceWorker registration failed: ', error);
            });
        });
      }
    </script>
</body>

</html>
