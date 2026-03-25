@extends('layouts.admin')
@section('title', 'Product List')
@section('page_title', 'Inventory Management')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="bg-white rounded-[3rem] p-10 shadow-sm border border-slate-100">
        
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
            <div>
                <h3 class="text-2xl font-black text-slate-800 tracking-tighter">Product Catalog</h3>
                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Total: {{ count($products) }} Items</p>
            </div>
            
            <div class="flex flex-1 max-w-md gap-4">
                <div class="relative flex-1">
                    <i class="fa-solid fa-magnifying-glass absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
                    <input type="text" id="productSearch" placeholder="Search product name or ID..." 
                           class="w-full bg-slate-50 border border-slate-100 rounded-2xl py-3 ps-12 text-xs font-bold outline-none focus:ring-4 focus:ring-indigo-600/5 focus:bg-white transition-all">
                </div>
                
                <a href="{{ route('admin.products.create') }}" class="bg-indigo-600 text-white px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:bg-slate-900 transition-all shadow-lg shadow-indigo-200 flex items-center gap-2">
                    <i class="fa-solid fa-plus"></i> Add Item
                </a>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-separate border-spacing-y-3" id="productTable">
                <thead>
                    <tr class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-300">
                        <th class="px-6 py-3">Product Info</th>
                        <th>Pricing Details</th>
                        <th>Attributes</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody id="productTableBody">
                    @foreach($products as $prod)
                    <tr class="product-row bg-slate-50/50 rounded-3xl group transition-all hover:bg-white hover:shadow-xl hover:shadow-slate-200/50">
                        <td class="px-6 py-4 rounded-l-[2rem]">
                            <div class="flex items-center gap-4">
                                <img src="{{ asset('products/'.$prod->image) }}" class="w-16 h-16 rounded-2xl object-cover shadow-sm">
                                <div>
                                    <p class="product-name font-black text-slate-800 leading-none mb-1 text-sm uppercase">{{ $prod->name }}</p>
                                    <p class="product-id text-[9px] text-indigo-500 font-black uppercase tracking-widest">ID: #{{ $prod->id }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4">
                            <p class="text-xs font-black text-slate-800 tracking-tight">Rp {{ number_format($prod->original_price, 0, ',', '.') }}</p>
                            @if($prod->promo_price)
                            <div class="flex items-center gap-2 mt-1">
                                <span class="text-[9px] font-black bg-emerald-100 text-emerald-600 px-1.5 py-0.5 rounded">-{{ $prod->discount_percent }}%</span>
                                <span class="text-[10px] font-bold text-slate-400 italic">Rp {{ number_format($prod->promo_price, 0, ',', '.') }}</span>
                            </div>
                            @endif
                        </td>
                        <td class="py-4">
                            <div class="flex flex-wrap gap-1">
                                @php $cats = json_decode($prod->category) ?? []; @endphp
                                @foreach(array_slice($cats, 0, 2) as $c)
                                    <span class="text-[8px] font-black uppercase bg-white border border-slate-200 px-2 py-0.5 rounded-full text-slate-500">{{ $c }}</span>
                                @endforeach
                            </div>
                        </td>
                        <td class="py-4 px-6 rounded-r-[2rem] text-center">
                            <div class="flex items-center justify-center gap-3">
                                <button onclick="openEditModal({{ $prod->id }})" class="w-10 h-10 bg-white border border-slate-100 rounded-xl flex items-center justify-center text-indigo-600 shadow-sm hover:bg-indigo-600 hover:text-white transition-all">
                                    <i class="fa-solid fa-pen-to-square text-xs"></i>
                                </button>
                                <button onclick="deleteProduct({{ $prod->id }})" class="w-10 h-10 bg-white border border-slate-100 rounded-xl flex items-center justify-center text-red-500 shadow-sm hover:bg-red-500 hover:text-white transition-all">
                                    <i class="fa-solid fa-trash-can text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL EDIT FULL ASPECT --}}
