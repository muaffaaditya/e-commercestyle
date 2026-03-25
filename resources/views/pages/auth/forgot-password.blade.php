@extends('layouts.app')

@section('title', 'Forgot Password | LUXE')

@section('content')
@php
    $settings = DB::table('home_settings')->pluck('value', 'key_name')->toArray();
@endphp
<section class="min-h-screen flex items-stretch bg-white">
<div class="hidden lg:flex lg:w-1/2 relative overflow-hidden bg-[#111318]">
    <img src="{{ asset('forgot/'.($settings['forgot_image'] ?? 'default.jpg')) }}" 
         class="absolute inset-0 w-full h-full object-cover opacity-80">
    <div class="absolute inset-0 bg-black/20"></div>
    
    <div class="relative z-10 flex flex-col justify-between p-16 w-full text-white">
        <div class="flex items-center gap-2">
            <span class="text-xl font-black tracking-tighter uppercase">LUXE</span>
        </div>

        <div data-aos="fade-right">
            <h2 class="text-5xl font-light leading-tight mb-6 text-white">
                {{ $settings['forgot_title_top'] ?? 'Restore your access to' }} <br> 
                <span class="font-extrabold italic text-white">{{ $settings['forgot_title_bottom'] ?? 'curated lifestyle.' }}</span>
            </h2>
            <div class="w-12 h-1 bg-white mb-8"></div>
        </div>

        <div class="flex gap-8 text-[10px] font-bold uppercase tracking-widest opacity-60">
            <span>Security</span><span>Privacy</span><span>Support</span>
        </div>
    </div>
</div>

    <div class="w-full lg:w-1/2 flex items-center justify-center p-8 md:p-16 bg-white dark:bg-[#111318]">
        <div class="max-w-md w-full" data-aos="fade-up">
            
            <div class="mb-10">
                <h3 class="text-3xl font-bold tracking-tighter text-[#111318] dark:text-black mb-2">Reset Password</h3>
                <p class="text-gray-500 dark:text-gray-400 font-light text-sm">Enter your email and we'll send you a link to get back into your account.</p>
            </div>

            @if (session('status'))
                <div class="bg-green-50 dark:bg-green-500/10 text-green-600 dark:text-green-400 p-4 rounded-xl text-xs font-bold mb-6 flex items-center gap-3">
                    <span class="material-symbols-outlined text-sm">check_circle</span>
                    {{ session('status') }}
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-[11px] font-black uppercase tracking-widest text-black-400 mb-2">Email Address</label>
<input type="email" name="email" value="{{ old('email') }}" placeholder="name@gmail.com" required
       class="w-full px-5 py-4 rounded-xl border border-gray-100 bg-gray-50/50 focus:bg-white focus:ring-2 focus:ring-[#1754cf]/10 outline-none transition-all">
@error('email')
    <span class="text-[10px] text-red-500 mt-2 block font-bold">{{ $message }}</span>
@enderror
                </div>

                <button type="submit" class="w-full bg-[#1754cf] text-white py-4 rounded-xl font-bold tracking-wide hover:bg-[#1754cf]/90 focus:ring-4 focus:ring-[#1754cf]/20 transition-all shadow-xl shadow-[#1754cf]/20 active:scale-[0.98]">
                    Send Reset Link
                </button>
            </form>

            <div class="mt-10 pt-6 border-t border-black-100 dark:border-white/5 text-center">
                <a href="{{ route('login') }}" class="text-xs font-bold text-black-400 hover:text-[#1754cf] transition-colors flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-sm">arrow_back</span>
                    Return to Login
                </a>
            </div>

            <p class="mt-10 text-center text-[11px] text-black-400 leading-relaxed">
                Need help? Contact our <a href="{{ route('support.team') }}" class="underline font-bold text-black-600 dark:text-black-300">Support Team</a> for immediate assistance.
            </p>
        </div>
    </div>
</section>
@endsection