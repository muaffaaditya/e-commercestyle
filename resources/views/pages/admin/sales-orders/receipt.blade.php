<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resi Pengiriman - #ORD-{{ $order->id }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { background: white; }
            .no-print { display: none; }
        }
        .dashed-line {
            border-top: 2px dashed #000;
            width: 100%;
            margin: 10px 0;
        }
        .barcode-sim {
            font-family: 'Libre Barcode 39', cursive;
            font-size: 50px;
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+39&display=swap" rel="stylesheet">
</head>
<body class="bg-gray-100 p-0 md:p-10" onload="window.print()">

    <div class="max-w-[600px] mx-auto bg-white border-2 border-black p-4 text-slate-900 font-sans shadow-lg">
        
        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center gap-2">
                <div class="bg-[#111318] text-white p-2 rounded font-black text-xl italic tracking-tighter">LUXE</div>
                <span class="text-xs font-bold uppercase border-l-2 border-black pl-2">Premium Express</span>
            </div>
            <div class="text-right">
                <p class="text-[10px] font-bold uppercase tracking-widest leading-none">Official Store</p>
                <p class="text-[8px] italic tracking-tighter text-slate-400">logistics.luxepremium.id</p>
            </div>
        </div>

        <div class="border-2 border-black p-2 text-center mb-4">
            <p class="text-sm font-bold uppercase leading-none">No. Pesanan: ORD-{{ $order->id }}</p>
        </div>

        <div class="flex flex-col items-center justify-center py-4 border-b-2 border-black mb-4">
            <div class="barcode-sim leading-none h-16">ORD{{ $order->id }}LUXE</div>
            <p class="text-[10px] font-bold mt-1 tracking-[0.5em]">#ORD-{{ $order->id }}#</p>
        </div>

        <div class="dashed-line"></div>

        <div class="grid grid-cols-2 gap-6 mb-4">
            <div>
                <p class="text-[10px] font-bold uppercase tracking-widest mb-1">Penerima:</p>
                <h4 class="text-sm font-black uppercase">{{ $order->first_name }} {{ $order->last_name }}</h4>
                <p class="text-xs font-bold">{{ $order->phone_number }}</p>
                <p class="text-[10px] leading-tight mt-1 uppercase italic">
                    {{ $order->address_detail }}, {{ $order->district }},<br>
                    {{ $order->city }}, {{ $order->province }},<br>
                    {{ $order->country }} ({{ $order->postal_code }})
                </p>
            </div>
            <div class="border-l-2 border-black pl-4">
                <p class="text-[10px] font-bold uppercase tracking-widest mb-1">Pengirim:</p>
                <h4 class="text-sm font-black uppercase">LUXE Premium Store</h4>
                <p class="text-xs font-bold">0812-9901-2231</p>
                <p class="text-[10px] leading-tight mt-1 uppercase italic">
                    Kota Surabaya, Jawa Timur,<br>
                    Indonesia (60111)
                </p>
            </div>
        </div>

        <div class="grid grid-cols-2 border-2 border-black mb-4">
            <div class="p-2 border-r-2 border-black text-center font-black uppercase text-xs">
                {{ $order->city }}
            </div>
            <div class="p-2 text-center font-black uppercase text-xs bg-slate-100">
                {{ $order->subdistrict ?? 'Standard' }}
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 text-[10px] font-bold uppercase border-b-2 border-black pb-4 mb-4">
            <div class="space-y-1">
                <div class="flex justify-between">
                    <span>Berat:</span>
                    <span>1.0 KG</span>
                </div>
                <div class="flex justify-between">
                    <span>COD:</span>
                    <span>RP 0 (PREPAID)</span>
                </div>
            </div>
            <div class="flex flex-col items-center justify-center border-l-2 border-black">
                <div class="barcode-sim text-3xl leading-none">ID{{ $order->id }}</div>
                <p class="text-[8px] tracking-widest">ORD-{{ $order->id }}</p>
            </div>
        </div>

        <div class="mb-6">
            <table class="w-full text-[10px] text-left">
                <thead class="border-b border-black">
                    <tr class="font-black uppercase tracking-widest">
                        <th class="py-1 w-8">#</th>
                        <th class="py-1">Nama Produk</th>
                        <th class="py-1">Atribut</th>
                        <th class="py-1 text-center">Qty</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    <tr>
                        <td class="py-2">1</td>
                        <td class="py-2 font-black uppercase tracking-tighter">{{ $order->product_name }}</td>
                        <td class="py-2 italic">{{ $order->color_choice }} / {{ $order->size_choice }}</td>
                        <td class="py-2 text-center font-black">{{ $order->quantity }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="border-t border-black pt-4">
            <div class="flex justify-between items-end">
                <div>
                    <p class="text-[8px] font-black uppercase tracking-[0.3em] text-slate-400">Payment Verified</p>
                    <p class="text-[10px] font-bold italic">Pesan: ({{ $order->id }}) Masterpiece Package</p>
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-bold uppercase">Grand Total:</p>
                    <p class="text-lg font-black tracking-tighter">IDR {{ number_format($order->total_price, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-4 border-t-2 border-dashed border-slate-200 text-center">
            <p class="text-[9px] font-black uppercase tracking-[0.5em] text-slate-300">Thank you for your premium investment</p>
        </div>
    </div>

</body>
</html>