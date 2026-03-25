@extends('layouts.admin')

@section('content')
<div class="p-6 bg-[#f8fafc] min-h-screen text-left">
    
    {{-- Breadcrumb Navigation --}}
    <nav class="flex mb-8 text-[10px] font-black uppercase tracking-[0.2em]" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.orders.index') }}" class="text-slate-400 hover:text-blue-600 transition-colors flex items-center gap-2">
                    <i class="fa-solid fa-receipt"></i> Sales Orders
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <span class="text-slate-300 mx-2">/</span>
                    <span class="text-slate-800">Show Order Detail</span>
                </div>
            </li>
        </ol>
    </nav>

    {{-- Header Section --}}
    <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-black tracking-tighter text-slate-800 uppercase">Order #ORD-{{ $order->id }}</h1>
            <p class="text-slate-500 text-sm font-medium">Placed on {{ date('M d, Y \a\t H:i', strtotime($order->created_at)) }} from Website Storefront</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.orders.print', $order->id) }}" target="_blank" class="px-6 py-3 bg-white border border-slate-200 rounded-xl font-black text-[10px] uppercase tracking-widest flex items-center gap-2 hover:bg-slate-50 transition-all shadow-sm">
                <i class="fa-solid fa-print"></i> Print Invoice
            </a>
            
            {{-- Update Status Button (Fungsional Dropdown) --}}
            <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST" id="status-update-form">
                @csrf @method('PATCH')
                <div class="relative group">
                    <select name="status" onchange="this.form.submit()" 
                        class="appearance-none pl-6 pr-12 py-3 bg-blue-600 text-white rounded-xl font-black text-[10px] uppercase tracking-widest flex items-center gap-2 shadow-lg shadow-blue-200 cursor-pointer border-none focus:ring-4 focus:ring-blue-300 transition-all">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                    <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-white">
                        <i class="fa-solid fa-chevron-down text-[10px]"></i>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Order Timeline Visual --}}
    <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 mb-8 flex justify-between items-center relative overflow-hidden">
        @php
            $statuses = ['pending' => 'Order Placed', 'processing' => 'Processing', 'shipped' => 'Shipped', 'completed' => 'Delivered'];
            $currentIdx = array_search($order->status, array_keys($statuses));
        @endphp
        @foreach($statuses as $key => $label)
            <div class="flex flex-col items-center z-10">
                <div class="w-10 h-10 rounded-full flex items-center justify-center border-4 {{ $loop->index <= $currentIdx ? 'bg-blue-600 border-blue-100 text-white shadow-lg' : 'bg-slate-50 border-white text-slate-300' }}">
                    <i class="fa-solid {{ $loop->index <= $currentIdx ? 'fa-check' : 'fa-circle' }} text-xs"></i>
                </div>
                <p class="text-[10px] font-black uppercase mt-3 {{ $loop->index <= $currentIdx ? 'text-slate-800' : 'text-slate-300' }}">{{ $label }}</p>
            </div>
        @endforeach
        <div class="absolute top-[52px] left-20 right-20 h-1 bg-slate-100 -z-0"></div>
    </div>

    {{-- Sisanya sama dengan kode yang Anda berikan namun dengan perbaikan format harga --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden h-fit text-left">
                <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center text-left">
                    <h3 class="font-black uppercase text-xs tracking-widest text-slate-800">Order Items ({{ $order->quantity }})</h3>
                </div>
                <div class="p-8">
                    <table class="w-full text-left border-collapse">
                        <thead class="text-[10px] uppercase font-black text-slate-400 border-b border-slate-50 pb-4 text-left">
                            <tr>
                                <th class="pb-4">Product Narrative</th>
                                <th class="pb-4">SKU Code</th>
                                <th class="pb-4">Qty</th>
                                <th class="pb-4 text-right">Investment Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            <tr>
                                <td class="py-6 flex items-center gap-6 text-left">
                                    <img src="{{ asset('products/'.$order->product_image) }}" class="w-20 h-24 rounded-2xl object-cover border border-slate-100 shadow-sm">
                                    <div>
                                        <p class="font-black text-slate-800 uppercase text-xs leading-tight text-left">{{ $order->product_name }}</p>
                                        <div class="flex gap-2 mt-2">
                                            <span class="text-[8px] font-black text-blue-600 bg-blue-50 px-2 py-0.5 rounded uppercase">Col: {{ $order->color_choice }}</span>
                                            <span class="text-[8px] font-black text-slate-400 bg-slate-50 px-2 py-0.5 rounded uppercase">Size: {{ $order->size_choice }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-6 text-[10px] font-black text-slate-300 uppercase tracking-widest">ORD-{{ $order->product_id }}-LUXE</td>
                                <td class="py-6 font-black text-xs text-left">{{ $order->quantity }}</td>
                                <td class="py-6 text-right">
                                    @php $totalPrice = (float) $order->total_price; @endphp
                                    <p class="font-black text-slate-800 text-lg leading-none">
                                        IDR {{ number_format($totalPrice, 0, ',', '.') }}
                                    </p>
                                    <p class="text-[9px] font-bold text-slate-300 uppercase mt-1 italic tracking-widest">Verified Payment</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Sidebar Identitas --}}
        <div class="space-y-8">
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 text-left">
                <h3 class="font-black uppercase text-xs tracking-widest mb-6 text-slate-800">Customer Profile</h3>
                <div class="flex items-center gap-4 mb-6 text-left">
                    <div class="w-14 h-14 rounded-2xl bg-slate-900 text-white flex items-center justify-center font-black text-lg shadow-xl shadow-slate-200">
                        {{ substr($order->first_name, 0, 1) }}
                    </div>
                    <div class="text-left">
                        <p class="font-black text-slate-800 uppercase text-sm leading-tight text-left">{{ $order->first_name }} {{ $order->last_name }}</p>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Premium Member</p>
                    </div>
                </div>
                <div class="space-y-4 pt-4 border-t border-slate-50 text-left">
                    <div class="flex items-center gap-3 text-left">
                        <span class="material-symbols-outlined text-xs text-slate-400">mail</span>
                        <span class="text-xs font-medium text-slate-600">{{ $order->email }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-left">
                        <span class="material-symbols-outlined text-xs text-slate-400">call</span>
                        <span class="text-xs font-medium text-slate-600 text-left">{{ $order->phone_number }}</span>
                    </div>
                </div>
            </div>

            {{-- Terminal Shipping --}}
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 text-left">
                <h3 class="font-black uppercase text-xs tracking-widest mb-6 text-slate-800">Shipping Terminal</h3>
                <div class="space-y-6 text-left">
                    <div>
                        <p class="text-[9px] font-black text-slate-300 uppercase tracking-widest mb-2 text-left">Destination Address</p>
                        <p class="text-[11px] font-bold text-slate-600 leading-relaxed uppercase italic text-left">
                            {{ $order->address_detail }}, {{ $order->district }}, {{ $order->city }}, {{ $order->province }}, {{ $order->postal_code }}
                        </p>
                    </div>
                    <div class="pt-4 border-t border-dashed border-slate-100 text-center">
                        <button class="w-full py-4 bg-[#111318] text-white rounded-xl font-black text-[10px] uppercase tracking-widest transition-all hover:bg-blue-600 shadow-lg">
                            Track Logistics
                        </button>
                    </div>
                </div>
            </div>
            
            {{-- Bukti Pembayaran --}}
            @if($order->payment_proof)
            <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 text-left">
                <h3 class="font-black uppercase text-xs tracking-widest mb-4 text-slate-800">Payment Verification</h3>
                <a href="{{ asset('payment_proofs/'.$order->payment_proof) }}" target="_blank">
                    <img src="{{ asset('payment_proofs/'.$order->payment_proof) }}" class="w-full h-40 object-cover rounded-2xl group-hover:opacity-80 transition-all border border-slate-50 shadow-sm">
                </a>
                <p class="text-[9px] text-slate-400 font-bold mt-3 text-center uppercase tracking-widest italic">Click image to expand proof</p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection