@extends('layouts.app')

@section('title', 'Purchase History | LUXE')

@section('content')
<section class="min-h-screen bg-[#f6f6f8] pt-10 pb-32"> {{-- Padding top dikurangi agar tampilan lebih ke atas --}}
    <div class="max-w-5xl mx-auto px-6">
        
        {{-- Breadcrumb: Minimalist Style --}}
        <nav class="flex mb-12 text-[9px] font-black uppercase tracking-[0.3em]" data-aos="fade-down">
            <ol class="inline-flex items-center space-x-2">
                <li><a href="{{ route('home') }}" class="text-slate-400 hover:text-[#1754cf] transition-colors">Terminal</a></li>
                <li class="text-slate-300">/</li>
                <li class="text-[#111318]">Archive</li>
            </ol>
        </nav>

        {{-- Header Section: Disesuaikan dengan tema LUXE Premium --}}
        <div class="mb-16 text-center md:text-left" data-aos="fade-up">
            <span class="text-[10px] uppercase tracking-[0.4em] font-black text-[#1754cf] mb-3 block">Order Tracking</span>
            <h2 class="text-5xl md:text-7xl font-light tracking-tighter text-[#111318] leading-tight">
                Purchase <br>
                <span class="italic font-extrabold text-[#111318]">History</span>
            </h2>
            <p class="text-slate-400 font-medium italic text-sm mt-6 max-w-xl">A curated archive of your fashion investments and style acquisitions.</p>
        </div>

        @if($orders->isEmpty())
            {{-- Empty State --}}
            <div class="bg-white rounded-[3.5rem] p-24 text-center border border-slate-100 shadow-sm" data-aos="zoom-in">
                <span class="material-symbols-outlined text-6xl text-slate-100 mb-6 block">inventory_2</span>
                <p class="font-black text-slate-300 uppercase tracking-widest text-xs">No recorded acquisitions found.</p>
                <a href="{{ route('home') }}" class="inline-block mt-8 bg-[#111318] text-white px-10 py-4 rounded-full text-[10px] font-black tracking-widest uppercase hover:bg-[#1754cf] transition-all shadow-xl">Start Exploring</a>
            </div>
        @else
            {{-- Order List Container --}}
            <div class="grid grid-cols-1 gap-8">
                @foreach($orders as $item)
                <div class="bg-white rounded-[3rem] p-8 flex flex-col md:flex-row items-center gap-8 shadow-sm border border-slate-50 group hover:border-[#1754cf]/30 hover:shadow-2xl hover:shadow-slate-200/50 transition-all duration-700" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 50 }}">
                    
                    {{-- Product Image --}}
                    <div class="relative flex-shrink-0">
                        <img src="{{ asset('products/'.$item->image) }}" class="w-28 h-36 object-cover rounded-[2.2rem] shadow-xl group-hover:scale-105 transition-transform duration-700">
                        @if($item->status == 'completed')
                        <div class="absolute -top-3 -right-3 bg-emerald-500 text-white w-9 h-9 rounded-full flex items-center justify-center border-4 border-white shadow-lg">
                            <span class="material-symbols-outlined text-lg">check</span>
                        </div>
                        @endif
                    </div>

                    {{-- Order Information --}}
                    <div class="flex-grow text-center md:text-left">
                        <div class="flex flex-col md:flex-row md:items-center gap-2 md:gap-4 mb-3">
                            <span class="text-[9px] font-black text-[#1754cf] bg-blue-50 px-4 py-1.5 rounded-full uppercase tracking-widest">#ORD-{{ $item->id }}</span>
                            <span class="text-[9px] font-bold text-slate-300 uppercase tracking-[0.2em]">{{ date('d M Y', strtotime($item->created_at)) }}</span>
                        </div>
                        <h4 class="text-2xl font-black text-[#111318] uppercase tracking-tighter mb-1">{{ $item->name }}</h4>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em] italic">Authentic LUXE Investment Recorded</p>
                    </div>

                    {{-- Status & Pricing --}}
                    <div class="flex flex-col items-center md:items-end gap-4 min-w-[180px]">
                        <div class="text-center md:text-right">
                            <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest mb-1">Total Amount</p>
                            <p class="text-xl font-black text-[#111318]">IDR {{ number_format($item->total_price, 0, ',', '.') }}</p>
                        </div>
                        
                        @php
                            $statusColors = [
                                'pending'    => 'bg-amber-50 text-amber-600 border-amber-100',
                                'processing' => 'bg-blue-50 text-blue-600 border-blue-100',
                                'shipped'    => 'bg-purple-50 text-purple-600 border-purple-100',
                                'completed'  => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                'cancelled'  => 'bg-red-50 text-red-600 border-red-100'
                            ];
                            $colorClass = $statusColors[$item->status] ?? 'bg-slate-50 text-slate-600 border-slate-100';
                        @endphp
                        
                        <span class="px-6 py-2.5 {{ $colorClass }} border rounded-2xl text-[9px] font-black uppercase tracking-[0.2em]">
                            {{ $item->status }}
                        </span>
                    </div>

                    {{-- Navigation Action --}}
                    <a href="{{ route('checkout.success', $item->id) }}" class="w-16 h-16 bg-[#f8fafc] text-slate-300 rounded-[2rem] flex items-center justify-center hover:bg-[#111318] hover:text-white transition-all shadow-sm group-hover:shadow-lg">
                        <span class="material-symbols-outlined transition-transform group-hover:translate-x-1">arrow_forward_ios</span>
                    </a>
                </div>
                @endforeach
            </div>
        @endif
        
        {{-- Bottom Footer Info --}}
        <div class="mt-20 pt-8 border-t border-slate-200 text-center" data-aos="fade-up">
            <p class="text-[9px] font-bold text-slate-300 uppercase tracking-[0.4em]">Archived Terminal — Securing Your Style Legacy</p>
        </div>
    </div>
</section>

<style>
    /* UI Customizations */
    .material-symbols-outlined { font-size: 20px; }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .bg-white.rounded-\[3rem\] { border-radius: 2.5rem; padding: 2rem; }
    }
</style>
@endsection