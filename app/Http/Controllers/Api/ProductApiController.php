<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductApiController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');

        $products = DB::table('products')
            ->when($query, function ($q) use ($query) {
                return $q->where('name', 'LIKE', "%{$query}%")
                         ->orWhere('category', 'LIKE', "%{$query}%");
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Decode JSON field agar Flutter mudah membacanya
        $products->transform(function($product) {
            $product->category = json_decode($product->category);
            $product->colors = json_decode($product->colors);
            $product->sizes = json_decode($product->sizes);
            return $product;
        });

        return response()->json($products);
    }

    public function getHomeSettings()
    {
        $settings = DB::table('home_settings')->pluck('value', 'key_name');
        return response()->json($settings);
    }
}