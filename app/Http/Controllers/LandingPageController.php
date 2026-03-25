<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    /**
     * Menampilkan halaman utama dengan sistem rolling 8 produk terbaru.
     */
    public function index()
    {
        // 1. Mengambil 8 produk terbaru untuk fitur "New Arrivals"
        // Menggunakan latest() agar produk yang baru di-upload otomatis menggeser produk lama
        $newArrivals = DB::table('products')
                         ->where('is_active', true)
                         ->latest()
                         ->take(8) // Membatasi hanya 8 produk agar tampilan grid tetap rapi
                         ->get();

        // 2. Mengambil data galeri untuk setiap produk agar slideshow otomatis berfungsi
        foreach ($newArrivals as $product) {
            $product->galleries = DB::table('product_galleries')
                                    ->where('product_id', $product->id)
                                    ->get();
        }

        // 3. Mengirimkan data ke view pages.home
        return view('pages.home', compact('newArrivals'));
    }
}