<div class="border border-slate-100 rounded-2xl overflow-hidden shadow-sm group bg-white">
    <button type="button" onclick="togglePayment('{{ $id }}')" class="w-full flex items-center justify-between p-4 hover:bg-slate-50 transition-all">
        <div class="flex items-center gap-4">
            <div class="w-12 h-8 flex items-center justify-center">
                <img src="{{ $logo }}" class="max-w-full max-h-full object-contain" alt="{{ $name }}">
            </div>
            <span class="text-[10px] font-black uppercase tracking-widest text-[#111318]">{{ $name }}</span>
        </div>
        <span class="material-symbols-outlined !text-lg text-slate-300 group-hover:text-[#111318]" id="icon-{{ $id }}">expand_more</span>
    </button>
    <div id="pay-{{ $id }}" class="hidden p-5 bg-slate-50/50 border-t border-slate-50 space-y-4">
        <div class="bg-white p-4 rounded-xl border border-slate-100 shadow-sm relative">
            <p class="text-[8px] text-[#1754cf] font-black uppercase mb-1">Transfer Destination</p>
            <p class="text-lg font-black tracking-widest text-[#111318]">{{ $acc }}</p>
            <p class="text-[10px] text-slate-500 font-bold uppercase">{{ $owner }}</p>
        </div>
        <div class="text-[10px] text-slate-400 font-medium leading-relaxed italic">
            *Please transfer exactly <b class="text-[#111318]">{{ $total }}</b> to authorize this order.
        </div>
    </div>
</div>