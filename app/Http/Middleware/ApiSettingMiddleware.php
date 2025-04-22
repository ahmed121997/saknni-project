<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ApiSettingMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the request is an API request
        if ($request->is('api/*')) {
           // set header for API requests
            $request->headers->set('Content-Type', 'application/json');
            $request->headers->set('Accept', 'application/json');

            // set locale for API requests
            $locale = $request->header('Accept-Language', 'en');
            app()->setLocale($locale);
        }
        return $next($request);
    }
}
