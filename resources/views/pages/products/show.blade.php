@extends('layouts.app')

@section('title', $product->name . ' | LUXE')

@section('content')
@php 
    $totalSlides = $galleries->count() + 1; 
    // Pastikan sizes adalah array agar tidak error count()
    $productSizes = is_array($product->sizes) ? $product->sizes : (json_decode($product->sizes, true) ?? []);
@endphp

<section class="min-h-screen bg-[#f6f6f8] pt-20 pb-32">
    <div class="max-w-7xl mx-auto px-6">
        {{-- Form Utama --}}
        <form action="{{ route('checkout.payment') }}" method="POST" id="checkout-form">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="selected_color" id="input-color">
            <input type="hidden" name="selected_size" id="input-size">
            <input type="hidden" name="total_price" :value="calculateFinalTotal">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
                
                {{-- KIRI: Media & Narrative Section --}}
                <div class="lg:col-span-7 space-y-10">
                    {{-- 1. Image Slider --}}
                    <div class="relative overflow-hidden rounded-[3rem] shadow-sm bg-white border border-gray-100 group" data-aos="fade-right">
                        <div id="main-slider" class="flex transition-transform duration-700 ease-in-out">
                            <div class="min-w-full aspect-[4/5]">
                                <img src="{{ asset('products/'.$product->image) }}" class="w-full h-full object-cover">
                            </div>
                            @foreach($galleries as $gal)
                                <div class="min-w-full aspect-[4/5]">
                                    <img src="{{ asset('products/gallery/'.$gal->image) }}" class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>

                        @if($totalSlides > 1)
                        <button type="button" @click="moveSlide(-1, {{ $totalSlides }})" class="absolute left-6 top-1/2 -translate-y-1/2 w-14 h-14 bg-white/80 backdrop-blur-md rounded-full flex items-center justify-center shadow-xl opacity-0 group-hover:opacity-100 transition-all hover:bg-black hover:text-white z-20">
                            <span class="material-symbols-outlined !text-3xl">chevron_left</span>
                        </button>
                        <button type="button" @click="moveSlide(1, {{ $totalSlides }})" class="absolute right-6 top-1/2 -translate-y-1/2 w-14 h-14 bg-white/80 backdrop-blur-md rounded-full flex items-center justify-center shadow-xl opacity-0 group-hover:opacity-100 transition-all hover:bg-black hover:text-white z-20">
                            <span class="material-symbols-outlined !text-3xl">chevron_right</span>
                        </button>
                        <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex gap-2 z-20">
                            @for($i = 0; $i < $totalSlides; $i++)
                                <div class="slider-dot w-2 h-2 rounded-full bg-black/20 transition-all duration-300" :class="{'active-dot': currentSlide === {{ $i }}}"></div>
                            @endfor
                        </div>
                        @endif
                    </div>

                    {{-- 2. Deskripsi Produk --}}
                    <div class="bg-white p-10 rounded-[2.5rem] shadow-sm border border-gray-100" data-aos="fade-up">
                        <span class="text-[10px] font-black uppercase tracking-[0.4em] text-[#1754cf] mb-4 block">Product Essence</span>
                        <h3 class="text-2xl font-bold text-[#111318] mb-6 tracking-tight uppercase italic">The Narrative</h3>
                        <p class="text-gray-500 font-light leading-relaxed text-lg italic">
                            "{{ $product->detail }}"
                        </p>
                    </div>
                </div>

                {{-- KANAN: Configuration Section --}}
                <div class="lg:col-span-5">
                    <div class="sticky top-32 space-y-8">
                        <div data-aos="fade-left">
                            <span class="text-[10px] font-black uppercase tracking-[0.4em] text-[#1754cf] mb-2 block">Luxury Essentials</span>
                            <h1 class="text-4xl md:text-6xl font-bold tracking-tighter text-[#111318] mb-4 uppercase">{{ $product->name }}</h1>
                        </div>

                        {{-- SELEKSI ATRIBUT --}}
                        <div class="space-y-8" data-aos="fade-left">
                            <div id="color-picker">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-4 block">Colorway</label>
                                <div class="flex flex-wrap gap-3">
                                    @php $productColors = is_array($product->colors) ? $product->colors : (json_decode($product->colors, true) ?? []); @endphp
                                    @foreach($productColors as $color)
                                        <button type="button" @click="selectAttr($event, 'color', '{{ $color }}')" class="attr-btn px-6 py-3 border-2 border-slate-100 rounded-2xl text-[10px] font-black uppercase transition-all hover:border-black">{{ $color }}</button>
                                    @endforeach
                                </div>
                            </div>

                            <div id="size-picker">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-4 block">Tailored Sizing</label>
                                
                                {{-- PERBAIKAN LOGIKA: Cek ketersediaan ukuran --}}
                                @if(!empty($productSizes))
                                    <div class="flex flex-wrap gap-3">
                                        @foreach($productSizes as $size)
                                            <button type="button" @click="selectAttr($event, 'size', '{{ $size }}')" class="attr-btn w-14 h-14 border-2 border-slate-100 rounded-2xl text-[11px] font-black transition-all uppercase hover:border-black">{{ $size }}</button>
                                        @endforeach
                                    </div>
                                @else
                                    {{-- NOTE AMBER: Tampil jika array sizes kosong --}}
                                    <div class="p-6 bg-amber-50 border border-amber-200 rounded-[2rem] space-y-3">
                                        <div class="flex items-center gap-3 text-amber-700">
                                            <span class="material-symbols-outlined font-bold">inventory_2</span>
                                            <span class="text-xs font-black uppercase tracking-widest">Stock Alert</span>
                                        </div>
                                        <p class="text-[11px] font-bold text-amber-800 uppercase tracking-widest leading-relaxed text-left">
                                            Note: We apologize, but this masterpiece is currently <span class="text-red-600 underline">Sold Out</span>. No sizes are available for selection at this moment.
                                        </p>
                                    </div>
                                @endif

                                {{-- SIZE GUIDE --}}
                                <div class="mt-6 p-4 bg-blue-50/50 rounded-2xl border border-blue-100 flex items-center gap-4 group">
                                    <div class="w-10 h-10 bg-[#1754cf] rounded-xl flex items-center justify-center text-white shrink-0 shadow-lg">
                                        <span class="material-symbols-outlined text-xl">straighten</span>
                                    </div>
                                    <div class="flex-grow text-left">
                                        <p class="text-[10px] text-blue-900 font-bold uppercase tracking-wider leading-tight">Size Problems?</p>
                                        <a href="https://drive.google.com/drive/folders/1cwRKxM7Ns0jFwarDzjy4QZZDa_lyfzyT?usp=drive_link" target="_blank" class="text-[11px] font-black text-[#1754cf] uppercase underline decoration-2 underline-offset-4 hover:text-black transition-colors">
                                            Check Our Sizing Guide
                                        </a>
                                    </div>
                                    <span class="material-symbols-outlined text-blue-300 group-hover:translate-x-1 transition-transform">arrow_forward_ios</span>
                                </div>
                            </div>

                            {{-- QUANTITY --}}
                            <div>
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-4 block">Quantity</label>
                                <div class="flex items-center gap-4 bg-white w-fit p-2 rounded-2xl border border-slate-100 shadow-sm">
                                    <button type="button" @click="updateQty(-1)" class="w-10 h-10 flex items-center justify-center bg-slate-50 rounded-xl hover:bg-black hover:text-white transition-all text-xl font-bold" {{ empty($productSizes) ? 'disabled' : '' }}>-</button>
                                    <input type="number" name="quantity" v-model="cartQty" readonly class="w-12 text-center font-black text-lg border-none outline-none bg-transparent">
                                    <button type="button" @click="updateQty(1)" class="w-10 h-10 flex items-center justify-center bg-slate-50 rounded-xl hover:bg-black hover:text-white transition-all text-xl font-bold" {{ empty($productSizes) ? 'disabled' : '' }}>+</button>
                                </div>
                            </div>
                        </div>

                        {{-- INVESTMENT & VOUCHER --}}
                        <div class="p-8 bg-white rounded-[2.5rem] shadow-sm border border-slate-100 space-y-6" data-aos="fade-up">
                            <div class="flex justify-between items-end border-b border-dashed border-slate-200 pb-6 text-left">
                                <div>
                                    <p class="text-[10px] font-black text-slate-400 uppercase mb-1">Total Investment</p>
                                    <h3 class="text-4xl font-black text-[#111318]">
                                        IDR @{{ formatNumber(calculateFinalTotal) }}
                                    </h3>
                                    <p v-if="voucherDiscount > 0" class="text-emerald-500 text-[10px] font-bold mt-1 uppercase tracking-widest">
                                        Voucher Applied: - IDR @{{ formatNumber(voucherDiscount) }}
                                    </p>
                                </div>
                            </div>
                            <div class="relative flex gap-3">
                                <input type="text" v-model="voucherInput" name="promo_code" placeholder="PROMO CODE" class="w-full px-6 py-4 rounded-2xl bg-slate-50 border border-slate-100 font-black text-[10px] uppercase tracking-widest outline-none focus:ring-4 focus:ring-[#1754cf]/5 transition-all">
                                <button type="button" @click="applyVoucher('{{ $product->id }}')" class="bg-[#111318] text-white px-8 py-2.5 rounded-2xl text-[10px] font-black hover:bg-[#1754cf] transition-all uppercase" {{ empty($productSizes) ? 'disabled' : '' }}>Redeem</button>
                            </div>
                        </div>

                        {{-- SHIPPING FORM --}}
                        <div class="p-8 bg-white rounded-[3rem] shadow-sm border border-slate-100 space-y-6">
                            <h4 class="text-[11px] font-black uppercase tracking-[0.3em] text-slate-800 border-b pb-4 text-center">Shipping Terminal</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <input type="text" value="{{ $user->first_name }} {{ $user->last_name }}" readonly class="md:col-span-2 px-6 py-4 rounded-2xl bg-slate-100 text-slate-500 text-xs font-bold border-none outline-none cursor-not-allowed">
                                <input type="text" value="{{ $user->email }}" readonly class="md:col-span-2 px-6 py-4 rounded-2xl bg-slate-100 text-slate-500 text-xs font-bold border-none outline-none cursor-not-allowed">
                                
                                <div class="md:col-span-2">
                                    <input type="tel" name="phone_number" required placeholder="WHATSAPP NUMBER" class="w-full px-6 py-4 rounded-2xl bg-slate-50 border border-slate-100 text-xs font-bold outline-none focus:ring-4 focus:ring-[#1754cf]/5 transition-all">
                                </div>

                                <div class="md:col-span-2">
                                    <select id="country" onchange="handleCountryChange()" name="country" required class="w-full px-6 py-4 rounded-2xl bg-slate-50 text-xs font-black uppercase border-none outline-none appearance-none">
                                        <option value="">Select Country</option>
                                    </select>
                                </div>
                                
                                <select id="province" name="province" onchange="loadCities(this.value)" class="location-select px-6 py-4 rounded-2xl bg-slate-50 text-[10px] font-black uppercase border-none outline-none hidden"></select>
                                <select id="city" name="city" onchange="loadDistricts(this.value)" class="location-select px-6 py-4 rounded-2xl bg-slate-50 text-[10px] font-black uppercase border-none outline-none hidden"></select>
                                <select id="district" name="district" onchange="loadVillages(this.value)" class="location-select px-6 py-4 rounded-2xl bg-slate-50 text-[10px] font-black uppercase border-none outline-none hidden"></select>
                                <select id="subdistrict" name="subdistrict" class="location-select px-6 py-4 rounded-2xl bg-slate-50 text-[10px] font-black uppercase border-none outline-none hidden"></select>
                                
                                <div class="md:col-span-2">
                                    <input type="text" name="postal_code" required placeholder="POSTAL CODE" class="w-full px-6 py-4 rounded-2xl bg-slate-50 border border-slate-100 text-xs font-bold">
                                </div>

                                <textarea name="address_detail" required placeholder="COMPLETE ADDRESS DETAILS" class="md:col-span-2 px-6 py-4 rounded-2xl bg-slate-50 text-xs font-medium border-none outline-none" rows="3"></textarea>
                            </div>

                            {{-- TOMBOL AKSI --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-4">
                                @if(!empty($productSizes))
                                    <button type="button" @click="addToCart('{{ $product->id }}')" class="bg-white border-2 border-[#111318] text-[#111318] py-5 rounded-2xl font-black uppercase text-[10px] tracking-widest hover:bg-slate-900 hover:text-white transition-all flex items-center justify-center gap-3 active:scale-95 shadow-lg">
                                        <span class="material-symbols-outlined !text-lg">shopping_bag</span> Add To Cart
                                    </button>
                                    <button type="submit" class="bg-[#1754cf] text-white py-5 rounded-2xl font-black uppercase text-[10px] tracking-widest shadow-2xl shadow-indigo-200 hover:bg-black transition-all flex items-center justify-center gap-3 active:scale-95">
                                        <span class="material-symbols-outlined !text-lg">payments</span> Secure Pay
                                    </button>
                                @else
                                    <button type="button" disabled class="md:col-span-2 bg-gray-200 text-gray-400 py-5 rounded-2xl font-black uppercase text-[10px] tracking-widest flex items-center justify-center gap-3 cursor-not-allowed">
                                        <span class="material-symbols-outlined !text-lg">block</span> Masterpiece Sold Out
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
    /* LOGIKA AJAX & LOCATION API TETAP SAMA */
    async function addToCart(productId) {
        const color = document.getElementById('input-color').value;
        const size = document.getElementById('input-size').value;
        const qty = document.getElementsByName('quantity')[0].value;

        if (!color || !size) {
            Swal.fire({
                icon: 'warning',
                title: 'Selection Required',
                text: 'Harap pilih Warna dan Ukuran terlebih dahulu.',
                confirmButtonColor: '#1754cf',
                customClass: { popup: 'rounded-[2.5rem]' }
            });
            return;
        }

        try {
            const response = await fetch('{{ route("cart.add") }}', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                },
                body: JSON.stringify({ product_id: productId, selected_color: color, selected_size: size, quantity: qty })
            });

            const data = await response.json();
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    showCancelButton: true,
                    confirmButtonText: 'Buka Keranjang',
                    cancelButtonText: 'Lanjut Belanja',
                    confirmButtonColor: '#1754cf',
                    customClass: { popup: 'rounded-[2.5rem]' }
                }).then((result) => {
                    if (result.isConfirmed) window.location.href = '{{ route("cart.index") }}';
                });
            }
        } catch (error) {
            console.error('Cart Error:', error);
        }
    }

    /* LOCATION LOGIC */
    async function initLocation() {
        const res = await fetch('https://restcountries.com/v3.1/all?fields=name,cca2');
        const countries = await res.json();
        const el = document.getElementById('country');
        el.innerHTML = '<option value="">Select Country</option>';
        countries.sort((a,b) => a.name.common.localeCompare(b.name.common)).forEach(c => {
            el.innerHTML += `<option value="${c.cca2}">${c.name.common}</option>`;
        });
    }

    function handleCountryChange() {
        const val = document.getElementById('country').value;
        const locs = document.querySelectorAll('.location-select');
        if(val === 'ID') {
            locs.forEach(l => l.classList.remove('hidden'));
            loadProvinces();
        } else {
            locs.forEach(l => l.classList.add('hidden'));
        }
    }

    async function loadProvinces() {
        const res = await fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json');
        const data = await res.json();
        const el = document.getElementById('province');
        el.innerHTML = '<option value="">Province</option>';
        data.forEach(p => el.innerHTML += `<option value="${p.id}">${p.name}</option>`);
    }

    async function loadCities(id) {
        const res = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${id}.json`);
        const data = await res.json();
        const el = document.getElementById('city');
        el.innerHTML = '<option value="">City</option>';
        data.forEach(p => el.innerHTML += `<option value="${p.id}">${p.name}</option>`);
    }

    async function loadDistricts(id) {
        const res = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${id}.json`);
        const data = await res.json();
        const el = document.getElementById('district');
        el.innerHTML = '<option value="">District</option>';
        data.forEach(p => el.innerHTML += `<option value="${p.id}">${p.name}</option>`);
    }

    async function loadVillages(id) {
        const res = await fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${id}.json`);
        const data = await res.json();
        const el = document.getElementById('subdistrict');
        el.innerHTML = '<option value="">Sub-District</option>';
        data.forEach(p => el.innerHTML += `<option value="${p.id}">${p.name}</option>`);
    }

    document.addEventListener('DOMContentLoaded', initLocation);
</script>
@endsection