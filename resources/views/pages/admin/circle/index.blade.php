@extends('layouts.admin')

@section('title', 'Circle Management')

@section('content')
<div class="max-w-5xl mx-auto">
    {{-- Header Section --}}
    <div class="mb-12 text-left" data-aos="fade-down">
        <h2 class="text-3xl font-black tracking-tighter text-slate-800 uppercase text-left">Circle LUXE Hub</h2>
        <p class="text-sm text-slate-400 font-medium mt-1 italic text-left">Refine and manage exclusive transmissions for your inner circle members.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
        {{-- Sisi Kiri: Transmit New Message --}}
        <div class="lg:col-span-5">
            <div class="bg-white rounded-[2.5rem] p-8 shadow-sm border border-slate-100 sticky top-28" data-aos="fade-right">
                <div class="flex justify-between items-start mb-8">
                    <div class="flex items-center gap-4 text-left">
                        <div class="w-10 h-10 bg-indigo-50 rounded-xl flex items-center justify-center text-indigo-600">
                            <span class="material-symbols-outlined">podcasts</span>
                        </div>
                        <h4 class="font-black text-slate-800 uppercase tracking-widest text-xs">New Transmission</h4>
                    </div>
                    {{-- Status Notifikasi Email --}}
                    <div class="flex items-center gap-1.5 bg-emerald-50 px-3 py-1.5 rounded-full border border-emerald-100">
                        <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full animate-pulse"></span>
                        <span class="text-[8px] font-black text-emerald-600 uppercase tracking-widest">Email Sync ON</span>
                    </div>
                </div>

                <form action="{{ route('admin.circle.store') }}" method="POST">
                    @csrf
                    <div class="mb-6 text-left">
                        <label class="text-[9px] font-black uppercase text-slate-400 mb-2 block tracking-widest ml-1">Message Content</label>
                        <textarea name="message" rows="5" required
                                  class="w-full px-6 py-4 rounded-2xl bg-slate-50 border border-slate-100 text-sm font-medium outline-none focus:ring-4 focus:ring-indigo-600/5 focus:bg-white transition-all"
                                  placeholder="Type your exclusive update here..."></textarea>
                        <p class="text-[8px] text-slate-400 mt-3 italic text-left">*Pesan ini akan otomatis dikirimkan ke seluruh email subscriber.</p>
                    </div>

                    <button type="submit" class="w-full bg-[#111318] text-white py-4 rounded-2xl font-black uppercase text-[10px] tracking-[0.3em] hover:bg-[#1754cf] transition-all shadow-xl active:scale-95 flex items-center justify-center gap-2">
                        Transmit & Notify
                        <span class="material-symbols-outlined text-sm">mail</span>
                    </button>
                </form>
            </div>
        </div>

        {{-- Sisi Kanan: Transmission Logs (Daftar Chat) --}}
        <div class="lg:col-span-7 space-y-6">
            <h4 class="font-black text-slate-300 uppercase tracking-[0.4em] text-[9px] mb-4 ml-4 text-left">Active Transmissions</h4>
            
            @forelse($messages as $msg)
            <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-slate-100 hover:border-indigo-100 transition-all group" data-aos="fade-up">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex items-center gap-3 text-left">
                        <div class="w-8 h-8 bg-slate-100 rounded-full flex items-center justify-center text-slate-400">
                            <span class="material-symbols-outlined text-sm">person</span>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-slate-800 uppercase leading-none text-left">{{ $msg->admin_name }}</p>
                            <p class="text-[8px] text-slate-400 font-bold uppercase mt-1 text-left">{{ date('M d, Y • H:i', strtotime($msg->created_at)) }}</p>
                        </div>
                    </div>
                    
                    {{-- Action Buttons: Edit & Delete --}}
                    <div class="flex items-center gap-2">
                        <button onclick="openEditModal({{ $msg->id }}, '{{ addslashes($msg->message) }}')" 
                                class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-300 hover:bg-indigo-50 hover:text-indigo-600 transition-all">
                            <span class="material-symbols-outlined text-lg">edit_note</span>
                        </button>
                        
                        <form action="{{ route('admin.circle.destroy', $msg->id) }}" method="POST" id="delete-form-{{ $msg->id }}">
                            @csrf @method('DELETE')
                            <button type="button" onclick="confirmDelete({{ $msg->id }})" 
                                    class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-300 hover:bg-red-50 hover:text-red-500 transition-all">
                                <span class="material-symbols-outlined text-lg">delete_sweep</span>
                            </button>
                        </form>
                    </div>
                </div>
                <div class="pl-11 text-left">
                    <p class="text-sm text-slate-600 leading-relaxed font-medium italic text-left">"{{ $msg->message }}"</p>
                </div>
            </div>
            @empty
            <div class="py-20 text-center bg-slate-50/50 rounded-[3rem] border-2 border-dashed border-slate-100">
                <span class="material-symbols-outlined text-4xl text-slate-200 mb-3">history_toggle_off</span>
                <p class="text-[10px] font-black text-slate-300 uppercase tracking-widest text-center">No previous transmissions</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

