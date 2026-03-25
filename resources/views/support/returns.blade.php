@extends('layouts.app')

@section('title', 'Returns & Exchanges | LUXE Fashion')

@section('content')
<section class="pt-10 pb-24 bg-[#FDFBF7]">
    <div class="max-w-4xl mx-auto px-6">
        <div class="text-center mb-10" data-aos="fade-up">
            <span class="text-[10px] uppercase tracking-[0.4em] font-black text-[#1754cf] mb-3 block">Premium Service</span>
            <h2 class="text-4xl md:text-6xl font-light tracking-tighter text-[#111318]">
                Returns & <br>
                <span class="italic font-extrabold text-[#111318]">Exchanges</span>
            </h2>
        </div>

        <div class="space-y-8">
            {{-- Policy Highlight Card --}}
            <div class="bg-white rounded-[2.5rem] p-8 md:p-12 shadow-sm border border-gray-100" data-aos="fade-up">
                <div class="flex flex-col md:flex-row gap-8 items-start">
                    <div class="w-16 h-16 bg-[#f6f6f8] rounded-full flex items-center justify-center shrink-0">
                        <span class="material-symbols-outlined text-[#1754cf] text-3xl">checkroom</span>
                    </div>
                    <div>
                        <h4 class="text-2xl font-bold mb-4 text-[#111318]">Garment Return Policy</h4>
                        <p class="text-gray-500 font-light leading-relaxed mb-6">
                            Ensuring you find the perfect fit is our priority. If your new attire isn't quite right, you have <strong class="text-[#111318]">14 calendar days</strong> from the delivery date to request a return or exchange.
                        </p>
                        <ul class="space-y-3 p-0 m-0 list-none">
                            <li class="flex items-center gap-3 text-sm text-gray-600 font-light">
                                <span class="w-1.5 h-1.5 bg-[#1754cf] rounded-full"></span> 
                                Items must be unworn, unwashed, and in original condition.
                            </li>
                            <li class="flex items-center gap-3 text-sm text-gray-600 font-light">
                                <span class="w-1.5 h-1.5 bg-[#1754cf] rounded-full"></span> 
                                All LUXE security tags and brand labels must remain attached.
                            </li>
                            <li class="flex items-center gap-3 text-sm text-gray-600 font-light">
                                <span class="w-1.5 h-1.5 bg-[#1754cf] rounded-full"></span> 
                                Footwear must be returned with the original branded box.
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            {{-- Process Steps --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-8 rounded-[2rem] border border-gray-100 text-center hover:border-[#1754cf]/30 transition-all shadow-sm" data-aos="fade-up" data-aos-delay="100">
                    <span class="text-3xl font-black text-[#1754cf]/20 block mb-4">01.</span>
                    <h5 class="font-bold mb-2 text-[#111318]">Register</h5>
                    <p class="text-xs text-gray-400 font-light leading-relaxed">Notify our Style Concierge to start your return authorization.</p>
                </div>
                <div class="bg-white p-8 rounded-[2rem] border border-gray-100 text-center hover:border-[#1754cf]/30 transition-all shadow-sm" data-aos="fade-up" data-aos-delay="200">
                    <span class="text-3xl font-black text-[#1754cf]/20 block mb-4">02.</span>
                    <h5 class="font-bold mb-2 text-[#111318]">Package</h5>
                    <p class="text-xs text-gray-400 font-light leading-relaxed">Place items back in their original LUXE packaging for protection.</p>
                </div>
                <div class="bg-white p-8 rounded-[2rem] border border-gray-100 text-center hover:border-[#1754cf]/30 transition-all shadow-sm" data-aos="fade-up" data-aos-delay="300">
                    <span class="text-3xl font-black text-[#1754cf]/20 block mb-4">03.</span>
                    <h5 class="font-bold mb-2 text-[#111318]">Credit</h5>
                    <p class="text-xs text-gray-400 font-light leading-relaxed">Refunds are processed to your original payment within 5-7 days.</p>
                </div>
            </div>
        </div>

        {{-- Call to Action --}}
        <div class="mt-16 text-center" data-aos="fade-up">
            <p class="text-gray-400 text-sm font-light mb-6">Need help with sizing before an exchange?</p>
            <a href="https://wa.me/6281234567890?text=Hello%20LUXE,%20I%20need%20assistance%20regarding%20a%20return%20or%20exchange%20for%20my%20order..." 
               target="_blank"
               class="inline-flex items-center gap-2 bg-[#111318] text-white px-12 py-4 rounded-full font-bold tracking-widest text-[10px] hover:bg-[#1754cf] transition-all shadow-lg hover:shadow-[#1754cf]/20 uppercase">
                <span>Contact Style Support</span>
                <span class="material-symbols-outlined text-[16px]">support_agent</span>
            </a>
        </div>
    </div>
</section>
@endsection