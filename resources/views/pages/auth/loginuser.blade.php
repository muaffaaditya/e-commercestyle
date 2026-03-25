@extends('layouts.app')

@section('title', 'Login | LUXE')

@section('content')

{{-- LOGIKA PENGAMBILAN DATA DARI DATABASE --}}
@php
    $settings = \Illuminate\Support\Facades\DB::table('home_settings')
                ->pluck('value', 'key_name')
                ->toArray();
    
    // Penentuan Gambar Latar Belakang
    $loginBg = (isset($settings['login_image']) && file_exists(public_path('login/'.$settings['login_image']))) 
               ? asset('login/'.$settings['login_image']) 
               : 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?q=80&w=1200';
@endphp

<section class="min-h-screen flex items-stretch bg-white overflow-hidden">
    {{-- BAGIAN KIRI: BRANDING PANEL (DINAMIS) --}}
    <div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-[#111318]">
        <img src="{{ $loginBg }}" 
             class="absolute inset-0 w-full h-full object-cover opacity-80 transition-opacity duration-700" 
             alt="Auth Background">
        
        <div class="absolute inset-0 bg-black/20"></div>
        
        <div class="relative z-10 flex flex-col justify-between p-16 w-full text-white">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8">
                    <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                        <path d="M36.7273 44C33.9891 44 31.6043 39.8386 30.3636 33.69C29.123 39.8386 26.7382 44 24 44C21.2618 44 18.877 39.8386 17.6364 33.69C16.3957 39.8386 14.0109 44 11.2727 44C7.25611 44 4 35.0457 4 24C4 12.9543 7.25611 4 11.2727 4C14.0109 4 16.3957 8.16144 17.6364 14.31C18.877 8.16144 21.2618 4 24 4C26.7382 4 29.123 8.16144 30.3636 14.31C31.6043 8.16144 33.9891 4 36.7273 4C40.7439 4 44 12.9543 44 24C44 35.0457 40.7439 44 36.7273 44Z" fill="currentColor"></path>
                    </svg>
                </div>
                <span class="text-xl font-black tracking-tighter uppercase">LUXE</span>
            </div>

            <div data-aos="fade-right">
                <h2 class="text-5xl font-light leading-tight mb-6 text-left">
                    {{ $settings['login_title_top'] ?? 'Elevate your everyday with' }} 
                    <br> 
                    <span class="font-extrabold italic">{{ $settings['login_title_bottom'] ?? 'curated essentials.' }}</span>
                </h2>
                <div class="w-12 h-1 bg-white mb-8"></div>
            </div>

            <div class="flex gap-8 text-[10px] font-bold uppercase tracking-widest opacity-60">
                <span>Vogue Magazine</span>
                <span>Collections</span>
                <span>Elle Fashion</span>
            </div>
        </div>
    </div>

    {{-- BAGIAN KANAN: FORM LOGIN --}}
    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 md:p-16 bg-white">
        <div class="max-w-md w-full" data-aos="fade-up">
            <div class="flex bg-gray-100 p-1 rounded-xl mb-10">
                <a href="{{ route('login') }}" class="flex-1 text-center py-2.5 rounded-lg text-sm font-bold bg-white shadow-sm text-[#111318] no-underline">Login</a>
                <a href="{{ route('register') }}" class="flex-1 text-center py-2.5 rounded-lg text-sm font-bold text-gray-500 hover:text-[#111318] transition-all no-underline">Create Account</a>
            </div>

            <div class="mb-10 text-left">
                <h3 class="text-3xl font-bold tracking-tighter text-[#111318] mb-2 leading-none">Welcome Back</h3>
                <p class="text-gray-500 font-light text-sm italic">Identify yourself to access your premium dashboard.</p>
            </div>

            {{-- ERROR HANDLING --}}
            @if($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-600 text-[10px] font-bold flex items-start gap-3 animate-pulse">
                    <span class="material-symbols-outlined text-sm">warning</span>
                    <span>{{ $errors->first() }}</span>
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf
                <div class="text-left">
                    <label class="block text-[11px] font-black uppercase tracking-widest text-gray-400 mb-2">Email Identity</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="name@luxe.com" required
                           class="w-full px-5 py-4 rounded-xl border border-gray-100 bg-gray-50/50 focus:bg-white focus:ring-4 focus:ring-[#1754cf]/5 focus:border-[#1754cf] outline-none transition-all text-sm font-medium">
                </div>

                <div class="text-left">
                    <div class="flex justify-between mb-2">
                        <label class="block text-[11px] font-black uppercase tracking-widest text-gray-400">Security Key</label>
                        <a href="{{ route('password.request') }}" class="text-[11px] font-bold text-[#1754cf] hover:underline">Forgot?</a>
                    </div>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" name="password" placeholder="••••••••" required
                               class="w-full px-5 py-4 rounded-xl border border-gray-100 bg-gray-50/50 focus:bg-white focus:ring-4 focus:ring-[#1754cf]/5 focus:border-[#1754cf] outline-none transition-all text-sm">
                        
                        <span @click="togglePasswordVisibility" 
                              class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 cursor-pointer text-lg hover:text-[#1754cf] transition-colors select-none">
                            @{{ showPassword ? 'visibility' : 'visibility_off' }}
                        </span>
                    </div>
                </div>

                <button type="submit" class="w-full bg-[#111318] text-white py-4 rounded-xl font-bold tracking-[0.1em] uppercase text-xs hover:bg-[#1754cf] transition-all shadow-xl shadow-blue-500/10 active:scale-[0.98] flex items-center justify-center gap-2 group">
                    Authenticate
                    <span class="material-symbols-outlined text-sm group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </button>
            </form>

            <div class="relative my-10 text-center">
                <hr class="border-gray-100">
                <span class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-white px-4 text-[10px] font-bold text-gray-400 uppercase tracking-widest">Or Secure Entry with</span>
            </div>

            <a href="{{ route('auth.google') }}" class="flex items-center justify-center gap-3 py-4 border border-gray-100 rounded-xl hover:bg-gray-50 transition-all font-bold text-xs text-[#111318] w-full no-underline uppercase tracking-widest">
                <img src="https://www.svgrepo.com/show/355037/google.svg" class="w-4 h-4" alt="Google"> 
                <span>Google Account</span>
            </a>

            <div class="mt-12 text-center">
                <p class="text-[9px] font-bold text-gray-300 uppercase tracking-[0.3em]">© 2026 LUXE Premium Terminal • Session Encrypted</p>
            </div>
        </div>
    </div>
</section>

{{-- SCRIPT ANTI-KADALUARSA (CSRF HEARTBEAT) --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const refreshUrl = '{{ route("refresh.csrf") }}';
        
        // Ping server setiap 5 menit agar sesi tetap hidup
        setInterval(async () => {
            try {
                const response = await fetch(refreshUrl);
                const data = await response.json();
                console.log('Session Refreshed:', data.timestamp);
            } catch (error) {
                console.warn('Silent refresh failed');
            }
        }, 5 * 60 * 1000);

        // Cek validitas sesi saat user kembali fokus ke tab ini
        window.addEventListener('focus', async () => {
            try {
                const response = await fetch(refreshUrl);
                if (!response.ok) {
                    window.location.reload(); // Reload jika token sudah benar-benar mati
                }
            } catch (e) {
                window.location.reload();
            }
        });
    });
</script>

@endsection