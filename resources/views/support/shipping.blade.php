@extends('layouts.app')

@section('title', 'Shipping Information | LUXE Fashion')

@section('content')
<section class="pt-10 pb-24 bg-[#FDFBF7]">
    <div class="max-w-4xl mx-auto px-6">
        <div class="text-center mb-10" data-aos="fade-up">
            <span class="text-[10px] uppercase tracking-[0.4em] font-black text-[#1754cf] mb-3 block">Global Logistics</span>
            <h2 class="text-4xl md:text-6xl font-light tracking-tighter text-[#111318]">
                Shipping <br>
                <span class="italic font-extrabold text-[#111318]">Information</span>
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            {{-- Box 1: Timeline --}}
            <div class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-gray-100 hover:border-[#1754cf]/30 transition-all" data-aos="fade-right">
                <h4 class="text-xl font-bold mb-6 text-[#111318]">Delivery Timelines</h4>
                <ul class="space-y-4 p-0 m-0 list-none">
                    <li class="flex flex-col border-b border-gray-50 pb-4">
                        <span class="text-[10px] font-bold uppercase tracking-widest text-[#1754cf]">Standard At-Home</span>
                        <p class="text-gray-500 font-light mt-1 text-sm">3 - 5 Business Days</p>
                    </li>
                    <li class="flex flex-col border-b border-gray-0 pb-4">
                        <span class="text-[10px] font-bold uppercase tracking-widest text-[#1754cf]">Priority Express</span>
                        <p class="text-gray-500 font-light mt-1 text-sm">1 - 2 Business Days</p>
                    </li>
                    <li class="flex flex-col">
                        <span class="text-[10px] font-bold uppercase tracking-widest text-[#1754cf]">Global Runway Access</span>
                        <p class="text-gray-500 font-light mt-1 text-sm">7 - 14 Business Days</p>
                    </li>
                </ul>
            </div>

            {{-- Box 2: Rates --}}
            <div class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-gray-100 hover:border-[#1754cf]/30 transition-all" data-aos="fade-left">
                <h4 class="text-xl font-bold mb-6 text-[#111318]">Curation Rates</h4>
                <div class="space-y-6">
                    <div class="flex justify-between items-center border-b border-gray-50 pb-4">
                        <span class="text-gray-600 font-light text-sm">Domestic Delivery</span>
                        <span class="font-bold text-[#111318] text-sm">Free</span>
                    </div>
                    <div class="flex justify-between items-center border-b border-gray-50 pb-4">
                        <span class="text-gray-600 font-light text-sm">Orders over Rp 2.000.000</span>
                        <span class="font-bold text-[#1754cf] text-sm">Complimentary</span>
                    </div>
                    <p class="text-[11px] text-gray-400 leading-relaxed italic">
                        *International duties and taxes are calculated at checkout based on your specific global destination.
                    </p>
                </div>
            </div>
        </div>

        {{-- Tracking Section --}}
        <div class="mt-12 bg-[#111318] rounded-[2.5rem] p-10 text-white text-center shadow-xl shadow-black/10" data-aos="zoom-in">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-[#1754cf] rounded-full mb-6">
                <span class="material-symbols-outlined text-white text-xl">local_shipping</span>
            </div>
            <h4 class="text-2xl font-bold mb-4 tracking-tight">Track Your Style Journey</h4>
            <p class="text-gray-400 font-light mb-8 max-w-lg mx-auto leading-relaxed text-sm">
                Once your LUXE garments are dispatched from our studio, you will receive a confirmation email with your signature tracking ID.
            </p>
            
            {{-- PERBAIKAN: Tombol sekarang tetap Biru/Indigo saat diklik/hover --}}
            <button class="bg-[#1754cf] text-white px-12 py-4 rounded-full font-bold tracking-widest text-[10px] hover:bg-[#1754cf]/90 hover:scale-105 transition-all active:scale-95 uppercase shadow-lg shadow-[#1754cf]/20">
                Track My Order
            </button>
        </div>
    </div>
</section>
@endsection