<div id="editModal" class="fixed inset-0 z-[2000] hidden flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4 overflow-y-auto">
    <div class="bg-white w-full max-w-4xl rounded-[3rem] shadow-2xl my-auto">
        <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="p-8 md:p-12">
                <div class="flex justify-between items-center mb-10">
                    <div>
                        <h3 class="text-2xl font-black text-slate-800 tracking-tighter uppercase">Evolution Terminal</h3>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-[0.3em]">Refining Product DNA</p>
                    </div>
                    <button type="button" onclick="closeModal()" class="w-10 h-10 flex items-center justify-center bg-slate-50 rounded-full text-slate-400 hover:text-red-500 transition-all text-2xl">&times;</button>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
                    {{-- SISI KIRI: Media --}}
                    <div class="md:col-span-4 space-y-6 text-center">
                        <div>
                            <label class="text-[9px] font-black uppercase text-slate-400 mb-3 block tracking-widest">Master Image</label>
                            <div class="relative group aspect-[3/4] rounded-[2rem] overflow-hidden bg-slate-100 border-2 border-dashed border-slate-200">
                                <img id="edit_prev_main" class="absolute inset-0 w-full h-full object-cover">
                                <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer z-10" onchange="previewMain(this)">
                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all">
                                    <span class="text-white text-[10px] font-black uppercase">Change Cover</span>
                                </div>
                            </div>
                        </div>
                        <div>
                            <label class="text-[9px] font-black uppercase text-slate-400 mb-3 block tracking-widest">Add Gallery</label>
                            <div class="relative py-4 bg-indigo-50 border-2 border-indigo-100 rounded-2xl border-dashed">
                                <input type="file" name="gallery_images[]" multiple class="absolute inset-0 opacity-0 cursor-pointer">
                                <i class="fa-solid fa-images text-indigo-400"></i>
                                <p class="text-[8px] font-black text-indigo-500 uppercase mt-1">Upload More Photos</p>
                            </div>
                        </div>
                    </div>

                    {{-- SISI KANAN: Data --}}
                    <div class="md:col-span-8 space-y-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="col-span-2">
                                <label class="text-[9px] font-black uppercase text-slate-400 mb-1 ml-1">Product Name</label>
                                <input type="text" name="name" id="edit_name" required class="w-full px-5 py-3.5 rounded-2xl bg-slate-50 border border-slate-100 font-bold outline-none focus:ring-4 focus:ring-indigo-500/5 transition-all">
                            </div>
                            
                            <div class="col-span-2">
                                <label class="text-[9px] font-black uppercase text-slate-400 mb-1 ml-1">Kategori (Select Multiple)</label>
                                <div class="flex flex-wrap gap-2 p-4 bg-slate-50 rounded-2xl border border-slate-100 shadow-inner">
                                    @foreach(['Men', 'Women', 'Unisex', 'Accessories', 'New Arrival', 'Special Edition'] as $cat)
                                    <label class="inline-flex items-center gap-2 bg-white px-3 py-1.5 rounded-xl border border-slate-200 cursor-pointer active:scale-95 transition-all">
                                        <input type="checkbox" name="category[]" value="{{ $cat }}" class="edit-cat-check w-3 h-3 rounded text-indigo-600 border-slate-300">
                                        <span class="text-[10px] font-bold text-slate-600">{{ $cat }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="col-span-2">
                                <label class="text-[9px] font-black uppercase text-slate-400 mb-1 ml-1">Description Detail</label>
                                <textarea name="detail" id="edit_detail" rows="3" class="w-full px-5 py-3 rounded-2xl bg-slate-50 border border-slate-100 text-xs font-medium leading-relaxed outline-none"></textarea>
                            </div>

                            <div>
                                <label class="text-[9px] font-black uppercase text-slate-400 mb-1 ml-1">Original Price</label>
                                <input type="number" name="original_price" id="edit_original" class="w-full px-5 py-3 rounded-2xl bg-slate-50 border border-slate-100 font-bold text-slate-800">
                            </div>
                            <div>
                                <label class="text-[9px] font-black uppercase text-slate-400 mb-1 ml-1">Promo Price</label>
                                <input type="number" name="promo_price" id="edit_promo" class="w-full px-5 py-3 rounded-2xl bg-indigo-50/50 border border-indigo-100 font-bold text-indigo-600">
                            </div>

                            <div>
                                <label class="text-[9px] font-black uppercase text-slate-400 mb-1 ml-1">Voucher Code</label>
                                <input type="text" name="voucher_code" id="edit_v_code" class="w-full px-5 py-3 rounded-2xl bg-slate-50 border border-slate-100 font-black uppercase text-indigo-500 tracking-widest">
                            </div>
                            <div>
                                <label class="text-[9px] font-black uppercase text-slate-400 mb-1 ml-1">Voucher Price</label>
                                <input type="number" name="voucher_price" id="edit_v_price" class="w-full px-5 py-3 rounded-2xl bg-slate-50 border border-slate-100 font-bold">
                            </div>

                            {{-- MULTI ATTRIBUTE EDIT --}}
                            <div>
                                <label class="text-[9px] font-black uppercase text-slate-400 mb-1 ml-1">Colors</label>
                                <div class="grid grid-cols-3 gap-1 bg-slate-50 p-2 rounded-xl">
                                    @foreach(['Black', 'White', 'Beige', 'Navy', 'Grey', 'Red'] as $color)
                                    <label class="text-[8px] font-bold flex items-center gap-1">
                                        <input type="checkbox" name="colors[]" value="{{ $color }}" class="edit-color-check scale-75"> {{ $color }}
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                            <div>
                                <label class="text-[9px] font-black uppercase text-slate-400 mb-1 ml-1">Sizes</label>
                                <div class="grid grid-cols-3 gap-1 bg-slate-50 p-2 rounded-xl">
                                    @foreach(['S', 'M', 'L', 'XL', 'XXL', 'All Size'] as $size)
                                    <label class="text-[8px] font-bold flex items-center gap-1">
                                        <input type="checkbox" name="sizes[]" value="{{ $size }}" class="edit-size-check scale-75"> {{ $size }}
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4 mt-12">
                    <button type="button" onclick="closeModal()" class="px-8 py-4 rounded-2xl text-[10px] font-black uppercase text-slate-400 hover:bg-slate-50 transition-all">Discard</button>
                    <button type="submit" class="bg-[#111318] text-white px-12 py-4 rounded-2xl text-[10px] font-black uppercase tracking-[0.3em] shadow-2xl hover:bg-indigo-600 transition-all active:scale-95">Update Evolution</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // SEARCH ENGINE
    document.getElementById('productSearch').addEventListener('keyup', function() {
        const query = this.value.toLowerCase();
        document.querySelectorAll('.product-row').forEach(row => {
            const name = row.querySelector('.product-name').textContent.toLowerCase();
            const id = row.querySelector('.product-id').textContent.toLowerCase();
            row.classList.toggle('hidden', !(name.includes(query) || id.includes(query)));
        });
    });

    // OPEN MODAL & DATA FETCHING
    function openEditModal(id) {
        fetch(`/admin/products/${id}/edit`)
            .then(res => res.json())
            .then(data => {
                // Reset Checkboxes
                document.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);

                // Fill Inputs
                document.getElementById('edit_name').value = data.name;
                document.getElementById('edit_detail').value = data.detail;
                document.getElementById('edit_original').value = data.original_price;
                document.getElementById('edit_promo').value = data.promo_price;
                document.getElementById('edit_v_code').value = data.voucher_code;
                document.getElementById('edit_v_price').value = data.voucher_price;
                document.getElementById('edit_prev_main').src = `/products/${data.image}`;

                // Fill Checkboxes Category
                if(data.category) {
                    data.category.forEach(c => {
                        const check = document.querySelector(`.edit-cat-check[value="${c}"]`);
                        if(check) check.checked = true;
                    });
                }

                // Fill Checkboxes Colors
                if(data.colors) {
                    data.colors.forEach(c => {
                        const check = document.querySelector(`.edit-color-check[value="${c}"]`);
                        if(check) check.checked = true;
                    });
                }

                // Fill Checkboxes Sizes
                if(data.sizes) {
                    data.sizes.forEach(s => {
                        const check = document.querySelector(`.edit-size-check[value="${s}"]`);
                        if(check) check.checked = true;
                    });
                }

                document.getElementById('editForm').action = `/admin/products/update/${id}`;
                document.getElementById('editModal').classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Lock Scroll
            });
    }

    function closeModal() {
        document.getElementById('editModal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }

    function previewMain(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => document.getElementById('edit_prev_main').src = e.target.result;
            reader.readAsDataURL(input.files[0]);
        }
    }

    function deleteProduct(id) {
        Swal.fire({
            title: 'Terminate Data?',
            text: "This asset will be erased from central database!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            confirmButtonText: 'Yes, Erase It',
            customClass: { popup: 'rounded-[2rem]' }
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/admin/products/destroy/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                }).then(() => location.reload());
            }
        })
    }
</script>
@endsection