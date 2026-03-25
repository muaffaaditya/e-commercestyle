@extends('layouts.app')

@section('title', 'Terms of Service | LUXE Fashion')

@section('content')
<section class="pt-10 pb-24 bg-[#FDFBF7]">
    <div class="max-w-4xl mx-auto px-6">
        <div class="text-center mb-10" data-aos="fade-up">
            <span class="text-[10px] uppercase tracking-[0.4em] font-black text-[#1754cf] mb-3 block">User Agreement</span>
            <h2 class="text-4xl md:text-6xl font-light tracking-tighter text-[#111318]">
                Terms of <br>
                <span class="italic font-extrabold text-[#111318]">Service</span>
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Point 01: Intellectual Property --}}
            <div class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-gray-100 hover:border-[#1754cf]/30 transition-all" data-aos="fade-right">
                <div class="text-[10px] font-bold uppercase tracking-widest text-[#1754cf] mb-4">01. Ownership</div>
                <h4 class="text-xl font-bold mb-4 text-[#111318]">Design License</h4>
                <p class="text-gray-500 font-light leading-relaxed text-sm">
                    All visual content, garment designs, and artisanal imagery on LUXE are exclusive intellectual property. Use of materials is restricted to personal, non-commercial style inspiration only.
                </p>
            </div>

            {{-- Point 02: Product Accuracy --}}
            <div class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-gray-100 hover:border-[#1754cf]/30 transition-all" data-aos="fade-left">
                <div class="text-[10px] font-bold uppercase tracking-widest text-[#1754cf] mb-4">02. Curation</div>
                <h4 class="text-xl font-bold mb-4 text-[#111318]">Style Disclaimer</h4>
                <p class="text-gray-500 font-light leading-relaxed text-sm">
                    We strive for digital accuracy; however, fabric textures and colors may vary slightly due to studio lighting or display calibrations. All fashion items are provided on an 'as-curated' basis.
                </p>
            </div>
        </div>

        {{-- Bottom Summary Card --}}
        <div class="mt-8 bg-[#111318] rounded-[2.5rem] p-12 text-white text-center shadow-xl shadow-black/10" data-aos="zoom-in">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-white/5 rounded-full mb-6">
                <span class="material-symbols-outlined text-[#1754cf] text-xl">gavel</span>
            </div>
            <h4 class="text-2xl font-bold mb-4 tracking-tight">Member Responsibilities</h4>
            <p class="text-gray-400 font-light mb-8 max-w-lg mx-auto leading-relaxed text-sm">
                By entering the LUXE terminal, you commit to ethical engagement. Members are responsible for securing their account credentials and adhering to our fair-trade purchasing policies.
            </p>
            <div class="pt-8 border-t border-white/5 flex flex-col md:flex-row justify-center items-center gap-6 md:gap-12">
                <div class="text-[10px] uppercase tracking-[0.2em] font-bold text-[#1754cf]">Revised: February 2026</div>
                <div class="text-[10px] uppercase tracking-[0.2em] font-bold text-gray-500">LUXE Global Compliance</div>
            </div>
        </div>
    </div>
</section>
@endsection