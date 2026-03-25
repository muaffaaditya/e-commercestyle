@extends('layouts.admin')
@section('title', 'Login Page Editor')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-slate-100" data-aos="fade-up">
        <h3 class="text-2xl font-black text-slate-800 mb-2">Login Branding</h3>
        <p class="text-slate-400 text-sm mb-10 italic">Kelola tampilan visual panel kiri pada halaman masuk pelanggan (Login).</p>

        <form action="{{ route('admin.login.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">Live Preview Content</label>
                    <div class="relative rounded-[2rem] overflow-hidden bg-[#111318] aspect-[4/5] shadow-2xl">
                        {{-- Menampilkan gambar dari folder public/login/ --}}
                        <img id="login-preview" 
                             src="{{ (isset($settings['login_image']) && file_exists(public_path('login/'.$settings['login_image']))) ? asset('login/'.$settings['login_image']) : 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?q=80&w=1200' }}" 
                             class="absolute inset-0 w-full h-full object-cover opacity-60">
                        
                        <div class="absolute inset-0 bg-black/20"></div>
                        
                        <div class="relative z-10 p-8 h-full flex flex-col justify-between text-white">
                            <div class="flex items-center gap-2">
                                <div class="w-6 h-6 bg-white/20 rounded-lg flex items-center justify-center backdrop-blur-sm">
                                    <i class="fa-solid fa-crown text-[10px]"></i>
                                </div>
                                <span class="text-xs font-black uppercase tracking-tighter">LUXE</span>
                            </div>
                            
                            <div>
                                <h2 class="text-2xl font-light leading-tight mb-4">
                                    <span id="text-top-preview">{{ $settings['login_title_top'] ?? 'Elevate your everyday with' }}</span> <br>
                                    <span id="text-bottom-preview" class="font-extrabold italic">{{ $settings['login_title_bottom'] ?? 'curated essentials.' }}</span>
                                </h2>
                                <div class="w-8 h-0.5 bg-white mb-4"></div>
                            </div>
                            
                            <div class="flex gap-4 text-[7px] font-bold uppercase tracking-widest opacity-60">
                                <span>Security</span><span>Privacy</span><span>Support</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Background Image Asset</label>
                        <input type="file" name="login_image" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 transition-all" onchange="previewImg(this)">
                        <p class="text-[9px] text-slate-400 mt-2 italic">*Rekomendasi ukuran: 1200 x 1600px (Portrait)</p>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Branding Title (Top)</label>
                        <input type="text" name="login_title_top" value="{{ $settings['login_title_top'] ?? '' }}" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-100 font-bold outline-none focus:ring-4 focus:ring-indigo-500/5 text-sm" oninput="document.getElementById('text-top-preview').innerText = this.value">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Branding Title (Bottom Italic)</label>
                        <input type="text" name="login_title_bottom" value="{{ $settings['login_title_bottom'] ?? '' }}" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-100 font-bold outline-none focus:ring-4 focus:ring-indigo-500/5 text-sm" oninput="document.getElementById('text-bottom-preview').innerText = this.value">
                    </div>

                    <div class="p-4 bg-indigo-50 rounded-2xl border border-indigo-100">
                        <p class="text-[10px] text-indigo-600 leading-relaxed font-bold italic">
                            Info: Tampilan ini akan muncul secara eksklusif pada terminal login pelanggan di sisi kiri layar.
                        </p>
                    </div>

                    <button type="submit" class="w-full bg-[#111318] text-white py-4 rounded-2xl font-black uppercase text-[10px] tracking-[0.2em] shadow-xl hover:bg-indigo-600 transition-all active:scale-95 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-rocket"></i> Deploy Update
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Preview Gambar saat dipilih
    function previewImg(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('login-preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Tampilkan SweetAlert jika ada session success
    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            Swal.fire({
                title: 'Terminal Updated!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#4f46e5',
                customClass: {
                    popup: 'rounded-[2rem]',
                    confirmButton: 'rounded-full px-8 py-3 font-bold uppercase text-xs tracking-widest'
                }
            });
        @endif
    });
</script>
@endsection