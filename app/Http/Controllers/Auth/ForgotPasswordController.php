<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ResetPasswordMail;

class ForgotPasswordController extends Controller
{
    public function showLinkRequestForm()
    {
        return view('pages.auth.forgot-password');
    }

    public function sendResetLinkEmail(Request $request)
    {
        // Validasi input email
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'Email tidak terdaftar di sistem kami.'
        ]);

        $token = Str::random(60);

        try {
            // Gunakan updateOrInsert agar tidak terjadi duplikat token untuk satu email
            DB::table('password_reset_tokens')->updateOrInsert(
                ['email' => $request->email],
                [
                    'token' => $token,
                    'created_at' => now()
                ]
            );

            // Kirim email kustom
            Mail::to($request->email)->send(new ResetPasswordMail($token, $request->email));

            return back()->with('status', 'Link reset sudah kami kirimkan ke email Anda.');
            
        } catch (\Exception $e) {
            // Jika terjadi error (misal koneksi database atau SMTP email mati)
            return back()->withErrors(['email' => 'Terjadi kesalahan sistem. Silahkan coba lagi nanti.']);
        }
    }

    public function showResetForm($token)
    {
        // Pastikan token ada di database sebelum menampilkan form
        $reset = DB::table('password_reset_tokens')->where('token', $token)->first();
        
        if (!$reset) {
            return redirect()->route('password.request')->withErrors(['email' => 'Link reset tidak valid atau sudah kadaluwarsa.']);
        }

        return view('pages.auth.reset-password', ['token' => $token, 'email' => $reset->email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        // Cek kecocokan token dan email
        $resetData = DB::table('password_reset_tokens')
                        ->where('email', $request->email)
                        ->where('token', $request->token)
                        ->first();

        if (!$resetData) {
            return back()->withErrors(['email' => 'Token reset password tidak valid.']);
        }

        // Update Password
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->setRememberToken(Str::random(60));
        $user->save();

        // Hapus token setelah berhasil digunakan
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Kata sandi berhasil diubah! Silahkan login.');
    }
}