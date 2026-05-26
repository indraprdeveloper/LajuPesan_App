@extends('layouts.app')

@section('content')
    <style>
        .notif-dropdown {
            position: absolute;
            right: 0;
            top: 56px;
            width: 200px;
            z-index: 50;
            font-family: 'Poppins', sans-serif;
        }
        .notif-arrow {
            position: absolute;
            top: -6px;
            right: 18px;
            width: 12px;
            height: 12px;
            background-color: #ffffff;
            transform: rotate(45deg);
            box-shadow: -3px -3px 5px rgba(0, 0, 0, 0.03);
            border-left: 1px solid #f1f2f6;
            border-top: 1px solid #f1f2f6;
            z-index: 51;
        }
        .notif-card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            border: 1px solid #f1f2f6;
            overflow: hidden;
            position: relative;
            z-index: 52;
        }
        .notif-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 12px 14px;
            text-decoration: none;
            transition: background-color 0.2s ease;
        }
        .notif-item:hover {
            background-color: #FFF7ED;
        }
        .notif-item:not(:last-child) {
            border-bottom: 1px solid #f1f2f6;
        }
        .notif-icon-star {
            width: 18px;
            height: 18px;
            color: #888888;
            flex-shrink: 0;
        }
        .notif-content {
            flex: 1;
            min-width: 0;
        }
        .notif-code {
            color: #353535;
            font-size: 14px;
            font-weight: 600;
            margin: 0;
            line-height: 1.2;
        }
        .notif-desc {
            color: #888888;
            font-size: 11.5px;
            line-height: 1.3;
            margin: 2px 0 0 0;
        }
        .notif-arrow-right {
            width: 12px;
            height: 12px;
            color: #cccccc;
            flex-shrink: 0;
        }
        .header-title {
            color: #ffffff;
            font-weight: 600;
            margin-top: 20px;
            font-family: 'Poppins', sans-serif;
            font-size: 18px;
            line-height: 24px;
            max-width: 70%;
        }
        .mobile-br {
            display: block;
        }
        @media (min-width: 640px) {
            .header-title {
                font-size: 24px;
                line-height: 30px;
                max-width: 100%;
            }
            .mobile-br {
                display: none;
            }
        }
    </style>

    <div id="Background"
        class="absolute top-0 w-full h-[200px] rounded-b-[45px] bg-[linear-gradient(90deg,#FF923C_0%,#FF801A_100%)]">
    </div>

    <div id="TopNav" class="relative flex flex-col px-5 mt-[20px] h-[200px]">
        <div class="relative flex items-center justify-between">
            <div class="flex flex-col gap-1">
                <p class="text-white text-sm">Selamat Datang di,</p>
                <h1 class="text-white font-semibold">{{ $store->name }}</h1>
            </div>
            <div class="relative">
                <button onclick="toggleNotification()" id="bell-btn"
                    class="w-12 h-12 flex items-center justify-center shrink-0 rounded-full bg-white bg-opacity-20">
                    <img src="{{ asset('assets/images/icons/ic_bell.svg') }}" class="w-[28px] h-[28px]" alt="icon">
                </button>

                {{-- Badge counter - selalu dirender, hidden jika kosong --}}
                <div id="notification-badge"
                    class="absolute top-0 right-0 w-[18px] h-[18px] rounded-full bg-[#FF001A] flex items-center justify-center pointer-events-none z-10 border-2 border-white"
                    style="{{ (isset($unratedTransactions) && $unratedTransactions->count() > 0) ? '' : 'display:none' }}">
                    <span id="notification-count"
                        class="text-white text-[9px] font-bold leading-none">{{ isset($unratedTransactions) ? $unratedTransactions->count() : 0 }}</span>
                </div>

                {{-- Notification Dropdown --}}
                <div id="notification-dropdown" class="hidden notif-dropdown">
                    {{-- Arrow pointing to bell --}}
                    <div class="notif-arrow"></div>
                    <div class="notif-card">
                        <div id="notification-list" class="max-h-[250px] overflow-y-auto">
                            @if (isset($unratedTransactions) && $unratedTransactions->count() > 0)
                                @foreach ($unratedTransactions as $trx)
                                    <a href="{{ route('rating', ['username' => $store->username, 'transaction_code' => $trx->code]) }}"
                                        class="notif-item">
                                        <svg class="notif-icon-star" fill="none" stroke="currentColor"
                                            stroke-width="1.5" viewBox="0 0 24 24" stroke-linecap="round"
                                            stroke-linejoin="round">
                                            <polygon
                                                points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" />
                                        </svg>
                                        <div class="notif-content">
                                            <p class="notif-code">{{ $trx->code }}</p>
                                            <p class="notif-desc">Beri rating<br>pesanan Anda ⭐</p>
                                        </div>
                                        <svg class="notif-arrow-right" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <polyline points="9 18 15 12 9 6" />
                                        </svg>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <h1 class="header-title">
            Pesan menu pilihanmu <br class="mobile-br"> di sini!
        </h1>

        <form action="{{ route('product.find-result', $store->username) }}" method="GET"
            class="absolute bottom-0 left-0 right-0 w-full gap-2 px-5">
            <label
                class="flex items-center w-full rounded-full p-[8px_8px] gap-3 bg-white ring-1 ring-[#F1F2F6] focus-within:ring-[#F3AF00] transition-all duration-300">
                <img src="{{ asset('assets/images/icons/ic_search.svg') }}" class="w-8 h-8 flex shrink-0" alt="icon">
                <input type="text" name="search" id="search-input"
                    class="appearance-none outline-none w-full font-semibold placeholder:text-ngekos-grey placeholder:font-light"
                    placeholder="Cari menu, dll...">
                <button type="submit"
                    class="flex items-center justify-center w-9 h-9 shrink-0 rounded-full bg-[linear-gradient(90deg,#FF923C_0%,#FF801A_100%)] hover:opacity-90 transition-opacity duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                        <polyline points="12 5 19 12 12 19"></polyline>
                    </svg>
                </button>
            </label>
        </form>

    </div>

    <div id="Categories" class="relative flex flex-col px-5 mt-[20px]">
        <div class="flex items-end justify-between ">
            <h1 class="text-[#353535] font-[500] text-lg">Kategori</h1>
        </div>

        <div class="swiper w-full">
            <div class="swiper-wrapper mt-[20px]">
                @foreach ($store->productCategories as $category)
                    <a href="{{ route('product.find-result', $store->username) . '?category=' . $category->slug }}"
                        class="swiper-slide !w-fit">
                        <div class="flex flex-col items-center shrink-0 gap-2 text-center">
                            <div
                                class="w-[64px] h-[64px] rounded-full flex shrink-0 overflow-hidden bg-[#9393931A] bg-opacity-10">
                                <img src="{{ asset('storage/' . $category->icon) }}" class="w-full h-full object-cover"
                                    alt="thumbnail">
                            </div>

                            <div class="flex flex-col gap-[2px]">
                                <h3 class="font-light text-[#504D53] text-[14px]">{{ $category->name }}</h3>
                            </div>
                        </div>
                    </a>
                @endforeach

            </div>
        </div>
    </div>

    <div id="Favorites" class="relative flex flex-col px-5 mt-[20px]">
        <div class="flex items-end justify-between">
            <h1 class="text-[#353535] font-[500] text-lg">Menu Favorit</h1>
        </div>

        <div class="swiper w-full">
            <div class="swiper-wrapper mt-[10px]">
                @foreach ($populars as $popular)
                    <div class="swiper-slide !w-fit">
                        <a href="{{ route('product.show', ['username' => $store->username, 'id' => $popular->id]) }}"
                            class="card">
                            <div
                                class="flex flex-col w-[210px] shrink-0 rounded-[8px] bg-white p-[12px] pb-5 gap-[10px] hover:bg-[#FFF7F0] hover:border-[1px] hover:border-[#F3AF00] transition-all duration-300 cursor-pointer">
                                <div
                                    class="position-relative flex w-full h-[150px] shrink-0 rounded-[8px] bg-[#D9D9D9] overflow-hidden">
                                    <img src="{{ asset('storage/' . $popular->image) }}" class="w-full h-full object-cover"
                                        alt="thumbnail">

                                    <!-- rating -->
                                    <div
                                        class="absolute top-5 right-5 flex items-center gap-1 bg-white px-[8px] py-[4px] rounded-full">
                                        <img src="assets/images/icons/ic_star.svg" alt="rating" class="w-4 h-4">
                                        <p class="text-sm">{{ $popular->average_rating }}</p>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-1">
                                    <p class="text-[#F3AF00] font-[400] text-[12px]">
                                        {{ $popular->productCategory->name }}
                                    </p>
                                    <h3 class="text-[#353535] font-[500] text-[14px]">
                                        {{ $popular->name }}
                                    </h3>
                                    <p class="text-[#606060] font-[400] text-[10px]">
                                        {{ $popular->description }}
                                    </p>

                                </div>

                                <div class="flex items-center justify-between ">
                                    <p class="text-[#FF001A] font-[600] text-[14px]">
                                        Rp {{ number_format($popular->price) }}
                                    </p>
                                    <button type="button"
                                        class="flex items-center justify-center w-[24px] h-[24px] rounded-full bg-transparent"
                                        data-id="{{ $popular->id }}" onclick="addToCart(this.dataset.id)">
                                        <img src="assets/images/icons/ic_plus.svg" class="w-full h-full" alt="icon">
                                    </button>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <div id="Recomendations" class="relative flex flex-col px-5 mt-[20px]">
        <div class="flex items-end justify-between ">
            <h1 class="text-[#353535] font-[500] text-lg">Rekomendasi</h1>
            <a href="{{ route('product.find-result', $store->username) }}" class="text-[#FF801A] text-sm ">Lihat Semua</a>
        </div>
        <div class="flex flex-col gap-4 mt-[10px]">

            @foreach ($products as $product)
                <a href="{{ route('product.show', ['username' => $store->username, 'id' => $product->id]) }}"
                    class="card">
                    <div
                        class="flex rounded-[8px] border border-[#F1F2F6] p-[12px] gap-4 bg-white hover:bg-[#FFF7F0] hover:border-[1px] hover:border-[#F3AF00] transition-all duration-300">
                        <img src="{{ asset('storage/' . $product->image) }}" class="w-[128px] object-cover rounded-[8px]"
                            alt="icon">
                        <div class="flex flex-col gap-1 w-full">
                            <p class="text-[#F3AF00] font-[400] text-[12px]">
                                {{ $product->productCategory->name }}
                            </p>
                            <h3 class="text-[#353535] font-[500] text-[14px]">
                                {{ $product->name }}
                            </h3>
                            <p class="text-[#606060] font-[400] text-[10px]">
                                {{ $product->description }}
                            </p>

                            <div class="flex items-center justify-between ">
                                <p class="text-[#FF001A] font-[600] text-[14px]">
                                    Rp {{ number_format($product->price) }}
                                </p>
                                <button type="button"
                                    class="flex items-center justify-center w-[24px] h-[24px] rounded-full bg-transparent"
                                    data-id="{{ $product->id }}" onclick="addToCart(this.dataset.id)">
                                    <img src="assets/images/icons/ic_plus.svg" class="w-full h-full" alt="icon">
                                </button>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    @include('includes.navigation')
