<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <title>Admin Portal | LUXE Premium</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@300;400&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;700;800&display=swap" rel="stylesheet"/>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <script src="https://unpkg.com/react@18/umd/react.production.min.js"></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.production.min.js"></script>
    <script src="https://unpkg.com/@babel/standalone/babel.min.js"></script>

    <style>
        body { font-family: 'Manrope', sans-serif; background-color: #ffffff; margin: 0; height: 100vh; overflow: hidden; }
        .admin-gradient { background: linear-gradient(135deg, #111318 0%, #1754cf 100%); }
        @media (max-height: 750px) { .login-box { transform: scale(0.85); transform-origin: center; } }
        @media (max-width: 1024px) { body { overflow-y: auto; height: auto; } }
    </style>
</head>

<body class="h-screen overflow-hidden">
    <div id="admin-login-root" class="h-full"></div>

    {{-- LOGIKA PENGAMBILAN DATA DARI DATABASE --}}
    @php
        $settings = \Illuminate\Support\Facades\DB::table('home_settings')
                    ->pluck('value', 'key_name')
                    ->toArray();
        
        $adminBg = (isset($settings['login_image']) && file_exists(public_path('login/'.$settings['login_image']))) 
                   ? asset('login/'.$settings['login_image']) 
                   : 'https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=1200';
    @endphp

    <script>
        window.LuxeConfig = {
            csrf: '{{ csrf_token() }}',
            loginUrl: '{{ route("admin.login") }}',
            refreshUrl: '{{ route("refresh.csrf") }}', // Gunakan rute refresh yang sudah kita buat di web.php
            oldEmail: '{{ old("email") }}',
            error: '{{ $errors->first("email") }}',
            bgImage: '{{ $adminBg }}'
        };

        // --- ANTI-EXPIRATION LOGIC (CSRF HEARTBEAT) ---
        // Melakukan ping ke server setiap 5 menit agar sesi tidak mati
        setInterval(async () => {
            try {
                const response = await fetch(window.LuxeConfig.refreshUrl);
                const data = await response.json();
                console.log('Session Refreshed:', data.timestamp);
            } catch (error) {
                console.error('Failed to refresh session');
            }
        }, 5 * 60 * 1000); 

        // Auto-reload jika user kembali ke tab ini setelah lama ditinggalkan
        window.addEventListener('focus', async () => {
            try {
                const response = await fetch(window.LuxeConfig.refreshUrl);
                if (!response.ok) window.location.reload();
            } catch (e) {
                window.location.reload();
            }
        });
    </script>

    <script type="text/babel">
        const { useState } = React;

        const AdminLogin = () => {
            const [showPassword, setShowPassword] = useState(false);

            return (
                <section className="h-screen flex items-stretch bg-white overflow-hidden">
                    {/* LEFT SIDE: Visual Branding */}
                    <div className="hidden lg:flex lg:w-1/2 relative overflow-hidden admin-gradient">
                        <img src={window.LuxeConfig.bgImage} className="absolute inset-0 w-full h-full object-cover opacity-40 transition-opacity duration-700" />
                        <div className="absolute inset-0 bg-[#111318]/40"></div>
                        
                        <div className="relative z-10 flex flex-col justify-between p-12 w-full text-white">
                            <div className="flex items-center gap-3">
                                <div className="w-9 h-9 bg-white/10 backdrop-blur-md rounded-xl flex items-center justify-center border border-white/20">
                                    <svg className="w-5 h-5" fill="white" viewBox="0 0 48 48">
                                        <path d="M36.7273 44C33.9891 44 31.6043 39.8386 30.3636 33.69C29.123 39.8386 26.7382 44 24 44C21.2618 44 18.877 39.8386 17.6364 33.69C16.3957 39.8386 14.0109 44 11.2727 44C7.25611 44 4 35.0457 4 24C4 12.9543 7.25611 4 11.2727 4C14.0109 4 16.3957 8.16144 17.6364 14.31C18.877 8.16144 21.2618 4 24 4C26.7382 4 29.123 8.16144 30.3636 14.31C31.6043 8.16144 33.9891 4 36.7273 4C40.7439 4 44 12.9543 44 24C44 35.0457 40.7439 44 36.7273 44Z" />
                                    </svg>
                                </div>
                                <span className="text-xl font-black tracking-tighter uppercase italic">Luxe Admin</span>
                            </div>
                            <div data-aos="fade-right">
                                <h2 className="text-4xl font-light leading-tight mb-4">Dedicated Admin <br /> <span className="font-extrabold italic">Secure Gateway.</span></h2>
                            </div>
                            <div className="flex gap-6 text-[10px] font-bold uppercase tracking-[0.3em] opacity-60">
                                <span>Security Root</span>
                                <span>v2.0.4</span>
                            </div>
                        </div>
                    </div>

                    {/* RIGHT SIDE: Form Side */}
                    <div className="w-full lg:w-1/2 flex items-center justify-center p-8 bg-white h-full overflow-hidden">
                        <div className="max-w-sm w-full login-box" data-aos="fade-up">
                            <div className="mb-6 text-left">
                                <div className="inline-flex items-center gap-2 px-2.5 py-1 rounded-full bg-indigo-50 text-indigo-600 text-[9px] font-bold uppercase tracking-wider mb-3 border border-indigo-100">
                                    <span className="w-1.5 h-1.5 rounded-full bg-indigo-600 animate-pulse"></span>
                                    Protected Terminal
                                </div>
                                <h3 className="text-3xl font-bold tracking-tighter text-[#111318] mb-1 leading-none">Authentication</h3>
                                <p className="text-gray-400 font-light text-xs italic leading-relaxed">Identify yourself to access the dashboard.</p>
                            </div>

                            {window.LuxeConfig.error && (
                                <div className="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-600 text-[10px] font-bold flex items-start gap-3 animate-pulse">
                                    <span className="material-symbols-outlined text-sm font-bold">warning</span>
                                    <span>{window.LuxeConfig.error}</span>
                                </div>
                            )}

                            <form action={window.LuxeConfig.loginUrl} method="POST" className="space-y-4">
                                <input type="hidden" name="_token" value={window.LuxeConfig.csrf} />
                                <div className="text-left">
                                    <label className="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2 ml-1">Admin Identity</label>
                                    <input type="email" name="email" defaultValue={window.LuxeConfig.oldEmail} required
                                           placeholder="e.g. root@luxe.com"
                                           className="w-full px-5 py-3.5 rounded-xl border border-gray-100 bg-gray-50 focus:bg-white focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-600 outline-none transition-all text-xs font-medium" />
                                </div>
                                <div className="text-left">
                                    <label className="block text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 mb-2 ml-1">Security Key</label>
                                    <div className="relative">
                                        <input type={showPassword ? 'text' : 'password'} name="password" placeholder="••••••••" required
                                               className="w-full px-5 py-3.5 rounded-xl border border-gray-100 bg-gray-50 focus:bg-white focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-600 outline-none transition-all text-xs" />
                                        <span onClick={() => setShowPassword(!showPassword)} 
                                              className="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 cursor-pointer text-lg hover:text-indigo-600 transition-colors select-none">
                                            {showPassword ? 'visibility' : 'visibility_off'}
                                        </span>
                                    </div>
                                </div>
                                <button type="submit" className="w-full bg-[#111318] text-white py-4 rounded-xl font-black uppercase text-[10px] tracking-[0.3em] hover:bg-indigo-600 transition-all shadow-xl active:scale-[0.98] mt-2 flex items-center justify-center gap-2 group">
                                    Authenticate 
                                    <span className="material-symbols-outlined text-base group-hover:translate-x-1 transition-transform">arrow_forward</span>
                                </button>
                            </form>

                            <div className="mt-10 pt-6 border-t border-gray-100 text-center text-[9px] font-bold uppercase tracking-widest text-gray-400">
                                <p>© 2026 LUXE Premium Control Panel</p>
                            </div>
                        </div>
                    </div>
                </section>
            );
        };

        const root = ReactDOM.createRoot(document.getElementById('admin-login-root'));
        root.render(<AdminLogin />);
    </script>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        window.addEventListener('load', () => { AOS.init({ duration: 1000, once: true }); });
    </script>
</body>
</html>