<?php

namespace phGov\Auditlog;

use Illuminate\Auth\Events\Login;
use phGov\Auditlog\Listeners\LoginListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;


class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class   => [
            LoginListener::class
        ]
    ];

    public function boot()
    {
        parent::boot();
    }
}