{{-- MODAL EDIT MESSAGE --}}
<div id="editMessageModal" class="fixed inset-0 z-[3000] hidden flex items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4">
    <div class="bg-white w-full max-w-lg rounded-[2.5rem] shadow-2xl overflow-hidden" data-aos="zoom-in">
        <form id="editMessageForm" method="POST">
            @csrf @method('PATCH')
            <div class="p-10">
                <div class="flex justify-between items-center mb-8">
                    <h3 class="text-xl font-black text-slate-800 uppercase tracking-tighter text-left">Edit Transmission</h3>
                    <button type="button" onclick="closeEditModal()" class="text-slate-400 hover:text-slate-600">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                
                <div class="mb-8 text-left">
                    <label class="text-[9px] font-black uppercase text-slate-400 mb-2 block tracking-widest ml-1 text-left">Updated Content</label>
                    <textarea name="message" id="edit_message_input" rows="5" required
                              class="w-full px-6 py-4 rounded-2xl bg-slate-50 border border-slate-100 text-sm font-medium outline-none focus:ring-4 focus:ring-indigo-600/5 transition-all"></textarea>
                    <p class="text-[8px] text-slate-400 mt-2 italic text-left">*Catatan: Mengedit pesan tidak akan mengirim ulang email.</p>
                </div>

                <div class="flex gap-3">
                    <button type="button" onclick="closeEditModal()" class="flex-1 py-4 text-[10px] font-black uppercase tracking-widest text-slate-400 hover:bg-slate-50 rounded-xl transition-all">Cancel</button>
                    <button type="submit" class="flex-1 bg-[#1754cf] text-white py-4 rounded-xl font-black uppercase text-[10px] tracking-widest shadow-lg shadow-blue-200 active:scale-95 transition-all">Update DNA</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Fungsi Hapus dengan SweetAlert2
    function confirmDelete(id) {
        Swal.fire({
            title: 'RETRACT MESSAGE?',
            text: "This transmission will be permanently erased from the Circle database.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#111318',
            cancelButtonColor: '#f8fafc',
            confirmButtonText: 'CONFIRM ERASE',
            customClass: { popup: 'rounded-[2.5rem]', confirmButton: 'rounded-xl', cancelButton: 'rounded-xl text-slate-400' }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

    // Modal Logic
    function openEditModal(id, message) {
        const modal = document.getElementById('editMessageModal');
        const form = document.getElementById('editMessageForm');
        const input = document.getElementById('edit_message_input');
        
        // Sesuaikan endpoint rute PATCH update Anda
        form.action = `/admin/circle-broadcast/${id}/update`; 
        input.value = message;
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeEditModal() {
        const modal = document.getElementById('editMessageModal');
        modal.classList.replace('flex', 'hidden');
        document.body.style.overflow = 'auto';
    }
</script>
@endsection