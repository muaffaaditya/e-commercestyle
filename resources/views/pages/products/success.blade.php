@extends('layouts.app')

@section('content')
<section class="min-h-screen bg-[#f6f6f8] pt-20 pb-32">
    <div class="max-w-5xl mx-auto px-4">
        
        {{-- Header Section --}}
        <div class="mb-10 flex flex-col md:flex-row md:items-end justify-between gap-6" data-aos="fade-right">
            <div class="text-left">
                <span class="text-[9px] font-black uppercase tracking-[0.4em] text-[#1754cf] mb-2 block">Transaction Detail</span>
                <h2 class="text-4xl font-extrabold tracking-tighter text-[#111318] uppercase leading-none">Order #ORD-{{ $order->id }}</h2>
                <p class="text-slate-400 text-[10px] font-bold uppercase tracking-widest mt-2">Placed on {{ date('d M Y • H:i', strtotime($order->created_at)) }}</p>
            </div>
            
            {{-- Tombol Konfirmasi: Hilang otomatis jika sudah 'completed' --}}
            @if($order->status !== 'completed')
                <button onclick="showReceiveModal()" class="bg-[#111318] text-white px-10 py-5 rounded-[2rem] font-black text-[10px] tracking-[0.2em] uppercase hover:bg-[#1754cf] transition-all shadow-2xl shadow-blue-100 flex items-center gap-3 active:scale-95">
                    <span class="material-symbols-outlined text-sm">inventory_2</span>
                    Konfirmasi Diterima
                </button>
            @else
                <div class="bg-emerald-500 text-white px-10 py-5 rounded-[2rem] font-black text-[10px] tracking-[0.2em] uppercase flex items-center gap-3 cursor-default shadow-xl">
                    <span class="material-symbols-outlined text-sm">verified</span>
                    Order Completed
                </div>
            @endif
        </div>

        {{-- VISUAL TIMELINE (ALUR PESANAN) --}}
        <div class="bg-white p-10 md:p-14 rounded-[3rem] shadow-sm border border-slate-50 mb-10 relative overflow-hidden">
            @php
                // Logika Alur Status
                $steps = [
                    'pending'    => 'Order Placed',
                    'processing' => 'Processing',
                    'shipped'    => 'Shipped',
                    'completed'  => 'Delivered'
                ];
                $currentStatus = $order->status;
                $statusKeys = array_keys($steps);
                $currentIdx = array_search($currentStatus, $statusKeys);
                
                // Progress Bar Width
                $progressWidth = ($currentIdx / (count($steps) - 1)) * 100;
            @endphp

            <div class="relative flex justify-between items-center w-full z-10">
                @foreach($steps as $key => $label)
                    @php
                        $isDone = array_search($key, $statusKeys) <= $currentIdx;
                    @endphp
                    <div class="flex flex-col items-center">
                        <div class="w-12 h-12 md:w-16 md:h-16 rounded-full flex items-center justify-center border-4 transition-all duration-700
                            {{ $isDone ? 'bg-[#1754cf] border-blue-100 text-white shadow-lg shadow-blue-200' : 'bg-slate-50 border-white text-slate-300' }}">
                            @if($isDone)
                                <span class="material-symbols-outlined text-xl md:text-2xl">check</span>
                            @else
                                <div class="w-2 h-2 rounded-full bg-slate-200"></div>
                            @endif
                        </div>
                        <p class="text-[9px] md:text-[10px] font-black uppercase tracking-widest mt-4 transition-colors
                            {{ $isDone ? 'text-[#111318]' : 'text-slate-300' }}">
                            {{ $label }}
                        </p>
                    </div>
                @endforeach

                {{-- Background Line --}}
                <div class="absolute top-6 md:top-8 left-0 w-full h-[2px] bg-slate-100 -z-10"></div>
                {{-- Active Progress Line --}}
                <div class="absolute top-6 md:top-8 left-0 h-[2px] bg-[#1754cf] -z-10 transition-all duration-1000 ease-out" style="width: {{ $progressWidth }}%"></div>
            </div>
        </div>

        {{-- Detail Content --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 text-left">
            <div class="lg:col-span-2 space-y-8">
                {{-- Product Narrative --}}
                <div class="bg-white rounded-[3rem] p-8 md:p-10 shadow-sm border border-slate-50 flex flex-col md:flex-row gap-8">
                    <img src="{{ asset('products/'.$order->product_image) }}" class="w-40 h-52 object-cover rounded-[2.5rem] shadow-xl border-4 border-slate-50">
                    <div class="flex-grow">
                        <h3 class="text-2xl font-black text-[#111318] uppercase tracking-tighter mb-4">{{ $order->product_name }}</h3>
                        <div class="flex gap-2 mb-6">
                            <span class="text-[9px] font-black bg-slate-50 border border-slate-100 px-4 py-2 rounded-xl uppercase text-slate-400">SIZE: <span class="text-[#111318]">{{ $order->size_choice }}</span></span>
                            <span class="text-[9px] font-black bg-slate-50 border border-slate-100 px-4 py-2 rounded-xl uppercase text-slate-400">COLOR: <span class="text-[#111318]">{{ $order->color_choice }}</span></span>
                        </div>
                        <div class="pt-6 border-t border-slate-50 flex items-center justify-between">
                            <div>
                                <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest mb-1 leading-none">Total Investment</p>
                                <p class="text-2xl font-black text-[#111318]">IDR {{ number_format((float)$order->total_price, 0, ',', '.') }}</p>
                            </div>
                            <div class="px-5 py-2 bg-emerald-50 rounded-xl">
                                <p class="text-[8px] font-black text-emerald-600 uppercase tracking-widest">Verified Payment</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Shipping Terminal --}}
                <div class="bg-white rounded-[3rem] p-10 shadow-sm border border-slate-50 relative">
                    <h4 class="text-[10px] font-black uppercase tracking-widest text-[#1754cf] mb-6 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 rounded-full bg-[#1754cf]"></span> Shipping Terminal
                    </h4>
                    <p class="text-lg md:text-xl font-bold text-[#111318] leading-relaxed uppercase italic">
                        {{ $order->address_detail }}, {{ $order->district }}, {{ $order->city }}, {{ $order->province }}, {{ $order->postal_code }}
                    </p>
                    <div class="mt-8 pt-8 border-t border-dashed border-slate-100 flex justify-between items-center">
                        <span class="text-[10px] font-black uppercase text-slate-400">Delivery Status</span>
                        <span class="text-[10px] font-black uppercase text-[#111318]">{{ $order->status }}</span>
                    </div>
                </div>
            </div>

            {{-- Sidebar: Client & Proof --}}
            <div class="space-y-8">
                {{-- Client Identity --}}
                <div class="bg-[#111318] rounded-[3rem] p-10 text-white shadow-2xl shadow-slate-200">
                    <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-8 leading-none">Client Identity</h4>
                    <div class="flex items-center gap-5">
                        <div class="w-16 h-16 rounded-[1.5rem] bg-blue-600 flex items-center justify-center font-black text-2xl shadow-xl uppercase">
                            {{ substr($order->first_name, 0, 1) }}
                        </div>
                        <div>
                            <p class="font-black text-xl uppercase leading-tight">{{ $order->first_name }} {{ $order->last_name }}</p>
                            <p class="text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-1">Premium Member</p>
                        </div>
                    </div>
                    <div class="mt-10 space-y-6 pt-8 border-t border-slate-800">
                        <div class="flex items-center gap-4 text-slate-300">
                            <span class="material-symbols-outlined text-slate-500">mail</span>
                            <span class="text-xs font-bold">{{ $order->email }}</span>
                        </div>
                        <div class="flex items-center gap-4 text-slate-300">
                            <span class="material-symbols-outlined text-slate-500">call</span>
                            <span class="text-xs font-bold">{{ $order->phone_number }}</span>
                        </div>
                    </div>
                </div>

                {{-- Payment Verification --}}
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100">
                    <h4 class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">Payment Verification</h4>
                    <img src="{{ asset('payment_proofs/'.$order->payment_proof) }}" class="w-full h-40 object-cover rounded-2xl border border-slate-50 grayscale hover:grayscale-0 transition-all duration-500">
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Modal Konfirmasi --}}
<div id="receiveModal" class="fixed inset-0 bg-black/90 z-[999] hidden flex items-center justify-center p-4 backdrop-blur-xl transition-all duration-500">
    <div class="bg-white rounded-[4rem] p-10 md:p-16 max-w-lg w-full text-center relative shadow-2xl">
        <h3 class="text-3xl font-black text-[#111318] uppercase tracking-tighter mb-4">Masterpiece Arrived?</h3>
        <p class="text-slate-400 text-xs font-medium px-4 mb-10 uppercase tracking-widest leading-relaxed">
            By confirming, your transaction will be archived. Feel free to share the excellence.
        </p>
        
        <form action="{{ route('orders.confirm', $order->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-10 bg-slate-50 p-8 rounded-[2.5rem] border border-dashed border-slate-200">
                <label class="block text-[9px] font-black uppercase tracking-widest text-slate-400 mb-4 text-center">Capture the Product (Optional)</label>
                <input type="file" name="received_proof" class="w-full text-[10px] font-black text-slate-500 file:mr-4 file:py-3 file:px-8 file:rounded-2xl file:border-0 file:bg-[#111318] file:text-white cursor-pointer">
            </div>
            
            <div class="flex gap-4">
                <button type="button" onclick="hideReceiveModal()" class="flex-1 py-5 font-black text-[10px] uppercase tracking-widest text-slate-400 hover:text-[#111318]">Not Yet</button>
                <button type="submit" class="flex-1 py-5 bg-[#111318] text-white rounded-[1.8rem] font-black text-[10px] uppercase tracking-widest shadow-2xl active:scale-95 transition-all">Yes, Delivered</button>
            </div>
        </form>
    </div>
</div>

<script>
    function showReceiveModal() { document.getElementById('receiveModal').classList.replace('hidden', 'flex'); }
    function hideReceiveModal() { document.getElementById('receiveModal').classList.replace('flex', 'hidden'); }
</script>
@endsection