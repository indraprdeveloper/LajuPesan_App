@extends('layouts.app')

@section('content')
    {{-- Header --}}
    <div class="absolute top-0 w-full h-[170px] rounded-b-[45px] bg-[linear-gradient(90deg,#FF923C_0%,#FF801A_100%)]">
    </div>

    <div class="relative flex flex-col px-5 mt-[20px]">
        {{-- Top Nav --}}
        <div class="relative flex items-center justify-between mb-4">
            <a href="{{ route('index', $store->username) }}"
                class="w-10 h-10 flex items-center justify-center rounded-full bg-white/20 backdrop-blur-sm">
                <img src="{{ asset('assets/images/icons/Arrow - Left.svg') }}" class="w-6 h-6" alt="back">
            </a>
            <p class="text-white font-semibold text-lg">Rating Pesanan</p>
            <div class="w-10 h-10"></div>
        </div>

        {{-- Order Info Card --}}
        <div class="bg-white rounded-[16px] p-4 shadow-sm mt-[60px]">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-[#888] text-xs uppercase tracking-wider">Kode Pesanan</p>
                    <p class="text-[#353535] font-semibold text-lg mt-1">{{ $transaction->code }}</p>
                </div>
                <div class="px-3 py-1 rounded-full bg-green-50 text-green-700 text-xs font-semibold">
                    ✅ Berhasil
                </div>
            </div>
        </div>

        {{-- Rating Form --}}
        <form action="{{ route('rating.submit', ['username' => $store->username, 'transaction_code' => $transaction->code]) }}" method="POST">
            @csrf

            <div class="mt-5 space-y-4">
                <p class="text-[#353535] font-semibold text-base">Beri Rating untuk Setiap Menu</p>

                @foreach($transaction->transactionDetails as $detail)
                <div class="bg-white rounded-[16px] p-4 shadow-sm">
                    {{-- Product Info --}}
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-[40px] h-[40px] rounded-[8px] overflow-hidden bg-gray-100 shrink-0">
                            <img src="{{ asset('storage/' . $detail->product->image) }}" class="w-[40px] h-[40px] object-cover" alt="{{ $detail->product->name }}">
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-[#F3AF00] text-[10px]">{{ $detail->product->productCategory->name }}</p>
                            <h3 class="text-[#353535] font-semibold text-[13px] truncate">{{ $detail->product->name }}</h3>
                            <p class="text-[#888] text-[10px]">x{{ $detail->quantity }}</p>
                        </div>
                    </div>

                    {{-- Star Rating --}}
                    <div class="mb-3">
                        <p class="text-[#888] text-xs font-medium mb-2">Rating Bintang</p>
                        <div class="flex items-center gap-1" id="star-group-{{ $detail->product->id }}">
                            @for($i = 1; $i <= 5; $i++)
                            <button type="button" onclick="setRating({{ $detail->product->id }}, {{ $i }})"
                                class="star-btn w-10 h-10 flex items-center justify-center rounded-full transition-all duration-200 hover:scale-110"
                                data-product="{{ $detail->product->id }}" data-value="{{ $i }}" id="star-{{ $detail->product->id }}-{{ $i }}">
                                <svg class="w-7 h-7" fill="#E5E7EB" stroke="#E5E7EB" stroke-width="0.5" viewBox="0 0 24 24">
                                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                                </svg>
                            </button>
                            @endfor
                        </div>
                        <input type="hidden" name="ratings[{{ $detail->product->id }}]" id="rating-input-{{ $detail->product->id }}" value="0" required>
                    </div>

                    {{-- Review Text --}}
                    <div>
                        <p class="text-[#888] text-xs font-medium mb-2">Kritik & Saran (opsional)</p>
                        <textarea name="reviews[{{ $detail->product->id }}]" rows="2"
                            class="w-full rounded-[12px] border border-[#F1F2F6] p-3 text-sm text-[#353535] placeholder:text-[#ccc] focus:border-[#F97316] focus:ring-1 focus:ring-[#F97316] outline-none transition-all resize-none"
                            placeholder="Tulis kritik atau saran Anda..."></textarea>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Submit Button --}}
            <div class="mt-6 mb-8">
                <button type="submit" id="submit-rating-btn"
                    class="w-full flex items-center justify-center gap-3 py-4 px-5 rounded-full bg-gradient-to-r from-[#FF923C] to-[#F97316] text-black font-semibold text-sm shadow-md hover:shadow-lg transform hover:scale-[1.02] transition-all duration-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                        <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                    </svg>
                    Kirim Rating
                </button>
            </div>
        </form>
    </div>
@endsection

@section('script')
<script>
    function setRating(productId, value) {
        // Update hidden input
        document.getElementById('rating-input-' + productId).value = value;

        // Update star visuals
        for (let i = 1; i <= 5; i++) {
            const star = document.getElementById('star-' + productId + '-' + i);
            const svg = star.querySelector('svg');

            if (i <= value) {
                svg.setAttribute('fill', '#F97316');
                svg.setAttribute('stroke', '#F97316');
                star.classList.add('scale-110');
            } else {
                svg.setAttribute('fill', '#E5E7EB');
                svg.setAttribute('stroke', '#E5E7EB');
                star.classList.remove('scale-110');
            }
        }
    }

    // Validasi sebelum submit
    document.getElementById('submit-rating-btn')?.closest('form')?.addEventListener('submit', function(e) {
        const hiddenInputs = this.querySelectorAll('input[type="hidden"][name^="ratings"]');
        let allRated = true;

        hiddenInputs.forEach(input => {
            if (input.value === '0') {
                allRated = false;
            }
        });

        if (!allRated) {
            e.preventDefault();
            alert('Mohon beri rating bintang untuk semua menu!');
        }
    });
</script>
@endsection
