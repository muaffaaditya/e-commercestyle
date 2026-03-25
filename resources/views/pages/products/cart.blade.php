@extends('layouts.app')

@section('title', 'Shopping Bag | LUXE')

@section('content')
{{-- pt-10 membuat halaman naik ke atas mendekati navbar --}}
<section class="min-h-screen bg-[#f6f6f8] pt-10 pb-32">
    <div class="max-w-5xl mx-auto px-4 md:px-6">
        
        {{-- Header Section --}}
        <div class="mb-10" data-aos="fade-right">
            <span class="text-[9px] font-black uppercase tracking-[0.4em] text-[#1754cf] mb-1 block">Your Selection</span>
            <h2 class="text-4xl md:text-5xl font-extrabold tracking-tighter text-[#111318] uppercase text-left leading-none">Shopping Bag</h2>
            <p class="text-slate-400 font-bold text-[10px] md:text-xs tracking-[0.2em] mt-2 uppercase">{{ $cartItems->count() }} ITEMS IN BAG</p>
        </div>

        @if($cartItems->isEmpty())
            <div class="bg-white rounded-[2.5rem] p-16 text-center shadow-sm border border-gray-50" data-aos="zoom-in">
                <h3 class="text-xl font-bold mb-4 uppercase text-[#111318]">Your bag is empty</h3>
                <a href="{{ route('home') }}" class="inline-block bg-[#111318] text-white px-10 py-4 rounded-2xl font-black text-[10px] tracking-[0.3em] uppercase transition-all">Explore Collections</a>
            </div>
        @else
            {{-- NOTE: Instruksi --}}
            <div class="mb-8 p-6 bg-blue-50 border border-blue-100 rounded-[2rem] flex items-center gap-4" data-aos="fade-down">
                <span class="material-symbols-outlined text-[#1754cf] text-3xl">info</span>
                <p class="text-[11px] font-bold text-blue-900 uppercase tracking-widest leading-relaxed">
                    Luxurious Note: To process your masterpiece, please <span class="text-[#1754cf] underline decoration-2 underline-offset-4">click on the product image</span> to enter the secure payment terminal.
                </p>
            </div>

            <div class="grid grid-cols-1 gap-6">
                @foreach($cartItems as $item)
                @php 
                    $hasPromo = !is_null($item->promo_price);
                    $basePrice = $item->original_price;
                    $displayPrice = $hasPromo ? $item->promo_price : $item->original_price;
                @endphp
                {{-- Card Produk Utama --}}
                <div class="bg-white rounded-[2.5rem] md:rounded-[3.5rem] p-6 md:p-10 shadow-sm border border-slate-50 flex flex-col md:flex-row items-center gap-8 md:gap-12 group relative" data-aos="fade-up">
                    
                    {{-- Gambar Produk (Klik untuk ke Halaman Show) --}}
                    <a href="{{ route('products.show', $item->product_id) }}" class="w-full md:w-40 h-52 md:h-52 overflow-hidden rounded-[2rem] md:rounded-[2.5rem] shrink-0 shadow-sm relative block">
                        <img src="{{ asset('products/'.$item->image) }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <span class="text-white font-black text-[8px] tracking-widest uppercase bg-[#1754cf] px-4 py-2 rounded-full">Secure Terminal</span>
                        </div>
                    </a>
                    
                    {{-- Detail Produk --}}
                    <div class="flex-grow flex flex-col items-start text-left w-full">
                        <a href="{{ route('products.show', $item->product_id) }}" class="w-full">
                            <h4 class="text-2xl md:text-3xl font-black text-[#111318] uppercase mb-4 tracking-tighter hover:text-[#1754cf] transition-colors leading-tight">
                                {{ $item->name }}
                            </h4>
                        </a>
                        
                        <div class="flex flex-wrap gap-2 mb-6">
                            <span class="text-[9px] font-black bg-slate-50 border border-slate-100 px-4 py-2 rounded-xl uppercase tracking-widest text-slate-400">SIZE: <span class="text-[#111318]">{{ $item->size }}</span></span>
                            <span class="text-[9px] font-black bg-slate-50 border border-slate-100 px-4 py-2 rounded-xl uppercase tracking-widest text-slate-400">COLOR: <span class="text-[#111318]">{{ $item->color }}</span></span>
                        </div>

                        <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6 md:gap-10 w-full">
                            {{-- Section Harga --}}
                            <div class="min-w-fit text-left">
                                @if($hasPromo)
                                    <p class="text-[11px] text-gray-300 line-through font-bold italic mb-0.5">
                                        IDR {{ number_format($basePrice * $item->quantity, 0, ',', '.') }}
                                    </p>
                                @endif
                                <p class="font-black text-3xl md:text-4xl text-[#111318] tracking-tighter leading-none text-left">
                                    IDR {{ number_format($displayPrice * $item->quantity, 0, ',', '.') }}
                                </p>
                            </div>
                            
                            {{-- Fitur Ubah Jumlah --}}
                            <div class="flex items-center bg-slate-50 rounded-2xl p-1 border border-slate-100 shadow-inner">
                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center">
                                    @csrf @method('PATCH')
                                    <button name="quantity" value="{{ $item->quantity - 1 }}" 
                                            {{ $item->quantity <= 1 ? 'disabled' : '' }} 
                                            class="w-9 h-9 md:w-11 md:h-11 flex items-center justify-center bg-white rounded-xl shadow-sm hover:bg-black hover:text-white transition-all font-bold disabled:opacity-30">-</button>
                                    
                                    <span class="px-5 font-black text-xs md:text-sm text-[#111318] uppercase tracking-widest">QTY: {{ $item->quantity }}</span>
                                    
                                    <button name="quantity" value="{{ $item->quantity + 1 }}" 
                                            class="w-9 h-9 md:w-11 md:h-11 flex items-center justify-center bg-white rounded-xl shadow-sm hover:bg-black hover:text-white transition-all font-bold">+</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Hapus --}}
                    <div class="absolute top-6 right-6 md:static md:shrink-0">
                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="button" onclick="confirmDelete(this)" class="w-12 h-12 md:w-16 md:h-16 rounded-full bg-red-50 text-red-400 hover:bg-red-500 hover:text-white transition-all flex items-center justify-center shadow-sm active:scale-90">
                                <span class="material-symbols-outlined text-2xl md:text-3xl">delete_sweep</span>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach

                {{-- Footer Summary --}}
                <div class="mt-10 bg-[#111318] text-white p-10 md:p-14 rounded-[3.5rem] md:rounded-[4.5rem] shadow-2xl flex flex-col lg:flex-row justify-between items-center gap-8 text-left" data-aos="fade-up">
                    <div class="text-left w-full">
                        <p class="text-[9px] md:text-[10px] font-black uppercase tracking-[0.5em] text-slate-500 mb-2">Grand Total Investment</p>
                        <h3 class="text-4xl md:text-6xl font-black tracking-tighter text-left">
                            IDR {{ number_format($cartItems->sum(fn($i) => ($i->promo_price ?? $i->original_price) * $i->quantity), 0, ',', '.') }}
                        </h3>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4 w-full lg:w-auto">
                        <a href="{{ route('home') }}" class="px-10 py-5 rounded-2xl font-black text-[10px] tracking-[0.2em] uppercase border border-slate-700 hover:bg-white hover:text-black transition-all text-center">Keep Browsing</a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</section>

<script>
    function confirmDelete(button) {
        Swal.fire({
            title: 'Remove Item?',
            text: "Are you sure you want to remove this masterpiece from your bag?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#111318',
            cancelButtonColor: '#f1f5f9',
            confirmButtonText: 'YES, REMOVE IT',
            cancelButtonText: 'KEEP IT',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-[2.5rem]',
                confirmButton: 'rounded-xl font-black text-[10px] px-8 py-4',
                cancelButton: 'rounded-xl font-black text-[10px] px-8 py-4 text-slate-500'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        })
    }
</script>
@endsection