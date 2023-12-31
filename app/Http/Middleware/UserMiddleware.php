<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $auth_user = Auth::user();

        if ($auth_user->role != 'user'){
            //Auth::logout();
            //return response()->json('You don`t have permission to access');
            return to_route('admin.dashboard');
        }
        return $next($request);
    }
}
