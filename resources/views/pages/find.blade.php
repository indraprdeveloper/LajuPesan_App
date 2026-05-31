@extends('layouts.app')

@section('content')
    <div id="FindMenu" class="relative flex flex-col justify-center items-center mt-12 overflow-hidden p-5">
        <div class="bg-white flex items-center justify-center w-[180px] h-[180px] rounded-full overflow-hidden border border-[#F1F2F6] shadow-sm">
            @if($store->logo)
                <img src="{{ str_starts_with($store->logo, 'assets/') ? asset($store->logo) : Storage::url($store->logo) }}" alt="{{ $store->name }} logo" class="w-full h-full object-cover">
            @else
                <img src="{{ asset('assets/images/photos/find-image.png') }}" alt="image" class="w-[150px] object-cover">
            @endif
        </div>

        <h1 class="text-[#353535] font-[600] text-[24px] mt-6">Cari dan temukan hidangan kesukaanmu!</h1>

        <form action="{{ route('product.find-result', $store->username) }}"
            class="w-full flex flex-col rounded-[8px] border border-[#F1F2F6] p-5 gap-6 bg-white mt-6">
            @csrf
            <div id="InputContainer" class="flex flex-col gap-[18px]">
                <div class="flex flex-col w-full gap-2">
                    <p class="font-semibold">Nama Menu</p>
                    <label
                        class="flex items-center w-full rounded-[8px] p-[14px_20px] gap-3 bg-white ring-1 ring-[#F3AF003D] ring-opacity-5 focus-within:ring-[#F3AF00] focus-within:ring-opacity-100 transition-all duration-300">
                        <img src="{{ asset('assets/images/icons/Document.svg') }}" class="w-5 h-5 flex shrink-0"
                            alt="icon">
                        <input type="text" name="search" id="search"
                            class="appearance-none outline-none w-full font-regular placeholder:text-ngekos-grey placeholder:font-light"
                            placeholder="Ketik nama menu...">
                    </label>
                </div>
                <div class="flex flex-col w-full gap-2">
                    <p class="font-semibold">Pilih Kategori</p>
                    <label
                        class="relative flex items-center w-full rounded-[8px] p-[14px_20px] gap-2 bg-white ring-1 ring-[#F3AF003D] ring-opacity-5 focus-within:ring-[#F3AF00] focus-within:ring-opacity-100 transition-all duration-300">
                        <img src="{{ asset('assets/images/icons/Discovery.svg') }}"
                            class="absolute w-5 h-5 flex shrink-0 transform -translate-y-1/2 top-1/2 left-5" alt="icon">
                        <select name="category" id="" class="appearance-none outline-none w-full bg-white pl-8">
                            <option value="" hidden>Pilih kategori</option>
                            @foreach ($store->productCategories as $category)
                                <option value="{{ $category->slug }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        <img src="{{ asset('assets/images/icons/Arrow - Down 2.svg') }}" class="w-3 h-3" alt="icon">
                    </label>
                </div>
                <button type="submit"
                    class="flex w-full justify-center rounded-full p-[14px_20px] bg-[#FF801A] font-bold text-white">Cari
                    Sekarang</button>
            </div>
        </form>
    </div>

    @include('includes.navigation')
@endsection
