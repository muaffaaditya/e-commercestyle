<style>
    /* Sembunyikan elemen Vue sebelum siap agar tidak ada flickering */
    [v-cloak] { display: none !important; }
    
    /* Reset Google Translate agar tidak merusak layout */
    .skiptranslate, .goog-te-banner-frame { display: none !important; }
    body { top: 0 !important; }
    #goog-gt-tt { display: none !important; visibility: hidden !important; }

    /* Mencegah Navbar bergerak/bergetar saat pindah halaman */
    header {
        backface-visibility: hidden;
        transform: translate3d(0,0,0);
        transition: background-color 0.3s ease;
    }

    /* CSS UNTUK TANDA MENU AKTIF (Scroll Spy) */
    .nav-link-item {
        position: relative;
        transition: all 0.3s ease;
    }

    /* Garis bawah tipis sebagai penanda aktif */
    .nav-link-item.active-link {
        color: #1754cf !important;
    }

    .nav-link-item::after {
        content: '';
        position: absolute;
        bottom: -4px;
        left: 0;
        width: 0;
        height: 1.5px;
        background-color: #1754cf;
        transition: width 0.3s ease;
    }

    .nav-link-item.active-link::after {
        width: 100%;
    }
</style>

<header class="sticky top-0 z-[100] w-full glass-nav border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between relative z-[101]">
        
        {{-- Left Navigation --}}
        <div class="flex-1 flex items-center" data-aos="fade-right" data-aos-duration="1000" data-aos-once="true">
            <div class="md:hidden mr-4" @click="toggleMenu">
                <div class="nav-icon" :class="{ 'open': isMobileMenuOpen }">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>

            <nav class="hidden md:flex items-center gap-8">
                {{-- Tambahkan class 'nav-link-item' dan 'data-section' untuk tracking scroll --}}
                <a class="nav-link-item text-[11px] uppercase tracking-[0.2em] font-bold text-gray-800 hover:text-[#1754cf] transition-all no-underline" 
                   href="{{ url('/#') }}" data-section="hero">Home</a>
                <a class="nav-link-item text-[11px] uppercase tracking-[0.2em] font-bold text-gray-800 hover:text-[#1754cf] transition-all no-underline" 
                   href="{{ url('/#new-in') }}" data-section="new-in">New In</a>
                <a class="nav-link-item text-[11px] uppercase tracking-[0.2em] font-bold text-gray-800 hover:text-[#1754cf] transition-all no-underline" 
                   href="{{ url('/#collection') }}" data-section="collection">Collection</a>
                <a class="nav-link-item text-[11px] uppercase tracking-[0.2em] font-bold text-gray-700 hover:text-[#1754cf] transition-all no-underline" 
                   href="{{ url('/#sale') }}" data-section="sale">Sale</a>
            </nav>
        </div>

        {{-- Center Logo --}}
        <div class="flex items-center justify-center" data-aos="fade-down" data-aos-duration="1000" data-aos-once="true">
            <div class="flex items-center gap-2">
                <div class="w-6 h-6 text-[#1754cf]">
                    <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                        <path d="M36.7273 44C33.9891 44 31.6043 39.8386 30.3636 33.69C29.123 39.8386 26.7382 44 24 44C21.2618 44 18.877 39.8386 17.6364 33.69C16.3957 39.8386 14.0109 44 11.2727 44C7.25611 44 4 35.0457 4 24C4 12.9543 7.25611 4 11.2727 4C14.0109 4 16.3957 8.16144 17.6364 14.31C18.877 8.16144 21.2618 4 24 4C26.7382 4 29.123 8.16144 30.3636 14.31C31.6043 8.16144 33.9891 4 36.7273 4C40.7439 4 44 12.9543 44 24C44 35.0457 40.7439 44 36.7273 44Z" fill="currentColor"></path>
                    </svg>
                </div>
                <h1 class="text-xl font-black tracking-tighter m-0 leading-none text-gray-900 uppercase">LUXE</h1>
            </div>
        </div>

        {{-- Right Actions --}}
        <div class="flex-1 flex items-center justify-end gap-3 sm:gap-5" data-aos="fade-left" data-aos-duration="1000" data-aos-once="true">
            <button @click="toggleSearch" class="flex items-center text-gray-800 hover:text-[#1754cf] transition-colors focus:outline-none bg-transparent border-0">
                <span class="material-symbols-outlined text-[22px]">search</span>
            </button>
            
            <a href="{{ route('cart.index') }}" class="relative flex items-center text-gray-800 hover:text-[#1754cf] transition-colors focus:outline-none no-underline">
                <span class="material-symbols-outlined text-[22px]">shopping_bag</span>
                <span v-cloak v-if="cartCount > 0" class="absolute -top-1.5 -right-1.5 bg-[#1754cf] text-white text-[9px] w-4 h-4 rounded-full flex items-center justify-center font-bold shadow-sm">
                    @{{ cartCount }}
                </span>
            </a>

            {{-- Profile Section --}}
            <div class="relative flex items-center">
                <div @click="toggleProfile" class="w-8 h-8 rounded-full overflow-hidden border border-gray-200 shadow-sm cursor-pointer hover:border-[#1754cf] transition-all">
                    @auth
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->first_name . ' ' . Auth::user()->last_name) }}&background=1754cf&color=fff" alt="Profile" class="w-full h-full object-cover">
                    @else
                        <img src="https://ui-avatars.com/api/?name=Guest&background=f3f4f6&color=6b7280" alt="Profile" class="w-full h-full object-cover">
                    @endauth
                </div>
                
                <transition name="v">
                    <div v-cloak v-if="isProfileOpen" class="absolute top-12 right-0 w-64 bg-white shadow-xl rounded-2xl border border-gray-100 overflow-hidden py-2 z-[110]">
                        <div class="px-4 py-3 border-b border-gray-50 bg-gray-50/30">
                            @auth
                                <p class="text-[10px] text-gray-400 font-black uppercase tracking-widest mb-1">Account Active</p>
                                <p class="text-sm font-extrabold text-[#111318] truncate m-0">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
                            @else
                                <a href="{{ route('login') }}" class="block text-sm font-black text-[#1754cf] hover:underline uppercase tracking-widest no-underline">Login Now</a>
                            @endauth
                        </div>

                        <div class="px-2 py-2">
                            <p class="px-3 py-1 text-[9px] font-black text-gray-400 uppercase tracking-[0.2em] m-0">Menu Terminal</p>
                            
                            @auth
                                @php 
                                    $isCircleMember = \Illuminate\Support\Facades\DB::table('subscribers')->where('user_id', Auth::id())->exists(); 
                                @endphp

                                @if($isCircleMember)
                                <a href="{{ route('inner.circle') }}" class="flex items-center gap-3 px-3 py-2 hover:bg-blue-50 rounded-xl transition-all cursor-pointer group no-underline">
                                    <span class="material-symbols-outlined text-[20px] text-[#1754cf]">group</span>
                                    <span class="text-[11px] font-black text-[#1754cf] uppercase tracking-widest">Circle LUXE</span>
                                </a>
                                @endif

                                <a href="{{ route('orders.history') }}" class="flex items-center gap-3 px-3 py-2 hover:bg-gray-50 rounded-xl transition-all cursor-pointer group no-underline">
                                    <span class="material-symbols-outlined text-[20px] text-gray-700">history</span>
                                    <span class="text-[11px] font-bold text-gray-700 uppercase tracking-widest">Purchase History</span>
                                </a>
                            @endauth

                            <div class="flex items-center justify-between px-3 py-2 hover:bg-gray-50 rounded-xl transition-all cursor-pointer group" onclick="doGTranslate()">
                                <div class="flex items-center gap-3 text-gray-700">
                                    <span class="material-symbols-outlined text-[20px]">language</span>
                                    <span class="text-[11px] font-bold uppercase tracking-widest" id="lang-label">
                                        {{ request()->cookie('googtrans') == '/en/id' ? 'Switch to English' : 'Switch to Indonesia' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        @auth
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="w-full text-left block px-4 py-3 text-[11px] font-black uppercase tracking-widest text-red-500 hover:bg-red-50 transition-all border-t border-gray-50 mt-1 bg-transparent border-0 cursor-pointer">
                                    Logout Account
                                </button>
                            </form>
                        @endauth
                    </div>
                </transition>
            </div>
        </div>
    </div>

    {{-- Script Scroll Spy (Detect Section) --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navItems = document.querySelectorAll('.nav-link-item');
            const sections = ['hero', 'new-in', 'collection', 'sale'];

            function updateActiveMenu() {
                let current = '';

                sections.forEach(id => {
                    const section = document.getElementById(id);
                    if (section) {
                        const sectionTop = section.offsetTop;
                        const sectionHeight = section.clientHeight;
                        // Mendeteksi jika scroll berada di tengah layar
                        if (window.pageYOffset >= (sectionTop - 150)) {
                            current = id;
                        }
                    }
                });

                // Jika di paling atas sekali, paksa ke 'Home/Hero'
                if (window.pageYOffset < 100) current = 'hero';

                navItems.forEach(item => {
                    item.classList.remove('active-link');
                    if (item.getAttribute('data-section') === current) {
                        item.classList.add('active-link');
                    }
                });
            }

            window.addEventListener('scroll', updateActiveMenu);
            updateActiveMenu(); // Jalankan sekali saat load
        });
    </script>

    {{-- Sisanya: Google Translate & Search Overlay --}}
    <script>
        function doGTranslate() {
            const currentPair = getCookie('googtrans');
            if (currentPair === '/en/id') {
                document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
                document.cookie = "googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; domain=" + document.domain + "; path=/;";
            } else {
                document.cookie = "googtrans=/en/id; path=/";
                document.cookie = "googtrans=/en/id; domain=" + document.domain + "; path=/";
            }
            location.reload(); 
        }
        function getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        }
        function googleTranslateElementInit() {
            new google.translate.TranslateElement({
                pageLanguage: 'en', includedLanguages: 'en,id', autoDisplay: false
            }, 'google_translate_element');
        }
    </script>
    <div id="google_translate_element" style="display:none"></div>
    <script src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

    <transition name="v">
        <div v-cloak v-if="isSearchOpen" class="absolute top-16 w-full left-0 z-[90] glass-nav border-t border-gray-100 shadow-xl">
            <div class="max-w-7xl mx-auto px-6 py-8">
                <form action="{{ route('products.search') }}" method="GET" class="relative flex items-center border-b-2 border-gray-200 focus-within:border-[#1754cf] transition-all pb-2">
                    <span class="material-symbols-outlined text-gray-400 mr-3">search</span>
                    <input type="text" name="q" placeholder="Search luxury products..." class="w-full bg-transparent border-none outline-none text-lg font-medium text-gray-800" autofocus>
                    <button type="submit" class="bg-[#1754cf] text-white px-4 py-1.5 rounded-full text-[10px] font-bold uppercase tracking-widest hover:bg-[#111318] transition-all border-0">Search</button>
                </form>
            </div>
        </div>
    </transition>

    <transition name="v">
        <div v-cloak v-if="isMobileMenuOpen" class="md:hidden glass-nav border-t border-gray-100 absolute top-16 w-full left-0 z-[90] overflow-hidden shadow-2xl">
            <div class="flex flex-col p-6 gap-6">
                <a @click="toggleMenu" class="text-xs uppercase tracking-[0.2em] font-extrabold text-gray-800 border-l-2 border-transparent hover:border-[#1754cf] pl-4 no-underline" href="{{ url('/#') }}">Home</a>
                <a @click="toggleMenu" class="text-xs uppercase tracking-[0.2em] font-extrabold text-gray-800 border-l-2 border-transparent hover:border-[#1754cf] pl-4 no-underline" href="{{ url('/#new-in') }}">New In</a>
                <a @click="toggleMenu" class="text-xs uppercase tracking-[0.2em] font-extrabold text-gray-800 border-l-2 border-transparent hover:border-[#1754cf] pl-4 no-underline" href="{{ url('/#collection') }}">Collection</a>
                <a @click="toggleMenu" class="text-xs uppercase tracking-[0.2em] font-extrabold text-gray-800 border-l-2 border-transparent hover:border-[#1754cf] pl-4 no-underline" href="{{ url('/#sale') }}">Sale</a>
            </div>
        </div>
    </transition>
</header>