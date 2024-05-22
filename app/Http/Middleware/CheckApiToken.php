<?php

namespace App\Http\Middleware;

use json;
use Closure;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class CheckApiToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('x-api-key');
        $validToken = config('app.api_token');

        // Log for debugging
        Log::info('Token received', ['token' => $token]);
        Log::info('Valid token', ['validToken' => $validToken]);


        if ($token !== $validToken) {
            return Response::json([
                'message' => 'Invalid API Key',
            ], 400);
        }
        return $next($request);
    }
}
