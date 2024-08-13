<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiTokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('x-token');

        if (!$token || strlen($token) !== 32) {
            return response()->json(['error' => 'Invalid API token'], 401);
        }

        $validToken = config('services.api.token');

        if ($token !== $validToken) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}