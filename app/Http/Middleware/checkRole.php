<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next , string...$roles): Response
    {
        if (!$request->user()) {
            return response()->json([
                'message' => 'سەراتا پێویستە بچیتە ژورەوە'
            ], 401);
        }
        if (!in_array($request->user()->role, $roles)) {
            return response()->json([
                'message' => 'دەسەڵاتی ئەنجامدانی ئەم کارەت نیە',
            ], 403);
        }
        return $next($request);
    }
}
