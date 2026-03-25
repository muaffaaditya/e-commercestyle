@extends('layouts.app')

@section('title', 'Create New Password | LUXE')

@section('content')

@php
    $settings = \Illuminate\Support\Facades\DB::table('home_settings')->pluck('value', 'key_name')->toArray();

    // Definisi variabel dengan nilai fallback (cadangan) agar tidak kosong
    $resetImage  = $settings['reset_image'] ?? null;
    $resetTop    = $settings['reset_title_top'] ?? 'Secure your account';
    $resetBottom = $settings['reset_title_bottom'] ?? 'with a new identity.';

    // Logika URL Gambar: Cek folder public/reset/
    $resetUrl = ($resetImage && file_exists(public_path('reset/' . $resetImage))) 
                ? asset('reset/' . $resetImage) 
                : 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?q=80&w=1200';
@endphp
<section class="min-h-screen flex items-stretch bg-white">
<div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-[#111318]">
    <img src="{{ $resetUrl }}" 
         class="absolute inset-0 w-full h-full object-cover opacity-80" 
         alt="Auth Background">
    
    <div class="absolute inset-0 bg-black/20"></div>
    
    <div class="relative z-10 flex flex-col justify-between p-16 w-full text-white">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8">
                <svg fill="none" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                    <path d="M36.7273 44C33.9891 44 31.6043 39.8386 30.3636 33.69C29.123 39.8386 26.7382 44 24 44C21.2618 44 18.877 39.8386 17.6364 33.69C16.3957 39.8386 14.0109 44 11.2727 44C7.25611 44 4 35.0457 4 24C4 12.9543 7.25611 4 11.2727 4C14.0109 4 16.3957 8.16144 17.6364 14.31C18.877 8.16144 21.2618 4 24 4C26.7382 4 29.123 8.16144 30.3636 14.31C31.6043 8.16144 33.9891 4 36.7273 4C40.7439 4 44 12.9543 44 24C44 35.0457 40.7439 44 36.7273 44Z" fill="currentColor"></path>
                </svg>
            </div>
            <span class="text-xl font-black tracking-tighter text-white uppercase">LUXE</span>
        </div>

        <div data-aos="fade-right">
            <h2 class="text-5xl font-light leading-tight mb-6 text-white">
                {{ $resetTop }} <br> 
                <span class="font-extrabold italic text-white">{{ $resetBottom }}</span>
            </h2>
            <div class="w-12 h-1 bg-white mb-8"></div>
        </div>

        <div class="flex gap-8 text-[10px] font-bold uppercase tracking-widest opacity-60 text-white">
            <span>Protection</span>
            <span>Verification</span>
            <span>LUXE ID</span>
        </div>
    </div>
</div>

    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 md:p-16 bg-white">
        <div class="max-w-md w-full" data-aos="fade-up">
            
            <div class="mb-10">
                <h3 class="text-3xl font-bold tracking-tighter text-[#111318] mb-2">Create New Password</h3>
                <p class="text-gray-500 font-light text-sm">Pastikan kata sandi baru Anda kuat dan sulit ditebak.</p>
            </div>

            <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label class="block text-[11px] font-black uppercase tracking-widest text-gray-400 mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ request()->email }}" required readonly
                           class="w-full px-5 py-4 rounded-xl border border-gray-100 bg-gray-100 text-gray-500 outline-none cursor-not-allowed transition-all">
                </div>

                <div>
                    <label class="block text-[11px] font-black uppercase tracking-widest text-gray-400 mb-2">New Password</label>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" name="password" placeholder="••••••••" required
                               class="w-full px-5 py-4 rounded-xl border border-gray-100 bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-[#1754cf]/10 outline-none transition-all">
                        
                        <span @click="togglePasswordVisibility" 
                              class="material-symbols-outlined absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 cursor-pointer text-lg hover:text-[#1754cf] transition-colors">
                            @{{ showPassword ? 'visibility' : 'visibility_off' }}
                        </span>
                    </div>
                    @error('password')
                        <span class="text-[10px] text-red-500 mt-1 block font-bold tracking-tighter">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-[11px] font-black uppercase tracking-widest text-gray-400 mb-2">Confirm New Password</label>
                    <div class="relative">
                        <input :type="showPassword ? 'text' : 'password'" name="password_confirmation" placeholder="••••••••" required
                               class="w-full px-5 py-4 rounded-xl border border-gray-100 bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-[#1754cf]/10 outline-none transition-all">
                    </div>
                </div>

                <button type="submit" class="w-full bg-[#1754cf] text-white py-4 rounded-xl font-bold tracking-wide hover:bg-[#1754cf]/90 focus:ring-4 focus:ring-[#1754cf]/20 transition-all shadow-xl shadow-[#1754cf]/20 active:scale-[0.98]">
                    Update Password
                </button>
            </form>

            <div class="mt-10 pt-6 border-t border-gray-100 text-center">
                <a href="{{ route('login') }}" class="text-xs font-bold text-gray-400 hover:text-[#1754cf] transition-colors flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-sm">arrow_back</span>
                    Back to Login
                </a>
            </div>
        </div>
    </div>
</section>
@endsection