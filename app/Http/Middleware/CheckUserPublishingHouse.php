<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserPublishingHouse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        if (!$user || $user->role !== 'publisher') {
            return $next($request);
        }

        $publishingHouse = $user->publishingHouse()->first();
        if ($request->is('publisher/setup-account')) {
            return $next($request);
        }

        if (!$publishingHouse) {
            return redirect()->to('/publisher/setup-account');
        }

        return $next($request);
    }
}
