<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Fitur Pencarian Produk.
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        $products = DB::table('products')
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('detail', 'LIKE', "%{$query}%")
                  ->orWhere('category', 'LIKE', "%\"{$query}\"%"); 
            })->get();

        return view('pages.products.search-results', compact('products', 'query'));
    }

    /**
     * Menampilkan Detail Produk Masterpiece.
     */
    public function show($id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        if (!$product) abort(404);

        // Decode atribut JSON untuk tampilan detail
        $product->category = json_decode($product->category);
        $product->colors = json_decode($product->colors);
        $product->sizes = json_decode($product->sizes);

        $galleries = DB::table('product_galleries')->where('product_id', $id)->get();
        $user = Auth::user();

        return view('pages.products.show', compact('product', 'galleries', 'user'));
    }

    /**
     * Verifikasi Voucher Produk melalui AJAX.
     */
    public function verifyVoucher(Request $request)
    {
        $product = DB::table('products')->where('id', $request->product_id)->first();
        if ($product && $product->voucher_code === strtoupper($request->code)) {
            return response()->json([
                'success' => true,
                'discount' => (int)$product->voucher_price,
                'message' => 'Voucher Applied: IDR ' . number_format($product->voucher_price, 0, ',', '.')
            ]);
        }
        return response()->json(['success' => false, 'message' => 'Voucher code is invalid or expired.']);
    }

    /**
     * Menampilkan produk yang sedang dalam masa promosi (Shop Deals).
     * Terintegrasi dengan tombol Seasonal Promotions.
     */
    public function showDeals()
    {
        // Memfilter produk yang memiliki promo_price yang valid
        $products = DB::table('products')
            ->whereNotNull('promo_price')
            ->where('promo_price', '>', 0)
            ->get();

        $title = "Seasonal Deals";
        $description = "Curated items with exclusive price reductions for limited time offers.";

        return view('pages.products.filter-results', compact('products', 'title', 'description'));
    }

    /**
     * Menampilkan produk dengan program Voucher (Claim Voucher).
     * Produk otomatis hilang jika voucher_code dihapus/null di database.
     */
    public function showVouchers()
    {
        // Filter ketat: Hanya tampilkan jika voucher_code tidak kosong
        $products = DB::table('products')
            ->whereNotNull('voucher_code')
            ->where('voucher_code', '!=', '')
            ->get();

        $title = "Voucher Rewards";
        $description = "Unlock additional mastery with our exclusive claimable vouchers for your purchase.";

        return view('pages.products.filter-results', compact('products', 'title', 'description'));
    }
}