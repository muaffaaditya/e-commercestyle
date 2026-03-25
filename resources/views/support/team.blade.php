@extends('layouts.app')

@section('title', 'Support Team | LUXE Fashion')

@section('content')
<section class="pt-10 pb-24 bg-[#FDFBF7]">
    <div class="max-w-4xl mx-auto px-6">
        <div class="text-center mb-16" data-aos="fade-up">
            <span class="text-[10px] uppercase tracking-[0.4em] font-black text-[#1754cf] mb-3 block">Fashion Concierge</span>
            <h2 class="text-4xl md:text-6xl font-light tracking-tighter text-[#111318]">
                Support <br>
                <span class="italic font-extrabold text-[#111318]">Team</span>
            </h2>
            <p class="mt-6 text-gray-500 font-light max-w-lg mx-auto leading-relaxed text-sm md:text-base">
                We are dedicated to perfecting your wardrobe. Connect with our specialists for styling advice, order inquiries, or size consultations.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Email Support --}}
            <div class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-gray-100 hover:border-[#1754cf]/30 transition-all group" data-aos="fade-right">
                <div class="w-12 h-12 bg-[#1754cf]/5 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-[#1754cf] transition-colors">
                    <span class="material-symbols-outlined text-[#1754cf] group-hover:text-white">mail</span>
                </div>
                <div class="text-[10px] font-bold uppercase tracking-widest text-[#1754cf] mb-2">Electronic Mail</div>
                <h4 class="text-xl font-bold mb-4 text-[#111318]">Style Correspondence</h4>
                <p class="text-gray-500 font-light leading-relaxed mb-6 text-sm">
                    Reach out for detailed inquiries. Our team typically responds with professional advice within 24 business hours.
                </p>
                <a href="mailto:support@luxe.com" class="text-xs font-bold text-[#1754cf] uppercase tracking-widest hover:underline italic">support@luxe.com</a>
            </div>

            {{-- WhatsApp Support --}}
            <div class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-gray-100 hover:border-[#1754cf]/30 transition-all group" data-aos="fade-left">
                <div class="w-12 h-12 bg-[#1754cf]/5 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-[#1754cf] transition-colors">
                    <span class="material-symbols-outlined text-[#1754cf] group-hover:text-white">chat_bubble</span>
                </div>
                <div class="text-[10px] font-bold uppercase tracking-widest text-[#1754cf] mb-2">Instant Styling</div>
                <h4 class="text-xl font-bold mb-4 text-[#111318]">Live Concierge</h4>
                <p class="text-gray-500 font-light leading-relaxed mb-6 text-sm">
                    Need an immediate size check or styling tip? Consult instantly with our dedicated fashion specialists via WhatsApp.
                </p>
                <a href="https://wa.me/6281249771960" target="_blank" class="text-xs font-bold text-[#1754cf] uppercase tracking-widest hover:underline italic">+62 812-4977-1960</a>
            </div>
        </div>

        {{-- Service Hours --}}
        <div class="mt-8 bg-[#111318] rounded-[2.5rem] p-10 text-white text-center shadow-xl shadow-black/10 transition-transform hover:scale-[1.01]" data-aos="zoom-in">
            <div class="inline-flex items-center gap-2 mb-4 opacity-60">
                <span class="material-symbols-outlined text-sm">schedule</span>
                <span class="text-[10px] font-bold uppercase tracking-[0.2em]">Curation Hours</span>
            </div>
            <h4 class="text-2xl font-bold mb-4">Service Availability</h4>
            <p class="text-gray-400 font-light mb-0 max-w-lg mx-auto leading-relaxed text-sm">
                Monday — Friday: 09:00 - 18:00 WIB<br>
                Saturday — Sunday: 10:00 - 15:00 WIB
            </p>
        </div>

        {{-- Back Link --}}
        <div class="mt-12 text-center" data-aos="fade-up">
            <a href="{{ url('/') }}" class="text-[11px] font-bold text-gray-400 hover:text-[#1754cf] uppercase tracking-widest transition-all flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-sm">arrow_back</span>
                Back to Home
            </a>
        </div>
    </div>
</section>
@endsection