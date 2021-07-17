<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class PreventsBlockedUsersRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->isBlocked()) {
            auth()->logout();
            abort(403, 'Usuário bloqueado.');
        }

        return $next($request);
    }
}
