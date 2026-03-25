<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\Apple\AppleExtendSocialite;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Pemetaan event ke listener untuk aplikasi.
     * Menambahkan listener SocialiteWasCalled agar provider Apple dikenali.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        // Listener untuk Socialite Providers (Apple Login)
        SocialiteWasCalled::class => [
            AppleExtendSocialite::class.'@handle',
        ],
    ];

    /**
     * Daftarkan event apa pun untuk aplikasi Anda.
     */
    public function boot(): void
    {
        parent::boot();
    }

    /**
     * Tentukan apakah event dan listener harus ditemukan secara otomatis.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}