<?php

namespace App\Providers;

use App\Events\User\UserCreated;
use App\Events\User\UserUpdated;
use App\Listeners\User\LogUserActivity;
use App\Listeners\User\SendWelcomeEmail;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UserCreated::class => [
            SendWelcomeEmail::class,
        ],
        UserUpdated::class => [
            LogUserActivity::class,
        ],
    ];

    public function boot(): void
    {
        //
    }

    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}