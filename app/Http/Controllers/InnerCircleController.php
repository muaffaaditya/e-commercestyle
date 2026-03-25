<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InnerCircleController extends Controller
{
    // Halaman Chat Room
    public function index()
    {
        // Cek apakah user sudah subscribe
        $isSubscribed = DB::table('subscribers')->where('user_id', Auth::id())->exists();

        if (!$isSubscribed) {
            return redirect()->route('home')->with('error', 'You must join the Inner Circle first.');
        }

        $messages = DB::table('broadcast_messages')->orderBy('created_at', 'asc')->get();
        return view('pages.inner-circle', compact('messages'));
    }

    // Proses Subscribe via AJAX
    public function subscribe(Request $request)
    {
        $exists = DB::table('subscribers')->where('user_id', Auth::id())->exists();

        if (!$exists) {
            DB::table('subscribers')->insert([
                'user_id' => Auth::id(),
                'email' => $request->email,
                'created_at' => now()
            ]);
            return response()->json(['success' => true, 'message' => 'Welcome to the Circle!']);
        }

        return response()->json(['success' => false, 'message' => 'You are already a member.']);
    }
}