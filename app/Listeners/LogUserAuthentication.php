<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Events\Dispatcher;

class LogUserAuthentication
{
    /**
     * Daftarkan pendengar kustom untuk event ini.
     */
    public function subscribe(Dispatcher $events): void
    {
        $events->listen(
            Login::class,
            [LogUserAuthentication::class, 'handleUserLogin']
        );

        $events->listen(
            Logout::class,
            [LogUserAuthentication::class, 'handleUserLogout']
        );
    }

    public function handleUserLogin(Login $event): void
    {
        activity('authentication')
            ->causedBy($event->user)
            ->log('User berhasil login');
    }

    public function handleUserLogout(Logout $event): void
    {
        activity('authentication')
            ->causedBy($event->user)
            ->log('User melakukan logout');
    }
}
