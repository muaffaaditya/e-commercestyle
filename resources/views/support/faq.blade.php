@extends('layouts.app')

@section('title', 'FAQ | Fashion Support')

@section('content')
<section class="pt-10 pb-24 bg-[#FDFBF7]">
    <div class="max-w-3xl mx-auto px-6">
        <div class="text-center mb-10" data-aos="fade-up">
            <span class="text-[10px] uppercase tracking-[0.4em] font-black text-[#1754cf] mb-3 block">Style Concierge</span>
            <h2 class="text-4xl md:text-6xl font-light tracking-tighter text-[#111318]">
                Frequently Asked <br>
                <span class="italic font-extrabold">Questions</span>
            </h2>
        </div>

        <div class="space-y-4">
            {{-- Question 1 --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:border-[#1754cf]/30 transition-colors" data-aos="fade-up">
                <h4 class="font-bold text-lg mb-2 text-[#111318]">How do I find the right size?</h4>
                <p class="text-gray-500 font-light leading-relaxed text-sm md:text-base">
                    Every product page includes a detailed "Size Guide." We recommend measuring yourself and comparing it to our charts. If you're between sizes, we generally suggest sizing up for a more relaxed fit.
                </p>
            </div>

            {{-- Question 2 --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:border-[#1754cf]/30 transition-colors" data-aos="fade-up" data-aos-delay="100">
                <h4 class="font-bold text-lg mb-2 text-[#111318]">What is your return policy for apparel?</h4>
                <p class="text-gray-500 font-light leading-relaxed text-sm md:text-base">
                    We offer a 14-day return window. Items must be unworn, unwashed, and still have the original LUXE tags attached. Please note that for hygiene reasons, intimates and swimwear cannot be returned.
                </p>
            </div>

            {{-- Question 3 --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:border-[#1754cf]/30 transition-colors" data-aos="fade-up" data-aos-delay="200">
                <h4 class="font-bold text-lg mb-2 text-[#111318]">How should I care for my LUXE garments?</h4>
                <p class="text-gray-500 font-light leading-relaxed text-sm md:text-base">
                    To maintain the quality of your fashion pieces, always check the internal care label. We recommend cold washing for organic cottons and professional dry cleaning for our silk and wool-blend collections.
                </p>
            </div>
            
            {{-- Question 4 --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:border-[#1754cf]/30 transition-colors" data-aos="fade-up" data-aos-delay="300">
                <h4 class="font-bold text-lg mb-2 text-[#111318]">Can I cancel an order from a limited drop?</h4>
                <p class="text-gray-500 font-light leading-relaxed text-sm md:text-base">
                    Due to the high demand for our limited runway collections, cancellations can only be requested within 30 minutes of purchase. Once an order enters the processing stage, it cannot be modified.
                </p>
            </div>

            {{-- Question 5 --}}
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:border-[#1754cf]/30 transition-colors" data-aos="fade-up" data-aos-delay="350">
                <h4 class="font-bold text-lg mb-2 text-[#111318]">Do you restock "Sold Out" items?</h4>
                <p class="text-gray-500 font-light leading-relaxed text-sm md:text-base">
                    Some core essentials are restocked regularly, while seasonal runway pieces are limited edition. You can sign up for "Back in Stock" notifications on the specific product page to be alerted if it returns.
                </p>
            </div>
        </div>

        <div class="mt-16 text-center" data-aos="fade-up" data-aos-delay="400">
            <p class="text-gray-400 text-sm font-light mb-4">Need personal styling advice or support?</p>
            <a href="https://wa.me/6281234567890?text=Hello%20LUXE%20Fashion%20Support,%20I%20have%20a%20question%20regarding..." 
               target="_blank"
               class="inline-flex items-center gap-2 text-[#111318] font-bold border-b-2 border-[#111318] pb-1 hover:text-[#1754cf] hover:border-[#1754cf] transition-all uppercase tracking-widest text-[10px]">
                <span>Chat with our Stylist</span>
                <span class="material-symbols-outlined text-[14px]">chat</span>
            </a>
        </div>
    </div>
</section>
@endsection