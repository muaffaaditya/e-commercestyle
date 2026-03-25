@extends('layouts.app')

@section('title', 'LUXE | Premium Fashion for Men & Women')

@section('content')

{{-- INTEGRASI DATABASE: Mengambil data pengaturan Home --}}
@php
    // Mengambil data dari tabel home_settings dan mengubahnya menjadi array
    $hero = \Illuminate\Support\Facades\DB::table('home_settings')->pluck('value', 'key_name')->toArray();

    // Definisi variabel dengan nilai fallback yang sudah disesuaikan ke tema Fashion
    $subtitle    = $hero['hero_subtitle'] ?? 'Autumn / Winter Collection 2026';
    $titleTop    = $hero['hero_title_top'] ?? 'Define Your';
    $titleBottom = $hero['hero_title_bottom'] ?? 'Signature Style';
    $description = $hero['hero_description'] ?? 'Discover our curated selection of high-end apparel designed for the modern individual who values elegance and comfort.';
    $imageName   = $hero['hero_image'] ?? null;

    // Logika URL Gambar
    $imageUrl = ($imageName && file_exists(public_path('gambar/' . $imageName))) 
                ? asset('gambar/' . $imageName) 
                : 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=1200';
@endphp

{{-- SECTION HERO (DYNAMIC) --}}
<section id="hero" class="relative min-h-[90vh] md:h-[90vh] flex items-center bg-[#FDFBF7] overflow-hidden">
    <div class="absolute inset-0 md:relative md:flex md:flex-row w-full h-full">
        
        <div class="relative z-20 flex-1 flex items-center justify-center h-full">
            <div data-aos="fade-up" class="max-w-full md:max-w-[800px] w-full text-center bg-white/40 md:bg-transparent backdrop-blur-lg md:backdrop-blur-none p-8 md:p-0 h-full md:h-auto flex flex-col justify-center">
                
                {{-- Subtitle Dinamis --}}
                <span class="text-[10px] md:text-xs uppercase tracking-[0.3em] font-black text-[#1754cf] mb-3 md:mb-6 block italic">
                    {{ $subtitle }}
                </span>
                
                {{-- Judul Dinamis --}}
                <h2 class="text-5xl md:text-7xl lg:text-8xl font-light tracking-tight leading-[1.1] mb-4 md:mb-8 text-[#111318]">
                    {{ $titleTop }} <br/> 
                    <span class="font-extrabold italic">{{ $titleBottom }}</span>
                </h2>
                
                {{-- Deskripsi Dinamis --}}
                <p class="text-sm md:text-lg text-gray-700 md:text-gray-500 max-w-xs md:max-w-md mb-8 md:mb-10 mx-auto font-light leading-relaxed">
                    {{ $description }}
                </p>
                
                <div class="flex flex-col sm:flex-row gap-3 justify-center px-6 md:px-0">
                    <a href="{{ route('products.search', ['q' => '']) }}" 
                       class="bg-[#1754cf] text-white px-8 md:px-10 py-4 md:py-4 rounded-full text-[10px] md:text-sm font-bold tracking-wide hover:bg-[#1754cf]/90 transition-all shadow-lg shadow-[#1754cf]/20 text-center flex items-center justify-center no-underline">
                        EXPLORE THE LOOK
                    </a>

                    <a href="#new-in" 
                       class="border border-[#111318] px-8 md:px-10 py-4 md:py-4 rounded-full text-[10px] md:text-sm font-bold tracking-wide hover:bg-[#111318] hover:text-white transition-all text-center flex items-center justify-center no-underline">
                        COMPLETE PRODUCT
                    </a>
                </div>

                <div class="mt-12 hidden md:flex justify-center items-center opacity-30 grayscale text-[10px] font-bold uppercase tracking-widest gap-12 text-[#111318]">
                    <span>Vogue Magazine</span>
                    <span>Hypebeast Daily</span>
                    <span>Elle Fashion</span>
                </div>
            </div>
        </div>

        <div class="absolute inset-0 md:relative md:flex-1 h-full w-full z-10">
            <img data-aos="fade-left" data-aos-duration="1500" 
                 src="{{ $imageUrl }}" 
                 class="w-full h-full object-cover object-center md:object-left transition-all duration-700" 
                 alt="Hero Image LUXE Premium Fashion">
            
            <div class="absolute inset-0 bg-white/20 md:hidden"></div>
        </div>
    </div>
</section>

