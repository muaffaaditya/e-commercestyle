@extends('layouts.admin')

@section('content')
<div class="p-6 bg-[#f8fafc] min-h-screen text-left">
    {{-- Header & Search Bar --}}
    <div class="mb-10 flex flex-col lg:flex-row lg:items-center justify-between gap-6" data-aos="fade-down">
        <div>
            <h1 class="text-3xl font-black tracking-tighter text-slate-800 uppercase">Sales Orders</h1>
            <p class="text-slate-500 text-sm font-medium mt-1">Manage and track your premium customer transactions.</p>
        </div>
        
        <div class="relative w-full lg:w-96">
            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400">
                <i class="fa-solid fa-magnifying-glass text-sm"></i>
            </span>
            <input type="text" id="live-search" placeholder="Search Customer Name or Order ID..." 
                   class="w-full pl-12 pr-6 py-4 rounded-2xl bg-white border border-slate-100 shadow-sm outline-none focus:ring-4 focus:ring-blue-500/5 transition-all font-bold text-xs uppercase tracking-widest text-slate-600">
        </div>
    </div>

    {{-- Stats Widgets --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10" data-aos="fade-up">
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center space-x-5 group hover:border-blue-500 transition-all duration-300">
            <div class="p-4 bg-blue-50 text-blue-600 rounded-2xl group-hover:bg-blue-600 group-hover:text-white transition-all">
                <i class="fa-solid fa-box-open text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] uppercase font-black text-slate-400 tracking-[0.2em]">Total Orders</p>
                <p class="text-2xl font-black text-slate-800">{{ number_format($stats['total_orders']) }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center space-x-5 group hover:border-emerald-500 transition-all duration-300">
            <div class="p-4 bg-emerald-50 text-emerald-600 rounded-2xl group-hover:bg-emerald-600 group-hover:text-white transition-all">
                <i class="fa-solid fa-receipt text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] uppercase font-black text-slate-400 tracking-[0.2em]">Pembelian Hari Ini</p>
                <p class="text-2xl font-black text-slate-800">IDR {{ number_format($stats['today_revenue'], 0, ',', '.') }}</p>
            </div>
        </div>
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm flex items-center space-x-5 group hover:border-purple-500 transition-all duration-300">
            <div class="p-4 bg-purple-50 text-purple-600 rounded-2xl group-hover:bg-purple-600 group-hover:text-white transition-all">
                <i class="fa-solid fa-calendar-check text-xl"></i>
            </div>
            <div>
                <p class="text-[10px] uppercase font-black text-slate-400 tracking-[0.2em]">Pembelian Bulan Ini</p>
                <p class="text-2xl font-black text-slate-800">IDR {{ number_format($stats['month_revenue'], 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="mb-8 flex flex-col md:flex-row gap-4 items-end bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm" data-aos="fade-right">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="flex flex-wrap gap-4 items-end w-full">
            <div class="flex flex-col gap-2">
                <label class="text-[9px] font-black uppercase text-slate-400 tracking-widest">Filter Date</label>
                <input type="date" name="date" value="{{ request('date') }}" class="bg-slate-50 border-none rounded-xl text-xs font-bold p-3 outline-none ring-1 ring-slate-100 focus:ring-blue-500 transition-all">
            </div>
            <div class="flex flex-col gap-2">
                <label class="text-[9px] font-black uppercase text-slate-400 tracking-widest">Filter Month</label>
                <input type="month" name="month" value="{{ request('month') }}" class="bg-slate-50 border-none rounded-xl text-xs font-bold p-3 outline-none ring-1 ring-slate-100 focus:ring-blue-500 transition-all">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="bg-[#111318] text-white px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-blue-600 transition-all">Apply Filter</button>
                <a href="{{ route('admin.orders.index') }}" class="bg-slate-100 text-slate-500 px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-slate-200 transition-all text-center flex items-center">Reset</a>
            </div>
            
            <div class="ml-auto">
                <a href="{{ route('admin.orders.exportPDF', ['date' => request('date'), 'month' => request('month')]) }}" 
                   class="bg-emerald-500 text-white px-6 py-3 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-emerald-600 transition-all flex items-center gap-2">
                    <i class="fa-solid fa-file-pdf text-sm"></i> Export Report
                </a>
            </div>
        </form>
    </div>

    {{-- Filter Tabs --}}
    <div class="flex space-x-8 border-b border-slate-200 mb-8 text-[11px] font-black uppercase tracking-widest">
        @php $currentStatus = request('status', 'all'); @endphp
        @foreach(['all' => 'All Orders', 'pending' => 'Pending', 'processing' => 'Processing', 'completed' => 'Completed'] as $val => $label)
            <a href="{{ route('admin.orders.index', array_merge(request()->query(), ['status' => $val])) }}" 
               class="pb-4 transition-all relative {{ $currentStatus == $val ? 'text-blue-600' : 'text-slate-400 hover:text-slate-600' }}">
                {{ $label }}
                @if($currentStatus == $val)
                    <span class="absolute bottom-0 left-0 w-full h-1 bg-blue-600 rounded-full"></span>
                @endif
            </a>
        @endforeach
    </div>

    {{-- Table Section --}}
    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden" data-aos="fade-up">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50/50 text-slate-400 text-[10px] uppercase font-black tracking-[0.2em]">
                    <tr>
                        <th class="px-8 py-6">Reference</th>
                        <th class="px-6 py-6 text-left">Customer Details</th>
                        <th class="px-8 py-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody id="order-table-body" class="divide-y divide-slate-50 text-sm">
                    @include('pages.admin.sales-orders.partials.table')
                </tbody>
            </table>
        </div>
        <div id="pagination-links" class="px-8 py-6 bg-slate-50/50 border-t border-slate-50">
            {{ $orders->appends(request()->query())->links() }}
        </div>
    </div>
</div>

{{-- SweetAlert2 & AJAX Script --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Live Search Logic
        $('#live-search').on('keyup', function() {
            let query = $(this).val();
            let status = '{{ request("status", "all") }}';
            let date = '{{ request("date") }}';
            let month = '{{ request("month") }}';

            $.ajax({
                url: "{{ route('admin.orders.index') }}",
                type: "GET",
                data: { 'search': query, 'status': status, 'date': date, 'month': month },
                success: function(data) {
                    $('#order-table-body').html(data);
                    if(query.length > 0) { $('#pagination-links').fadeOut(); } 
                    else { $('#pagination-links').fadeIn(); }
                }
            });
        });

        // Konfirmasi Hapus SweetAlert
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            let form = $(this).closest('form');
            
            Swal.fire({
                title: 'Delete Masterpiece?',
                text: "This transaction will be permanently removed from the records.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#111318',
                cancelButtonColor: '#f8fafc',
                confirmButtonText: 'YES, DELETE IT',
                cancelButtonText: 'CANCEL',
                reverseButtons: true,
                customClass: {
                    popup: 'rounded-[2rem]',
                    confirmButton: 'rounded-xl px-8 py-4 font-black text-[10px] tracking-widest',
                    cancelButton: 'rounded-xl px-8 py-4 font-black text-[10px] tracking-widest text-slate-500'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endsection