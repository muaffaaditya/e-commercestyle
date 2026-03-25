@extends('layouts.admin')
@section('title', 'Add Fashion Item')

@section('content')
<div class="max-w-6xl mx-auto">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            {{-- KIRI: Informasi Utama Produk --}}
            <div class="lg:col-span-8 space-y-6">
                
                {{-- Bagian 1: Informasi Umum --}}
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                    <h3 class="text-lg font-black text-slate-800 mb-6 uppercase tracking-tight">General Information</h3>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2 ml-1">Product Name</label>
                            <input type="text" name="name" required class="w-full px-6 py-4 rounded-2xl border border-slate-100 bg-slate-50 focus:bg-white focus:ring-4 focus:ring-indigo-600/5 focus:border-indigo-500 outline-none transition-all font-bold text-slate-700 shadow-inner placeholder:font-normal" placeholder="e.g. Luxury Silk Shirt">
                        </div>

                        {{-- SEKSI KATEGORI DENGAN FITUR SELECT ALL --}}
                        <div>
                            <div class="flex justify-between items-center mb-3 ml-1">
                                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">Target Categories</label>
                                <button type="button" id="select-all-cat" class="text-[9px] font-black uppercase tracking-widest text-indigo-600 hover:bg-indigo-100 transition-colors bg-indigo-50 px-4 py-1.5 rounded-full border border-indigo-100 active:scale-95">
                                    Select All
                                </button>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 p-6 bg-slate-50 rounded-[2rem] border border-slate-100 shadow-inner">
                                @foreach(['Men', 'Women', 'Unisex', 'Accessories', 'New Arrival', 'Special Edition'] as $cat)
                                <label class="cat-label group relative flex items-center justify-center p-4 rounded-2xl border-2 border-white bg-white cursor-pointer hover:border-indigo-400 hover:shadow-md transition-all active:scale-95 overflow-hidden">
                                    <input type="checkbox" name="category[]" value="{{ $cat }}" class="cat-checkbox hidden">
                                    <span class="text-xs font-black text-slate-400 group-hover:text-indigo-600 transition-colors uppercase tracking-wider">{{ $cat }}</span>
                                    <div class="check-indicator absolute top-2 right-2 opacity-0 scale-50 transition-all">
                                        <span class="material-symbols-outlined text-indigo-600 text-sm font-black">check_circle</span>
                                    </div>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2 ml-1">Product Description</label>
                            <textarea name="detail" rows="4" class="w-full px-6 py-4 rounded-2xl border border-slate-100 bg-slate-50 focus:bg-white focus:ring-4 focus:ring-indigo-600/5 outline-none transition-all text-sm leading-relaxed text-slate-500 shadow-inner" placeholder="Provide details about materials, fitting, and essence of this style..."></textarea>
                        </div>

                        {{-- Atribut Produk: Warna & Ukuran --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 bg-slate-50 rounded-[2rem] border border-slate-100 shadow-inner">
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3 ml-1">Available Colors</label>
                                <div class="flex flex-wrap gap-2">
                                    @foreach(['Black', 'White', 'Beige', 'Navy', 'Grey', 'Red'] as $color)
                                    <label class="group inline-flex items-center gap-2 bg-white px-4 py-2 rounded-xl border border-slate-200 cursor-pointer hover:border-indigo-400 transition-all active:scale-95 shadow-sm">
                                        <input type="checkbox" name="colors[]" value="{{ $color }}" class="w-4 h-4 rounded text-indigo-600 border-slate-300 focus:ring-indigo-500">
                                        <span class="text-xs font-bold text-slate-600 group-hover:text-indigo-600">{{ $color }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            <div>
                                <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3 ml-1">Available Sizes</label>
                                <div class="flex flex-wrap gap-2">
                                    @foreach(['S', 'M', 'L', 'XL', 'XXL', 'All Size'] as $size)
                                    <label class="group inline-flex items-center gap-2 bg-white px-4 py-2 rounded-xl border border-slate-200 cursor-pointer hover:border-indigo-400 transition-all active:scale-95 shadow-sm">
                                        <input type="checkbox" name="sizes[]" value="{{ $size }}" class="w-4 h-4 rounded text-indigo-600 border-slate-300 focus:ring-indigo-500">
                                        <span class="text-xs font-bold text-slate-600 group-hover:text-indigo-600">{{ $size }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Bagian 2: Harga & Voucher --}}
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                    <h3 class="text-lg font-black text-slate-800 mb-6 italic uppercase tracking-tight">Pricing Architecture</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2 ml-1">Original Price (Rp)</label>
                            <input type="number" name="original_price" id="original_price" required class="w-full px-6 py-4 rounded-2xl border border-slate-100 bg-slate-50 focus:bg-white focus:ring-4 focus:ring-indigo-600/5 outline-none transition-all font-bold text-slate-800 shadow-inner">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2 ml-1">Promo Price (Rp)</label>
                            <input type="number" name="promo_price" id="promo_price" class="w-full px-6 py-4 rounded-2xl border border-slate-100 bg-indigo-50/30 focus:bg-white focus:ring-4 focus:ring-indigo-600/5 outline-none transition-all font-bold text-indigo-600 shadow-inner">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2 ml-1">Discount Rate (%)</label>
                            <input type="number" name="discount_percent" id="discount_percent" class="w-full px-6 py-4 rounded-2xl border border-slate-100 bg-emerald-50/30 focus:bg-white focus:ring-4 focus:ring-indigo-600/5 outline-none transition-all font-bold text-emerald-600 shadow-inner">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 bg-slate-50 rounded-[2rem] border border-slate-100 shadow-inner">
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2 ml-1">Exclusive Voucher Code</label>
                            <input type="text" name="voucher_code" placeholder="e.g. LUXE2026" class="w-full px-5 py-3 rounded-xl border border-white bg-white shadow-sm font-black uppercase tracking-tighter outline-none focus:ring-2 focus:ring-indigo-500/20 text-indigo-600">
                        </div>
                        <div>
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2 ml-1">Special Voucher Price (Rp)</label>
                            <input type="number" name="voucher_price" placeholder="Harga khusus voucher" class="w-full px-5 py-3 rounded-xl border border-white bg-white shadow-sm font-bold outline-none focus:ring-2 focus:ring-indigo-500/20 text-slate-700">
                        </div>
                    </div>
                </div>
            </div>

            {{-- KANAN: Media & Deployment --}}
            <div class="lg:col-span-4 space-y-6">
                <div class="bg-white p-8 rounded-[3rem] shadow-sm border border-slate-100 sticky top-28 text-center">
                    
                    {{-- Master Image --}}
                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-4">Master Thumbnail</label>
                    <div class="relative group aspect-[3/4] rounded-[2.5rem] overflow-hidden bg-slate-100 border-2 border-dashed border-slate-200 flex items-center justify-center transition-all hover:border-indigo-400 shadow-inner">
                        <img id="prev-prod" class="absolute inset-0 w-full h-full object-cover hidden transition-transform duration-500 group-hover:scale-110">
                        <input type="file" name="image" required class="absolute inset-0 opacity-0 cursor-pointer z-20" onchange="previewImage(this)">
                        <div class="text-center group-hover:scale-110 transition-transform" id="placeholder-icon">
                            <span class="material-symbols-outlined text-4xl text-slate-300"></span>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-2">Upload Cover</p>
                        </div>
                    </div>

                    {{-- Gallery Section --}}
                    <div class="mt-8">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-4">Gallery Showcase</label>
                        <div class="grid grid-cols-3 gap-3 mb-4" id="gallery-preview">
                            {{-- Preview Images --}}
                        </div>
                        <div class="relative bg-slate-50 border border-slate-100 rounded-2xl p-4 text-center hover:bg-indigo-50 transition-all cursor-pointer group shadow-sm">
                            <input type="file" name="gallery_images[]" multiple class="absolute inset-0 opacity-0 cursor-pointer" onchange="previewGallery(this)">
                            <div class="flex items-center justify-center gap-2 text-indigo-500">
                                <span class="material-symbols-outlined text-lg font-bold"></span>
                                <p class="text-[10px] font-black uppercase tracking-wider">Add More Photos</p>
                            </div>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" class="w-full bg-[#111318] text-white py-5 rounded-2xl mt-8 font-black uppercase text-[11px] tracking-[0.3em] hover:bg-indigo-600 shadow-2xl shadow-indigo-200 transition-all active:scale-[0.97] flex items-center justify-center gap-3">
                        Deploy Item <span class="material-symbols-outlined text-sm font-black"></span>
                    </button>
                    
                    <p class="text-[9px] text-slate-400 text-center mt-4 italic leading-relaxed">
                        Double-check all attributes before publishing to the live storefront.
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>

<style>
    /* Style untuk label kategori yang terpilih secara visual */
    .cat-label.selected {
        border-color: #4f46e5; 
        background-color: #f5f3ff;
    }
    .cat-label.selected span {
        color: #4f46e5;
    }
    .cat-label.selected .check-indicator {
        opacity: 1;
        transform: scale(1);
    }
</style>

<script>
    // 1. Logika Kalkulasi Harga & Diskon Otomatis
    const oPrice = document.getElementById('original_price');
    const pPrice = document.getElementById('promo_price');
    const dPercent = document.getElementById('discount_percent');

    pPrice.addEventListener('input', () => {
        if(oPrice.value > 0) {
            const disc = ((oPrice.value - pPrice.value) / oPrice.value) * 100;
            dPercent.value = Math.round(disc);
        }
    });

    dPercent.addEventListener('input', () => {
        if(oPrice.value > 0) {
            const promo = oPrice.value - (oPrice.value * (dPercent.value / 100));
            pPrice.value = Math.round(promo);
        }
    });

    // 2. Logika Select All Kategori
    const selectAllBtn = document.getElementById('select-all-cat');
    const catCheckboxes = document.querySelectorAll('.cat-checkbox');

    selectAllBtn.addEventListener('click', function() {
        const isSelectAll = this.innerText.trim() === 'SELECT ALL';
        catCheckboxes.forEach(cb => {
            cb.checked = isSelectAll;
            updateLabelStyle(cb);
        });
        this.innerText = isSelectAll ? 'DESELECT ALL' : 'SELECT ALL';
    });

    catCheckboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            updateLabelStyle(this);
        });
    });

    function updateLabelStyle(checkbox) {
        const label = checkbox.closest('.cat-label');
        if (checkbox.checked) {
            label.classList.add('selected');
        } else {
            label.classList.remove('selected');
        }
    }

    // 3. Preview Gambar Master
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('prev-prod');
                img.src = e.target.result;
                img.classList.remove('hidden');
                document.getElementById('placeholder-icon').classList.add('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // 4. Preview Gallery (Banyak Gambar)
    function previewGallery(input) {
        const container = document.getElementById('gallery-preview');
        if (input.files) {
            Array.from(input.files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = "aspect-square rounded-xl overflow-hidden border border-slate-100 shadow-sm animate-pulse";
                    div.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
                    container.appendChild(div);
                    setTimeout(() => div.classList.remove('animate-pulse'), 500);
                }
                reader.readAsDataURL(file);
            });
        }
    }
</script>
@endsection