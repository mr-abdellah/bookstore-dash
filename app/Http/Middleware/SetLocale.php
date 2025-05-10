<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        // Check user model first (if authenticated), then session, then config
        $locale = Auth::check() && method_exists(Auth::user(), 'getLanguage')
            ? Auth::user()->getLanguage()
            : Session::get('locale', config('app.locale'));

        App::setLocale($locale);

        Log::info('SetLocale Middleware', [
            'user_locale' => Auth::check() ? (method_exists(Auth::user(), 'getLanguage') ? Auth::user()->getLanguage() : null) : null,
            'session_locale' => Session::get('locale'),
            'app_locale' => App::getLocale(),
        ]);

        return $next($request);
    }
}
