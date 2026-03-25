@extends('layouts.app')

@section('title', 'Secure Payment | LUXE')

@section('content')
<section class="min-h-screen bg-[#f6f6f8] pt-10 pb-32">
    <div class="max-w-6xl mx-auto px-6">
        {{-- PENTING: Tambahkan enctype agar file bisa terupload ke Controller --}}
        <form action="{{ route('checkout.process') }}" method="POST" id="final-order-form" enctype="multipart/form-data">
            @csrf
            {{-- Data Hidden untuk Database --}}
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <input type="hidden" name="quantity" value="{{ $data['quantity'] }}">
            <input type="hidden" name="selected_color" value="{{ $data['selected_color'] }}">
            <input type="hidden" name="selected_size" value="{{ $data['selected_size'] }}">
            <input type="hidden" name="phone_number" value="{{ $data['phone_number'] }}">
            <input type="hidden" name="postal_code" value="{{ $data['postal_code'] }}">
            <input type="hidden" name="province" value="{{ $data['province'] ?? '-' }}">
            <input type="hidden" name="city" value="{{ $data['city'] ?? '-' }}">
            <input type="hidden" name="district" value="{{ $data['district'] ?? '-' }}">
            <input type="hidden" name="subdistrict" value="{{ $data['subdistrict'] ?? '-' }}">
            <input type="hidden" name="address_detail" value="{{ $data['address_detail'] }}">
            <input type="hidden" name="total_price" value="{{ $data['total_price'] }}">
            <input type="hidden" name="voucher_used" value="{{ $data['promo_code'] ?? null }}">

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                
                {{-- KIRI: Ringkasan Produk & Alamat --}}
                <div class="lg:col-span-7 space-y-8">
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100" data-aos="fade-right">
                        <h3 class="text-xl font-black uppercase tracking-tighter mb-6">Investment Summary</h3>
                        <div class="flex gap-6 items-center">
                            <img src="{{ asset('products/'.$product->image) }}" class="w-32 h-40 object-cover rounded-2xl shadow-md">
                            <div class="space-y-1">
                                <h4 class="text-2xl font-black uppercase leading-tight">{{ $product->name }}</h4>
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                                    {{ $data['selected_color'] }} / Size {{ $data['selected_size'] }} (x{{ $data['quantity'] }})
                                </p>
                                <div class="pt-4">
                                    @if($product->promo_price)
                                        <p class="text-xs text-slate-400 line-through">IDR {{ number_format($product->original_price, 0, ',', '.') }}</p>
                                    @endif
                                    <p class="text-2xl font-black text-[#1754cf]">IDR {{ number_format($product->promo_price ?? $product->original_price, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ALAMAT RINGKAS --}}
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100" data-aos="fade-right" data-aos-delay="100">
                        <h3 class="text-xl font-black uppercase tracking-tighter mb-4">Destination</h3>
                        <div class="flex items-start gap-4 p-4 bg-slate-50 rounded-2xl border border-slate-100">
                            <span class="material-symbols-outlined text-[#1754cf]">location_on</span>
                            <p class="text-sm font-medium text-slate-600 leading-relaxed italic">
                                "{{ $data['address_detail'] }}, {{ $data['postal_code'] }}"
                            </p>
                        </div>
                    </div>

                    {{-- SECTION BARU: UPLOAD BUKTI PEMBAYARAN --}}
                    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-gray-100" data-aos="fade-up">
                        <h3 class="text-xl font-black uppercase tracking-tighter mb-4">Upload Transfer Receipt</h3>
                        <p class="text-[10px] text-slate-400 font-bold uppercase mb-6 tracking-widest">Format: JPG, PNG, JPEG (Max 2MB)</p>
                        
                        <div class="relative group">
                            {{-- Input File Asli (Disembunyikan dengan opacity 0) --}}
                            <input type="file" name="payment_proof" id="payment_proof" required 
                                   class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10"
                                   onchange="previewImage(event)">
                            
                            {{-- Tampilan Visual Dropzone --}}
                            <div id="dropzone-visual" class="border-2 border-dashed border-slate-200 rounded-[2rem] p-12 text-center group-hover:border-[#1754cf] group-hover:bg-blue-50 transition-all duration-300">
                                <div id="preview-container" class="hidden mb-4">
                                    <img id="image-preview" src="#" class="mx-auto h-32 w-auto rounded-xl shadow-md border-2 border-white">
                                </div>
                                <span class="material-symbols-outlined text-5xl text-slate-300 mb-3 group-hover:text-[#1754cf] transition-colors">cloud_upload</span>
                                <p class="text-xs font-black text-slate-400 uppercase tracking-widest" id="file-label">Drop or click to upload receipt</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KANAN: Detail Pembayaran & Payment Gateway --}}
                <div class="lg:col-span-5 space-y-6">
                    <div class="bg-white p-8 rounded-[3rem] shadow-xl border border-gray-100" data-aos="fade-left">
                        <h3 class="text-xl font-black uppercase tracking-tighter mb-6 border-b pb-4 text-center">Payment Gateway</h3>
                        
                        <div class="space-y-4">
                            {{-- Item: BANK BCA --}}
                            <div class="border border-slate-100 rounded-2xl overflow-hidden shadow-sm">
                                <button type="button" onclick="togglePayment('bca')" class="w-full flex items-center justify-between p-5 bg-slate-50 hover:bg-white transition-all">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-6 bg-blue-900 rounded flex items-center justify-center text-[8px] text-white font-bold italic">BCA</div>
                                        <span class="text-[11px] font-black uppercase tracking-widest text-slate-700">Bank Central Asia</span>
                                    </div>
                                    <span class="material-symbols-outlined" id="icon-bca">expand_more</span>
                                </button>
                                <div id="pay-bca" class="hidden p-6 bg-white border-t border-slate-50 space-y-4">
                                    <div class="bg-blue-50 p-4 rounded-xl border border-blue-100">
                                        <p class="text-[10px] text-blue-400 font-black uppercase mb-1">Account Number</p>
                                        <p class="text-lg font-black tracking-widest text-blue-900">8832 9910 22</p>
                                        <p class="text-[10px] text-blue-800 font-bold mt-1 uppercase">A.N LUXE PREMIUM OFFICIAL</p>
                                    </div>
                                    <div class="text-[10px] text-slate-500 font-medium space-y-2">
                                        <p>1. Open BCA Mobile / KlikBCA</p>
                                        <p>2. Select m-Transfer > Antar Rekening</p>
                                        <p>3. Input Account Number and Total Amount</p>
                                        <p>4. Save Proof of Payment</p>
                                    </div>
                                </div>
                            </div>

                            {{-- Item: E-WALLET DANA --}}
                            <div class="border border-slate-100 rounded-2xl overflow-hidden shadow-sm">
                                <button type="button" onclick="togglePayment('dana')" class="w-full flex items-center justify-between p-5 bg-slate-50 hover:bg-white transition-all">
                                    <div class="flex items-center gap-4">
                                        <div class="w-10 h-6 bg-blue-500 rounded flex items-center justify-center text-[8px] text-white font-bold italic">DANA</div>
                                        <span class="text-[11px] font-black uppercase tracking-widest text-slate-700">Digital Wallet DANA</span>
                                    </div>
                                    <span class="material-symbols-outlined" id="icon-dana">expand_more</span>
                                </button>
                                <div id="pay-dana" class="hidden p-6 bg-white border-t border-slate-50 space-y-4 text-center">
                                    <div class="inline-block p-4 bg-slate-50 rounded-2xl border border-dashed border-slate-200">
                                        <p class="text-[10px] font-black text-[#1754cf] mb-2 uppercase">Scan QR Code or Transfer to:</p>
                                        <p class="text-xl font-black tracking-widest text-[#111318]">0812 - 9901 - 2231</p>
                                        <p class="text-[10px] text-slate-400 font-bold mt-1 uppercase">A.N LUXE STORE (DANA PREMIUM)</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- RINCIAN BIAYA --}}
                        <div class="mt-10 pt-6 border-t border-dashed border-slate-200 space-y-3 text-right">
                            <div class="flex justify-between text-xs font-medium text-slate-500 uppercase tracking-widest">
                                <span>Subtotal Items</span>
                                <span>IDR {{ number_format(($product->promo_price ?? $product->original_price) * $data['quantity'], 0, ',', '.') }}</span>
                            </div>
                            @if($voucher)
                            <div class="flex justify-between text-xs font-bold text-emerald-500 uppercase tracking-widest">
                                <span>Voucher Applied</span>
                                <span>- IDR {{ number_format($voucher->discount_amount, 0, ',', '.') }}</span>
                            </div>
                            @endif
                            <div class="flex justify-between text-lg font-black text-[#111318] pt-4">
                                <span>TOTAL TO PAY</span>
                                <span class="text-[#1754cf]">IDR {{ number_format($data['total_price'], 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <button type="submit" class="w-full mt-8 bg-[#111318] text-white py-6 rounded-2xl font-black uppercase text-[11px] tracking-[0.3em] shadow-2xl hover:bg-[#1754cf] transition-all transform active:scale-95">
                            COMPLETE PAYMENT
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
    // Logika Accordion Pembayaran
    function togglePayment(target) {
        const panels = ['bca', 'dana'];
        panels.forEach(p => {
            const el = document.getElementById('pay-' + p);
            const icon = document.getElementById('icon-' + p);
            if(p === target) {
                el.classList.toggle('hidden');
                icon.innerText = el.classList.contains('hidden') ? 'expand_more' : 'expand_less';
            } else {
                el.classList.add('hidden');
                document.getElementById('icon-' + p).innerText = 'expand_more';
            }
        });
    }

    // Logika Preview Gambar Saat Upload
    function previewImage(event) {
        const input = event.target;
        const preview = document.getElementById('image-preview');
        const container = document.getElementById('preview-container');
        const label = document.getElementById('file-label');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.classList.remove('hidden');
                label.innerText = input.files[0].name; // Tampilkan nama file
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection