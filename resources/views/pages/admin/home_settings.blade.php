@extends('layouts.admin')

@section('title', 'Hero Editor')
@section('page_title', 'Hero Section Editor')

@section('content')
<div class="max-w-5xl mx-auto">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h2 class="text-2xl font-extrabold text-slate-800 tracking-tight">Landing Page Customizer</h2>
            <p class="text-sm text-slate-500 font-medium mt-1">Modify the primary hero visuals and messaging of your storefront.</p>
        </div>
        <div class="flex items-center gap-2 px-4 py-2 bg-indigo-50 rounded-2xl border border-indigo-100">
            <span class="w-2 h-2 bg-indigo-500 rounded-full animate-pulse"></span>
            <span class="text-[10px] font-black text-indigo-600 uppercase tracking-widest">Live Editor Mode</span>
        </div>
    </div>

    @if(session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    background: '#ffffff',
                    confirmButtonColor: '#4f46e5',
                    customClass: {
                        popup: 'rounded-[2rem]',
                        confirmButton: 'rounded-xl px-10 py-3 text-sm font-bold'
                    },
                    showClass: {
                        popup: 'animate__animated animate__fadeInUp animate__faster'
                    }
                });
            });
        </script>
    @endif

    <form action="{{ route('admin.home.settings.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        <div class="bg-white p-10 rounded-[3rem] shadow-sm border border-slate-200/60 transition-all hover:shadow-md">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                
                <div class="lg:col-span-7 space-y-8">
                    <div class="group">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3 ml-1 group-focus-within:text-indigo-600 transition-colors">Hero Subtitle</label>
                        <input type="text" name="hero_subtitle" value="{{ $settings['hero_subtitle'] ?? '' }}" 
                               class="w-full px-6 py-4 rounded-2xl border border-slate-100 bg-slate-50/50 focus:bg-white focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-600 outline-none transition-all text-sm font-bold text-indigo-600 shadow-inner"
                               placeholder="e.g. Premium Essentials">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="group">
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3 ml-1">Title Top</label>
                            <input type="text" name="hero_title_top" value="{{ $settings['hero_title_top'] ?? '' }}" 
                                   class="w-full px-6 py-4 rounded-2xl border border-slate-100 bg-slate-50/50 focus:bg-white focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-600 outline-none transition-all text-sm font-extrabold text-slate-800 shadow-inner"
                                   placeholder="e.g. The Art">
                        </div>
                        <div class="group">
                            <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3 ml-1">Title Bottom</label>
                            <input type="text" name="hero_title_bottom" value="{{ $settings['hero_title_bottom'] ?? '' }}" 
                                   class="w-full px-6 py-4 rounded-2xl border border-slate-100 bg-slate-50/50 focus:bg-white focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-600 outline-none transition-all text-sm font-extrabold italic text-slate-800 shadow-inner"
                                   placeholder="e.g. of Living">
                        </div>
                    </div>

                    <div class="group">
                        <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3 ml-1">Hero Description</label>
                        <textarea name="hero_description" rows="5" 
                                  class="w-full px-6 py-5 rounded-3xl border border-slate-100 bg-slate-50/50 focus:bg-white focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-600 outline-none transition-all text-sm leading-relaxed text-slate-600 shadow-inner"
                                  placeholder="Describe your collection here...">{{ $settings['hero_description'] ?? '' }}</textarea>
                    </div>
                </div>

                <div class="lg:col-span-5 flex flex-col">
                    <label class="block text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-4 ml-1">Hero Visual Asset</label>
                    
                    <div class="relative group aspect-[4/5] rounded-[2.5rem] overflow-hidden bg-slate-100 border-2 border-dashed border-slate-200 flex items-center justify-center transition-all hover:border-indigo-300 shadow-sm">
                        <img id="preview-image" 
                             src="{{ (isset($settings['hero_image']) && file_exists(public_path('gambar/'.$settings['hero_image']))) ? asset('gambar/'.$settings['hero_image']) : 'https://images.unsplash.com/photo-1583847268964-b28dc8f51f92?q=80&w=1000' }}" 
                             class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" alt="Hero Preview">
                        
                        <div class="absolute inset-0 bg-indigo-900/40 opacity-0 group-hover:opacity-100 transition-all duration-300 flex flex-col items-center justify-center backdrop-blur-[2px]">
                            <label for="hero_image_input" class="cursor-pointer bg-white text-indigo-600 px-8 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest hover:scale-105 active:scale-95 transition-all shadow-xl">
                                Replace Image
                            </label>
                            <p class="text-white/70 text-[9px] mt-4 font-bold uppercase tracking-widest">JPG, PNG or WEBP (Max 2MB)</p>
                        </div>
                        
                        <input type="file" id="hero_image_input" name="hero_image" class="hidden" accept="image/*" onchange="previewFile()">
                    </div>
                    
                    <div class="mt-6 p-5 bg-slate-50 rounded-3xl border border-slate-100 flex items-start gap-4">
                        <span class="material-symbols-outlined text-slate-400">info</span>
                        <p class="text-[10px] text-slate-500 font-medium leading-relaxed uppercase tracking-wider">
                            The visual asset will be displayed on the right side of the main landing page. High-resolution portrait orientation recommended.
                        </p>
                    </div>
                </div>
            </div>

            <div class="mt-12 pt-8 border-t border-slate-50 flex items-center justify-between">
                <div class="hidden md:block">
                    <p class="text-[10px] font-bold text-slate-300 uppercase tracking-[0.2em]">Automatic session heartbeat active</p>
                </div>
                <button type="submit" class="w-full md:w-auto bg-[#111318] text-white px-12 py-5 rounded-2xl text-[11px] font-black uppercase tracking-[0.3em] hover:bg-indigo-600 transition-all shadow-2xl shadow-indigo-200 active:scale-[0.98] flex items-center justify-center gap-4 group">
                    Deploy Changes
                    <span class="material-symbols-outlined text-sm group-hover:rotate-180 transition-transform duration-500">sync</span>
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function previewFile() {
        const preview = document.getElementById('preview-image');
        const file = document.getElementById('hero_image_input').files[0];
        const reader = new FileReader();

        reader.onloadend = function () { 
            preview.classList.add('animate-fade-in');
            preview.src = reader.result; 
        }

        if (file) { 
            reader.readAsDataURL(file); 
        }
    }
</script>

<style>
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeIn 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
    }
</style>
@endsection