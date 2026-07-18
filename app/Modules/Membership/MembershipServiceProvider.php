<?php

namespace App\Modules\Membership;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class MembershipServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/membership.php', 'membership');
    }

    public function boot(): void
    {
        Route::middleware('web')
            ->domain(config('membership.domain'))
            ->name('membership.')
            ->group(__DIR__ . '/Routes/web.php');
    }
}
