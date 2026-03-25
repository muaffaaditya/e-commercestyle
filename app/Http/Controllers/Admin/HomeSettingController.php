<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class HomeSettingController extends Controller
{
    /**
     * 1. MANAJEMEN HERO LANDING
     */
    public function index()
    {
        $dbSettings = DB::table('home_settings')->pluck('value', 'key_name')->toArray();

        $settings = array_merge([
            'hero_subtitle'     => 'Premium Essentials',
            'hero_title_top'    => 'The Art',
            'hero_title_bottom' => 'of Living',
            'hero_description'  => 'Discover our curated collection of high-end essentials.',
            'hero_image'        => 'default-hero.jpg'
        ], $dbSettings);

        return view('pages.admin.home_settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'hero_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $dataTeks = $request->except('_token', 'hero_image');
        $this->massUpdateOrInsert($dataTeks);

        if ($request->hasFile('hero_image')) {
            $this->uploadFileProcess($request->file('hero_image'), 'hero_image', 'gambar');
        }

        return back()->with('success', 'Home Landing Page has been updated successfully!');
    }

    /**
     * 2. MANAJEMEN LOGIN EDITOR
     */
    public function loginIndex()
    {
        $dbSettings = DB::table('home_settings')->pluck('value', 'key_name')->toArray();
        
        $settings = array_merge([
            'login_title_top'    => 'Elevate your everyday with',
            'login_title_bottom' => 'curated essentials.',
            'login_image'        => 'login-default.jpg'
        ], $dbSettings);

        return view('pages.admin.login_settings', compact('settings'));
    }

    public function loginUpdate(Request $request)
    {
        $request->validate([
            'login_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $dataTeks = $request->except('_token', 'login_image');
        $this->massUpdateOrInsert($dataTeks);

        if ($request->hasFile('login_image')) {
            $this->uploadFileProcess($request->file('login_image'), 'login_image', 'login');
        }

        return back()->with('success', 'Login branding updated successfully!');
    }

    /**
     * 3. MANAJEMEN REGISTER EDITOR
     */
    public function registerIndex()
    {
        $dbSettings = DB::table('home_settings')->pluck('value', 'key_name')->toArray();
        
        $settings = array_merge([
            'register_title_top'    => 'Quality is not an act,',
            'register_title_bottom' => 'it is a habit.',
            'register_description'  => 'Join our community of home enthusiasts.',
            'register_image'        => 'register-default.jpg'
        ], $dbSettings);

        return view('pages.admin.register_settings', compact('settings'));
    }

    public function registerUpdate(Request $request)
    {
        $request->validate([
            'register_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $dataTeks = $request->except('_token', 'register_image');
        $this->massUpdateOrInsert($dataTeks);

        if ($request->hasFile('register_image')) {
            $this->uploadFileProcess($request->file('register_image'), 'register_image', 'register');
        }

        return back()->with('success', 'Register branding updated successfully!');
    }

    /**
     * 4. MANAJEMEN FORGOT PASSWORD EDITOR
     */
    public function forgotIndex()
    {
        $dbSettings = DB::table('home_settings')->pluck('value', 'key_name')->toArray();
        
        $settings = array_merge([
            'forgot_title_top'    => 'Restore your access to',
            'forgot_title_bottom' => 'curated lifestyle.',
            'forgot_image'        => 'forgot-default.jpg'
        ], $dbSettings);

        return view('pages.admin.forgot_settings', compact('settings'));
    }

    public function forgotUpdate(Request $request)
    {
        $request->validate([
            'forgot_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $dataTeks = $request->except('_token', 'forgot_image');
        $this->massUpdateOrInsert($dataTeks);

        if ($request->hasFile('forgot_image')) {
            $this->uploadFileProcess($request->file('forgot_image'), 'forgot_image', 'forgot');
        }

        return back()->with('success', 'Forgot Password branding updated successfully!');
    }

    /**
     * 5. MANAJEMEN RESET PASSWORD EDITOR
     */
    public function resetIndex()
    {
        $dbSettings = DB::table('home_settings')->pluck('value', 'key_name')->toArray();
        
        $settings = array_merge([
            'reset_title_top'    => 'Secure your account',
            'reset_title_bottom' => 'with a new identity.',
            'reset_image'        => 'reset-default.jpg'
        ], $dbSettings);

        return view('pages.admin.reset_settings', compact('settings'));
    }

    public function resetUpdate(Request $request)
    {
        $request->validate([
            'reset_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $dataTeks = $request->except('_token', 'reset_image');
        $this->massUpdateOrInsert($dataTeks);

        if ($request->hasFile('reset_image')) {
            $this->uploadFileProcess($request->file('reset_image'), 'reset_image', 'reset');
        }

        return back()->with('success', 'Reset Password branding updated successfully!');
    }

    /**
     * --- HELPER FUNCTIONS ---
     */
    private function massUpdateOrInsert($data)
    {
        foreach ($data as $key => $value) {
            DB::table('home_settings')->updateOrInsert(
                ['key_name' => $key],
                ['value' => $value, 'updated_at' => now()]
            );
        }
    }

    private function uploadFileProcess($file, $keyName, $folderName)
    {
        $name = $keyName . '_' . time() . '.' . $file->getClientOriginalExtension();
        $destinationPath = public_path($folderName);

        // 1. Ambil nama file lama & Hapus fisiknya agar server hemat ruang
        $oldImage = DB::table('home_settings')->where('key_name', $keyName)->value('value');
        if ($oldImage && File::exists($destinationPath . '/' . $oldImage)) {
            File::delete($destinationPath . '/' . $oldImage);
        }

        // 2. Buat folder jika belum ada (izin 0755)
        if (!File::isDirectory($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true, true);
        }

        // 3. Simpan file baru & Update DB
        $file->move($destinationPath, $name);
        DB::table('home_settings')->updateOrInsert(
            ['key_name' => $keyName],
            ['value' => $name, 'updated_at' => now()]
        );
    }
}