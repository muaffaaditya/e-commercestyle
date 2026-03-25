<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Admin;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Pemetaan model ke policy untuk aplikasi.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Daftarkan layanan autentikasi / otorisasi apa pun.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        /**
         * Gate: access-admin
         * Digunakan untuk memproteksi rute backend admin.
         * Sekarang menggunakan model Admin yang baru dibuat.
         * * Gate ini akan mengizinkan akses jika user yang sedang login
         * berasal dari Guard 'admin' (Model Admin).
         */
        Gate::define('access-admin', function ($user) {
            return $user instanceof Admin;
        });
    }
}