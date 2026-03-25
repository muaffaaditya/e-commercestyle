<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>LUXE Admin - @yield('title', 'Terminal')</title>
    
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@300;400&display=swap" rel="stylesheet"/>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root { scroll-behavior: smooth; }
        
        body { 
            font-family: 'Manrope', sans-serif; 
            background-color: #f6f6f8; 
            margin: 0; 
            overflow-x: hidden; 
        }

        /* Sidebar Styling */
        .sidebar { 
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            width: 288px; 
            height: 100vh; 
            position: fixed; 
            left: 0; top: 0; 
            z-index: 1050;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); 
            border-right: 1px solid rgba(0, 0, 0, 0.05);
        }

        .menu-header {
            font-size: 0.65rem; font-weight: 800; color: #94a3b8; text-transform: uppercase;
            letter-spacing: 0.2em; padding: 2rem 1.5rem 0.75rem; white-space: nowrap;
        }

        .nav-link { 
            color: #64748b; font-size: 0.85rem; border-radius: 16px; margin: 4px 1rem;
            padding: 1rem 1.2rem; display: flex; align-items: center;
            justify-content: space-between; transition: all 0.3s;
            text-decoration: none !important;
        }
        .nav-link:hover { background: #f0f7ff; color: #1754cf; }
        .nav-link.active { 
            background: #1754cf; 
            color: white !important; 
            font-weight: 700; 
            box-shadow: 0 10px 20px rgba(23, 84, 207, 0.15); 
        }

        .submenu-container {
            max-height: none !important; 
            overflow: visible; 
            background: transparent; 
        }

        .submenu-item { 
            color: #94a3b8; font-size: 0.75rem; display: flex; align-items: center;
            padding: 10px 1rem 10px 3.5rem; transition: 0.2s; font-weight: 700;
            text-decoration: none !important; text-transform: uppercase; letter-spacing: 0.05em;
        }
        .submenu-item:hover, .submenu-item.active { color: #1754cf; }

        .main-content { 
            margin-left: 288px; 
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1); 
            display: flex; flex-direction: column; min-height: 100vh; 
        }

        .admin-header {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            height: 80px;
        }

        .admin-dropdown-menu {
            position: absolute; top: 75px; right: 0; background: white; width: 260px;
            border-radius: 24px; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            display: none; z-index: 1100; border: 1px solid #f1f1f1; overflow: hidden;
        }
        .admin-dropdown-menu.show { display: block; animation: v-slide 0.4s ease; }
        
        @keyframes v-slide {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        [v-cloak] { display: none !important; }
    </style>
</head>
<body>

    <div id="app" v-cloak class="flex">
        <aside id="sidebar" class="sidebar shadow-sm">
            <div class="flex items-center space-x-3 px-8 mb-4 mt-10">
                <div class="bg-[#1754cf] p-2 rounded-xl shrink-0 shadow-lg shadow-blue-200">
                    <i class="fa-solid fa-crown text-white text-sm"></i>
                </div>
                <span class="text-[#111318] font-extrabold text-xl tracking-tighter sidebar-logo-text uppercase italic">Luxe <span class="text-[#1754cf]">Admin</span></span>
            </div>
            
            <nav class="pb-10 overflow-y-auto h-[calc(100vh-100px)]">
                <div class="menu-header">Overview</div>
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <div class="flex items-center space-x-4">
                        <i class="fa-solid fa-chart-pie w-5"></i> <span>Dashboard</span>
                    </div>
                </a>
                
                <div class="menu-header">Store Management</div>
                <div>
                    <div class="nav-link">
                        <div class="flex items-center space-x-4">
                            <i class="fa-solid fa-box w-5"></i> <span>Inventory</span>
                        </div>
                    </div>
                    <div class="submenu-container">
                        <ul class="list-none p-0 m-0">
                            <li><a href="{{ route('admin.products.index') }}" class="submenu-item {{ request()->routeIs('admin.products.index') ? 'active' : '' }}">Product List</a></li>
                            <li><a href="{{ route('admin.products.create') }}" class="submenu-item">Add New Item</a></li>
                        </ul>
                    </div>
                </div>

                <a href="{{ route('admin.orders.index') }}" class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <div class="flex items-center space-x-4">
                        <i class="fa-solid fa-receipt w-5"></i> <span>Sales Orders</span>
                    </div>
                </a>

                <div class="menu-header">Community</div>
                <a href="{{ route('admin.circle.index') }}" class="nav-link {{ request()->routeIs('admin.circle.*') ? 'active' : '' }}">
                    <div class="flex items-center space-x-4">
                        <i class="fa-solid fa-circle-nodes w-5"></i> <span>Circle LUXE</span>
                    </div>
                </a>

                <div class="menu-header">Configuration</div>
                <div>
                    <div class="nav-link">
                        <div class="flex items-center space-x-4">
                            <i class="fa-solid fa-window-restore w-5"></i> <span>Landing Page</span>
                        </div>
                    </div>
                    <div class="submenu-container">
                        <ul class="list-none p-0 m-0">
                            <li><a href="{{ route('admin.home.settings') }}" class="submenu-item">Hero Editor</a></li>
                            <li><a href="{{ route('admin.login.settings') }}" class="submenu-item">Login Editor</a></li>
                            <li><a href="{{ route('admin.register.settings') }}" class="submenu-item">Register Editor</a></li>
                            <li><a href="{{ route('admin.forgot.settings') }}" class="submenu-item">Forgot Editor</a></li>
                            <li><a href="{{ route('admin.reset.settings') }}" class="submenu-item">Reset Editor</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </aside>

        <main class="flex-1 main-content">
            <header class="admin-header flex items-center justify-between px-10 sticky top-0 z-50">
                <div class="flex items-center space-x-6">
                    <h1 class="text-sm font-black text-slate-400 uppercase tracking-[0.3em] hidden lg:block leading-none">Administrator Secure Terminal</h1>
                </div>

                <div class="flex items-center space-x-6">
                    <div class="pr-6 border-r border-slate-100">
                        <a href="#" class="relative text-slate-400 hover:text-[#1754cf] transition">
                            <i class="fa-solid fa-bell text-lg"></i>
                            <span class="absolute top-0 right-0 h-2 w-2 bg-red-500 rounded-full border-2 border-white"></span>
                        </a>
                    </div>
                    
                    <div class="relative">
                        <div @click="toggleProfile" class="flex items-center space-x-4 cursor-pointer group">
                            <div class="text-right hidden sm:block">
                                <p class="text-xs font-extrabold text-[#111318] leading-none mb-1">{{ Auth::guard('admin')->user()->first_name ?? 'Root' }}</p>
                                <p class="text-[9px] text-slate-400 font-bold uppercase tracking-widest">Administrator</p>
                            </div>
                            <img src="https://ui-avatars.com/api/?name={{ Auth::guard('admin')->user()->first_name ?? 'A' }}&background=f0f7ff&color=1754cf&bold=true" class="h-11 w-11 rounded-2xl border-2 border-white shadow-sm group-hover:border-[#1754cf] transition-all">
                        </div>
                        
                        <div v-if="isProfileOpen" class="admin-dropdown-menu show">
                            <div class="px-6 py-4 bg-slate-50 border-b border-slate-100 text-left">
                                <p class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Status</p>
                                <div class="flex items-center space-x-2 text-[#1754cf] font-bold text-xs">
                                    <span class="w-2 h-2 bg-emerald-500 rounded-full animate-pulse"></span>
                                    <span>Active Session</span>
                                </div>
                            </div>
                            <div class="p-2">
                                <form action="{{ route('admin.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center space-x-3 px-4 py-3 text-xs font-bold text-red-500 hover:bg-red-50 rounded-xl transition-all">
                                        <i class="fa-solid fa-power-off"></i> <span>Sign Out</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <div class="p-8 md:p-12 flex-grow" data-aos="fade-in">
                @yield('content')
            </div>

            <footer class="bg-white/50 backdrop-blur-sm border-t border-slate-100 p-8 text-center">
                <p class="text-slate-300 text-[9px] font-bold uppercase tracking-[0.4em] m-0 italic">© 2026 LUXE Premium — Encrypted Management Terminal</p>
            </footer>
        </main>
    </div>

    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <script>
        const { createApp } = Vue;
        createApp({
            data() {
                return {
                    isProfileOpen: false
                }
            },
            methods: {
                toggleProfile() { this.isProfileOpen = !this.isProfileOpen; },
                
                // --- ANTI-EXPIRATION LOGIC (CSRF HEARTBEAT) ---
                initHeartbeat() {
                    const refreshUrl = '{{ route("refresh.csrf") }}';
                    
                    // Lakukan ping setiap 5 menit
                    setInterval(async () => {
                        try {
                            const res = await fetch(refreshUrl);
                            const data = await res.json();
                            console.log('Admin Session Sync:', data.timestamp);
                        } catch (e) {
                            console.warn('Session Sync Failed');
                        }
                    }, 5 * 60 * 1000);

                    // Cek validitas sesi saat tab difokuskan kembali
                    window.addEventListener('focus', async () => {
                        try {
                            const res = await fetch(refreshUrl);
                            if (!res.ok) window.location.reload();
                        } catch (e) {
                            window.location.reload();
                        }
                    });
                }
            },
            mounted() {
                AOS.init({ duration: 800, once: true });
                this.initHeartbeat(); // Jalankan Heartbeat saat admin panel dibuka
                
                document.addEventListener('click', (e) => {
                    if (!e.target.closest('.relative')) this.isProfileOpen = false;
                });
            }
        }).mount('#app');
    </script>
</body>
</html>