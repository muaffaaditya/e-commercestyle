<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AdminProductController extends Controller
{
    /**
     * Menampilkan daftar semua produk.
     */
    public function index()
    {
        $products = DB::table('products')->orderBy('created_at', 'desc')->get();
        return view('pages.admin.products_index', compact('products'));
    }

    /**
     * Menampilkan form tambah produk baru.
     */
    public function create()
    {
        return view('pages.admin.products_create');
    }

    /**
     * Menyimpan produk baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|max:255',
            'category' => 'required|array',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'original_price' => 'required|numeric',
        ]);

        // 1. Upload Master Thumbnail
        $imageName = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageName = 'prod_main_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('products'), $imageName);
        }

        // 2. Simpan Data Produk ke tabel 'products'
        $productId = DB::table('products')->insertGetId([
            'name' => $request->name,
            'slug' => Str::slug($request->name) . '-' . rand(100, 999),
            'category' => json_encode($request->category), // Simpan array sebagai JSON
            'detail' => $request->detail,
            'image' => $imageName,
            'original_price' => $request->original_price,
            'promo_price' => $request->promo_price,
            'discount_percent' => $request->discount_percent,
            'voucher_code' => $request->voucher_code,
            'voucher_price' => $request->voucher_price,
            'colors' => json_encode($request->colors), // Simpan atribut warna
            'sizes' => json_encode($request->sizes),   // Simpan atribut ukuran
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // 3. Upload Gallery Images (Jika ada lebih dari satu)
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $galName = 'gal_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('products/gallery'), $galName);

                DB::table('product_galleries')->insert([
                    'product_id' => $productId,
                    'image' => $galName,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Masterpiece Published Successfully!');
    }

    /**
     * Mengambil data untuk modal edit (API JSON).
     */
    public function edit($id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        
        // Decode JSON data agar bisa dibaca kembali sebagai array di frontend (JS)
        if($product) {
            $product->category = json_decode($product->category);
            $product->colors = json_decode($product->colors);
            $product->sizes = json_decode($product->sizes);
        }
        
        return response()->json($product);
    }

    /**
     * Memperbarui data produk yang sudah ada.
     */
    public function update(Request $request, $id)
    {
        $product = DB::table('products')->where('id', $id)->first();

        // Tambahan: Logika kalkulasi diskon otomatis jika harga berubah
        $discount = 0;
        if ($request->original_price > 0 && $request->promo_price > 0) {
            $discount = round((($request->original_price - $request->promo_price) / $request->original_price) * 100);
        }
        
        $data = [
            'name' => $request->name,
            'category' => json_encode($request->category),
            'detail' => $request->detail,
            'original_price' => $request->original_price,
            'promo_price' => $request->promo_price,
            'discount_percent' => ($discount > 0) ? $discount : $request->discount_percent,
            'voucher_code' => $request->voucher_code,
            'voucher_price' => $request->voucher_price,
            'colors' => json_encode($request->colors),
            'sizes' => json_encode($request->sizes),
            'updated_at' => now(),
        ];

        // Update Master Thumbnail (Hapus foto lama jika upload baru)
        if ($request->hasFile('image')) {
            if ($product->image && File::exists(public_path('products/' . $product->image))) {
                File::delete(public_path('products/' . $product->image));
            }
            $file = $request->file('image');
            $name = 'prod_main_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('products'), $name);
            $data['image'] = $name;
        }

        DB::table('products')->where('id', $id)->update($data);

        // Tambah Gallery Baru tanpa menghapus gallery lama (Append mode)
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $file) {
                $galName = 'gal_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('products/gallery'), $galName);

                DB::table('product_galleries')->insert([
                    'product_id' => $id,
                    'image' => $galName,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return back()->with('success', 'Evolution Complete: Product Updated!');
    }

    /**
     * Menghapus produk beserta file fisik gambar dan galerinya.
     */
    public function destroy($id)
    {
        $product = DB::table('products')->where('id', $id)->first();
        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $galleries = DB::table('product_galleries')->where('product_id', $id)->get();

        // 1. Bersihkan file galeri fisik dari server
        foreach ($galleries as $gal) {
            if (File::exists(public_path('products/gallery/' . $gal->image))) {
                File::delete(public_path('products/gallery/' . $gal->image));
            }
        }
        // 2. Hapus record galeri dari DB
        DB::table('product_galleries')->where('product_id', $id)->delete();

        // 3. Bersihkan thumbnail utama fisik
        if ($product->image && File::exists(public_path('products/' . $product->image))) {
            File::delete(public_path('products/' . $product->image));
        }

        // 4. Hapus record produk utama
        DB::table('products')->where('id', $id)->delete();

        return response()->json(['success' => 'Product and all assets eliminated!']);
    }
}