<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman Login User.
     */
    public function showLogin()
    {
        // Diubah dari 'pages.auth.login' menjadi 'pages.auth.loginuser'
        return view('pages.auth.loginuser');
    }

    /**
     * Menampilkan halaman Register User.
     */
    public function showRegister()
    {
        // Diubah dari 'pages.auth.register' menjadi 'pages.auth.registeruser'
        return view('pages.auth.registeruser');
    }

    /**
     * Memproses Login Manual.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        try {
            $remember = true; 

            if (Auth::attempt($credentials, $remember)) {
                $request->session()->regenerate();
                return redirect()->intended('/')->with('success', 'Welcome back to LUXE!');
            }

            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->with('error', 'Login gagal!')->onlyInput('email');

        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan sistem.');
        }
    }

    /**
     * Memproses Pendaftaran Manual.
     */
    public function register(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|min:8',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password), 
        ]);

        Auth::login($user, true);

        return redirect()->route('home')->with('success', 'Welcome to LUXE.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    // --- SOSIAL LOGIN (GOOGLE & APPLE) ---
    public function redirectToGoogle() { return Socialite::driver('google')->redirect(); }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('google_id', $googleUser->id)->orWhere('email', $googleUser->email)->first();

            if (!$user) {
                $names = explode(' ', $googleUser->name, 2);
                $user = User::create([
                    'first_name' => $names[0],
                    'last_name'  => $names[1] ?? '',
                    'email'      => $googleUser->email,
                    'google_id'  => $googleUser->id,
                    'avatar'     => $googleUser->avatar,
                    'password'   => null, 
                ]);
            }

            Auth::login($user, true);
            return redirect()->route('home')->with('success', 'Logged in with Google!');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal login Google.');
        }
    }

    public function redirectToApple() { return Socialite::driver('apple')->redirect(); }

    public function handleAppleCallback()
    {
        try {
            $appleUser = Socialite::driver('apple')->user();
            $user = User::where('apple_id', $appleUser->id)->orWhere('email', $appleUser->email)->first();

            if (!$user) {
                $user = User::create([
                    'first_name' => $appleUser->name['firstName'] ?? 'Apple',
                    'last_name'  => $appleUser->name['lastName'] ?? 'User',
                    'email'      => $appleUser->email,
                    'apple_id'   => $appleUser->id,
                    'password'   => null,
                ]);
            }

            Auth::login($user, true);
            return redirect()->route('home')->with('success', 'Logged in with Apple!');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Gagal login Apple.');
        }
    }
}