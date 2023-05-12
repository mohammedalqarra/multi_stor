<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next , ...$types): Response
    {
          $user = $request->user();

        if (Auth::user()->type == $types) {
            return redirect()->route('login');
        }

        if (!in_array(Auth::user()->types , $types)) {
            return redirect('/no-access');
            //  abort(404);

        }


        return $next($request);
    }
}
