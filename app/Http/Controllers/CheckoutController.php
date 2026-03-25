<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class CheckoutController extends Controller
{
    /* |--------------------------------------------------------------------------
    | USER SIDE LOGIC (Pelanggan)
    |--------------------------------------------------------------------------
    */

    /**
     * Menampilkan halaman ringkasan pembayaran (User).
     */
    public function index(Request $request)
    {
        $product = DB::table('products')->where('id', $request->product_id)->first();
        
        $products = [];
        if ($request->has('items') && is_array($request->items)) {
            foreach ($request->items as $item) {
                $productInfo = DB::table('products')->where('id', $item['product_id'])->first();
                if ($productInfo) {
                    $products[] = [
                        'info'  => $productInfo,
                        'qty'   => $item['quantity'],
                        'color' => $item['color'],
                        'size'  => $item['size'],
                        'price' => $item['price']
                    ];
                }
            }
        }

        $data = $request->all();
        
        $voucher = null;
        if ($request->promo_code && Schema::hasTable('vouchers')) {
            $voucher = DB::table('vouchers')->where('code', $request->promo_code)->first();
        }

        return view('pages.products.payment', compact('product', 'products', 'data', 'voucher'));
    }

    /**
     * Memproses pesanan final, upload bukti bayar, & membersihkan keranjang (User).
     */
    public function process(Request $request)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $proofName = null;
        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $proofName = 'PROOF_' . time() . '_' . Auth::id() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('payment_proofs'), $proofName);
        }

        $orderId = DB::table('orders')->insertGetId([
            'user_id'        => Auth::id(),
            'product_id'     => $request->product_id,
            'quantity'       => $request->quantity,
            'total_price'    => $request->total_price,
            'voucher_used'   => $request->voucher_used,
            'phone_number'   => $request->phone_number,
            'postal_code'    => $request->postal_code,
            'color_choice'   => $request->selected_color,
            'size_choice'    => $request->selected_size,
            'country'        => $request->country ?? 'Indonesia',
            'province'       => $request->province,
            'city'           => $request->city,
            'district'       => $request->district,
            'subdistrict'    => $request->subdistrict,
            'address_detail' => $request->address_detail,
            'status'         => 'pending',
            'payment_proof'  => $proofName,
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

        // SINKRONISASI KERANJANG: Hapus item spesifik yang baru dibeli
        DB::table('carts')
            ->where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->where('color', $request->selected_color)
            ->where('size', $request->selected_size)
            ->delete();

        // Menggunakan rute checkout.success sesuai definisi di web.php
        return redirect()->route('checkout.success', $orderId);
    }

    /**
     * Daftar Pesanan Aktif untuk Dashboard User.
     */
    public function myOrders()
    {
        $orders = DB::table('orders')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->select('orders.*', 'products.name', 'products.image')
            ->where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'processing', 'shipped'])
            ->orderBy('orders.created_at', 'desc')
            ->get();

        return view('pages.products.my-orders', compact('orders'));
    }

    /**
     * Tampilan Detail Pesanan Sisi User (Read-Only dengan Alur/Timeline).
     */
    public function success($id)
    {
        $order = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->select('orders.*', 'users.first_name', 'users.last_name', 'users.email', 'products.name as product_name', 'products.image as product_image')
            ->where('orders.id', $id)
            ->where('orders.user_id', Auth::id()) 
            ->first();

        if (!$order) abort(404);

        return view('pages.products.success', compact('order'));
    }

    /**
     * Konfirmasi barang diterima & Upload foto bukti (User).
     */
    public function confirmReceived(Request $request, $id)
    {
        $request->validate([
            'received_proof' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $receivedProof = null;
        if ($request->hasFile('received_proof')) {
            $file = $request->file('received_proof');
            $receivedProof = 'RECEIVED_' . time() . '_' . Auth::id() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('received_proofs'), $receivedProof);
        }

        DB::table('orders')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->update([
                'status'         => 'completed',
                'received_proof' => $receivedProof,
                'updated_at'     => now()
            ]);

        return redirect()->route('orders.history')->with('success', 'Masterpiece diterima! Transaksi selesai.');
    }

    /**
     * Riwayat Pembelian Selesai atau Semua Status (User Archive).
     */
    public function history()
    {
        $orders = DB::table('orders')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->select('orders.*', 'products.name', 'products.image')
            ->where('user_id', Auth::id())
            ->orderBy('orders.created_at', 'desc')
            ->get();

        return view('pages.products.history', compact('orders'));
    }


    /* |--------------------------------------------------------------------------
    | ADMIN SIDE LOGIC (Management)
    |--------------------------------------------------------------------------
    */

    /**
     * Daftar Pesanan (Admin) dengan Live Search & Filter.
     */
    public function adminIndex(Request $request)
    {
        $status = $request->query('status');
        $search = $request->query('search');
        $date = $request->query('date');
        $month = $request->query('month');

        $query = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.*', 'users.first_name', 'users.last_name');

        if ($status && $status !== 'all') $query->where('orders.status', $status);
        if ($date) $query->whereDate('orders.created_at', $date);
        if ($month) {
            $carbonMonth = Carbon::parse($month);
            $query->whereMonth('orders.created_at', $carbonMonth->month)
                  ->whereYear('orders.created_at', $carbonMonth->year);
        }
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('users.first_name', 'like', "%{$search}%")
                  ->orWhere('users.last_name', 'like', "%{$search}%")
                  ->orWhere('orders.id', 'like', "%{$search}%");
            });
        }

        $orders = $query->orderBy('orders.created_at', 'desc')->paginate(10);

        if ($request->ajax()) {
            return view('pages.admin.sales-orders.partials.table', compact('orders'))->render();
        }

        // STATISTIK DASHBOARD ADMIN (Pembelian Hari Ini & Bulan Ini)
        $stats = [
            'total_orders'  => DB::table('orders')->count(),
            'today_revenue' => DB::table('orders')
                                ->whereDate('created_at', Carbon::today())
                                ->where('status', 'completed')
                                ->sum('total_price'),
            'month_revenue' => DB::table('orders')
                                ->whereMonth('created_at', Carbon::now()->month)
                                ->whereYear('created_at', Carbon::now()->year)
                                ->where('status', 'completed')
                                ->sum('total_price'),
        ];

        return view('pages.admin.sales-orders.index', compact('orders', 'stats'));
    }

    /**
     * Update Status Pesanan (Admin).
     */
    public function updateStatus(Request $request, $id)
    {
        DB::table('orders')->where('id', $id)->update([
            'status'     => $request->status,
            'updated_at' => now()
        ]);
        return back()->with('success', 'Status #ORD-' . $id . ' diperbarui.');
    }

    /**
     * Ekspor PDF Laporan Penjualan Berdasarkan Filter (Admin).
     */
    public function exportPDF(Request $request)
    {
        $date = $request->query('date');
        $month = $request->query('month');

        $query = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('products', 'orders.product_id', '=', 'products.id') // Join produk agar product_name tersedia
            ->select('orders.*', 'users.first_name', 'users.last_name', 'products.name as product_name');

        if ($date) $query->whereDate('orders.created_at', $date);
        if ($month) {
            $carbonMonth = Carbon::parse($month);
            $query->whereMonth('orders.created_at', $carbonMonth->month)
                  ->whereYear('orders.created_at', $carbonMonth->year);
        }

        $orders = $query->get();
        // Total hanya dihitung dari pesanan yang sukses dibayar/selesai
        $total = $orders->where('status', 'completed')->sum('total_price');
        
        $filter_label = $date ?: ($month ?: 'All Time');

        $pdf = Pdf::loadView('pages.admin.sales-orders.export-pdf', compact('orders', 'total', 'filter_label'));
        return $pdf->download('Sales-Report-'.$filter_label.'.pdf');
    }
}