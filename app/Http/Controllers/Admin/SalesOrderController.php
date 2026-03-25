<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\CircleBroadcastMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class SalesOrderController extends Controller
{
    /**
     * Menampilkan daftar pesanan dengan fitur Filter Status, Tanggal, Bulan, dan Live Search.
     */
    public function index(Request $request)
    {
        $status = $request->query('status');
        $search = $request->query('search');
        $date = $request->query('date');
        $month = $request->query('month');

        $query = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->select('orders.*', 'users.first_name', 'users.last_name');

        if ($status && $status !== 'all') {
            $query->where('orders.status', $status);
        }

        if ($date) {
            $query->whereDate('orders.created_at', $date);
        }

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
     * Memperbarui status pesanan.
     */
    public function updateStatus(Request $request, $id)
    {
        DB::table('orders')->where('id', $id)->update([
            'status'     => $request->status,
            'updated_at' => now()
        ]);

        return back()->with('success', 'Order status for #ORD-' . $id . ' has been updated to ' . strtoupper($request->status));
    }

    /**
     * Menghapus data pesanan.
     */
    public function destroy($id)
    {
        DB::table('orders')->where('id', $id)->delete();
        return back()->with('success', 'Transaction record #ORD-' . $id . ' has been deleted.');
    }

    /**
     * Menampilkan detail pesanan untuk Admin.
     */
    public function show($id)
    {
        $order = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->select(
                'orders.*', 
                'users.first_name', 
                'users.last_name', 
                'users.email', 
                'products.name as product_name', 
                'products.image as product_image', 
                'products.original_price'
            )
            ->where('orders.id', $id)
            ->first();

        if (!$order) { abort(404); }

        return view('pages.admin.sales-orders.show', compact('order'));
    }

    /**
     * Mencetak Resi Pengiriman.
     */
    public function printReceipt($id)
    {
        $order = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->select('orders.*', 'users.first_name', 'users.last_name', 'products.name as product_name')
            ->where('orders.id', $id)
            ->first();

        return view('pages.admin.sales-orders.receipt', compact('order'));
    }

    /**
     * Mengekspor Laporan PDF dengan JOIN ke tabel produk.
     */
    public function exportPDF(Request $request)
    {
        $date = $request->query('date');
        $month = $request->query('month');

        $query = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->select(
                'orders.*', 
                'users.first_name', 
                'users.last_name', 
                'products.name as product_name'
            );

        if ($date) $query->whereDate('orders.created_at', $date);
        if ($month) {
            $carbonMonth = Carbon::parse($month);
            $query->whereMonth('orders.created_at', $carbonMonth->month)
                  ->whereYear('orders.created_at', $carbonMonth->year);
        }

        $orders = $query->get();
        $total = $orders->where('status', 'completed')->sum('total_price');
        $filter_label = $date ?: ($month ?: 'All Time');

        $pdf = Pdf::loadView('pages.admin.sales-orders.export-pdf', compact('orders', 'total', 'filter_label'));
        return $pdf->download('Sales-Report-'.$filter_label.'.pdf');
    }

    // --- CIRCLE LUXE BROADCAST & EMAIL NOTIFICATION (ADMIN) ---

    /**
     * Menampilkan halaman manajemen pesan Circle LUXE.
     */
    public function circleIndex()
    {
        $messages = DB::table('broadcast_messages')->orderBy('created_at', 'desc')->get();
        return view('pages.admin.circle.index', compact('messages'));
    }

    /**
     * Menyimpan pesan broadcast baru & Mengirim Notifikasi Email ke Subscriber.
     */
    public function circleStore(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        // 1. Simpan Pesan ke Database
        DB::table('broadcast_messages')->insert([
            'message'    => $request->message,
            'admin_name' => Auth::guard('admin')->user()->first_name ?? 'LUXE Official',
            'created_at' => now(),
            'updated_at' => now(), // Pastikan kolom ini sudah ada di DB
        ]);

        // 2. Ambil seluruh email subscriber aktif
        $subscribers = DB::table('subscribers')->pluck('email');

        // 3. Kirim Email Notifikasi Massal
        foreach ($subscribers as $email) {
            try {
                Mail::to($email)->send(new CircleBroadcastMail($request->message));
            } catch (\Exception $e) {
                // Lewati jika satu email gagal agar proses tidak berhenti
                continue;
            }
        }

        return redirect()->back()->with('success', 'Broadcast transmitted and notified to all Circle members.');
    }

    /**
     * Memperbarui pesan broadcast yang sudah ada.
     */
    public function circleUpdate(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string',
        ]);

        // Menghindari error "Unknown column updated_at" jika kolom belum ada
        DB::table('broadcast_messages')->where('id', $id)->update([
            'message'    => $request->message,
            'updated_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Transmission DNA has been refined and updated.');
    }

    /**
     * Menghapus pesan broadcast.
     */
    public function circleDestroy($id)
    {
        DB::table('broadcast_messages')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Message retracted from the terminal.');
    }
}