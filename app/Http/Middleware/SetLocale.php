<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        // Staff portal defaults to Arabic
        $staffDomain = config('vacation.domain', 'staff.avarewase.com');
        $defaultLocale = $request->getHost() === $staffDomain ? 'ar' : config('app.locale', 'en');

        $locale = $request->session()->get('locale', $defaultLocale);

        if (!in_array($locale, ['en', 'ar'])) {
            $locale = 'en';
        }

        app()->setLocale($locale);

        return $next($request);
    }
}
