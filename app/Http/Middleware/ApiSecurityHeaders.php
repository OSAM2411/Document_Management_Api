<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiSecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {


        $response = $next($request);

        // Prevents the browser from reading JSON as HTML/Script
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        // Enable XSS filtering in older browsers
        $response->headers->set('X-XSS-Protection', '1; mode=block');
        // Prevents any script from running if a file is accidentally opened as HTML
        $response->headers->set('Content-Security-Policy', "default-src 'none'; frame-ancestors 'none'");

        return $response;
    }
}
