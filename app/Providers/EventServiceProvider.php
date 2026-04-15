<?php

namespace App\Providers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        Event::listen(Login::class, function ($event) {
            activity('auth')
                ->causedBy($event->user)
                ->log('Berhasil login ke dalam sistem');
        });

        Event::listen(Logout::class, function ($event) {
            if ($event->user) {
                activity('auth')
                    ->causedBy($event->user)
                    ->log('Keluar (logout) dari sistem');
            }
        });
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }

    /**
     * The event to subscriber mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $subscribe = [
        \App\Listeners\LogUserAuthentication::class,
    ];
}
