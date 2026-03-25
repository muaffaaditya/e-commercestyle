@extends('layouts.app')

@section('title', 'Inner Circle | LUXE')

@section('content')
<section class="min-h-screen bg-[#FDFBF7] pt-10 pb-24 flex items-center"> {{-- Background premium cream --}}
    <div class="max-w-7xl mx-auto px-6 w-full">
        
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-20 items-center">
            
            {{-- SISI KIRI: HEADER SECTION (30% Width on Large Screens) --}}
            <div class="lg:col-span-5 text-center lg:text-left" data-aos="fade-right">
                <span class="text-[10px] uppercase tracking-[0.4em] font-black text-[#1754cf] mb-4 block">Exclusive Access</span>
                <h2 class="text-6xl md:text-8xl font-light tracking-tighter text-[#111318] leading-none mb-6">
                    Inner <br>
                    <span class="italic font-extrabold text-[#111318]">Circle</span>
                </h2>
                <div class="w-20 h-1 bg-[#1754cf] mb-8 mx-auto lg:mx-0"></div>
                <p class="text-slate-400 font-medium max-w-md mx-auto lg:mx-0 italic text-sm leading-relaxed mb-8">
                    Secure broadcast terminal for trend updates, early drops, and artisanal insights curated specifically for the LUXE collective.
                </p>
                
                {{-- Compliance Info --}}
                <div class="hidden lg:block pt-8 border-t border-slate-200/60">
                    <p class="text-[9px] font-bold text-slate-300 uppercase tracking-[0.2em]">LUXE Global Compliance</p>
                    <p class="text-[8px] text-slate-400 font-medium mt-1">Ref: IC-BROADCAST-2026</p>
                </div>
            </div>

            {{-- SISI KANAN: ROOM CHAT CONTAINER (70% Width on Large Screens) --}}
            <div class="lg:col-span-7" data-aos="zoom-in" data-aos-delay="200">
                <div class="bg-white rounded-[3.5rem] shadow-2xl shadow-slate-200/50 border border-gray-100 overflow-hidden flex flex-col h-[75vh] relative">
                    
                    {{-- Header Chat Terminal --}}
                    <div class="p-8 border-b border-gray-50 flex items-center justify-between bg-gray-50/30">
                        <div class="flex items-center gap-5">
                            <div class="w-12 h-12 bg-[#1754cf] rounded-2xl flex items-center justify-center text-white shadow-lg shadow-blue-100">
                                <span class="material-symbols-outlined text-2xl">verified</span>
                            </div>
                            <div class="text-left">
                                <h3 class="text-sm font-black text-[#111318] uppercase tracking-widest leading-none mb-1">LUXE Broadcast</h3>
                                <p class="text-[9px] text-emerald-500 font-bold uppercase tracking-widest flex items-center gap-2">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                                    Connection Active
                                </p>
                            </div>
                        </div>
                        <span class="text-[10px] font-black text-slate-300 uppercase tracking-widest">Read-Only</span>
                    </div>

                    {{-- Body Chat (Read Only) --}}
                    <div class="flex-1 overflow-y-auto p-10 space-y-8 no-scrollbar bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] bg-fixed opacity-95">
                        @forelse($messages as $msg)
                        <div class="flex flex-col items-start max-w-[85%] group">
                            {{-- Meta Info --}}
                            <div class="flex items-center gap-3 mb-2 ml-3">
                                <span class="text-[9px] font-black text-[#1754cf] uppercase tracking-widest">{{ $msg->admin_name }}</span>
                                <span class="text-[8px] font-bold text-slate-300 uppercase tracking-tighter">{{ date('M d • H:i', strtotime($msg->created_at)) }}</span>
                            </div>
                            
                            {{-- Bubble Message --}}
                            <div class="bg-[#f8fafc] p-6 rounded-[2.2rem] rounded-tl-none border border-slate-50 shadow-sm transition-all group-hover:shadow-md group-hover:bg-white group-hover:border-blue-100 text-left">
                                <p class="text-sm text-[#111318] leading-relaxed font-medium">"{{ $msg->message }}"</p>
                            </div>
                        </div>
                        @empty
                        <div class="h-full flex flex-col items-center justify-center text-center opacity-30 grayscale">
                            <span class="material-symbols-outlined text-6xl mb-4 text-slate-200">history_toggle_off</span>
                            <p class="text-[10px] font-black uppercase tracking-[0.3em]">Standby for Transmission</p>
                        </div>
                        @endforelse
                    </div>

                    {{-- Footer Chat (Terminal Lock) --}}
                    <div class="p-8 bg-gray-50/50 border-t border-gray-50 flex items-center justify-center gap-3">
                        <span class="material-symbols-outlined text-slate-300 text-sm">lock</span>
                        <p class="text-[9px] font-black text-slate-400 uppercase tracking-[0.3em] italic">
                            Secured LUXE Terminal — Receiving Mode Only
                        </p>
                    </div>
                </div>

                {{-- Mobile only info --}}
                <div class="mt-8 text-center lg:hidden" data-aos="fade-up">
                    <p class="text-[9px] font-bold text-slate-300 uppercase tracking-[0.2em]">Revised: February 2026 • IC-GLOBAL</p>
                </div>
            </div>

        </div>
    </div>
</section>

<style>
    /* UI Refinements */
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    
    /* Smooth Scroll to bottom if needed */
    .flex-1 { scroll-behavior: smooth; }

    /* Custom Responsive Heading */
    @media (min-width: 1024px) {
        h2 { font-size: clamp(4rem, 8vw, 6rem); }
    }
</style>

<script>
    // Memastikan scroll berada di pesan paling bawah saat halaman dibuka
    window.onload = function() {
        const chatBody = document.querySelector('.flex-1.overflow-y-auto');
        if(chatBody) {
            chatBody.scrollTop = chatBody.scrollHeight;
        }
    }
</script>
@endsection