<footer class="bg-[#111318] text-white pt-24 pb-12 border-t border-white/5 w-full mt-auto relative z-10">
    <div class="max-w-7xl mx-auto px-6">
        
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12 mb-20">
            
            <div class="md:col-span-12 text-center mb-16">
                <div class="flex items-center justify-center gap-3 mb-8">
                    <div class="w-10 h-10 text-[#1754cf]">
                        <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                            <path d="M36.7273 44C33.9891 44 31.6043 39.8386 30.3636 33.69C29.123 39.8386 26.7382 44 24 44C21.2618 44 18.877 39.8386 17.6364 33.69C16.3957 39.8386 14.0109 44 11.2727 44C7.25611 44 4 35.0457 4 24C4 12.9543 7.25611 4 11.2727 4C14.0109 4 16.3957 8.16144 17.6364 14.31C18.877 8.16144 21.2618 4 24 4C26.7382 4 29.123 8.16144 30.3636 14.31C31.6043 8.16144 33.9891 4 36.7273 4C40.7439 4 44 12.9543 44 24C44 35.0457 40.7439 44 36.7273 44Z" fill="currentColor"></path>
                        </svg>
                    </div>
                    <h2 class="text-4xl font-black tracking-tighter m-0 uppercase text-white">LUXE</h2>
                </div>
                <p class="text-gray-400 text-lg md:text-xl leading-relaxed max-w-2xl mx-auto font-light italic">
                    Improving the quality of everyday life through quality fashion.
                </p>
            </div>

            <div class="md:col-span-12">
                <div class="grid grid-cols-2 md:grid-cols-3 gap-12 text-center">
                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-[0.25em] text-white mb-8">Shop</h4>
                        <ul class="flex flex-col gap-5 p-0 list-none">
                            <li><a href="{{ route('products.search') }}" class="text-gray-400 hover:text-[#1754cf] transition-colors text-sm md:text-base">All Products</a></li>
                            <li><a href="{{ url('/#new-in') }}" class="text-gray-400 hover:text-[#1754cf] transition-colors text-sm md:text-base">New In</a></li>
                            <li><a href="{{ url('/#sale') }}" class="text-gray-400 hover:text-[#1754cf] transition-colors text-sm md:text-base">Sale</a></li>            
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-xs font-bold uppercase tracking-[0.25em] text-white mb-8">Support</h4>
                        <ul class="flex flex-col gap-5 p-0 list-none">
                            <li><a href="{{ route('support.team') }}" class="text-gray-400 hover:text-[#1754cf] transition-colors text-sm md:text-base">Team</a></li>
                            <li><a href="{{ route('support.faq') }}" class="text-gray-400 hover:text-[#1754cf] transition-colors text-sm md:text-base">FAQ</a></li>
                            <li><a href="{{ route('support.shipping') }}" class="text-gray-400 hover:text-[#1754cf] transition-colors text-sm md:text-base">Shipping</a></li>
                            <li><a href="{{ route('support.returns') }}" class="text-gray-400 hover:text-[#1754cf] transition-colors text-sm md:text-base">Returns</a></li>
                        </ul>
                    </div>

                    <div class="col-span-2 md:col-span-1">
                        <h4 class="text-xs font-bold uppercase tracking-[0.25em] text-white mb-8">Follow Us</h4>
                        <div class="flex justify-center md:flex-col gap-6">
                            <a href="#" class="text-gray-400 hover:text-[#1754cf] transition-colors text-sm md:text-base">Instagram</a>
                            <a href="#" class="text-gray-400 hover:text-[#1754cf] transition-colors text-sm md:text-base">Twitter</a>
                            <a href="#" class="text-gray-400 hover:text-[#1754cf] transition-colors text-sm md:text-base">Facebook</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-12 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-8 text-center">
            <p class="text-gray-500 text-sm tracking-wide m-0">
                © 2026 LUXE Premium Fashion. All rights reserved.
            </p>
            <div class="flex gap-8">
                <a href="{{ route('support.privacy') }}" class="text-gray-500 hover:text-white text-sm transition-colors">Privacy Policy</a>
                <a href="{{ route('support.terms') }}" class="text-gray-500 hover:text-white text-sm transition-colors">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>