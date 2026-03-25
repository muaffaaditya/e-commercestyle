@extends('layouts.app')

@section('title', 'Collections | LUXE')

@section('content')
<section class="min-h-screen bg-[#f6f6f8] pt-10 pb-24">
    <div class="max-w-7xl mx-auto px-6">
        
        {{-- HEADER SECTION --}}
        <div class="mb-10 text-center md:text-left" data-aos="fade-up">
            <span class="text-[9px] uppercase tracking-[0.4em] font-black text-[#1754cf] mb-3 block">Curated Marketplace</span>
            <h2 class="text-3xl md:text-5xl font-light tracking-tighter text-[#111318]">
                {{ $query ? 'Results for: ' : 'Explore ' }}<span class="italic font-extrabold">"{{ $query ?? 'All Collections' }}"</span>
            </h2>
        </div>

        {{-- KATEGORI FILTER (Minimalist & Aesthetic Pills) --}}
        <div class="mb-16 overflow-x-auto no-scrollbar" data-aos="fade-up" data-aos-delay="100">
            <div class="flex md:flex-wrap items-center justify-start md:justify-center gap-3 pb-4">
                {{-- Opsi All Collections --}}
                <a href="{{ route('products.search', ['q' => '']) }}" 
                   class="flex-none px-8 py-3 rounded-full border transition-all active:scale-95 text-[10px] font-black tracking-widest
                   {{ empty($query) ? 'bg-[#111318] text-white border-[#111318] shadow-lg' : 'bg-white text-slate-400 border-slate-100 hover:border-[#1754cf] hover:text-[#1754cf]' }}">
                    ALL COLLECTIONS
                </a>

                @foreach(['MEN', 'WOMEN', 'UNISEX', 'ACCESSORIES', 'NEW ARRIVAL', 'SPECIAL EDITION'] as $cat)
                    @php $isActive = strtoupper($query) == $cat; @endphp
                    <a href="{{ route('products.search', ['q' => $cat]) }}" 
                       class="flex-none px-8 py-3 rounded-full border transition-all active:scale-95 text-[10px] font-black tracking-widest
                       {{ $isActive ? 'bg-[#1754cf] text-white border-[#1754cf] shadow-lg' : 'bg-white text-slate-400 border-slate-100 hover:border-[#1754cf] hover:text-[#1754cf]' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>
        </div>

        @if($products->isEmpty())
            {{-- EMPTY STATE --}}
            <div class="flex flex-col items-center justify-center py-20 text-center" data-aos="zoom-in">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mb-6 shadow-sm">
                    <span class="material-symbols-outlined text-gray-300 text-3xl">inventory_2</span>
                </div>
                <h4 class="text-xl font-bold text-[#111318] mb-2">No items found</h4>
                <p class="text-gray-500 max-w-xs mx-auto mb-8 font-light text-sm">We couldn't find any products in this segment. Explore our other premium collections.</p>
                <a href="{{ route('products.search', ['q' => '']) }}" class="bg-[#111318] text-white px-10 py-4 rounded-full text-[10px] font-black tracking-widest uppercase hover:bg-[#1754cf] transition-all">
                    Reset Filter
                </a>
            </div>
        @else
            {{-- PRODUCT GRID --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-16">
                @foreach($products as $product)
                <div class="group cursor-pointer" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 50 }}" @click="checkLogin({{ $product->id }})">
                    
                    {{-- IMAGE CONTAINER: SLIDESHOW & HOVER ZOOM --}}
                    <div class="relative aspect-[3/4] rounded-2xl overflow-hidden mb-6 bg-gray-100 shadow-sm product-card-slideshow">
                        
                        {{-- Master Thumbnail --}}
                        <img src="{{ asset('products/' . $product->image) }}" 
                             class="absolute inset-0 w-full h-full object-cover transition-all duration-1000 opacity-100 group-hover:scale-110 active-slide"
                             onerror="this.src='https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=1000'"
                             alt="{{ $product->name }}">
                        
                        {{-- Gallery Slides --}}
                        @php
                            $galleries = DB::table('product_galleries')->where('product_id', $product->id)->get();
                        @endphp
                        @foreach($galleries as $gallery)
                            <img src="{{ asset('products/gallery/' . $gallery->image) }}" 
                                 class="absolute inset-0 w-full h-full object-cover transition-all duration-1000 opacity-0 group-hover:scale-110"
                                 alt="{{ $product->name }}">
                        @endforeach
                        
                        {{-- LABEL DISKON --}}
                        @if($product->promo_price)
                            <div class="absolute top-4 left-4 bg-[#1754cf] text-white px-3 py-1 text-[8px] font-black uppercase tracking-tighter rounded shadow-lg z-10">
                                -{{ $product->discount_percent }}% OFF
                            </div>
                        @endif
                    </div>
                    
                    {{-- INFO SECTION --}}
                    <div class="flex justify-between items-start px-1">
                        <div class="max-w-[70%]">
                            <h4 class="font-bold text-base mb-1 group-hover:text-[#1754cf] transition-colors tracking-tight truncate uppercase">{{ $product->name }}</h4>
                            <p class="text-[9px] text-[#1754cf] uppercase tracking-[0.2em] font-black">
                                @php $cats = json_decode($product->category); @endphp
                                {{ $cats[0] ?? 'Luxe Edition' }}
                            </p>
                        </div>
                        <div class="text-right">
                            @if($product->promo_price)
                                <p class="text-[9px] text-gray-400 line-through font-bold italic">IDR {{ number_format($product->original_price, 0, ',', '.') }}</p>
                                <p class="font-bold text-[#111318] text-base">IDR {{ number_format($product->promo_price, 0, ',', '.') }}</p>
                            @else
                                <p class="font-bold text-[#111318] text-base">IDR {{ number_format($product->original_price, 0, ',', '.') }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<style>
    /* Menghilangkan scrollbar tapi tetap bisa di-scroll pada mobile */
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    
    /* Perhalus transisi slideshow */
    .product-card-slideshow img {
        transition: opacity 1s ease-in-out, transform 1.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
</style>
@endsection