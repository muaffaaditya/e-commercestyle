<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = DB::table('carts')
            ->join('products', 'carts.product_id', '=', 'products.id')
            ->where('carts.user_id', Auth::id())
            ->select('carts.*', 'products.name', 'products.image', 'products.promo_price', 'products.original_price')
            ->get();

        return view('pages.products.cart', compact('cartItems'));
    }

    public function store(Request $request)
    {
        // Validasi di sisi server (Double Check)
        if (!$request->selected_color || !$request->selected_size) {
            return response()->json(['success' => false, 'message' => 'Please select color and size.']);
        }

        // Cek apakah item yang sama sudah ada di keranjang
        $existing = DB::table('carts')
            ->where([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'color' => $request->selected_color,
                'size' => $request->selected_size
            ])->first();

        if ($existing) {
            DB::table('carts')->where('id', $existing->id)->increment('quantity', $request->quantity);
        } else {
            DB::table('carts')->insert([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'color' => $request->selected_color,
                'size' => $request->selected_size,
                'quantity' => $request->quantity,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Added to your premium collection!']);
    }

    public function destroy($id)
    {
        DB::table('carts')->where('id', $id)->where('user_id', Auth::id())->delete();
        return back()->with('success', 'Item removed.');
    }
    public function update(Request $request, $id)
{
    $request->validate(['quantity' => 'required|integer|min:1']);
    
    DB::table('carts')
        ->where('id', $id)
        ->where('user_id', Auth::id())
        ->update(['quantity' => $request->quantity, 'updated_at' => now()]);

    return back()->with('success', 'Quantity updated.');
}
}