@extends('layouts.app')

@section('title', $title . ' | LUXE')

@section('content')
<section class="min-h-screen bg-[#f6f6f8] pt-10 pb-24">
    <div class="max-w-7xl mx-auto px-6">
        
        {{-- HEADER SECTION --}}
        <div class="mb-10 text-center md:text-left" data-aos="fade-up">
            <span class="text-[9px] uppercase tracking-[0.4em] font-black text-[#1754cf] mb-3 block">Collection Filter</span>
            <h2 class="text-3xl md:text-5xl font-light tracking-tighter text-[#111318]">
                Explore <span class="italic font-extrabold">"{{ $title }}"</span>
            </h2>
            <p class="text-slate-400 font-medium italic text-sm mt-4">{{ $description }}</p>
        </div>

        @if($products->isEmpty())
            {{-- EMPTY STATE --}}
            <div class="flex flex-col items-center justify-center py-20 text-center" data-aos="zoom-in">
                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center mb-6 shadow-sm">
                    <span class="material-symbols-outlined text-gray-300 text-3xl">inventory_2</span>
                </div>
                <h4 class="text-xl font-bold text-[#111318] mb-2">Vault is empty</h4>
                <p class="text-gray-500 max-w-xs mx-auto mb-8 font-light text-sm italic">No items currently match this filter criteria. Check back soon for new arrivals.</p>
                <a href="{{ route('home') }}" class="bg-[#111318] text-white px-10 py-4 rounded-full text-[10px] font-black tracking-widest uppercase hover:bg-[#1754cf] transition-all">
                    Explore Home
                </a>
            </div>
        @else
            {{-- PRODUCT GRID --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-16">
                @foreach($products as $product)
                <div class="group cursor-pointer" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 50 }}">
                    
                    {{-- IMAGE CONTAINER: SLIDESHOW & HOVER ZOOM --}}
                    <div class="relative aspect-[3/4] rounded-2xl overflow-hidden mb-6 bg-gray-100 shadow-sm product-card-slideshow" @click="checkLogin({{ $product->id }})">
                        
                        {{-- Master Thumbnail --}}
                        <img src="{{ asset('products/' . $product->image) }}" 
                             class="absolute inset-0 w-full h-full object-cover transition-all duration-1000 opacity-100 group-hover:scale-110 active-slide"
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
                            <div class="absolute top-4 left-4 bg-[#111318] text-white px-3 py-1 text-[8px] font-black uppercase tracking-tighter rounded shadow-lg z-10">
                                -{{ round((($product->original_price - $product->promo_price) / $product->original_price) * 100) }}% OFF
                            </div>
                        @endif

                        @if($product->voucher_code)
                            <div class="absolute top-4 right-4 bg-[#1754cf] text-white p-1.5 rounded-full shadow-lg z-10 flex items-center justify-center">
                                <span class="material-symbols-outlined text-[14px]">confirmation_number</span>
                            </div>
                        @endif
                    </div>
                    
                    {{-- INFO SECTION --}}
                    <div class="px-1">
                        <div class="flex justify-between items-start mb-4">
                            <div class="max-w-[70%] text-left">
                                <h4 class="font-bold text-base mb-1 group-hover:text-[#1754cf] transition-colors tracking-tight truncate uppercase leading-none">{{ $product->name }}</h4>
                                <p class="text-[9px] text-[#1754cf] uppercase tracking-[0.2em] font-black leading-none">
                                    @php $cats = json_decode($product->category); @endphp
                                    {{ $cats[0] ?? 'Luxe Edition' }}
                                </p>
                            </div>
                            <div class="text-right">
                                @if($product->promo_price)
                                    <p class="text-[9px] text-gray-400 line-through font-bold italic">IDR {{ number_format($product->original_price, 0, ',', '.') }}</p>
                                    <p class="font-bold text-[#111318] text-base leading-none">IDR {{ number_format($product->promo_price, 0, ',', '.') }}</p>
                                @else
                                    <p class="font-bold text-[#111318] text-base leading-none">IDR {{ number_format($product->original_price, 0, ',', '.') }}</p>
                                @endif
                            </div>
                        </div>

                        {{-- Fitur Salin Voucher --}}
                        @if($product->voucher_code)
                            <div onclick="copyVoucher('{{ $product->voucher_code }}')" 
                                 class="p-4 bg-white rounded-2xl border border-gray-100 flex items-center justify-between cursor-pointer hover:border-[#1754cf]/30 hover:shadow-md transition-all group/voucher">
                                <div class="text-left">
                                    <p class="text-[8px] font-black text-[#1754cf] uppercase tracking-widest leading-none mb-1">Claim Code</p>
                                    <p class="text-xs font-black text-[#111318] tracking-[0.2em] uppercase leading-none">{{ $product->voucher_code }}</p>
                                </div>
                                <div class="w-8 h-8 bg-[#f0f7ff] rounded-full flex items-center justify-center group-hover/voucher:bg-[#1754cf] transition-colors">
                                    <span class="material-symbols-outlined text-[14px] text-[#1754cf] group-hover/voucher:text-white">content_copy</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<style>
    /* UI Refinements */
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    
    .product-card-slideshow img {
        transition: opacity 1s ease-in-out, transform 1.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
    }
</style>

{{-- SCRIPT SALIN VOUCHER --}}
<script>
    function copyVoucher(code) {
        navigator.clipboard.writeText(code).then(() => {
            Swal.fire({
                icon: 'success',
                title: 'CODE SECURED',
                text: 'Voucher ' + code + ' has been copied to clipboard.',
                showConfirmButton: false,
                timer: 1800,
                background: '#ffffff',
                color: '#111318',
                customClass: {
                    popup: 'rounded-[2.5rem] border border-slate-100 shadow-2xl',
                    title: 'font-black tracking-tighter uppercase',
                    htmlContainer: 'font-medium italic text-slate-400'
                }
            });
        }).catch(err => {
            console.error('Copy failed', err);
        });
    }
</script>
@endsection