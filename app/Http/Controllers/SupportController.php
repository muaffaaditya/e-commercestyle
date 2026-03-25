<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupportController extends Controller
{
    /**
     * Menampilkan halaman Support Team (Bantuan Pelanggan).
     */
    public function team()
    {
        return view('support.team');
    }

    /**
     * Menampilkan halaman Informasi Pengiriman.
     */
    public function shipping()
    {
        return view('support.shipping');
    }

    /**
     * Menampilkan halaman Kebijakan Pengembalian.
     */
    public function returns()
    {
        return view('support.returns');
    }

    /**
     * Menampilkan halaman Pertanyaan Umum (FAQ).
     */
    public function faq()
    {
        return view('support.faq');
    }

    /**
     * Menampilkan halaman Kebijakan Privasi (Privacy Policy).
     */
    public function privacy()
    {
        return view('support.privacy');
    }

    /**
     * Menampilkan halaman Syarat dan Ketentuan (Terms of Service).
     */
    public function terms()
    {
        return view('support.terms');
    }
}