{{-- SECTION NEW ARRIVALS --}}
<section id="new-in" class="max-w-7xl mx-auto px-6 py-24">
    <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-4 text-center md:text-left" data-aos="fade-up">
        <div class="w-full md:w-auto">
            <h3 class="text-4xl font-bold mb-4 tracking-tighter text-[#111318]">Our Newest Product</h3>
            <p class="text-gray-500 max-w-md mx-auto md:mx-0 text-sm">Fresh drops from our latest runway collection. Only showing our top 8 newest essentials.</p>
        </div>
    </div>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-16">
        @forelse($newArrivals as $product)
            <div class="group cursor-pointer" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}" @click="checkLogin({{ $product->id }})">
                
                {{-- Container Gambar: Slideshow & Hover Zoom --}}
                <div class="relative aspect-[3/4] rounded-2xl overflow-hidden mb-6 bg-gray-100 shadow-sm product-card-slideshow">
                    
                    {{-- Gambar Utama --}}
                    <img src="{{ asset('products/' . $product->image) }}" 
                         onerror="this.src='https://images.unsplash.com/photo-1515886657613-9f3515b0c78f?q=80&w=1000'"
                         class="absolute inset-0 w-full h-full object-cover transition-all duration-1000 opacity-100 group-hover:scale-110 active-slide"
                         alt="{{ $product->name }}">
                    
                    {{-- Gambar Galeri (Slideshow Otomatis) --}}
                    @php
                        $galleries = DB::table('product_galleries')->where('product_id', $product->id)->get();
                    @endphp
                    @foreach($galleries as $gallery)
                        <img src="{{ asset('products/gallery/' . $gallery->image) }}" 
                             class="absolute inset-0 w-full h-full object-cover transition-all duration-1000 opacity-0 group-hover:scale-110"
                             alt="{{ $product->name }}">
                    @endforeach
                    
                    {{-- Badges --}}
                    @if($product->promo_price)
                        <div class="absolute top-4 left-4 bg-[#1754cf] text-white px-3 py-1 text-[9px] font-black uppercase tracking-tighter rounded z-10 shadow-lg">On Sale</div>
                    @else
                        <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-sm px-3 py-1 text-[9px] font-black uppercase tracking-tighter rounded z-10 shadow-sm border border-gray-100">New Arrival</div>
                    @endif
                </div>

                <div class="flex justify-between items-start px-2">
                    <div class="text-left">
                        <h4 class="font-bold text-lg mb-1 group-hover:text-[#1754cf] transition-colors tracking-tight uppercase">{{ $product->name }}</h4>
                        <p class="text-[10px] text-gray-400 uppercase tracking-widest font-black text-left">
                            @php $cats = json_decode($product->category); @endphp
                            {{ $cats[0] ?? 'Luxe Collection' }}
                        </p>
                    </div>
                    <div class="text-right">
                        @if($product->promo_price)
                            <p class="text-[9px] text-gray-400 line-through font-bold italic">IDR {{ number_format($product->original_price, 0, ',', '.') }}</p>
                            <p class="font-bold text-[#1754cf] text-lg">IDR {{ number_format($product->promo_price, 0, ',', '.') }}</p>
                        @else
                            <p class="font-bold text-[#111318] text-lg">IDR {{ number_format($product->original_price, 0, ',', '.') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full py-20 text-center" data-aos="zoom-in">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-50 rounded-full mb-6">
                    <span class="material-symbols-outlined text-gray-300 text-4xl">styler</span>
                </div>
                <h4 class="text-xl font-bold text-[#111318] mb-2">The collection is coming soon</h4>
                <p class="text-gray-400 font-light max-w-sm mx-auto">Stay tuned for our exclusive fashion drops that will redefine your aesthetics.</p>
            </div>
        @endforelse
    </div>
</section>

{{-- SECTION COLLECTION --}}
<section id="collection" class="max-w-7xl mx-auto px-6 mb-24">
    <div data-aos="zoom-in" class="relative rounded-[2.5rem] overflow-hidden bg-[#111621] text-white p-12 md:p-32 text-center shadow-2xl">
        {{-- Background Effect --}}
        <div class="absolute inset-0 bg-gradient-to-tr from-[#1754cf]/30 to-transparent"></div>
        
        <div class="relative z-10">
            <h3 class="text-4xl md:text-6xl font-extrabold mb-8 tracking-tighter uppercase">Limited Product Collection</h3>
            <p class="text-base md:text-xl text-gray-400 mb-12 font-light max-w-2xl mx-auto leading-relaxed px-4 italic">
                Experience the essence of high-fashion craftsmanship. Our seasonal collection brings global trends and artisanal quality straight to your closet.
            </p>
            
            <a href="{{ route('products.search', ['q' => '']) }}" class="inline-block no-underline">
                <button class="bg-[#1754cf] text-white px-14 py-5 rounded-full font-black hover:scale-110 active:scale-95 transition-all shadow-2xl shadow-[#1754cf]/40 uppercase tracking-[0.3em] text-[10px]">
                    Explore the Runway
                </button>
            </a>
        </div>
    </div>
</section>

{{-- SECTION SALE --}}
<section id="sale" class="bg-white py-32 border-t border-gray-50 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 text-center mb-16" data-aos="fade-down">
        <span class="text-[#1754cf] font-black tracking-[0.3em] text-[10px] uppercase block mb-4">Limited Time Offers</span>
        <h3 class="text-4xl md:text-5xl font-bold tracking-tighter text-[#111318]">Seasonal Promotions</h3>
    </div>
    
    <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-8 md:gap-12">
        <div data-aos="fade-right" class="bg-[#f6f6f8] p-10 md:p-14 rounded-[2.5rem] flex flex-col sm:flex-row justify-between items-center group shadow-sm">
            <div class="text-center sm:text-left mb-8 sm:mb-0">
                <span class="text-[#1754cf] font-black text-xs tracking-widest uppercase">get promotions</span>
                <h4 class="text-3xl font-bold mt-4 mb-8 tracking-tight">get a discount<br class="hidden sm:block">of 5% to 20%</h4>
                <a href="{{ route('products.deals') }}" class="inline-block bg-[#111318] text-white px-8 py-4 rounded-full text-[10px] font-black tracking-widest uppercase hover:bg-[#1754cf] transition-all no-underline">
                    Shop Deals
                </a>
            </div>
            <div class="w-40 h-40 bg-white rounded-full flex items-center justify-center shadow-2xl group-hover:rotate-12 transition-transform duration-500">
                <span class="text-4xl font-black text-[#1754cf]">PIECE</span>
            </div>
        </div>

        <div data-aos="fade-left" class="bg-[#111318] p-10 md:p-14 rounded-[2.5rem] flex flex-col sm:flex-row justify-between items-center group text-white shadow-xl">
            <div class="text-center sm:text-left mb-8 sm:mb-0">
                <span class="text-[#1754cf] font-black text-xs tracking-widest uppercase">Limited Offer</span>
                <h4 class="text-3xl font-bold mt-4 mb-8 tracking-tight">get a voucher claim <br class="hidden sm:block">for your purchase</h4>
                <a href="{{ route('products.vouchers') }}" class="inline-block bg-[#1754cf] text-white px-8 py-4 rounded-full text-[10px] font-black tracking-widest uppercase hover:bg-white hover:text-black transition-all no-underline">
                    Claim Voucher
                </a>
            </div>
            <div class="w-40 h-40 bg-gray-800 rounded-full flex items-center justify-center shadow-2xl group-hover:-rotate-12 transition-transform duration-500 border border-gray-700">
                <span class="text-3xl font-black italic underline decoration-[#1754cf]">LUXE</span>
            </div>
        </div>
    </div>
</section>

{{-- SECTION NEWSLETTER (Subscribers to Circle) --}}
<section class="border-t border-gray-100 py-24 md:py-32 bg-[#FDFBF7] overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12 md:gap-16 items-center text-center md:text-left">
        <div data-aos="fade-right">
            <h3 class="text-3xl md:text-4xl font-bold mb-4 md:mb-6 tracking-tighter text-[#111318]">Join the Inner Circle</h3>
            <p class="text-gray-500 text-base md:text-lg leading-relaxed max-w-md mx-auto md:mx-0">
                Subscribe to receive early access to new drops, styling tips from our fashion experts, and exclusive member-only invitations.
            </p>
        </div>

        <div class="w-full max-w-lg mx-auto md:ml-auto md:mr-0" data-aos="fade-left">
            <form id="subscribeForm" class="flex flex-col sm:flex-row gap-4">
                @csrf
                <input type="email" id="sub_email" name="email"
                       class="w-full flex-1 bg-white border border-gray-200 rounded-full px-8 py-4 md:py-5 focus:ring-2 focus:ring-[#1754cf] outline-none transition-all shadow-sm text-sm" 
                       placeholder="Email address for trend updates" required>
                <button type="submit" 
                        class="w-full sm:w-auto bg-[#111318] text-white px-10 py-4 md:py-5 rounded-full font-black uppercase text-[10px] tracking-widest hover:bg-[#1754cf] transition-all active:scale-95">
                    Subscribe
                </button>
            </form>
        </div>
    </div>
</section>

{{-- SCRIPT SUBSCRIPTION --}}
<script>
    document.getElementById('subscribeForm')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        // Pengecekan Login sebelum subscribe
        const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
        if(!isLoggedIn) {
            Swal.fire({
                icon: 'info',
                title: 'AUTHENTICATION REQUIRED',
                text: 'Please login to join the LUXE Inner Circle.',
                confirmButtonColor: '#1754cf',
                customClass: { popup: 'rounded-[2rem]' }
            });
            return;
        }

        const emailInput = document.getElementById('sub_email');
        try {
            const res = await fetch('{{ route("subscribe.circle") }}', {
                method: 'POST',
                headers: { 
                    'Content-Type': 'application/json', 
                    'X-CSRF-TOKEN': '{{ csrf_token() }}' 
                },
                body: JSON.stringify({ email: emailInput.value })
            });
            const data = await res.json();
            
            if(data.success) {
                Swal.fire({ 
                    icon: 'success', 
                    title: 'WELCOME TO THE CIRCLE', 
                    text: data.message,
                    confirmButtonColor: '#1754cf',
                    customClass: { popup: 'rounded-[2rem]' }
                }).then(() => location.reload()); // Reload agar menu navbar muncul
            } else {
                Swal.fire({ 
                    icon: 'info', 
                    title: 'MEMBERSHIP STATUS', 
                    text: data.message,
                    confirmButtonColor: '#111318',
                    customClass: { popup: 'rounded-[2rem]' }
                });
            }
        } catch (error) {
            console.error('Subscription error:', error);
        }
    });
</script>

@endsection