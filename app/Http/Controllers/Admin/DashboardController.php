<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Menampilkan Dashboard Admin dengan Statistik Riil dan Slider Transaksi.
     */
    public function index()
    {
        // 1. Mengambil data statistik riil dari database
        $stats = [
            // Menghitung total user terdaftar
            'total_users' => DB::table('users')->count(),
            
            // Menghitung total pendapatan hanya dari pesanan yang sudah selesai (completed)
            'total_revenue' => DB::table('orders')
                                ->where('status', 'completed')
                                ->sum('total_price'),
            
            // Menghitung jumlah pesanan baru yang masih menunggu (pending)
            'new_orders' => DB::table('orders')
                                ->where('status', 'pending')
                                ->count(),
            
            // Menghitung total produk aktif di etalase
            'active_products' => DB::table('products')->count(),
        ];

        // 2. Mengambil 5 Transaksi Terbaru untuk tabel dan slider dashboard
        // Join dengan tabel users untuk mendapatkan nama pelanggan
        $recent_transactions = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select(
                'orders.*', 
                'users.first_name', 
                'users.last_name'
            )
            ->orderBy('orders.created_at', 'desc')
            ->limit(5) // Dibatasi tepat 5 data sesuai permintaan
            ->get();

        // 3. Mengirim data ke View Dashboard
        return view('pages.admin.dashboard', compact('stats', 'recent_transactions'));
    }
}