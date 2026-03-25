<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiCircleController extends Controller
{
    public function index()
    {
        // Pastikan user adalah subscriber sebelum melihat pesan
        $isSubscriber = DB::table('subscribers')
            ->where('user_id', auth()->id())
            ->exists();

        if (!$isSubscriber) {
            return response()->json(['message' => 'Access Denied. Join the Circle first.'], 403);
        }

        $messages = DB::table('broadcast_messages')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($messages);
    }

    public function orderHistory()
    {
        $orders = DB::table('orders')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->select('orders.*', 'products.name', 'products.image')
            ->where('orders.user_id', auth()->id())
            ->orderBy('orders.created_at', 'desc')
            ->get();

        return response()->json($orders);
    }
}