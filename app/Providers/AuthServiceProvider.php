<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{

    protected $policies = [
        \App\Models\Order::class => \App\Policies\OrderPolicy::class,
    ];


    public function boot(): void
    {
        $this->registerPolicies();
    }
}
