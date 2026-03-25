@extends('layouts.app')

@section('title', 'Privacy Policy | LUXE Fashion')

@section('content')
<section class="pt-10 pb-24 bg-[#FDFBF7]">
    <div class="max-w-4xl mx-auto px-6">
        <div class="text-center mb-10" data-aos="fade-up">
            <span class="text-[10px] uppercase tracking-[0.4em] font-black text-[#1754cf] mb-3 block">Fashion Confidential</span>
            <h2 class="text-4xl md:text-6xl font-light tracking-tighter text-[#111318]">
                Privacy <br>
                <span class="italic font-extrabold text-[#111318]">Policy</span>
            </h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            {{-- Point 01: Lifestyle Data --}}
            <div class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-gray-100 hover:border-[#1754cf]/30 transition-all" data-aos="fade-right">
                <div class="text-[10px] font-bold uppercase tracking-widest text-[#1754cf] mb-4">01. Curation</div>
                <h4 class="text-xl font-bold mb-4 text-[#111318]">Style Intelligence</h4>
                <p class="text-gray-500 font-light leading-relaxed text-sm">
                    We collect essential profile data and shopping preferences to curate a personalized fashion feed that resonates with your unique aesthetic and size requirements.
                </p>
            </div>

            {{-- Point 02: Secure Access --}}
            <div class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-gray-100 hover:border-[#1754cf]/30 transition-all" data-aos="fade-left">
                <div class="text-[10px] font-bold uppercase tracking-widest text-[#1754cf] mb-4">02. Encryption</div>
                <h4 class="text-xl font-bold mb-4 text-[#111318]">Vault-Grade Security</h4>
                <p class="text-gray-500 font-light leading-relaxed text-sm">
                    Your credentials and payment information are protected by advanced SSL encryption. Using secure social auth ensures your LUXE ID remains private and fortified.
                </p>
            </div>
        </div>

        {{-- Bottom Statement --}}
        <div class="mt-8 bg-[#111318] rounded-[2.5rem] p-12 text-white text-center shadow-xl shadow-black/10" data-aos="zoom-in">
            <h3 class="text-xl font-bold mb-4">Our Integrity Promise</h3>
            <p class="text-gray-400 font-light max-w-lg mx-auto leading-relaxed text-sm">
                At LUXE, we believe your data is as valuable as your style. We never disclose your personal trends or information to third-party retailers. Your privacy is the foundation of our luxury service.
            </p>
            <div class="mt-8 pt-8 border-t border-white/5 flex flex-col md:flex-row justify-center items-center gap-4 md:gap-12">
                <div class="text-[10px] uppercase tracking-[0.2em] font-bold text-[#1754cf]">Effective: February 2026</div>
                <a href="{{ route('support.faq') }}" class="text-[10px] uppercase tracking-[0.2em] font-bold text-white hover:text-[#1754cf] transition-colors underline decoration-[#1754cf] underline-offset-4">Learn More</a>
            </div>
        </div>
    </div>
</section>
@endsection