@endsection

@section('script')
    <script>
        function toggleNotification() {
            const badge = document.getElementById('notification-badge');
            const countEl = document.getElementById('notification-count');
            const count = parseInt(countEl ? countEl.textContent : '0') || 0;

            // Jika jumlah notifikasi adalah 0 atau badge disembunyikan, lonceng tidak bisa diklik
            if (count === 0 || (badge && badge.style.display === 'none')) {
                return;
            }

            const dropdown = document.getElementById('notification-dropdown');
            if (dropdown) {
                dropdown.classList.toggle('hidden');
            }
        }

        // Tutup dropdown ketika klik di luar
        document.addEventListener('click', function(e) {
            const dropdown = document.getElementById('notification-dropdown');
            const bellBtn = document.getElementById('bell-btn');
            if (dropdown && bellBtn && !bellBtn.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Tampilkan toast jika ada session rating_success
        @if (session('rating_success'))
            document.addEventListener('DOMContentLoaded', function() {
                showToast('{{ session('rating_success') }}');
            });
        @endif

        // Auto-buka notifikasi jika dari halaman sukses
        document.addEventListener('DOMContentLoaded', function() {
            const params = new URLSearchParams(window.location.search);
            if (params.get('from') === 'success') {
                const dropdown = document.getElementById('notification-dropdown');
                if (dropdown) {
                    dropdown.classList.remove('hidden');
                }

                // Hapus query param dari URL agar tidak terbuka ulang saat refresh
                window.history.replaceState({}, '', window.location.pathname);
            }
        });
        // Data transaksi milik pengunjung ini (dari cookie)
        var myTransactionIds = @json($userTransactions ?? []).map(Number);

        // Realtime: notif rating muncul otomatis tanpa reload
        var echoInterval = setInterval(function() {
            if (window.Echo) {
                clearInterval(echoInterval);
                window.Echo.channel('store.{{ $store->id }}')
                    .listen('TransactionStatusUpdated', (data) => {
                        if (data.status === 'success' && myTransactionIds.includes(Number(data.transaction_id))) {
                            // Update badge counter
                            var badge = document.getElementById('notification-badge');
                            var countEl = document.getElementById('notification-count');
                            var currentCount = parseInt(countEl.textContent) || 0;
                            countEl.textContent = currentCount + 1;
                            badge.style.display = 'flex';

                            // Tambah item ke dropdown
                            var list = document.getElementById('notification-list');
                            var ratingUrl = '/{{ $store->username }}/rating/' + data.code;
                            var newItem = document.createElement('a');
                            newItem.href = ratingUrl;
                            newItem.className = 'notif-item';
                            newItem.innerHTML = '<svg class="notif-icon-star" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2" /></svg><div class="notif-content"><p class="notif-code">' + data.code + '</p><p class="notif-desc">Beri rating<br>pesanan Anda ⭐</p></div><svg class="notif-arrow-right" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6" /></svg>';
                            list.insertBefore(newItem, list.firstChild);

                            // Auto-buka dropdown
                            var dropdown = document.getElementById('notification-dropdown');
                            if (dropdown) {
                                dropdown.classList.remove('hidden');
                            }
                        }
                    });
            }
        }, 500);
    </script>
@endsection
