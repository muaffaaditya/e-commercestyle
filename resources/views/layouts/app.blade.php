<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>LUXE | @yield('title', 'Premium Store')</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@300;400&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700;800&display=swap" rel="stylesheet"/>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        /* Global Reset & Smooth Scroll */
        :root { scroll-behavior: smooth; }
        
        body { 
            font-family: 'Manrope', sans-serif;
            background-color: #f6f6f8; 
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            width: 100%;
        }

        a { text-decoration: none; color: inherit; }
        
        /* Navbar Sticky Fix */
        header { 
            position: sticky;
            top: 0;
            z-index: 1000 !important; 
            width: 100%;
        }

        .glass-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        }

        /* Vue Transitions */
        .v-enter-active, .v-leave-active {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .v-enter-from, .v-leave-to {
            opacity: 0;
            transform: translateY(-10px);
        }

        /* Hamburger Animation */
        .nav-icon { width: 24px; height: 18px; position: relative; cursor: pointer; }
        .nav-icon span {
            display: block; position: absolute; height: 2px; width: 100%;
            background: #111318; border-radius: 9px; left: 0; transition: .25s ease-in-out;
        }
        .nav-icon span:nth-child(1) { top: 0px; }
        .nav-icon span:nth-child(2) { top: 8px; }
        .nav-icon span:nth-child(3) { top: 16px; }
        .nav-icon.open span:nth-child(1) { top: 8px; transform: rotate(135deg); }
        .nav-icon.open span:nth-child(2) { opacity: 0; left: -40px; }
        .nav-icon.open span:nth-child(3) { top: 8px; transform: rotate(-135deg); }

        /* AOS Pointer Events Fix */
        [data-aos] { pointer-events: none; }
        .aos-animate { pointer-events: auto; }

        /* Prevents flickering */
        [v-cloak] { display: none !important; }

        /* --- GLOBAL TRANSITION: ZOOM & FADE --- */
        .product-card-slideshow img {
            transition: opacity 1s ease-in-out, transform 1s cubic-bezier(0.4, 0, 0.2, 1) !important;
        }
        .product-card-slideshow:hover img {
            transform: scale(1.1);
        }

        /* Aesthetic UX Styles */
        .attr-btn.active { 
            border-color: #1754cf !important; 
            background-color: #f0f7ff !important; 
            color: #1754cf !important; 
            transform: translateY(-3px); 
            box-shadow: 0 10px 20px rgba(23,84,207,0.1); 
        }

        .slider-dot.active-dot { 
            background-color: #1754cf !important; 
            width: 24px !important; 
        }

        /* Reset Google Translate agar tidak merusak layout */
        .skiptranslate, .goog-te-banner-frame { display: none !important; }
        body { top: 0 !important; }
        #goog-gt-tt { display: none !important; visibility: hidden !important; }

        header {
            backface-visibility: hidden;
            transform: translate3d(0,0,0);
            transition: background-color 0.3s ease;
        }

        /* --- CSS UNTUK TANDA MENU AKTIF (SCROLL SPY) --- */
        .nav-link-item {
            position: relative;
            transition: all 0.3s ease;
        }
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
</head>

<body>
    {{-- Initial Cart Count from PHP --}}
    @php 
        $initialCartCount = Auth::check() ? DB::table('carts')->where('user_id', Auth::id())->sum('quantity') : 0; 
    @endphp

    <div id="app" v-cloak class="min-h-screen flex flex-col">
        
        @include('components.navbar')

        <main class="flex-grow">
            @yield('content')
        </main>

        @include('components.footer')
        
    </div>

    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        const { createApp } = Vue;
        createApp({
            data() {
                return {
                    // Data Dasar & UI
                    cartCount: {{ $initialCartCount ?? 0 }}, 
                    isMobileMenuOpen: false,
                    isSearchOpen: false,
                    isProfileOpen: false,
                    activeFaq: null, 
                    showPassword: false,

                    // DATA DETAIL PRODUK & CHECKOUT
                    cartQty: 1, 
                    currentSlide: 0,
                    unitPrice: {{ isset($product) ? ($product->promo_price ?? $product->original_price) : 0 }},
                    voucherDiscount: 0,
                    voucherInput: ''
                }
            },
            computed: {
                calculateFinalTotal() {
                    let total = (this.unitPrice * this.cartQty) - this.voucherDiscount;
                    return total < 0 ? 0 : total;
                }
            },
            methods: {
                /* --- LOGIKA UPDATE KERANJANG --- */
                async updateCartQty(itemId, newQty) {
                    if (newQty < 1) return;
                    try {
                        const response = await fetch(`/cart/update/${itemId}`, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                            },
                            body: JSON.stringify({ quantity: newQty })
                        });
                        const data = await response.json();
                        if (data.success) {
                            location.reload();
                        }
                    } catch (error) {
                        console.error("Gagal update qty:", error);
                    }
                },

                /* --- LOGIKA ADD TO CART --- */
                async addToCart(productId) {
                    const colorInput = document.getElementById('input-color');
                    const sizeInput = document.getElementById('input-size');

                    if (!colorInput?.value || !sizeInput?.value) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Selection Required',
                            text: 'Harap pilih Warna dan Ukuran terlebih dahulu.',
                            confirmButtonColor: '#1754cf',
                            customClass: { popup: 'rounded-[2.5rem]' }
                        });
                        return;
                    }

                    try {
                        const response = await fetch('{{ route("cart.add") }}', {
                            method: 'POST',
                            headers: { 
                                'Content-Type': 'application/json', 
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content 
                            },
                            body: JSON.stringify({ 
                                product_id: productId, 
                                selected_color: colorInput.value, 
                                selected_size: sizeInput.value, 
                                quantity: this.cartQty 
                            })
                        });

                        const data = await response.json();
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: data.message,
                                showCancelButton: true,
                                confirmButtonText: 'Buka Keranjang',
                                cancelButtonText: 'Lanjut Belanja',
                                confirmButtonColor: '#1754cf',
                                customClass: { popup: 'rounded-[2.5rem]' }
                            }).then((result) => {
                                if (result.isConfirmed) window.location.href = '{{ route("cart.index") }}';
                            });
                            this.cartCount += this.cartQty;
                        }
                    } catch (error) {
                        console.error('Cart Error:', error);
                    }
                },

                updateQty(amount) {
                    if (this.cartQty + amount >= 1) {
                        this.cartQty += amount;
                    }
                },

                moveSlide(direction, totalSlides) {
                    this.currentSlide = (this.currentSlide + direction + totalSlides) % totalSlides;
                    const slider = document.getElementById('main-slider');
                    if (slider) {
                        slider.style.transform = `translateX(-${this.currentSlide * 100}%)`;
                    }
                    const dots = document.querySelectorAll('.slider-dot');
                    dots.forEach((dot, idx) => {
                        dot.classList.toggle('active-dot', idx === this.currentSlide);
                    });
                },

                selectAttr(event, type, value) {
                    document.querySelectorAll(`#${type}-picker .attr-btn`).forEach(b => b.classList.remove('active'));
                    event.currentTarget.classList.add('active');
                    const input = document.getElementById(`input-${type}`);
                    if (input) input.value = value;
                },

                async applyVoucher(productId) {
                    if(!this.voucherInput) return;
                    try {
                        const res = await fetch('{{ route("products.verify_voucher") }}', {
                            method: 'POST',
                            headers: { 
                                'Content-Type': 'application/json', 
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content 
                            },
                            body: JSON.stringify({ code: this.voucherInput, product_id: productId })
                        });
                        const data = await res.json();
                        if(data.success) {
                            this.voucherDiscount = data.discount;
                            Swal.fire({icon:'success', title:'VERIFIED', text: data.message, customClass:{popup:'rounded-[2.5rem]'}});
                        } else {
                            this.voucherDiscount = 0;
                            Swal.fire({icon:'error', title:'FAILED', text: data.message, customClass:{popup:'rounded-[2.5rem]'}});
                        }
                    } catch(e) { console.error("Voucher error"); }
                },

                formatNumber(val) {
                    return new Intl.NumberFormat('id-ID').format(val);
                },

                initProductSlideshow() {
                    const containers = document.querySelectorAll('.product-card-slideshow');
                    containers.forEach(container => {
                        const images = container.querySelectorAll('img');
                        if (images.length > 1) {
                            let currentIndex = 0;
                            setInterval(() => {
                                images[currentIndex].classList.replace('opacity-100', 'opacity-0');
                                currentIndex = (currentIndex + 1) % images.length;
                                images[currentIndex].classList.replace('opacity-0', 'opacity-100');
                            }, 5000);
                        }
                    });
                },

                async handleSubscription(event) {
                    event.preventDefault();
                    const emailInput = document.getElementById('sub_email');
                    if(!emailInput.value) return;

                    const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
                    if(!isLoggedIn) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Login Required',
                            text: 'Harap login terlebih dahulu untuk bergabung dengan Inner Circle.',
                            confirmButtonColor: '#1754cf',
                            customClass: { popup: 'rounded-[2rem]' }
                        });
                        return;
                    }

                    try {
                        const res = await fetch('{{ route("subscribe.circle") }}', {
                            method: 'POST',
                            headers: { 
                                'Content-Type': 'application/json', 
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content 
                            },
                            body: JSON.stringify({ email: emailInput.value })
                        });
                        const data = await res.json();
                        if(data.success) {
                            Swal.fire({ 
                                icon: 'success', 
                                title: 'JOINED', 
                                text: data.message,
                                confirmButtonColor: '#1754cf',
                                customClass: { popup: 'rounded-[2rem]' }
                            }).then(() => location.reload());
                        } else {
                            Swal.fire({ 
                                icon: 'info', title: 'NOTICE', text: data.message,
                                confirmButtonColor: '#111318', customClass: { popup: 'rounded-[2rem]' }
                            });
                        }
                    } catch (error) { console.error('Subscription error:', error); }
                },

                /* --- LOGIKA SCROLL SPY (PENANDA MENU) --- */
                initScrollSpy() {
                    const navItems = document.querySelectorAll('.nav-link-item');
                    const sections = ['hero', 'new-in', 'collection', 'sale'];

                    const updateActiveMenu = () => {
                        let current = '';
                        sections.forEach(id => {
                            const section = document.getElementById(id);
                            if (section) {
                                const sectionTop = section.offsetTop;
                                if (window.pageYOffset >= (sectionTop - 150)) {
                                    current = id;
                                }
                            }
                        });

                        if (window.pageYOffset < 100) current = 'hero';

                        navItems.forEach(item => {
                            item.classList.remove('active-link');
                            if (item.getAttribute('data-section') === current) {
                                item.classList.add('active-link');
                            }
                        });
                    };

                    window.addEventListener('scroll', updateActiveMenu);
                    updateActiveMenu(); // Jalankan saat load
                },

                refreshSession() {
                    fetch('{{ route("refresh.csrf") }}').catch(err => console.log("Session Keep-Alive failed"));
                },
                toggleFaq(index) { this.activeFaq = this.activeFaq === index ? null : index; },
                isFaqOpen(index) { return this.activeFaq === index; },
                togglePasswordVisibility() { this.showPassword = !this.showPassword; },
                toggleMenu() {
                    this.isMobileMenuOpen = !this.isMobileMenuOpen;
                    document.body.style.overflow = this.isMobileMenuOpen ? 'hidden' : 'auto';
                },
                toggleSearch() {
                    this.isSearchOpen = !this.isSearchOpen;
                    if(this.isSearchOpen) { 
                        setTimeout(() => {
                            const input = document.querySelector('input[placeholder*="Search"]');
                            input?.focus();
                        }, 400);
                    }
                },
                toggleProfile() { this.isProfileOpen = !this.isProfileOpen; },
                closeAllOverlays() {
                    this.isMobileMenuOpen = false;
                    this.isSearchOpen = false;
                    this.isProfileOpen = false;
                    document.body.style.overflow = 'auto';
                },
                checkLogin(productId) {
                    const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
                    if (!isLoggedIn) {
                        Swal.fire({
                            title: 'Premium Content',
                            text: "Silahkan login terlebih dahulu.",
                            icon: 'info',
                            showCancelButton: true,
                            confirmButtonColor: '#1754cf',
                            confirmButtonText: 'Login Sekarang',
                            customClass: { popup: 'rounded-[2rem]' }
                        }).then((result) => {
                            if (result.isConfirmed) window.location.href = "{{ route('login') }}";
                        });
                    } else {
                        window.location.href = "/product/" + productId;
                    }
                }
            },
            mounted() {
                this.initProductSlideshow();
                this.initScrollSpy(); // Jalankan fitur penanda menu
                setInterval(this.refreshSession, 15 * 60 * 1000);
                window.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') this.closeAllOverlays();
                });
                
                const subForm = document.getElementById('subscribeForm');
                if(subForm) subForm.addEventListener('submit', this.handleSubscription);

                AOS.init({ duration: 1000, once: true, offset: 50, easing: 'ease-out-cubic' });
                this.$nextTick(() => {
                    setTimeout(() => { AOS.refresh(); }, 800);
                    window.addEventListener('scroll', () => { AOS.refresh(); }, { once: true });
                });
            }
        }).mount('#app');
    </script>
</body>
</html>