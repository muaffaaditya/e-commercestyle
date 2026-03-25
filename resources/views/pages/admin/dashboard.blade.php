@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page_title', 'Ecommerce Overview')

@section('content')
<div class="max-w-7xl mx-auto">
    
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-10" data-aos="fade-down">
        <div>
            <h2 class="text-3xl font-black tracking-tighter text-slate-800 uppercase">TERMINAL SUMMARY</h2>
            <p class="text-sm text-slate-500 font-medium mt-1 italic">
                Welcome back, <span class="text-indigo-600 font-bold">{{ Auth::guard('admin')->user()->first_name ?? 'Root' }}</span>! Monitor your store performance today.
            </p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('admin.orders.index') }}" class="bg-white px-6 py-3 rounded-2xl text-[10px] font-black uppercase tracking-widest shadow-sm border border-slate-200 hover:bg-slate-50 transition-all flex items-center gap-3 text-slate-600 active:scale-95">
                <i class="fa-solid fa-list-check text-indigo-600"></i> Manage Orders
            </a>
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        {{-- Revenue Card --}}
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 group hover:border-indigo-500 transition-all" data-aos="fade-up" data-aos-delay="100">
            <div class="w-14 h-14 bg-indigo-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 transition-all duration-500 shadow-inner">
                <i class="fa-solid fa-wallet text-indigo-600 group-hover:text-white text-xl"></i>
            </div>
            <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2">Total Revenue</h4>
            <div class="text-2xl font-black text-slate-800">IDR {{ number_format($stats['total_revenue'], 0, ',', '.') }}</div>
            <p class="text-[9px] text-slate-400 font-bold uppercase mt-3">Tervalidasi (Status Completed)</p>
        </div>

        {{-- New Orders Card --}}
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 group hover:border-amber-500 transition-all" data-aos="fade-up" data-aos-delay="200">
            <div class="w-14 h-14 bg-amber-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-amber-500 transition-all duration-500 shadow-inner">
                <i class="fa-solid fa-box-open text-amber-600 group-hover:text-white text-xl"></i>
            </div>
            <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2">New Orders</h4>
            <div class="text-2xl font-black text-slate-800">{{ $stats['new_orders'] }}</div>
            <p class="text-[10px] text-amber-500 font-bold mt-3 italic underline decoration-amber-200">Waiting for processing</p>
        </div>

        {{-- Customers Card --}}
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 group hover:border-blue-500 transition-all" data-aos="fade-up" data-aos-delay="300">
            <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-blue-600 transition-all duration-500 shadow-inner">
                <i class="fa-solid fa-users text-blue-600 group-hover:text-white text-xl"></i>
            </div>
            <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2">Total Customers</h4>
            <div class="text-2xl font-black text-slate-800">{{ number_format($stats['total_users']) }}</div>
            <p class="text-[10px] text-slate-400 font-bold mt-3 uppercase tracking-tighter italic">Premium Members registered</p>
        </div>

        {{-- Active Products Card --}}
        <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 group hover:border-emerald-500 transition-all" data-aos="fade-up" data-aos-delay="400">
            <div class="w-14 h-14 bg-emerald-50 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-emerald-600 transition-all duration-500 shadow-inner">
                <i class="fa-solid fa-tags text-emerald-600 group-hover:text-white text-xl"></i>
            </div>
            <h4 class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-2">Active Products</h4>
            <div class="text-2xl font-black text-slate-800">{{ $stats['active_products'] }}</div>
            <p class="text-[10px] text-emerald-500 font-bold mt-3 uppercase tracking-tighter italic">Live in storefront</p>
        </div>
    </div>

    {{-- Bottom Grid: Recent Transactions --}}
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-8 bg-white rounded-[3rem] p-10 shadow-sm border border-slate-100" data-aos="fade-right">
            <div class="flex items-center justify-between mb-10">
                <div class="flex items-center gap-4 text-left">
                    <div class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center">
                        <i class="fa-solid fa-list-ul text-slate-500"></i>
                    </div>
                    <h3 class="text-xl font-black tracking-tight text-slate-800 uppercase">LATEST TRANSACTIONS</h3>
                </div>
                <a href="{{ route('admin.orders.index') }}" class="text-[10px] font-black text-indigo-600 uppercase tracking-widest hover:text-indigo-800 transition-colors italic">View All Report</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="text-[10px] font-black uppercase tracking-[0.2em] text-slate-300 border-b border-slate-50">
                            <th class="pb-6 px-4 text-left">Order ID</th>
                            <th class="pb-6 text-left">Pelanggan</th>
                            <th class="pb-6 text-left">Status</th>
                            <th class="pb-6 text-right px-4">Jumlah</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm font-medium">
                        @forelse($recent_transactions as $order)
                        <tr class="border-b border-slate-50/50 hover:bg-slate-50/30 transition-all group">
                            <td class="py-5 px-4 font-extrabold text-indigo-600 text-left">#ORD-{{ $order->id }}</td>
                            <td class="py-5 text-slate-600 font-bold text-left uppercase text-xs">{{ $order->first_name }} {{ $order->last_name }}</td>
                            <td class="py-5 text-left">
                                @php
                                    $statusClasses = [
                                        'pending' => 'bg-amber-100 text-amber-600 border-amber-200',
                                        'completed' => 'bg-emerald-100 text-emerald-600 border-emerald-200',
                                        'shipped' => 'bg-blue-100 text-blue-600 border-blue-200',
                                        'processing' => 'bg-slate-100 text-slate-600 border-slate-200'
                                    ];
                                @endphp
                                <span class="{{ $statusClasses[$order->status] ?? 'bg-gray-100' }} px-3 py-1.5 rounded-xl text-[9px] font-black uppercase tracking-tighter border">
                                    {{ $order->status }}
                                </span>
                            </td>
                            <td class="py-5 text-right font-black text-slate-800 px-4">IDR {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="py-20 text-center text-slate-300 font-bold uppercase tracking-widest text-xs">Belum ada transaksi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Sidebar: System Guard --}}
        <div class="lg:col-span-4 space-y-8">
            <div class="bg-slate-900 rounded-[3rem] p-10 text-white shadow-2xl shadow-slate-900/20 relative overflow-hidden" data-aos="fade-left">
                <div class="absolute -right-4 -top-4 w-24 h-24 bg-indigo-500/10 rounded-full blur-3xl"></div>

                <h3 class="text-xl font-black tracking-tight mb-10 flex items-center gap-3 uppercase">
                    <i class="fa-solid fa-shield-halved text-indigo-400 text-sm"></i> System Guard
                </h3>
                <div class="space-y-8">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4 text-left">
                            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                            <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Database</div>
                        </div>
                        <span class="text-[10px] font-black text-emerald-500 uppercase">Synchronized</span>
                    </div>
                    <div class="flex items-center justify-between text-left">
                        <div class="flex items-center gap-4">
                            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                            <div class="text-xs font-bold text-slate-400 uppercase tracking-widest">Payment Gate</div>
                        </div>
                        <span class="text-[10px] font-black text-emerald-500 uppercase">Ready</span>
                    </div>
                    
                    <hr class="border-white/10">
                    
                    <div class="bg-white/5 p-6 rounded-3xl border border-white/5 backdrop-blur-sm text-left">
                        <h5 class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-400 mb-3">Priority Tasks</h5>
                        <p class="text-sm font-light text-slate-300 leading-relaxed italic opacity-80">"Monitor the verification of proof of payment for new orders in the Sales Orders menu."</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection