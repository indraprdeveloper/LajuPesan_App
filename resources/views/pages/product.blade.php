@extends('layouts.app')

@section('content')
    <div id="TopNavAbsolute"
            class="absolute top-0 left-0 right-0 flex items-center justify-between w-full px-5 py-3 z-10 bg-gradient-to-b from-black/80 to-transparent">
            <a href="javascript:history.back()"
                class="w-12 h-12 flex items-center justify-center shrink-0 rounded-full overflow-hidden bg-white/10">
                <img src="{{ asset('assets/images/icons/Arrow - Left.svg') }}" class="w-8 h-8" alt="icon">
            </a>
            <p class="font-semibold text-white">Detail Menu</p>
            <button
                class="w-12 h-12 flex items-center justify-center shrink-0 rounded-full overflow-hidden bg-white/10">
                <img src="{{ asset('assets/images/icons/Thumbs Up.svg') }}" class="w-[26px] h-[26px]" alt="">
            </button>
        </div>

        <div id="Image" class="relative w-full overflow-x-hidden -mb-[38px]">
            <img src="{{ asset('storage/' . $product->image) }}" alt="" class="w-full h-[500px] object-cover">

            <div class="absolute bottom-20 right-5 flex items-center gap-1  bg-white/10 px-[8px] py-[4px] rounded-full">
                <img src="{{ asset('assets/images/icons/ic_star.svg') }}" alt="rating" class="w-4 h-4">
                <p class="text-white text-sm">{{ $product->average_rating }}</p>
            </div>
        </div>

        <!-- details -->
        <div class="flex flex-col w-full px-5 py-5 gap-5 bg-white rounded-t-[20px] shadow-sm mt-[-20px] z-10">
            <div id="Title">
                <p class="text-[#F3AF00] font-[400] text-[12px]">
                    {{ $product->productCategory->name }}
                </p>
                <h1 class="text-[26px] font-semibold">{{ $product->name }}</h1>
                <p class="text-[#606060] font-[400] text-[14px]">
                    {{ $product->description }}
                </p>
            </div>
            <div id="Ingredients">
                <h2 class="font-[500] mb-3">Bahan-bahan</h2>
                <div class="grid grid-cols-2 gap-3">
                    @foreach ($product->productIngredients as $productIngredient)
                        <div class="flex items-center gap-2">
                            <img src="{{ asset('assets/images/icons/ic_check.svg') }}" alt="icon" class="w-5 h-5">
                            <span class="text-sm text-gray-600">{{ $productIngredient->name }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
            <div id="Reviews">
                <h2 class="font-[500] mb-3">Ulasan Pelanggan</h2>

                @if(isset($reviews) && $reviews->count() > 0)
                <div class="swiper w-full">
                    <div class="swiper-wrapper">
                        @foreach($reviews as $review)
                        <div class="swiper-slide !w-fit">
                            <div
                                class="flex flex-col gap-3 w-[320px] border border-gray-200 hover:border-[#F3AF00] hover:bg-[#FFF7F0] hover:cursor-pointer rounded-[8px] p-4">
                                <div class="flex items-center justify-between gap-3">
                                    <h3 class="text-[#353535] font-[500] text-[14px]">{{ $review->transaction->name }}</h3>

                                    <div class="flex items-center gap-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $review->rating)
                                                <img src="{{ asset('assets/images/icons/ic_star.svg') }}" alt="rating" class="w-4 h-4">
                                            @else
                                                <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>
                                </div>

                                <p class="text-[#606060] font-[400] text-[14px]">
                                    {{ $review->review ?? 'Tidak ada komentar.' }}
                                </p>
                                <p class="text-[#999] font-[400] text-[11px] mt-1">{{ $review->created_at->format('d-m-Y') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @else
                <div class="flex flex-col items-center py-6 px-4 border border-gray-200 rounded-[8px]">
                    <svg class="w-10 h-10 text-[#ddd] mb-2" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/>
                    </svg>
                    <p class="text-[#888] text-sm">Belum ada review untuk menu ini.</p>
                </div>
                @endif
            </div>
        </div>

        <div class="fixed inset-x-0 bottom-0 max-w-[640px] z-50 bg-white shadow-sm mx-auto">
            <div class="flex items-center justify-between p-[20px]">
                <div class="flex flex-col  gap-2">
                    <p class="text-[#606060] font-[400] text-[14px]">
                        Harga Menu
                    </p>
                    <p class="font-[600] text-[18px]">
                        Rp {{ number_format($product->price) }}
                    </p>
                </div>

                <button type="button"
                    class="flex justify-center items-center rounded-full px-5 py-3 bg-[#FF801A] font-medium text-white text-sm whitespace-nowrap shrink-0"
                    data-id="{{ $product->id }}" onclick="addToCart(this.dataset.id)">
                    Tambah ke Keranjang
                </button>
            </div>
        </div>
@endsection