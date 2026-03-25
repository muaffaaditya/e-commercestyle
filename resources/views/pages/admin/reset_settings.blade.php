@extends('layouts.admin')
@section('title', 'Reset Password Editor')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-slate-100" data-aos="fade-up">
        <h3 class="text-2xl font-black text-slate-800 mb-2">Reset Password Branding</h3>
        <p class="text-slate-400 text-sm mb-10 italic">Kelola visual panel kiri pada halaman pengaturan kata sandi baru.</p>

        <form action="{{ route('admin.reset.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                
                <div>
                    <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4">Live Preview Content</label>
                    <div class="relative rounded-[2rem] overflow-hidden bg-[#111318] aspect-[4/5] shadow-2xl">
                        <img id="reset-preview" 
                             src="{{ (isset($settings['reset_image']) && file_exists(public_path('reset/'.$settings['reset_image']))) ? asset('reset/'.$settings['reset_image']) : 'https://images.unsplash.com/photo-1586023492125-27b2c045efd7?q=80&w=1200' }}" 
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
                                    <span id="text-top-preview">{{ $settings['reset_title_top'] ?? 'Secure your account' }}</span> <br>
                                    <span id="text-bottom-preview" class="font-extrabold italic">{{ $settings['reset_title_bottom'] ?? 'with a new identity.' }}</span>
                                </h2>
                                <div class="w-8 h-0.5 bg-white mb-4"></div>
                            </div>
                            
                            <div class="flex gap-4 text-[7px] font-bold uppercase tracking-widest opacity-60">
                                <span>Protection</span><span>Verification</span><span>LUXE ID</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Background Image Asset</label>
                        <input type="file" name="reset_image" class="w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-indigo-50 file:text-indigo-600 hover:file:bg-indigo-100 transition-all" onchange="previewImg(this)">
                        <p class="text-[9px] text-slate-400 mt-2 italic">*Orientation: Portrait</p>
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Title Top</label>
                        <input type="text" name="reset_title_top" value="{{ $settings['reset_title_top'] ?? '' }}" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-100 font-bold outline-none focus:ring-4 focus:ring-indigo-500/5 text-sm" oninput="document.getElementById('text-top-preview').innerText = this.value">
                    </div>

                    <div>
                        <label class="block text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Title Bottom (Italic)</label>
                        <input type="text" name="reset_title_bottom" value="{{ $settings['reset_title_bottom'] ?? '' }}" class="w-full px-5 py-4 rounded-2xl bg-slate-50 border border-slate-100 font-bold outline-none focus:ring-4 focus:ring-indigo-500/5 text-sm" oninput="document.getElementById('text-bottom-preview').innerText = this.value">
                    </div>

                    <button type="submit" class="w-full bg-[#111318] text-white py-4 rounded-2xl font-black uppercase text-[10px] tracking-[0.2em] shadow-xl hover:bg-indigo-600 transition-all active:scale-95 flex items-center justify-center gap-2">
                        <i class="fa-solid fa-lock"></i> Deploy Update
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImg(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('reset-preview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        @if(session('success'))
            Swal.fire({
                title: 'Terminal Secured!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonColor: '#4f46e5',
                customClass: { popup: 'rounded-[2rem]', confirmButton: 'rounded-full px-8 py-3 font-bold uppercase text-xs tracking-widest' }
            });
        @endif
    });
</script>
@endsection