@forelse($orders as $order)
<tr class="hover:bg-slate-50/80 transition-all duration-200">
    {{-- 1. Kolom Reference & ID --}}
    <td class="px-8 py-6">
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.orders.show', $order->id) }}" class="font-black text-blue-600 block hover:underline">
                #ORD-{{ $order->id }}
            </a>
            {{-- Tanda Centang untuk Pesanan Selesai --}}
            @if($order->status == 'completed')
                <div class="flex items-center justify-center w-5 h-5 bg-emerald-100 text-emerald-600 rounded-full shadow-sm" title="Order Completed">
                    <i class="fa-solid fa-check text-[10px]"></i>
                </div>
            @endif
        </div>
        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">
            {{ date('d M Y • H:i', strtotime($order->created_at)) }}
        </span>
    </td>

    {{-- 2. Kolom Customer Details --}}
    <td class="px-6 py-6 text-left">
        <div class="flex items-center space-x-4">
            <div class="w-10 h-10 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-500 font-black text-xs border border-slate-200 uppercase">
                {{ substr($order->first_name, 0, 1) }}{{ substr($order->last_name, 0, 1) }}
            </div>
            <div>
                <p class="font-black text-slate-800 uppercase text-xs text-left">{{ $order->first_name }} {{ $order->last_name }}</p>
                <p class="text-[10px] font-medium text-slate-400 text-left">{{ $order->phone_number }}</p>
            </div>
        </div>
    </td>

    {{-- 3. KOLOM BARU: Received Proof (Bukti Barang Diterima) --}}
    <td class="px-6 py-6">
        @if($order->received_proof)
            <div class="relative group w-12 h-16">
                <a href="{{ asset('received_proofs/' . $order->received_proof) }}" target="_blank">
                    <img src="{{ asset('received_proofs/' . $order->received_proof) }}" 
                         class="w-full h-full object-cover rounded-xl shadow-sm border-2 border-white group-hover:border-blue-500 transition-all"
                         alt="Proof">
                    <div class="absolute inset-0 bg-black/20 group-hover:bg-transparent rounded-xl transition-all"></div>
                </a>
            </div>
        @else
            <span class="text-[9px] font-black text-slate-300 uppercase tracking-widest">No Proof yet</span>
        @endif
    </td>

    {{-- 4. Kolom Badge Status & Actions --}}
    <td class="px-8 py-6 text-right">
        <div class="flex justify-end items-center space-x-3">
            {{-- Badge Status Ringkas --}}
            <span class="px-3 py-1.5 rounded-lg text-[8px] font-black uppercase tracking-widest 
                {{ $order->status == 'completed' ? 'bg-emerald-50 text-emerald-600' : 'bg-slate-50 text-slate-400' }}">
                {{ $order->status }}
            </span>

            <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST" class="delete-form">
                @csrf @method('DELETE')
                <button type="button" 
                        class="btn-delete w-12 h-12 flex items-center justify-center rounded-2xl bg-red-50 text-red-400 hover:bg-red-500 hover:text-white transition-all shadow-sm active:scale-95">
                    <i class="fa-solid fa-trash-can"></i>
                </button>
            </form>
        </div>
    </td>
</tr>
@empty
<tr>
    <td colspan="4" class="px-8 py-20 text-center"> {{-- Ubah colspan jadi 4 karena tambah kolom --}}
        <div class="flex flex-col items-center">
            <i class="fa-solid fa-inbox text-5xl text-slate-100 mb-4"></i>
            <p class="text-slate-400 font-bold uppercase tracking-[0.3em] text-xs text-center">No transactions found</p>
        </div>
    </td>
</tr>
@endforelse